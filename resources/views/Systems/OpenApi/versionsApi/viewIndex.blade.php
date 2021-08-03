@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenApi.versionsApi.component.formSearch')

    {{--list data---}}
    @include('Systems.OpenApi.versionsApi.component.listData')
@stop
