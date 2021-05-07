<?php use App\Library\AdminFunction\CGlobal; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\FunctionLib; ?>
@extends('admin.AdminLayouts.indexHDI')
@section('content')
    <div class="wrapper wrapper-content">
        {{--Lịch công tác--}}
        @include('admin.AdminDashBoard.component.dashBoardCms')
    </div>
@stop