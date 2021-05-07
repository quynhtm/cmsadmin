<?php
    use App\Library\AdminFunction\CGlobal;
    $ver = '?ver=' . CGlobal::$css_ver;
?>
<script type="text/javascript">
    var WEB_ROOT = "{{URL::to('/')}}";
</script>

<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/theme/main.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/theme/style.css').$ver}}"/>

<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/swal/latoja.datepicker.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/swal/sweetalert2.min.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/upload/cssUpload.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/jAlert/jquery.alerts.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/chosen/chosen.min.css').$ver}}"/>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/font-awesome/4.2.0/css/font-awesome.min.css').$ver}}"/>

<script type="text/javascript" src="{{URL::asset('assets/backend/theme/assets/scripts/main.js').$ver}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/backend/theme/assets/scripts/jquery-3.2.1.slim.min.js').$ver}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/backend/theme/assets/scripts/popper.min.js').$ver}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/backend/theme/assets/scripts/bootstrap.min.js').$ver}}"></script>

<script src="{{URL::asset('assets/backend/theme/assets/js/jquery-3.1.1.min.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/theme/assets/js/bootstrap.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/theme/assets/js/plugins/jquery-ui/jquery-ui.min.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/theme/assets/js/plugins/chosen/chosen.jquery.js').$ver}}"></script>
<script src="{{URL::asset('assets/backend/theme/assets/js/plugins/toastr/toastr.min.js').$ver}}"></script>

<script src="{{URL::asset('assets/backend/admin/lib/upload/jquery.uploadfile.js').$ver}}"></script>
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


{!!CGlobal::$extraHeaderCSS!!}
{!!CGlobal::$extraHeaderJS!!}