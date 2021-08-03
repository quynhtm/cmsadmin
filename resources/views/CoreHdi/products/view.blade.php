@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('CoreHdi.products.component.formSearch')

    {{--list data---}}
    @include('CoreHdi.products.component.listData')
@stop
