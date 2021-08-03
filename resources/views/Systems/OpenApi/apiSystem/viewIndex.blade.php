@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenApi.apiSystem.component.formSearch')

    {{--list data---}}
    @include('Systems.OpenApi.apiSystem.component.listData')
@stop
