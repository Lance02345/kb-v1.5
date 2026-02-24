<header class="sticky top-0 z-50 border-b border-slate-800/80 bg-[#050812]/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('index') }}" class="font-display text-lg font-semibold tracking-wide text-white">
            <span class="text-amber-300">KINGS</span>BRIDGE MOTORS
        </a>

        <nav class="hidden items-center gap-6 text-sm md:flex">
            <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'text-white' : 'text-slate-300 hover:text-white' }}">Home</a>
            <a href="{{ route('marketplace.index') }}" class="{{ request()->routeIs('marketplace.index') ? 'text-white' : 'text-slate-300 hover:text-white' }}">Marketplace</a>
            <a href="{{ route('spareparts') }}" class="{{ request()->routeIs('spareparts') || request()->routeIs('spare_parts_search') ? 'text-white' : 'text-slate-300 hover:text-white' }}">Vehicle Parts</a>
            <a href="{{ route('carevent') }}" class="{{ request()->routeIs('carevent') ? 'text-white' : 'text-slate-300 hover:text-white' }}">Car Events</a>
            <a href="{{ route('about_us') }}" class="{{ request()->routeIs('about_us') ? 'text-white' : 'text-slate-300 hover:text-white' }}">About</a>
        </nav>

        <div class="flex items-center gap-2">
            @guest
                <a href="{{ route('register') }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold text-slate-200 hover:border-slate-500 hover:text-white">Sign Up</a>
                <a href="{{ route('login') }}" class="rounded-lg bg-amber-300 px-3 py-2 text-xs font-semibold text-slate-900 hover:bg-amber-200">Login</a>
            @else
                <details class="group relative">
                    <summary class="list-none cursor-pointer rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold text-slate-200 hover:border-slate-500 hover:text-white">
                        {{ \Illuminate\Support\Str::limit(Auth::user()->name, 14) }}
                    </summary>
                    <div class="absolute right-0 mt-2 w-48 overflow-hidden rounded-xl border border-slate-700 bg-slate-900 shadow-2xl">
                        <a href="{{ route('user.my_list') }}" class="block px-4 py-2 text-xs text-slate-200 hover:bg-slate-800">My List</a>
                        <a href="{{ route('user.myspareparts') }}" class="block px-4 py-2 text-xs text-slate-200 hover:bg-slate-800">Spare Parts</a>
                        <a href="{{ route('user.userevent') }}" class="block px-4 py-2 text-xs text-slate-200 hover:bg-slate-800">My Events</a>
                        <a href="{{ route('user.invoice.index') }}" class="block px-4 py-2 text-xs text-slate-200 hover:bg-slate-800">Invoices</a>
                        <a href="{{ route('user.user_profile', Auth::user()->id) }}" class="block px-4 py-2 text-xs text-slate-200 hover:bg-slate-800">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="border-t border-slate-700">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-xs text-rose-300 hover:bg-slate-800">Logout</button>
                        </form>
                    </div>
                </details>
                <a href="{{ route('user.new_listing') }}" class="rounded-lg bg-amber-300 px-3 py-2 text-xs font-semibold text-slate-900 hover:bg-amber-200">Create Listing</a>
            @endguest
        </div>
    </div>
</header>
