<?php $data["title"] = "Trang chủ"; ?>
<!DOCTYPE html>
<html lang="vi">
{{--<img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/logo_h.png" alt="" >--}}
<head>
    <meta charset="UTF-8">
    @include('Frontend.Shop.Layouts.meta_file')
</head>

<body class="">
    <div id="app" class="uk-height-viewport uk-offcanvas-content uk-overflow-hidden uk-position-relative">
        <!--Header-->
        @include('Frontend.Shop.Layouts.header')
        <!--Content-->
        <div class="home__section" uk-height-viewport="offset-top: true;offset-bottom: true">
            <!--Header banner-->
            @include('Frontend.Shop.Layouts.header_banner')
            @include('Frontend.Shop.Layouts.content_web')
        </div>
    </div>
    @include('Frontend.Shop.Layouts.footer')
</body>
</html>
