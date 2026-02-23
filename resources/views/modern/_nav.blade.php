<header class="sticky top-0 z-50 border-b border-slate-800/80 bg-[#050812]/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('index') }}" class="font-display text-lg font-semibold tracking-wide text-white">
            <span class="text-amber-300">KINGS</span>BRIDGE MOTORS
        </a>

        <nav class="hidden items-center gap-6 text-sm text-slate-300 md:flex">
            <a href="{{ route('marketplace.index') }}" class="{{ request()->routeIs('index') || request()->routeIs('marketplace.index') ? 'text-white' : 'hover:text-white' }}">Marketplace</a>
            <a href="{{ route('spareparts') }}" class="{{ request()->routeIs('spareparts') || request()->routeIs('spare_parts_search') ? 'text-white' : 'hover:text-white' }}">Vehicle Parts</a>
            <a href="{{ route('carevent') }}" class="{{ request()->routeIs('carevent') ? 'text-white' : 'hover:text-white' }}">Car Events</a>
            <a href="{{ route('about_us') }}" class="{{ request()->routeIs('about_us') ? 'text-white' : 'hover:text-white' }}">About</a>
        </nav>

        <div class="flex items-center gap-2">
            <a href="{{ route('signup') }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold text-slate-200 hover:border-slate-500 hover:text-white">Sign Up</a>
            <a href="{{ route('user.login') }}" class="rounded-lg bg-amber-300 px-3 py-2 text-xs font-semibold text-slate-900 hover:bg-amber-200">Login</a>
        </div>
    </div>
</header>
