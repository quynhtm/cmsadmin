@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{ Form::open(array('method' => 'GET', 'role'=>'form','id'=>'formSeachIndex')) }}
    {{--Search---}}
    @include('Sellings.Inspection.MotorVehicleInspection.component.formSearch')

    {{--list data---}}
    @include('Sellings.Inspection.MotorVehicleInspection.component.listData')
    {{ Form::close() }}
@stop
