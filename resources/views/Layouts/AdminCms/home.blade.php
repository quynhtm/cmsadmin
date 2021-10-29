<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title')</title>
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

  <!-- css include -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
  <link rel="stylesheet" href="{{ asset('css/metisMenu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

  <script type="text/javascript">
      var _token = '{{ csrf_field() }}';
      var _domain = '{{\Illuminate\Support\Facades\URL::route('home.index')}}';
  </script>
</head>

<body>
<!-- body wrap start -->
<div class="body_wrap">
  <!-- backtotop - start -->
  <div id="thetop"></div>
  <div id="backtotop">
    <a href="#" id="scroll"><i class="fal fa-arrow-up"></i><i class="fal fa-arrow-up"></i></a>
  </div>
  <!-- backtotop - end -->

  <!-- start Preloader  -->
  <div class="preloder_part">
    <div class="spinner"><div class="dot1"></div><div class="dot2"></div></div>
  </div>
  <!-- End Preloader  -->

  @widget('header')
  @yield('content')
  @widget('footer')

</div>
<!-- body wrap end -->

<!-- jquery include -->
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/wow.min.js') }}"></script>
<script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
