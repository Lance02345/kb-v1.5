<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Modern vehicle marketplace')">
    <meta name="theme-color" content="#0b1020">
    <title>@yield('title', 'Kingsbridge Marketplace')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @php($tailwindCssPath = public_path('css/tailwind.css'))
    @if(file_exists($tailwindCssPath))
        <link href="{{ asset('css/tailwind.css') }}?v={{ filemtime($tailwindCssPath) }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    @endif

    <style>
        body { font-family: Inter, sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
    </style>

    @livewireStyles
</head>
<body class="min-h-screen bg-[#0b1020] text-slate-100 antialiased">
    @yield('content')

    @livewireScripts
</body>
</html>
