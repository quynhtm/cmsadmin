@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')
    {{ Form::open(array('method' => 'GET', 'role'=>'form','id'=>'formSeachIndex')) }}
    {{--list data---}}
    @include('Report.claim.listDataClaim')
    {{ Form::close() }}
@stop
