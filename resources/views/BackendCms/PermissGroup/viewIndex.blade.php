@extends('Layouts.AdminCms.indexAdmin')
@section('content')
    {{---breadcrumbs---}}
    @include('Layouts.AdminCms.breadcrumbs')
    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
        {{ csrf_field() }}

    {{--Search---}}
        @include('BackendCms.PermissGroup.component.formSearch')

        {{--list data---}}
        @include('BackendCms.PermissGroup.component.listData')
    {{ Form::close() }}
@stop
