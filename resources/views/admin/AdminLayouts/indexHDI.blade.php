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
    <title>{!! CGlobal::$pageAdminTitle !!}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="{!! CGlobal::$pageAdminTitle !!}">
    <meta name="msapplication-tap-highlight" content="no">
    @include('admin.AdminLayouts.component._files_header')
</head>

<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar closed-sidebar" id="app-container">
        {{----Header---}}
        @include('admin.AdminLayouts.component._block_header')

        {{----Setting color site---}}
        @include('admin.AdminLayouts.component._block_support')

        <div class="app-main">
            {{----Menu left---}}
            @include('admin.AdminLayouts.component._block_left')

            {{----Content---}}
            <div class="app-main__outer">
                <div class="app-main__inner">
                <!--Content page-->
                    @yield('content')
                    <div id="loader"><span class="loadingAjax"></span></div>
                </div>
                {{----Footer---}}
                @include('admin.AdminLayouts.component._files_footer')
            </div>
        </div>
        @include('admin.AdminLayouts.component._block_footer')

    </div>
    {{----Modal hiển thị layout site ngoài----}}
    <div class="modal inmodal fade" id="sys_showLayoutSite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLongTitle">An tâm tín dụng</h5>
                </div>
                <div class="modal-body" style="height: 400px; overflow: hidden; overflow-y: auto">
                    <div id="hdi-sdk"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
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

            //var color_header = @if(isset($colorWithTab[$tab_top]['header']))'{{$colorWithTab[$tab_top]['header']}}' @else 'bg-vicious-stance' @endif;
            //$(".switch-header-cs-class").removeClass("active"), $("."+color_header).addClass("active"), $(".app-header").attr("class", "app-header"), $(".app-header").addClass("header-shadow " + color_header +' header-text-light');

            //color menu default
            //var color_menu = @if(isset($colorWithTab[$tab_top]['menu']))'{{$colorWithTab[$tab_top]['menu']}}' @else 'bg-vicious-stance' @endif;
            //$(".switch-sidebar-cs-class").removeClass("active"), $("."+color_menu).addClass("active"), $(".app-sidebar").attr("class", "app-sidebar"), $(".app-sidebar").addClass("sidebar-shadow " + color_menu + ' sidebar-text-light');

            //getIPAddress();
        });
        /*function getIPAddress() {
            $.getJSON("https://jsonip.com?callback=?", function(data) {
                $('#ipaddress').val(data.ip);
                console.log(data.ip);
            });
        };*/

    </script>
<input type="hidden" id="ipaddress" name="ipaddress">
</body>
<foot></foot>
</html>
