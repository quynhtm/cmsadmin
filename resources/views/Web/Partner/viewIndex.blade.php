@extends('Layouts.AdminCms.indexAdmin')
@section('content')
    {{---breadcrumbs---}}
    @include('Layouts.AdminCms.breadcrumbs')
    {{ Form::open(array('method' => 'POST', 'role'=>'form')) }}
        {{ csrf_field() }}

    {{--Search---}}
        @include('Web.Partner.component.formSearch')

        {{--list data---}}
        @include('Web.Partner.component.listData')
    {{ Form::close() }}
@stop
