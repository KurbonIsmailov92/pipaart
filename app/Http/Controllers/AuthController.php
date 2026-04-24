<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerForm(): View|Factory|Application
    {
        return view('auth.register');
    }

    public function signUp(): View|Factory|Application
    {
        return view('auth.sign-up');
    }

    public function loginForm(): View|Factory|Application
    {
        return view('auth.login');
    }

    public function forgot(): View|Factory|Application
    {
        return view('auth.forgot-password');
    }

    public function reset(string $token): View|Factory|Application
    {
        return view('auth.reset-password', [
            'token' => $token,
        ]);
    }

    public function register(SignUpRequest $request): RedirectResponse
    {
        return $this->createAndLoginUser($request);
    }

    public function store(SignUpRequest $request): RedirectResponse
    {
        return $this->createAndLoginUser($request);
    }

    public function login(SignInRequest $request): RedirectResponse
    {
        if (! auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => __('auth.failed'),
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended($this->localizedHomeUrl($request));
    }

    public function logout(): RedirectResponse
    {
        $locale = request()->hasSession()
            ? request()->session()->get('locale', config('app.locale', 'ru'))
            : config('app.locale', 'ru');

        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home', [
            'locale' => $locale,
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('message', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            static function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('message', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    protected function createAndLoginUser(SignUpRequest $request): RedirectResponse
    {
        $user = User::query()->create([
            'name' => $request->string('name')->value(),
            'email' => $request->string('email')->lower()->value(),
            'password' => Hash::make($request->string('password')->value()),
            'role' => UserRole::Student->value,
        ]);

        event(new Registered($user));

        auth()->login($user);
        $request->session()->regenerate();

        return redirect()->intended($this->localizedHomeUrl($request));
    }

    protected function localizedHomeUrl(Request $request): string
    {
        return route('home', [
            'locale' => $request->session()->get('locale', config('app.locale', 'ru')),
        ]);
    }
}
