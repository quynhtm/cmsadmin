@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')
    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
    {{--Search---}}
    @include('Sellings.PaymentContract.component.formSearch')

    {{--list data---}}
    @include('Sellings.PaymentContract.component.listData')
    {{ Form::close() }}
@stop
