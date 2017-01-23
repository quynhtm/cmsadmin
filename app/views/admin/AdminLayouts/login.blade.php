<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Login Page - Ace Admin</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    {{ HTML::style('assets/css/bootstrap.min.css'); }}
    {{--<link rel="stylesheet" href="assets/css/bootstrap.min.css" />--}}
    {{ HTML::style('assets/font-awesome/4.2.0/css/font-awesome.min.css'); }}
    {{--<link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />--}}

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    {{ HTML::style('assets/fonts/fonts.googleapis.com.css'); }}
    {{--<link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />--}}

    <!-- ace styles -->
    {{ HTML::style('assets/css/ace.min.css'); }}
    {{--<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />--}}

    <!--[if lte IE 9]>
    {{ HTML::style('assets/css/ace-part2.min.css'); }}
    <![endif]-->

    <!--[if lte IE 9]>
    {{ HTML::style('assets/css/ace-ie.min.css'); }}
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    {{ HTML::script('assets/js/ace-extra.min.js'); }}
    {{--<script src="assets/js/ace-extra.min.js"></script>--}}

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
    {{ HTML::script('assets/js/html5shiv.min.js'); }}
    {{ HTML::script('assets/js/respond.min.js'); }}
    <![endif]-->
</head>

<body class="login-layout">
{{$content}}
</body>
</html>
