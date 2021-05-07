<?php
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\FunctionLib;
use Illuminate\Support\Facades\Session;
use App\Stringee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>{!! CGlobal::$pageAdminTitle !!}</title>

    <meta name="description" content="overview &amp; stats"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <!-- bootstrap & fontawesome -->
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.min.css')}}"/>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/lib/font-awesome/4.2.0/css/font-awesome.min.css')}}"/>

    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/jquery-ui.min.css')}}"/>
    <!-- text fonts -->
    {{--<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/fonts/fonts.googleapis.com.css')}}" />--}}

    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/chosen.min.css')}}"/>
    <!-- ace styles -->
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/ace.min.css')}}"/>
    <!--[if lte IE 9]>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/ace-part2.min.css')}}"/>
    <![endif]-->

    <!--[if lte IE 9]>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/ace-ie.min.css')}}"/>
    <![endif]-->

    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/admin/css/admin_css.css')}}"/>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/admin/css/adminStyle.css')}}"/>
    <!-- inline styles related to this page -->

    <!--[if !IE]> -->
    <!--jquery-3.2.1.min.js-->
    <script src="{{URL::asset('assets/js/jquery.2.1.1.min.js')}}"></script>

    <!-- ace settings handler -->
    <script src="{{URL::asset('assets/js/ace-extra.min.js')}}"></script>

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
    <link media="all" type="text/css" rel="stylesheet"
          href="{{URL::asset('assets/lib/datetimepicker/datetimepicker.css')}}"/>

    <!--[if lte IE 8]>
    <script src="{{URL::asset('assets/js/html5shiv.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/respond.min.js')}}"></script>
    <![endif]-->
    <script type="text/javascript">
        var WEB_ROOT = "{{URL::to('/')}}";
    </script>
    <!-- basic scripts -->


    <!--[if IE]>
    {{--<script src="{{URL::asset('assets/js/jquery.1.11.1.min.js')}}"></script>--}}
    <![endif]-->

    <script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/ace-elements.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/chosen.jquery.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.ui.touch-punch.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/ace.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/ace-elements.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/moment.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/bootbox.min.js')}}"></script>

    <script src="{{URL::asset('assets/backend/admin/js/admin.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/jquery.elevatezoom.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/number.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/format.js')}}"></script>
    <script src="{{URL::asset('assets/lib/datetimepicker/jquery.datetimepicker.js')}}"></script>

    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/admin/js/hdinsurance/swal/latoja.datepicker.css')}}"/>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/admin/js/hdinsurance/swal/sweetalert2.min.css')}}"/>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/lib/upload/cssUpload.css')}}"/>
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/lib/jAlert/jquery.alerts.css')}}"/>

    <script src="{{URL::asset('assets/lib/upload/jquery.uploadfile.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/baseUpload.js')}}"></script>
    <script src="{{URL::asset('assets/lib/jAlert/jquery.alerts.js')}}"></script>

    {!!CGlobal::$extraHeaderCSS!!}
    {!!CGlobal::$extraHeaderJS!!}

    <script type="text/javascript" src="{{URL::asset('assets/lib/ckeditor/ckeditor.js')}}"></script>
</head>
<body class="no-skin" @if($languageSite == VIETNAM_LANGUAGE) lang="vi" @else lang="en" @endif>
<div id="navbar" class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-container" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="navbar-header pull-left">
            <a href="{{URL::route('admin.dashboard')}}" class="navbar-brand">
                <small class="rlt3" style="text-transform: uppercase;font-size: 14px;">
                    <i class="fa fa-child fa-2x"></i>
                    {{CGlobal::web_name}}
                </small>
            </a>
        </div>
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue" style="display: none">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/icon/vi.png"/>
                        @else
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/icon/en.png"/>
                        @endif
                    </a>
                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close" style="display: none">
                        <li>
                            <a href="{{URL::route('admin.dashboard',array('lang'=>VIETNAM_LANGUAGE))}}">
                                <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/icon/vi.png"/>
                                Viet Nam
                            </a>
                        </li>
                    </ul>
                </li>
                @if(isset($user) && isset($user['user_id']))
                    <li class="light-blue">

                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <span class="user-info">
                            <small>{{viewLanguage('Xin chào')}},</small>
                            @if(isset($user) && isset($user['user_full_name']))
                                {{$user['user_full_name']}}
                                @if($user['user_depart_name'])
                                    || {{$user['user_depart_name']}}
                                @endif
                            @endif
                            @if(isset($user) && isset($user['user_image']) && trim($user['user_image']) != '')
                                <img src="{{getLinkImage(FOLDER_FILE_USER_ADMIN, $user['user_image'])}}" height="40" width="40" style="border-radius: 20px; overflow: hidden;"/>
                            @else
                                <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/icon/avatar-boy.png" height="40" width="40" style="border-radius: 20px; overflow: hidden;"/>
                            @endif
                        </span>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="{{URL::route('admin.user_profile',array('id' => setStrVar($user['user_id'])))}}">
                                    <i class="ace-icon fa fa-user"></i>
                                    {{viewLanguage('Thông tin cá nhân')}}
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{URL::route('admin.logout')}}">
                                    <i class="ace-icon fa fa-power-off"></i>
                                    {{viewLanguage('logout')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="main-container" id="main-container">
    <div id="sidebar" class="sidebar sidebar-fixed sidebar-scroll responsive">
        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <a href="{{URL::route('admin.dashboard')}}" title="Trang chủ"><img width="100%" src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/hdinsurance.png" alt="CMS Admin"/></a>
            </div>
            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                <span class="btn btn-success"></span>
                <span class="btn btn-info"></span>
                <span class="btn btn-warning"></span>
                <span class="btn btn-danger"></span>
            </div>
        </div>
        {{-----Menu Left ----}}
        @include('admin.AdminLayouts.menu_left')
    </div>

    <div class="main-content" style="position: relative">

        <div class="breadcrumbs breadcrumbs-fixed top_nav">
            {{---Menu tab top--}}
            @if($is_dashboard == 1)
                @include('admin.AdminLayouts.menu_top')
            @endif
        </div>

        <div class="content-new" style="margin-top: 0px!important;">
            @if (Session::has('status') && Session::get('status') != '')
                <div class="alert alert-success">
                    {!! Session::get('status') !!} @php Session::forget('status'); @endphp
                </div>
            @endif
            @if (Session::has('status_error') && Session::get('status_error') != '')
                <div class="alert alert-danger">
                    {!! Session::get('status_error') !!} @php Session::forget('status_error'); @endphp
                </div>
            @endif
            @yield('content')
        </div>
        <div id="loadingAjax"><span class="sts"></span></div>
    </div>
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-info">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-300"></i>
    </a>
</div>

{{--MODAL UPLOAD/DOWNLOAD EXCEL--}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{---Popup common--}}
<div class="modal fade" id="sys_showPopupCommon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style="width: 850px">
        <div id="sys_show_infor"></div>
    </div>
</div>

<script>
    try{ace.settings.loadState('sidebar')}catch(e){}
    try {
        ace.settings.check('sidebar', 'collapsed')
    } catch (e) {
    }
    $(document).ready(function() {
        // document is loaded and DOM is ready
        @if(!$is_tech)
            $('.phpdebugbar-minimized').css('display','none');
        @endif
    });
</script>

{!!CGlobal::$extraFooterCSS!!}
{!!CGlobal::$extraFooterJS!!}

</body>
</html>
