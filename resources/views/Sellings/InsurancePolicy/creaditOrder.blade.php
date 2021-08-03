@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--layout create---}}
    @include('Sellings.InsurancePolicy.component._detailFormItem')
@stop
