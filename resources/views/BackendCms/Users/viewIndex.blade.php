@extends('Layouts.AdminCms.indexAdmin')
@section('content')
    {{---breadcrumbs---}}
    @include('Layouts.AdminCms.breadcrumbs')
    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
        {{ csrf_field() }}

    {{--Search---}}
        @include('BackendCms.Users.component.formSearch')

        {{--list data---}}
        `@include('BackendCms.Users.component.listData')
    {{ Form::close() }}
@stop
