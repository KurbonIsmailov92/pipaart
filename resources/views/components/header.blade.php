<header class="relative z-50 mt-4 text-white">
    <div class="shell-container">
        <div class="surface-card border border-white/10 bg-slate-950/75 px-4 py-4 text-white shadow-2xl sm:px-6">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="text-xl font-semibold tracking-[0.18em] sm:text-2xl">
                    {{ $siteSettings['site_name'] ?? 'PIPAA' }}
                </a>

                <nav class="hidden items-center gap-5 text-sm uppercase tracking-[0.18em] lg:flex">
                    <a href="{{ route('home') }}" class="hover:text-blue-200">Home</a>
                    <a href="{{ route('about') }}" class="hover:text-blue-200">About</a>
                    <a href="{{ route('certifications') }}" class="hover:text-blue-200">Certifications</a>
                    <a href="{{ route('courses.index') }}" class="hover:text-blue-200">Courses</a>
                    <a href="{{ route('schedule.index') }}" class="hover:text-blue-200">Schedule</a>
                    <a href="{{ route('news.index') }}" class="hover:text-blue-200">News</a>
                    <a href="{{ route('gallery.index') }}" class="hover:text-blue-200">Gallery</a>
                    <a href="{{ route('contact') }}" class="hover:text-blue-200">Contact</a>
                </nav>

                <details class="group lg:hidden">
                    <summary class="list-none rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium backdrop-blur marker:hidden">
                        Menu
                    </summary>
                    <div class="absolute right-4 top-full mt-3 w-[min(18rem,calc(100vw-2rem))] overflow-hidden rounded-3xl border border-white/15 bg-slate-950/95 p-3 shadow-2xl">
                        <div class="grid gap-2 text-sm">
                            <a href="{{ route('home') }}" class="rounded-2xl px-4 py-3 hover:bg-white/10">Home</a>
                            <a href="{{ route('about') }}" class="rounded-2xl px-4 py-3 hover:bg-white/10">About</a>
                            <a href="{{ route('certifications') }}" class="rounded-2xl px-4 py-3 hover:bg-white/10">Certifications</a>
                            <a href="{{ route('courses.index') }}" class="rounded-2xl px-4 py-3 hover:bg-white/10">Courses</a>
                            <a href="{{ route('schedule.index') }}" class="rounded-2xl px-4 py-3 hover:bg-white/10">Schedule</a>
                            <a href="{{ route('news.index') }}" class="rounded-2xl px-4 py-3 hover:bg-white/10">News</a>
                            <a href="{{ route('gallery.index') }}" class="rounded-2xl px-4 py-3 hover:bg-white/10">Gallery</a>
                            <a href="{{ route('contact') }}" class="rounded-2xl px-4 py-3 hover:bg-white/10">Contact</a>
                        </div>
                    </div>
                </details>
            </div>
        </div>
    </div>
</header>
