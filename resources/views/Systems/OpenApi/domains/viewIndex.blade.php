@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenApi.domains.component.formSearch')

    {{--list data---}}
    @include('Systems.OpenApi.domains.component.listData')
@stop
