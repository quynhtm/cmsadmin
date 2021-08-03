@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenId.banks.component.formSearch')

    {{--list data---}}
    @include('Systems.OpenId.banks.component.listData')
@stop
