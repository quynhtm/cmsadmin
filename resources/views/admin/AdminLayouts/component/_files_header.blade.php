<?php
    use App\Library\AdminFunction\CGlobal;
    $ver = '?ver=' . CGlobal::$css_ver;
    $ver_js = '?ver=' . CGlobal::$js_ver;
?>
<script type="text/javascript">
    var WEB_ROOT = "{{URL::to('/')}}";
</script>

<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/theme/style.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/theme/modify_style.css').$ver}}"/>


<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/swal/latoja.datepicker.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/swal/sweetalert2.min.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/upload/cssUpload.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/jAlert/jquery.alerts.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/chosen/chosen.min.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/font-awesome/4.2.0/css/font-awesome.min.css').$ver}}"/>

<!-- OLD -->
<link rel="stylesheet" href="{{URL::asset('assets/style_pro/vendors/@fortawesome/fontawesome-free/css/all.min.css').$ver}}">
<link rel="stylesheet" href="{{URL::asset('assets/style_pro/vendors/ionicons-npm/css/ionicons.css').$ver}}">
<link rel="stylesheet" href="{{URL::asset('assets/style_pro/vendors/linearicons-master/dist/web-font/style.css').$ver}}">
<link rel="stylesheet" href="{{URL::asset('assets/style_pro/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css').$ver}}">
<link rel="stylesheet" href="{{URL::asset('assets/style_pro/styles/css/base.css').$ver}}" >






<!-- NEW -->
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/jquery/dist/jquery.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/bootstrap/dist/js/bootstrap.bundle.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/moment/moment.js').$ver_js}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/metismenu/dist/metisMenu.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/bootstrap4-toggle/js/bootstrap4-toggle.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/jquery-circle-progress/dist/circle-progress.min.js').$ver_js}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/toastr/build/toastr.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/jquery.fancytree/dist/jquery.fancytree-all-deps.min.js').$ver_js}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/apexcharts/dist/apexcharts.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/bootstrap-table/dist/bootstrap-table.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/datatables.net/js/jquery.dataTables.min.js').$ver_js}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/datatables.net-responsive/js/dataTables.responsive.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js').$ver_js}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/slick-carousel/slick/slick.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/charts/apex-charts.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/circle-progress.js').$ver_js}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/apexcharts/dist/apexcharts.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/select2/dist/js/select2.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/smartwizard/dist/js/jquery.smartWizard.min.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js').$ver_js}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/demo.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/scrollbar.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/toastr.js').$ver_js}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/treeview.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/form-components/toggle-switch.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/tables.js').$ver_js}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/carousel-slider.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/form-components/toggle-switch.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/form-components/input-select.js').$ver_js}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/form-components/form-wizard.js').$ver_js}}"></script>

<script type="text/javascript" src="{{URL::asset('assets/style_pro/js/app.js').$ver_js}}"></script>

<!-- OLD -->
<script src="{{URL::asset('assets/backend/admin/lib/ckeditor/ckeditor.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/admin/lib/swal/sweetalert2.min.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/admin/js/admin.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/admin/js/jqueryCommon.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/admin/js/jqueryHtml.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/admin/js/jquery.validate.min.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/admin/js/additional-methods.min.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/admin/lib/number/autoNumeric.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/admin/lib/highcharts/highcharts.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/admin/lib/highcharts/highcharts-3d.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/admin/lib/highcharts/exporting.js').$ver}}"></script>

<script src="{{URL::asset('assets/backend/theme/assets/js/plugins/chosen/chosen.jquery.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/theme/assets/js/plugins/jquery-ui/jquery-ui.min.js').$ver}}"></script>

{!!CGlobal::$extraHeaderCSS!!}
{!!CGlobal::$extraHeaderJS!!}