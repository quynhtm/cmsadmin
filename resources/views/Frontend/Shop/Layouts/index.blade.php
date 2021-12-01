<!DOCTYPE html>

<html dir="ltr" lang="vi"><!--<![endif]-->
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#FFFFFF">
    {!! \App\Library\AdminFunction\CGlobal::$extraMeta !!}

    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/css.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/owl_002.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/owl.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/base.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/module.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/jquery_002.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/stylesheet_002.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/styles_shop.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/stylesheet.css')}}">

    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/js/jquery.2.1.1.min.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/js/shopcuatui.js')}}"></script>

    {{\App\Library\AdminFunction\CGlobal::$extraHeaderCSS}}
    <script type="text/javascript">
        var WEB_ROOT = "{{url('', array(), Config::get('config.SECURE'))}}";
        var DEVMODE = "{{Config::get('config.DEVMODE')}}";
        var COOKIE_DOMAIN = "{{Config::get('config.DOMAIN_COOKIE_SERVER')}}";
        var IS_DEBUG = "{{\App\Library\AdminFunction\CGlobal::$is_debug}}";
    </script>
    {{\App\Library\AdminFunction\CGlobal::$extraHeaderJS}}

    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/jquery.js')}}"></script>
    <script src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/sdk_002.js')}}" async=""></script>
    <script id="facebook-jssdk" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/sdk.js')}}"></script>
    @if(env('IS_LIVE') == true)
        <meta name="google-site-verification" content="lJpAlY8qAQ365SzwbRN9_UEySpftXGaB4zgKeZgwKyk" />
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-76848213-1', 'auto');
            ga('send', 'pageview');
        </script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        {{--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-76848213-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-76848213-1');
        </script>--}}


        <script rel="nofollow" type="application/ld+json">
		{
		  "@context": "http://schema.org/",
		  "@type": "Review",
		  "itemReviewed": {
			"@type": "Thing",
			"name": "Super Book"
		  },
		  "author": {
			"@type": "Person",
			"name": "Google"
		  },
		  "reviewRating": {
			"@type": "Rating",
			"ratingValue": "9",
			"bestRating": "10"
		  },
		  "publisher": {
			"@type": "Organization",
			"name": "Washington Times"
		  }
		}
		</script>
    @endif
    <script src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/jquery-3.js')}}" async=""></script>
</head>

<body class="common-home">

<div class="hidden-md hidden-lg opacity_menu"></div>
<div class="opacity_filter"></div>

@yield('header')

@yield('content')

<!--Footer--->
@yield('footer')

</body>
</html>
