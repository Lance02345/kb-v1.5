<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-color" content="#0f172a">
    <title>Kingsbridge Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/sweetalert/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @php($adminModernPath = public_path('css/admin-modern.css'))
    @if(file_exists($adminModernPath))
        <link href="{{ asset('css/admin-modern.css') }}?v={{ filemtime($adminModernPath) }}" rel="stylesheet">
    @endif

    @livewireStyles
    @stack('styles')
</head>
<body class="kb-modern kb-admin2">
@php($segment = Request::segment(2))

<div class="kb2-shell">
    <aside class="kb2-sidebar" id="kb2Sidebar">
        <div class="kb2-brand">
            <a href="{{ route('admin.dashboard') }}" style="color: inherit; text-decoration:none;">
                <span>KINGS</span>BRIDGE ADMIN
            </a>
        </div>

        <nav class="kb2-nav">
            <div class="kb2-group">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="kb2-link {{ !$segment ? 'active' : '' }}"><i class="icon-speedometer"></i>Dashboard</a>

            <div class="kb2-group">Users & Access</div>
            <a href="{{ route('admin.user.index') }}" class="kb2-link {{ $segment == 'user' ? 'active' : '' }}"><i class="icon-user"></i>Users</a>
            <a href="{{ route('admin.role.index') }}" class="kb2-link {{ $segment == 'role' ? 'active' : '' }}"><i class="icon-shield"></i>Roles</a>
            <a href="{{ route('admin.permission.index') }}" class="kb2-link {{ $segment == 'permission' ? 'active' : '' }}"><i class="icon-key"></i>Permissions</a>

            <div class="kb2-group">Listings</div>
            <a href="{{ route('admin.listing.index') }}" class="kb2-link {{ $segment == 'listing' ? 'active' : '' }}"><i class="icon-note"></i>Listings</a>
            <a href="{{ route('admin.listing.vehicles') }}" class="kb2-link {{ request()->routeIs('admin.listing.vehicles') ? 'active' : '' }}"><i class="icon-directions"></i>Vehicles</a>
            <a href="{{ route('admin.listing.carhirelist') }}" class="kb2-link {{ request()->routeIs('admin.listing.carhirelist') ? 'active' : '' }}"><i class="icon-calendar"></i>Car Hire</a>

            <div class="kb2-group">Finance</div>
            <a href="{{ route('admin.invoice.index') }}" class="kb2-link {{ $segment == 'invoice' ? 'active' : '' }}"><i class="icon-doc"></i>Invoices</a>
            <a href="{{ route('admin.package.index') }}" class="kb2-link {{ $segment == 'package' ? 'active' : '' }}"><i class="icon-diamond"></i>Packages</a>

            <div class="kb2-group">Catalog</div>
            <a href="{{ route('admin.category.index') }}" class="kb2-link {{ $segment == 'category' ? 'active' : '' }}"><i class="icon-layers"></i>Categories</a>
            <a href="{{ route('admin.carmake.index') }}" class="kb2-link {{ $segment == 'carmake' ? 'active' : '' }}"><i class="icon-wrench"></i>Car Makes</a>
            <a href="{{ route('admin.carmodel.index') }}" class="kb2-link {{ $segment == 'carmodel' ? 'active' : '' }}"><i class="icon-list"></i>Car Models</a>

            <div class="kb2-group">Locations</div>
            <a href="{{ route('admin.county.index') }}" class="kb2-link {{ $segment == 'county' ? 'active' : '' }}"><i class="icon-map"></i>Counties</a>
            <a href="{{ route('admin.city.index') }}" class="kb2-link {{ $segment == 'city' ? 'active' : '' }}"><i class="icon-location-pin"></i>Cities</a>
        </nav>
    </aside>

    <div class="kb2-main">
        <header class="kb2-topbar">
            <div class="d-flex align-items-center" style="gap: 10px;">
                <button type="button" class="kb2-toggle" id="kb2Toggle" aria-label="Toggle navigation">
                    <i class="icon-menu"></i>
                </button>
                <div>
                    <h1 class="kb2-title">Admin Console</h1>
                    <div class="kb2-subtitle">Manage users, listings, packages, and invoices</div>
                </div>
            </div>

            <div class="d-flex align-items-center" style="gap: 10px;">
                <span class="kb2-subtitle">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Logout</button>
                </form>
            </div>
        </header>

        <main class="kb2-content content-body">
            @yield('content')
        </main>

        <footer class="kb2-footer">
            Kingsbridge Admin Panel
        </footer>
    </div>
</div>

<script src="{{ asset('admin/plugins/common/common.min.js') }}"></script>
<script src="{{ asset('admin/js/custom.min.js') }}"></script>
<script src="{{ asset('admin/js/settings.js') }}"></script>
<script src="{{ asset('admin/js/gleek.js') }}"></script>
<script src="{{ asset('admin/js/styleSwitcher.js') }}"></script>
<script src="{{ asset('admin/plugins/tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/tables/js/datatable-init/datatable-basic.min.js') }}"></script>
<script src="{{ asset('admin/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('admin/plugins/sweetalert/js/sweetalert.init.js') }}"></script>

<script>
    (function () {
        var toggle = document.getElementById('kb2Toggle');
        var sidebar = document.getElementById('kb2Sidebar');
        if (!toggle || !sidebar) return;

        toggle.addEventListener('click', function () {
            document.body.classList.toggle('kb2-nav-open');
        });

        document.addEventListener('click', function (event) {
            if (!document.body.classList.contains('kb2-nav-open')) return;
            if (sidebar.contains(event.target) || toggle.contains(event.target)) return;
            document.body.classList.remove('kb2-nav-open');
        });
    })();
</script>

@livewireScripts
@stack('scripts')
</body>
</html>
