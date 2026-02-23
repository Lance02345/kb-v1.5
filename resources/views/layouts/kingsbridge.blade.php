<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Kingsbridge Motors Kenya - buy, sell, and discover vehicles, parts, and car events.">
  <meta name="theme-color" content="#0f172a">
  <title>@yield('title', 'Kingsbridge Motors')</title>

  <link href="{{ asset('images/king2.png') }}" rel="shortcut icon" type="image/png">

  <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap-slider.css') }}">
  <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick/slick-theme.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/fancybox/jquery.fancybox.pack.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/jquery-nice-select/css/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
  @php($tailwindCssPath = public_path('css/tailwind.css'))
  @if(file_exists($tailwindCssPath))
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}?v={{ filemtime($tailwindCssPath) }}">
  @else
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
  @endif
  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ @filemtime(public_path('css/style.css')) }}">
  <link rel="stylesheet" href="{{ asset('css/kingsbridge-modern.css') }}?v=20260222i">
  <style>
    body.kb-modern{background:#f3f5f9!important;font-family:"Plus Jakarta Sans",sans-serif!important}
    .kb-nav-shell{position:sticky;top:0;z-index:1000;background:linear-gradient(90deg,#020617,#0f172a)!important}
    .kb-modern .card,.kb-modern .widget,.kb-modern .dashboard-container{background:#fff;border:1px solid #d8e0ea;border-radius:16px;box-shadow:0 16px 40px rgba(15,23,42,.08)}
    .kb-modern .btn-main,.kb-modern .btn-primary,.kb-modern .add-button{background:linear-gradient(120deg,#d4af37,#e4c96a)!important;border-color:#a68014!important;color:#151515!important}
    .kb-modern .form-control{border-radius:12px!important;border:1px solid #d8e0ea!important}
    .kb-modern .footer{background:#0f172a!important}
    .kb-modern .footer .block{background:transparent!important;border:0!important;box-shadow:none!important}
    .kb-modern .footer .block h4,.kb-modern .footer .block p,.kb-modern .footer .block .text{color:#dbe4f4!important}
    .kb-modern .footer .block a{color:#f2d98a!important}
    .kb-modern .footer-bottom{background:#0a1222!important}
    .landing-v2-value-item{background:linear-gradient(180deg,#fff,#f9fbff)!important;color:#1f2937!important;border:1px solid #dfcf96!important;border-radius:14px!important;min-height:138px!important;padding:1.05rem 1rem!important}
    .landing-v2-value-item h4{color:#162033!important}
    .landing-v2-value-item p{color:#5a697f!important;margin:0!important}
    .landing-property-price .badge-sale{background:#d4af37!important;color:#fff!important}
    .landing-property-price .price{background:#aaa9ad!important;color:#2a303b!important}
  </style>
  @livewireStyles
  @stack('styles')
</head>

<body class="body-wrapper kb-modern">
<section class="nav-bg kb-nav-shell">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light" id="ftco-navbar" aria-label="Main navigation">
          <a class="navbar-brand" href="{{ route('index') }}">
            <img src="{{ asset('images/king2.png') }}" alt="Kingsbridge Motors" style="width:55px;height:50px;vertical-align:middle;padding:0;border-style:none;">
            <span style="color:#d4af37">Kings</span><span>bridge motors</span>
          </a>

          <button class="navbar-toggler kb-mobile-toggle" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse kb-mobile-menu" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto main-nav">
              <li class="nav-item {{ request()->routeIs('index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('index') }}">Home</a>
              </li>
              <li class="nav-item {{ request()->routeIs('vehicleslist') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('vehicleslist') }}">Buy a Vehicle</a>
              </li>
              <li class="nav-item {{ request()->routeIs('spareparts') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('spareparts') }}">Vehicle Parts</a>
              </li>
              <li class="nav-item {{ request()->routeIs('carevent') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('carevent') }}">Car Events</a>
              </li>
              <li class="nav-item {{ request()->routeIs('about_us') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('about_us') }}">About Us</a>
              </li>
            </ul>

            <ul class="navbar-nav ml-auto mt-10">
              @guest
                @if (Route::has('signup'))
                  <li class="nav-item">
                    <a class="nav-link login-button" href="{{ route('signup') }}">Sign Up</a>
                  </li>
                @endif

                @if (Route::has('user.login'))
                  <li class="nav-item">
                    <a class="nav-link login-button" href="{{ route('user.login') }}">Login</a>
                  </li>
                @endif
              @else
                <li class="nav-item dropdown dropdown-slide">
                  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('user.my_list') }}">My List</a>
                    <a class="dropdown-item" href="{{ route('user.myspareparts') }}">Spare Parts</a>
                    <a class="dropdown-item" href="{{ route('user.userevent') }}">Events</a>
                    <a class="dropdown-item" href="{{ route('user.invoice.index') }}">Invoices</a>
                    <a class="dropdown-item" href="{{ route('user.user_profile', Auth::user()->id) }}">User Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                  </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white add-button" href="{{ route('user.new_listing') }}">Add Listing</a>
                </li>
              @endguest
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </div>
</section>

<main class="kb-page-content">
  @yield('content')
</main>

<nav class="kb-mobile-cta d-lg-none" aria-label="Quick mobile actions">
  <a href="{{ route('vehicleslist') }}">Browse</a>
  <a href="{{ Auth::check() ? route('user.new_listing') : route('login') }}">Add Listing</a>
</nav>

<footer class="footer section section-sm">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-7 offset-md-1 offset-lg-0">
        <div class="block about">
          <a class="navbar-brand" href="{{ route('index') }}">
            <img src="{{ asset('images/king2.png') }}" alt="Kingsbridge Motors" style="width:55px;height:50px;vertical-align:middle;padding:0;border-style:none;">
            <span style="color:#d4af37">Kings</span><span style="color:#aaa9ad">bridge motors</span>
          </a>
          <p>Kingsbridge Motors Kenya</p>
          <p>The leading online platform for buying and selling vehicles, promoting car events, and supporting garage owners.</p>
          <ul class="ftco-footer-social float-md-left float-lft mt-5 footer-social-links">
            <li class="ftco-animate"><a href="#" aria-label="Twitter">Twitter</a></li>
            <li class="ftco-animate"><a href="#" aria-label="Facebook">Facebook</a></li>
            <li class="ftco-animate"><a href="#" aria-label="Instagram">Instagram</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-2 offset-lg-1 col-md-3">
        <div class="block">
          <h4>Site Pages</h4>
          <ul>
            <li><a href="{{ route('blog') }}">Blog</a></li>
            <li><a href="{{ route('about_us') }}">How It Works</a></li>
            <li><a href="{{ route('package') }}">Packages</a></li>
            <li><a href="{{ route('contact_us') }}">Contact</a></li>
            <li><a href="{{ route('terms_condition') }}">Terms & Conditions</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-2 col-md-3 offset-md-1 offset-lg-0">
        <div class="block">
          <h4>Browse</h4>
          <ul>
            <li><a href="{{ route('vehicleslist') }}">Vehicle Listings</a></li>
            <li><a href="{{ route('spareparts') }}">Spare Parts</a></li>
            <li><a href="{{ route('carevent') }}">Car Events</a></li>
            <li><a href="{{ route('carhirelist') }}">Car Hire</a></li>
            <li><a href="{{ route('index') }}">Home</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 col-md-3 offset-md-1 offset-lg-0">
        <div class="block block-23 mb-3">
          <h4>Have a question?</h4>
          <ul>
            <li><span class="text">Nandi Road, Karen, Nairobi, Kenya</span></li>
            <li><span class="text">+254 703126261</span></li>
            <li><span class="text">info@kingsbridgeke.com</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>

<footer class="footer-bottom">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="copyright">
          <p>Copyright © <script>document.write(new Date().getFullYear());</script>. Kingsbridge Motors</p>
        </div>
      </div>
    </div>
  </div>
  <div class="top-to">
    <a id="top" href="#" aria-label="Back to top">Top</a>
  </div>
</footer>

<script src="{{ asset('plugins/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap-slider.js') }}"></script>
<script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('plugins/tether/js/tether.min.js') }}"></script>
<script src="{{ asset('plugins/raty/jquery.raty-fa.js') }}"></script>
<script src="{{ asset('plugins/slick-carousel/slick/slick.min.js') }}"></script>
<script src="{{ asset('plugins/fancybox/jquery.fancybox.pack.js') }}"></script>
<script src="{{ asset('plugins/smoothscroll/SmoothScroll.min.js') }}"></script>
<script src="{{ asset('plugins/conditional-field/conditional-field.min.js') }}"></script>
<script src="{{ asset('plugins/google-map/gmap.js') }}"></script>
<script src="{{ asset('js/script.js') }}?v={{ @filemtime(public_path('js/script.js')) }}"></script>
@livewireScripts

<script>
  function addCommas(numberText) {
    var x = String(numberText).split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  }

  if (window.jQuery) {
    jQuery('.price').each(function () {
      var self = jQuery(this);
      self.html('<div>' + addCommas(self.text()) + '</div>');
    });

    jQuery('.kb-mobile-menu .nav-link').on('click', function () {
      if (window.innerWidth < 992) {
        jQuery('.kb-mobile-menu').collapse('hide');
      }
    });
  }
</script>
@stack('scripts')
</body>
</html>
