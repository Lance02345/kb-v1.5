<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-color" content="#0f172a">
    <title>Kingsbridge Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('watermark/KINGSBRIDGE.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('watermark/KINGSBRIDGE.png') }}">

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
    <style>
        /* Fallback styles for kb-admin2 if admin-modern.css is unavailable/cached */
        body.kb-admin2 { background: #0b1020; color: #e5e7eb; margin: 0; }
        .kb2-shell { display: grid; grid-template-columns: 270px minmax(0,1fr); min-height: 100vh; }
        .kb2-sidebar { background: #0b1225; border-right: 1px solid #263248; height: 100vh; overflow-y: auto; -webkit-overflow-scrolling: touch; }
        .kb-admin2 .kb2-sidebar { height: 100vh; overflow-y: auto; -webkit-overflow-scrolling: touch; }
        .kb2-brand { height: 72px; padding: 18px 20px; border-bottom: 1px solid rgba(148,163,184,.15); color: #fff; font-weight: 700; }
        .kb2-brand span { color: #fbbf24; }
        .kb2-nav { padding: 12px; }
        .kb-admin2 .kb2-nav { min-height: calc(100vh - 72px); padding-bottom: 24px; }
        .kb2-group { color: #94a3b8; font-size: 11px; font-weight: 700; letter-spacing: .08em; margin: 14px 8px 8px; text-transform: uppercase; }
        .kb2-link { display: flex; align-items: center; gap: 10px; border: 1px solid transparent; border-radius: 10px; color: #cbd5e1; font-size: 13px; font-weight: 600; margin: 4px 0; padding: 9px 10px; text-decoration: none; }
        .kb2-link:hover { background: rgba(148,163,184,.1); color: #fff; text-decoration: none; }
        .kb2-link.active { background: rgba(251,191,36,.14); border-color: rgba(251,191,36,.45); color: #fde68a; }
        .kb2-main { min-width: 0; }
        .kb2-topbar { position: sticky; top: 0; z-index: 30; background: rgba(8,13,26,.92); border-bottom: 1px solid #263248; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; }
        .kb2-title { margin: 0; font-size: 18px; color: #fff; }
        .kb2-subtitle { color: #94a3b8; font-size: 12px; }
        .kb2-content { padding: 20px; }
        .kb2-footer { border-top: 1px solid #263248; color: #94a3b8; font-size: 12px; padding: 14px 20px; }
        .kb2-toggle { display: none; width: 36px; height: 36px; border: 1px solid #263248; border-radius: 10px; background: #0b1327; color: #e2e8f0; align-items: center; justify-content: center; }
        .kb-admin2 .content-body { margin-left: 0 !important; }
        .kb-admin2 .content-body .container-fluid { padding: 0 !important; }
        .kb-admin2 .card { border: 1px solid #263248; border-radius: 14px; background: #111827; color: #e5e7eb; }
        .kb-admin2 .table { color: #e5e7eb; }
        .kb-admin2 .table td, .kb-admin2 .table th { border-color: rgba(148,163,184,.2); }
        .kb-admin2 .btn-primary { background: #fbbf24; border-color: #f59e0b; color: #111827 !important; font-weight: 700; }
        .kb-admin2 .alert-success { border: 1px solid rgba(16,185,129,.35); background: rgba(16,185,129,.12); color: #d1fae5; }
        @media (max-width: 992px) {
            .kb2-shell { grid-template-columns: 1fr; }
            .kb2-sidebar { position: fixed; inset: 0 auto 0 0; width: 270px; z-index: 50; transform: translateX(-100%); transition: transform .2s ease; overscroll-behavior: contain; }
            .kb-admin2 .kb2-sidebar { height: 100dvh; overflow-y: auto; }
            .kb-admin2 .kb2-nav { min-height: calc(100dvh - 72px); }
            .kb-admin2.kb2-nav-open .kb2-sidebar { transform: translateX(0); }
            .kb2-toggle { display: inline-flex; }
        }
    </style>

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
