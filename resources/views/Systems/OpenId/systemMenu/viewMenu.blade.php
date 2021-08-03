@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenId.systemMenu.component.formSearch')

    {{--list data---}}
    @include('Systems.OpenId.systemMenu.component.listData')
@stop
