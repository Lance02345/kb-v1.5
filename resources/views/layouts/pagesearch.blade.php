<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- SITE TITTLE -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KingsBridge</title>
    
    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <!-- PLUGINS CSS STYLE -->
    <!-- <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"> -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap-slider.css')}}">
    <!-- Font Awesome -->

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick/slick.css')}}" >
    <link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick/slick-theme.css')}}" >
    <!-- Fancy Box -->
    <link rel="stylesheet"  href="{{ asset('plugins/fancybox/jquery.fancybox.pack.css')}}" >
    <link rel="stylesheet" href="{{ asset('plugins/jquery-nice-select/css/nice-select.css')}}" >
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css')}}" >
    <link rel="stylesheet"  href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')}}" >

  
  
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  
  </head>
  
  <body class="body-wrapper">
  
  
  <section class="nav-bg">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
            <a class="navbar-brand" href="/"><img src="images/king2.png" 
            style=" width:55px; height:50px;vertical-align: middle;padding-left: 0px;padding-right: 0px; padding-top: 0px; border-style: none; " >Kings<span>bridge</span></a>
  
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
             aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
  
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto main-nav ">
                <li class="nav-item active">
                  <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item dropdown dropdown-slide">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="">Dashboard<span><i class="fa fa-angle-down"></i></span>
                  </a>
  
                  <!-- Dropdown list -->
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a>
                    <a class="dropdown-item" href="{{route('dashboard_my_ads')}}">Dashboard My Ads</a>
                    <a class="dropdown-item" href="{{route('dashboard_favourite_ads')}}">Dashboard Favourite Ads</a>
                    <a class="dropdown-item" href="{{route('dashboard_archived_ads')}}">Dashboard Archived Ads</a>
                    <a class="dropdown-item" href="{{route('dashboard_pending_ads')}}">Dashboard Pending Ads</a>
                  </div>
                </li>
                <li class="nav-item dropdown dropdown-slide">
                  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Pages <span><i class="fa fa-angle-down"></i></span>
                  </a>
                  <!-- Dropdown list -->
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('about_us')}}">About Us</a>
                    <a class="dropdown-item" href="{{ route('contact_us')}}">Contact Us</a>
                    <a class="dropdown-item" href="{{ route('user_profile')}}">User Profile</a>
                    <a class="dropdown-item" href="404.html">404 Page</a>
                    <a class="dropdown-item" href="package.html">Package</a>
                    <a class="dropdown-item" href="{{ route('single')}}">Single Page</a>
                    <a class="dropdown-item" href="store.html">Store Single</a>
                    <a class="dropdown-item" href="single-blog.html">Single Post</a>
                    <a class="dropdown-item" href="blog.html">Blog</a>
  
                  </div>
                </li>
                <li class="nav-item dropdown dropdown-slide">
                  <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Listing <span><i class="fa fa-angle-down"></i></span>
                  </a>
                  <!-- Dropdown list -->
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('category')}}">Ad-Gird View</a>
                    <a class="dropdown-item" href="ad-listing-list.html">Ad-List View</a>
                  </div>
                </li>
              </ul>
              <ul class="navbar-nav ml-auto mt-10">
                <li class="nav-item">
                  <a class="nav-link login-button " href="login.html">Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white add-button" href="ad-listing.html"><i class="fa fa-plus-circle"></i> Add Listing</a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </section>

  
  

 <!--============================
=            Footer            =
=============================-->

<footer class="footer section section-sm">
    <!-- Container Start -->
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-7 offset-md-1 offset-lg-0">
          <!-- About -->
          <div class="block about">
            <!-- footer logo -->
            <a class="navbar-brand" href="/"><img src="images/king2.png" 
            style=" width:55px; height:50px;vertical-align: middle;padding-left: 0px;padding-right: 0px; padding-top: 0px; border-style: none; " >KingsBridge<p>Kingsbridge Properties</p></a>
            <p>The leading online platform that sells both Vehicles and Houses.</p>
          </div>
        </div>
        <!-- Link list -->
        <div class="col-lg-2 offset-lg-1 col-md-3">
          <div class="block">
            <h4>Site Pages</h4>
            <ul>
              <li><a href="#">Boston</a></li>
              <li><a href="#">How It works</a></li>
              <li><a href="#">Deals & Coupons</a></li>
              <li><a href="#">Articls & Tips</a></li>
              <li><a href="terms-condition.html">Terms & Conditions</a></li>
            </ul>
          </div>
        </div>
        <!-- Link list -->
        <div class="col-lg-2 col-md-3 offset-md-1 offset-lg-0">
          <div class="block">
            <h4>Admin Pages</h4>
            <ul>
              <li><a href="category.html">Category</a></li>
              <li><a href="single.html">Single Page</a></li>
              <li><a href="store.html">Store Single</a></li>
              <li><a href="single-blog.html">Single Post</a>
              </li>
              <li><a href="blog.html">Blog</a></li>
  
  
  
            </ul>
          </div>
        </div>
        <!-- Promotion -->
        <div class="col-lg-4 col-md-7">
          <!-- App promotion -->
          <div class="block-2 app-promotion">
            <div class="mobile d-flex">
              <a href="">
                <!-- Icon -->
                <img src="images/footer/phone-icon.png" alt="mobile-icon">
              </a>
              <p>Get the Dealsy Mobile App and Save more</p>
            </div>
            <div class="download-btn d-flex my-3">
              <a href="#"><img src="images/apps/google-play-store.png" class="img-fluid" alt=""></a>
              <a href="#" class=" ml-3"><img src="images/apps/apple-app-store.png" class="img-fluid" alt=""></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container End -->
  </footer>
  <!-- Footer Bottom -->
  <footer class="footer-bottom">
    <!-- Container Start -->
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-12">
          <!-- Copyright -->
          <div class="copyright">
            <p>Copyright © <script>
                var CurrentYear = new Date().getFullYear()
                document.write(CurrentYear)
              </script>. Kingsbridge</p>
          </div>
        </div>
        <div class="col-sm-6 col-12">
          <!-- Social Icons -->
          <ul class="social-media-icons text-right">
            <li><a class="fa fa-facebook" href="#" target="_blank"></a></li>
            <li><a class="fa fa-twitter" href="#" target="_blank"></a></li>
            <li><a class="fa fa-pinterest-p" href="#" target="_blank"></a></li>
            <li><a class="fa fa-vimeo" href=""></a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Container End -->
    <!-- To Top -->
    <div class="top-to">
      <a id="top" class="" href="#"><i class="fa fa-angle-up"></i></a>
    </div>
  </footer>
  
  <!-- JAVASCRIPTS -->
  <script src="{{ asset('plugins/jQuery/jquery.min.js')}}"></script>
  <script src="{{ asset('plugins/bootstrap/js/popper.min.js')}}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap-slider.js')}}"></script>
    <!-- tether js -->
  <script src="{{ asset('plugins/tether/js/tether.min.js')}}"></script>
  <script src="{{ asset('plugins/raty/jquery.raty-fa.js')}}"></script>
  <script src="{{ asset('plugins/slick-carousel/slick/slick.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-nice-select/js/jquery.nice-select.min.js')}}"></script>
  <script src="{{ asset('plugins/fancybox/jquery.fancybox.pack.js')}}"></script>
  <script src="{{ asset('plugins/smoothscroll/SmoothScroll.min.js')}}"></script>
  <!-- google map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
  <script src="{{ asset('plugins/google-map/gmap.js')}}"></script>
  <script src="{{ asset('js/script.js')}}"></script>
  
  </body>
  
  </html>
