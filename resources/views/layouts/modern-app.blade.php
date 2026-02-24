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
    <script src="https://cdn.tailwindcss.com"></script>
    @if(request()->boolean('legacy_ui'))
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @endif

    <style>
        body { font-family: Inter, sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        :root { color-scheme: dark; }
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="tel"],
        input[type="url"],
        input[type="password"],
        input[type="date"],
        input[type="time"],
        input[type="search"],
        input[type="file"],
        select,
        textarea {
            background-color: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(51, 65, 85, 1);
            border-radius: 0.75rem;
            color: #e2e8f0;
            width: 100%;
        }
        input::placeholder,
        textarea::placeholder {
            color: #94a3b8;
            opacity: 1;
        }
        input:focus,
        select:focus,
        textarea:focus {
            border-color: rgba(251, 191, 36, 0.75);
            box-shadow: 0 0 0 2px rgba(251, 191, 36, 0.25);
            outline: none;
        }
        select option {
            background-color: #0f172a;
            color: #e2e8f0;
        }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus,
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus {
            -webkit-text-fill-color: #e2e8f0;
            box-shadow: 0 0 0 1000px rgba(15, 23, 42, 0.9) inset;
            transition: background-color 9999s ease-in-out 0s;
        }
        .listing-step-dot {
            align-items: center;
            border-radius: 9999px;
            display: inline-flex;
            font-size: 11px;
            font-weight: 700;
            height: 22px;
            justify-content: center;
            margin-right: 8px;
            width: 22px;
        }
        .listing-step-indicator.completed {
            border-color: rgba(16, 185, 129, 0.45);
            background: rgba(16, 185, 129, 0.12);
            color: #86efac;
        }
        .listing-step-indicator.completed .listing-step-dot {
            background: rgba(16, 185, 129, 0.3);
            color: #dcfce7;
        }
        .listing-step-progress {
            height: 6px;
            width: 100%;
            border-radius: 9999px;
            background: rgba(51, 65, 85, 0.6);
            overflow: hidden;
        }
        .listing-step-progress > span {
            display: block;
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #fbbf24, #34d399);
            transition: width .25s ease;
        }
        .listing-upload-dropzone {
            border: 1px dashed rgba(148, 163, 184, 0.55);
            transition: border-color .2s ease, background-color .2s ease;
        }
        .listing-upload-dropzone.drag-over {
            border-color: rgba(251, 191, 36, 0.95);
            background: rgba(251, 191, 36, 0.08);
        }
        .listing-upload-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }
        .listing-upload-item {
            align-items: center;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(51, 65, 85, 0.95);
            border-radius: 10px;
            display: inline-flex;
            gap: 8px;
            max-width: 260px;
            padding: 6px 8px;
        }
        .listing-upload-item img {
            border-radius: 6px;
            height: 38px;
            object-fit: cover;
            width: 38px;
        }
        .listing-upload-item span {
            color: #cbd5e1;
            display: inline-block;
            font-size: 11px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>

    @livewireStyles
</head>
<body class="min-h-screen bg-[#0b1020] text-slate-100 antialiased {{ request()->boolean('legacy_ui') ? 'kb-modern' : '' }}">
    @yield('content')
    @include('modern._footer')

    @livewireScripts
</body>
</html>
