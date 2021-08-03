@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')
    {!!Form::open(array('method' => 'POST', 'role'=>'form')) !!}
    {{--Search---}}
    @include('Systems.OpenId.menuGroup.component.formSearch')

    {{--list data---}}
    @include('Systems.OpenId.menuGroup.component.listData')
    {!! Form::close() !!}
@stop
