@extends('Layouts.AdminCms.indexAdmin')
@section('content')
    {{---breadcrumbs---}}
    @include('Layouts.AdminCms.breadcrumbs')
    {{ Form::open(array('method' => 'POST', 'role'=>'form')) }}
        {{ csrf_field() }}

    {{--Search---}}
        @include('Shop.Orders.component.formSearch')

        {{--list data---}}
        @include('Shop.Orders.component.listData')
    {{ Form::close() }}
@stop
