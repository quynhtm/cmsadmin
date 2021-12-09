<!doctype html>
<html lang="en">
<?php
use App\Library\AdminFunction\CGlobal;
$imageDefault = Config::get('config.WEB_ROOT').'assets/backend/img/HDInsurance.png';
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{!! \App\Library\AdminFunction\CGlobal::$pageAdminTitle !!}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="{!! \App\Library\AdminFunction\CGlobal::$pageAdminTitle !!}">
    <meta name="msapplication-tap-highlight" content="no">
    @include('Layouts.AdminCms.component._files_header')
</head>

<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar closed-sidebar" id="app-container">
        {{----Header---}}
        @include('Layouts.AdminCms.component._block_header')

        {{----Setting color site---}}
        @include('Layouts.AdminCms.component._block_support')

        <div class="app-main">
            {{----Menu left---}}
            @include('Layouts.AdminCms.component._block_left')

            {{----Content---}}
            <div class="app-main__outer">
                <div class="app-main__inner">
                <!--Content page-->
                    @yield('content')
                    <div id="loader"><span class="loadingAjax"></span></div>
                </div>
                {{----Footer---}}
                @include('Layouts.AdminCms.component._files_footer')
            </div>
        </div>
        @include('Layouts.AdminCms.component._block_footer')

    </div>

    {{---Popup common--}}
    <div class="modal inmodal fade" id="sys_showPopupCommon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div id="sys_show_infor"></div>
        </div>
    </div>

    <div class="modal fade" id="sys_showPopupCommonSmall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div id="sys_show_infor_small"></div>
        </div>
    </div>
    <script>
        var WEB_ROOT = "{{URL::to('/')}}";
        $(document).ready(function() {
            @if(!$is_tech)
            $('.phpdebugbar-minimized').css('display','none');
            @endif
            //$('#app-container').addClass("closed-sidebar");
        });

    </script>
</body>
</html>
