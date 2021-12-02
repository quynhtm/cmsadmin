<?php $data["title"] = "Trang chủ"; ?>
    <!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        @include('Frontend.Shop.Layouts.meta_file')
    </head>

    <body class="">
        <div id="app" class="uk-height-viewport uk-offcanvas-content uk-overflow-hidden uk-position-relative">
            {{--Header--}}
            @include('Frontend.Shop.Layouts.header')
            {{--Content--}}
            <div class="home__section" uk-height-viewport="offset-top: true;offset-bottom: true">
                @yield('content')
            </div>
        </div>
        {{--Footer--}}
        @include('Frontend.Shop.Layouts.footer')
    </body>
</html>
