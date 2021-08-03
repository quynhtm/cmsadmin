@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenApi.databaseConnection.component.formSearch')

    {{--list data---}}
    @include('Systems.OpenApi.databaseConnection.component.listData')
@stop
