<!-- header start -->
<header class="header_area">
  <div class="header_top">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <ul class="right">
            <li><a href="#"><i class="ti-facebook"></i></a></li>
            <li><a href="#"><i class="ti-twitter"></i></a></li>
            <li><a href="#"><i class="ti-linkedin"></i></a></li>
            <li><a href="#"><i class="ti-instagram"></i></a></li>
            <li><a href="#"><i class="ti-vimeo-alt"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>


  <div id="sticky-header" class="header_bottom white_bg pl-130 pr-130">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-2 col-lg-2 col-6">
          <div class="logo">
            <a href="{{\Illuminate\Support\Facades\URL::route('home.index')}}">
              <img src="{{ asset('images/buv-logo.png') }}" alt="" class="img-logo">
            </a>
          </div>
        </div>
        <div class="col-xl-6 col-lg-7 d-none d-lg-block">
          <nav class="main_menu">
            <ul>
              <li @if(\App\Library\Funcs::getRouteNameAction() == 'home.index') class="active" @endif><a href="{{\Illuminate\Support\Facades\URL::route('home.index')}}">Home</a></li>
              <li @if(\App\Library\Funcs::getRouteNameAction() == 'career.index') class="active" @endif><a href="{{\Illuminate\Support\Facades\URL::route('career.index')}}" target="_blank">Career Development</a></li>
              <li @if(\App\Library\Funcs::getRouteNameAction() == 'evaluation.index') class="active" @endif><a href="{{\Illuminate\Support\Facades\URL::route('evaluation.index')}}" target="_blank">Internship Evaluation</a></li>
              <li @if(\App\Library\Funcs::getRouteNameAction() == 'booking.index') class="active" @endif><a href="{{\Illuminate\Support\Facades\URL::route('booking.index')}}" target="_blank">Booking</a></li>
            </ul>
          </nav>
        </div>
        <div class="col-xl-4 col-lg-3 col-6">
          <div class="header_right">
            @if(!empty($user))
            <div class="account">
              <a href="account.html">
                <span class="avatar" style="background-image: url('http://localhost:82/uploads/staff_avatar/Nguyen Duc Chung_gx.jpg')"></span>
                <a href="#" class="ml-2"><span>Hello!</span><br>{{ ucfirst(mb_strtolower($user['name'])) }}</a>
              </a>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- header start -->

<!-- slide-bar start -->
<aside class="slide-bar">
  <div class="close-mobile-menu">
    <a href="javascript:void(0);"><i class="ti-close"></i></a>
  </div>

  <!-- side-mobile-menu start -->
  <nav class="side-mobile-menu">
    <div class="header-mobile-search">
      <form role="search" method="get" action="#">
        <input type="text" placeholder="Search Keywords">
        <button type="submit"><i class="ti-search"></i></button>
      </form>
    </div>
    <ul id="mobile-menu-active">
      <li><a href="index-2.html">Home</a></li>
      <li><a href="about.html">About</a></li>
      <li class="dropdown"><a href="#">Pages</a>
        <ul class="sub-menu">
          <li class="dropdown">
            <a href="#">Shop</a>
            <ul class="submenu">
              <li><a href="shop.html">Shop List</a></li>
              <li><a href="shop-details.html">Shop Details</a></li>
              <li><a href="cart.html">Shop Cart</a></li>
              <li><a href="checkout.html">Shop Checkout</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#">Team</a>
            <ul class="submenu">
              <li><a href="team.html">Team</a></li>
              <li><a href="team-details.html">Team Details</a></li>
            </ul>
          </li>
          <li><a href="pricing.html">Pricing</a></li>
          <li><a href="faq.html">FAQ</a></li>
          <li><a href="account.html">Account</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#">Courses</a>
        <ul class="sub-menu">
          <li><a href="courses.html">Courses</a></li>
          <li><a href="course-details.html">Course Details</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#">Blog</a>
        <ul class="sub-menu">
          <li><a href="blog.html">Blog</a></li>
          <li><a href="blog-details.html">Blog Details</a></li>
        </ul>
      </li>
      <li><a href="contact.html">Contact</a></li>
    </ul>
  </nav>
  <!-- side-mobile-menu end -->
</aside>
<div class="body-overlay"></div>
<!-- slide-bar end -->
