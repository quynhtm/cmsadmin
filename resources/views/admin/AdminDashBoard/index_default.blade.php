<?php use App\Library\AdminFunction\CGlobal; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\FunctionLib; ?>
@extends('admin.AdminLayouts.indexHDI')
@section('content')

    <div class="wrapper wrapper-content">

        {{--Total report--}}
        @include('admin.AdminDashBoard.component.listCMS')

    </div>
@stop