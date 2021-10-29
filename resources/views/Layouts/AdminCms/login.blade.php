<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Login {{\App\Library\AdminFunction\CGlobal::$pageAdminTitle}}</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    @include('admin.AdminLayouts.component._files_header')
    <script type="text/javascript">
        var WEB_ROOT = "<?php echo e(URL::to('/')); ?>";
    </script>
</head>

<body class="body-login">
<div id="loader"><span class="loadingAjax"></span></div>
    @yield('content')
    <script>
        $(document).ready(function() {
            // document is loaded and DOM is ready
            $('.phpdebugbar').css('display','none');
        });
    </script>
</body>
</html>
