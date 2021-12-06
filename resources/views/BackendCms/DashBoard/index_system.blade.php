<?php use App\Library\AdminFunction\CGlobal; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\FunctionLib; ?>
@extends('Layouts.AdminCms.indexAdmin')
@section('content')
    <div class="wrapper wrapper-content">
        {{--Lịch công tác--}}
        @include('BackendCms.DashBoard.component.dashBoardCms')
    </div>
@stop
