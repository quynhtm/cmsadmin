@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')
    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
    {{--Search---}}
    @include('Systems.OpenId.typeDefines.component.formSearch')

    {{--list data---}}
    @include('Systems.OpenId.typeDefines.component.listData')
    {{ Form::close() }}
@stop
