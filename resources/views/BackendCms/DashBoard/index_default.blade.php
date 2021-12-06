<?php use App\Library\AdminFunction\CGlobal; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\FunctionLib; ?>
@extends('Layouts.AdminCms.indexAdmin')
@section('content')

    <div class="wrapper wrapper-content">

        {{--Total report--}}
        @include('BackendCms.DashBoard.component.listCMS')

    </div>
@stop
