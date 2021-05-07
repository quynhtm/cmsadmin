<?php use App\Library\AdminFunction\CGlobal; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\FunctionLib; ?>
@extends('admin.AdminLayouts.indexHDI')
@section('content')
    @if(isset($error) && !empty($error))
        <div class="alert alert-danger fade show" role="alert">
            @foreach($error as $itmError)
                <p><b>{{ $itmError }}</b></p>
            @endforeach
        </div>
    @endif

    {{----report--}}
    @include('admin.AdminDashBoard.component.dashBoardSelling')
@stop