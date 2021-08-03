@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{ Form::open(array('method' => 'GET', 'role'=>'form','id'=>'formSeachIndex')) }}
    {{--Search---}}
    {{--@include('Sellings.ClaimIndemnify.ClaimVietJet.component.formSearch')--}}

    {{--list data---}}
    @include('Sellings.ClaimIndemnify.ClaimVietJet.component.listData')
    {{ Form::close() }}
@stop
