<footer class="border-t border-slate-800 bg-[#060a16]">
    <div class="grid w-full gap-8 px-4 py-10 sm:px-6 lg:grid-cols-4 lg:px-10">
        <div>
            <a href="{{ route('index') }}" class="font-display text-lg font-semibold tracking-wide text-white">
                <span class="text-amber-300">KINGS</span>BRIDGE MOTORS
            </a>
            <p class="mt-3 text-sm text-slate-400">Buy, sell, and discover vehicles, parts, and events in one place.</p>
        </div>

        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wide text-slate-200">Marketplace</h4>
            <ul class="mt-3 space-y-2 text-sm text-slate-400">
                <li><a href="{{ route('marketplace.index') }}" class="hover:text-white">Browse Vehicles</a></li>
                <li><a href="{{ route('spareparts') }}" class="hover:text-white">Vehicle Parts</a></li>
                <li><a href="{{ route('carevent') }}" class="hover:text-white">Car Events</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wide text-slate-200">Company</h4>
            <ul class="mt-3 space-y-2 text-sm text-slate-400">
                <li><a href="{{ route('about_us') }}" class="hover:text-white">About</a></li>
                <li><a href="{{ route('contact_us') }}" class="hover:text-white">Contact</a></li>
                <li><a href="{{ route('terms_condition') }}" class="hover:text-white">Terms</a></li>
                <li><a href="{{ route('package') }}" class="hover:text-white">Packages</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wide text-slate-200">Account</h4>
            <ul class="mt-3 space-y-2 text-sm text-slate-400">
                @auth
                    <li><a href="{{ route('user.my_list') }}" class="hover:text-white">My List</a></li>
                    <li><a href="{{ route('user.userevent') }}" class="hover:text-white">My Events</a></li>
                    <li><a href="{{ route('user.new_listing') }}" class="hover:text-white">Create Listing</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white">Sign Up</a></li>
                @endauth
            </ul>
        </div>
    </div>

    <div class="border-t border-slate-800 px-4 py-4 text-center text-xs text-slate-500 sm:px-6 lg:px-10">
        &copy; {{ date('Y') }} Kingsbridge Motors. All rights reserved.
    </div>
</footer>
