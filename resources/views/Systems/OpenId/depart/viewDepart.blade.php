@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {!!Form::open(array('method' => 'POST', 'role'=>'form')) !!}
    {{--Search---}}
    @include('Systems.OpenId.depart.component.formSearch')

    {{--list data---}}
    @include('Systems.OpenId.depart.component.listData')
    {!! Form::close() !!}
@stop

