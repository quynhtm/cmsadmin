@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--list data---}}
    @include('Sellings.Vouchers.vouchersGift.component.listDataDetails')
@stop
