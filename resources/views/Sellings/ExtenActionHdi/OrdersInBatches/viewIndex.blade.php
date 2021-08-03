@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Sellings.ExtenActionHdi.OrdersInBatches.component.formSearch')

    {{--list data---}}
    @include('Sellings.ExtenActionHdi.OrdersInBatches.component.listData')

@stop
