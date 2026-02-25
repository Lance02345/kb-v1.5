
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-color" content="#0f172a">
    <title>@yield('title', 'Kingsbrige Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" href="{{ asset('watermark/KINGSBRIDGE.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('watermark/KINGSBRIDGE.png') }}">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="{{ asset('admin/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('css/kingsbridge-modern.css') }}?v={{ @filemtime(public_path('css/kingsbridge-modern.css')) }}" rel="stylesheet">
    @livewireStyles
    @stack('styles')
    
</head>

<body class="h-100 kb-modern">
    
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    @yield('content')
    
  
    

    


    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('admin/plugins/common/common.min.js')}}"></script>
    <script src="{{ asset('admin/js/custom.min.js')}}"></script>
    <script src="{{ asset('admin/js/settings.js')}}"></script>
    <script src="{{ asset('admin/js/gleek.js')}}"></script>
    <script src="{{ asset('admin/js/styleSwitcher.js')}}"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>


