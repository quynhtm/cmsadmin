@extends('Layouts.AdminCms.indexAdmin')
@section('content')
    {{---breadcrumbs---}}
    @include('Layouts.AdminCms.breadcrumbs')
    {{ Form::open(array('method' => 'POST', 'role'=>'form', "enctype"=>"multipart/form-data")) }}
        {{ csrf_field() }}

    {{--Search---}}
        @include('Shop.Products.component.formSearch')

        {{--list data---}}
        @include('Shop.Products.component.listData')
    {{ Form::close() }}
@stop
