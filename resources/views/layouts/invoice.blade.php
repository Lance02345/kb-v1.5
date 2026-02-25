<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- SITE TITTLE -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f172a">
    <title>@yield('title', 'KingsBridge')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('watermark/KINGSBRIDGE.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('watermark/KINGSBRIDGE.png') }}">
    <!-- PLUGINS CSS STYLE -->
    <!-- <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"> -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap-slider.css')}}">
    <!-- Font Awesome -->
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css')}}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick/slick.css')}}" >
    <link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick/slick-theme.css')}}" >
    <!-- Fancy Box -->
    <link rel="stylesheet"  href="{{ asset('plugins/fancybox/jquery.fancybox.pack.css')}}" >
 <link rel="stylesheet" href="{{ asset('plugins/jquery-nice-select/css/nice-select.css')}}" > 
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css')}}" >
    <link rel="stylesheet" href="{{ asset('css/kingsbridge-modern.css') }}?v={{ @filemtime(public_path('css/kingsbridge-modern.css')) }}">
    <link rel="stylesheet"  href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')}}" >
    @livewireStyles
    @stack('styles')


  
  
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  
  </head>
  
  <body class="body-wrapper kb-modern">
  

   

  @yield('content')



<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>	
<!-- JAVASCRIPTS -->
<script src="{{ asset('plugins/jQuery/jquery.min.js')}}"></script>
<script src="{{ asset('plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap-slider.js')}}"></script>
  <!-- tether js -->
   <!-- Swiper JS -->
   <script src="js/swiper-bundle.min.js"></script>
<script src="{{ asset('plugins/tether/js/tether.min.js')}}"></script>
<script src="{{ asset('plugins/raty/jquery.raty-fa.js')}}"></script>
<script src="{{ asset('plugins/slick-carousel/slick/slick.min.js')}}"></script>
<script src="{{ asset('https://kit.fontawesome.com/a354c8bd18.js" crossorigin="anonymous"')}}"></script>

<script src="{{ asset('plugins/fancybox/jquery.fancybox.pack.js')}}"></script>
<script src="{{ asset('plugins/smoothscroll/SmoothScroll.min.js')}}"></script>
<script src="{{ asset('plugins/conditional-field/conditional-field.min.js')}}"></script>


  <!-- <script src="{{ asset('plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script> -->
<script src="{{ asset('plugins/google-map/gmap.js')}}"></script>
<script src="{{ asset('js/script.js')}}"></script>
<script src="/path/to/flickity.pkgd.min.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.numberformatter.js"></script>
@livewireScripts
@stack('scripts')



</body>

</html>
