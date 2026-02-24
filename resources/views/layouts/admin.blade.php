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
    <link href="{{ asset('css/admin-modern.css') }}?v={{ @filemtime(public_path('css/admin-modern.css')) }}" rel="stylesheet">

    @livewireStyles
    @stack('styles')
</head>
<body class="kb-modern kb-admin">
@php($segment = Request::segment(2))

<div class="kb-admin-shell">
    <aside class="kb-admin-sidebar" id="kbAdminSidebar">
        <div class="kb-admin-brand">
            <a href="{{ route('admin.dashboard') }}" style="color: inherit; text-decoration:none;">
                <span>KINGS</span>BRIDGE ADMIN
            </a>
        </div>

        <nav class="kb-admin-nav">
            <div class="group-label">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="kb-admin-link {{ !$segment ? 'active' : '' }}"><i class="icon-speedometer"></i>Dashboard</a>

            <div class="group-label">Users & Access</div>
            <a href="{{ route('admin.user.index') }}" class="kb-admin-link {{ $segment == 'user' ? 'active' : '' }}"><i class="icon-user"></i>Users</a>
            <a href="{{ route('admin.role.index') }}" class="kb-admin-link {{ $segment == 'role' ? 'active' : '' }}"><i class="icon-shield"></i>Roles</a>
            <a href="{{ route('admin.permission.index') }}" class="kb-admin-link {{ $segment == 'permission' ? 'active' : '' }}"><i class="icon-key"></i>Permissions</a>

            <div class="group-label">Listings</div>
            <a href="{{ route('admin.listing.index') }}" class="kb-admin-link {{ $segment == 'listing' ? 'active' : '' }}"><i class="icon-note"></i>Listings</a>
            <a href="{{ route('admin.listing.vehicles') }}" class="kb-admin-link {{ request()->routeIs('admin.listing.vehicles') ? 'active' : '' }}"><i class="icon-directions"></i>Vehicles</a>
            <a href="{{ route('admin.listing.carhirelist') }}" class="kb-admin-link {{ request()->routeIs('admin.listing.carhirelist') ? 'active' : '' }}"><i class="icon-calendar"></i>Car Hire</a>

            <div class="group-label">Finance</div>
            <a href="{{ route('admin.invoice.index') }}" class="kb-admin-link {{ $segment == 'invoice' ? 'active' : '' }}"><i class="icon-doc"></i>Invoices</a>
            <a href="{{ route('admin.package.index') }}" class="kb-admin-link {{ $segment == 'package' ? 'active' : '' }}"><i class="icon-diamond"></i>Packages</a>

            <div class="group-label">Catalog</div>
            <a href="{{ route('admin.category.index') }}" class="kb-admin-link {{ $segment == 'category' ? 'active' : '' }}"><i class="icon-layers"></i>Categories</a>
            <a href="{{ route('admin.carmake.index') }}" class="kb-admin-link {{ $segment == 'carmake' ? 'active' : '' }}"><i class="icon-wrench"></i>Car Makes</a>
            <a href="{{ route('admin.carmodel.index') }}" class="kb-admin-link {{ $segment == 'carmodel' ? 'active' : '' }}"><i class="icon-list"></i>Car Models</a>

            <div class="group-label">Locations</div>
            <a href="{{ route('admin.county.index') }}" class="kb-admin-link {{ $segment == 'county' ? 'active' : '' }}"><i class="icon-map"></i>Counties</a>
            <a href="{{ route('admin.city.index') }}" class="kb-admin-link {{ $segment == 'city' ? 'active' : '' }}"><i class="icon-location-pin"></i>Cities</a>
        </nav>
    </aside>

    <div class="kb-admin-main">
        <header class="kb-admin-topbar">
            <div class="d-flex align-items-center" style="gap: 10px;">
                <button type="button" class="kb-admin-toggle" id="kbAdminToggle" aria-label="Toggle navigation">
                    <i class="icon-menu"></i>
                </button>
                <div>
                    <h1 class="kb-admin-title">Admin Console</h1>
                    <div class="kb-admin-subtitle">Manage users, listings, packages, and invoices</div>
                </div>
            </div>

            <div class="d-flex align-items-center" style="gap: 10px;">
                <span class="kb-admin-subtitle">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Logout</button>
                </form>
            </div>
        </header>

        <main class="kb-admin-content content-body">
            @yield('content')
        </main>

        <footer class="kb-admin-footer">
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
        var toggle = document.getElementById('kbAdminToggle');
        var sidebar = document.getElementById('kbAdminSidebar');
        if (!toggle || !sidebar) return;
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('open');
        });
    })();
</script>

@livewireScripts
@stack('scripts')
</body>
</html>
