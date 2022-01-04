<?php $data["title"] = "Trang chủ"; ?>
    <!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        @include('Frontend.Shop.Layouts.meta_file')
    </head>

    <body class="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div id="app" class="uk-height-viewport uk-offcanvas-content uk-overflow-hidden uk-position-relative">
            {{--Header--}}
            @include('Frontend.Shop.Layouts.header')
            {{--Content--}}
            @yield('content')

        </div>
        {{--Footer--}}
        @include('Frontend.Shop.Layouts.footer')
        <script>
            var WEB_ROOT = "{{URL::to('/')}}";
            $(document).ready(function() {
                $('.phpdebugbar-minimized').css('display','none');
            });
        </script>
    </body>
</html>
