@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--list data---}}
    @include('Report.orderBuyInsurance.listDataOrderBuyInsurance')
@stop
