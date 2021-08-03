@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{ Form::open(array('method' => 'GET', 'role'=>'form','id'=>'formSeachIndex')) }}
        {{--Search---}}
        @include('Sellings.InsurancePolicy.component.formSearch')

        {{--list data---}}
        @include('Sellings.InsurancePolicy.component.listData')
    {{ Form::close() }}
@stop
