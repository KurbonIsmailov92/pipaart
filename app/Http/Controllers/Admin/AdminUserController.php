<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
{
    public function __construct(
        protected UserService $userService,
    ) {
    }

    public function index(): View|Factory|Application
    {
        $this->authorize('viewAny', User::class);

        return view('admin.users.index', [
            'users' => User::query()->latest()->paginate(10),
        ]);
    }

    public function create(): View|Factory|Application
    {
        $this->authorize('create', User::class);

        return view('admin.users.create', [
            'userModel' => new User(),
            'roles' => $this->assignableRoles(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->create($request->validated());

        return redirect()->route('admin.users.index')->with('success', __('ui.flash.user_created'));
    }

    public function edit(User $user): View|Factory|Application
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', [
            'userModel' => $user,
            'roles' => $this->assignableRoles(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->userService->update($user, $request->validated());

        return redirect()->route('admin.users.index')->with('success', __('ui.flash.user_updated'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $this->userService->delete($user);

        return redirect()->route('admin.users.index')->with('success', __('ui.flash.user_deleted'));
    }

    /**
     * @return list<UserRole>
     */
    protected function assignableRoles(): array
    {
        return array_values(array_filter(
            UserRole::cases(),
            static fn (UserRole $role): bool => in_array($role->value, UserRole::assignableValues(), true),
        ));
    }
}
