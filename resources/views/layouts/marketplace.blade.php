<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Find Your Drive - Vehicle Marketplace')</title>
    <meta name="description" content="@yield('description', 'Browse fresh marketplace inventory across every budget and style.')">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @php($tailwindCssPath = public_path('css/tailwind.css'))
    @if(file_exists($tailwindCssPath))
        <link href="{{ asset('css/tailwind.css') }}?v={{ filemtime($tailwindCssPath) }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    @endif
    <style>
        .mk-icon { width: 1rem; height: 1rem; display: inline-block; flex: none; }
        .mk-icon-sm { width: .875rem; height: .875rem; display: inline-block; flex: none; }
        .mk-icon-lg { width: 3rem; height: 3rem; display: inline-block; flex: none; }
    </style>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-[#0c0f14] text-gray-100" style="font-family: Inter, sans-serif;">
    @yield('content')
    @include('partials.geolocation-script')
</body>
</html>
