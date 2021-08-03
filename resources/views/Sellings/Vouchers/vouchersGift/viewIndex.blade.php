@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Sellings.Vouchers.vouchersGift.component.formSearch')

    {{--list data---}}
    @include('Sellings.Vouchers.vouchersGift.component.listData')
@stop
