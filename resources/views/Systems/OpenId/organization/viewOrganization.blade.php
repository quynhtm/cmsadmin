@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenId.organization.component.organization.formSearch')

    {{--list data---}}
    @include('Systems.OpenId.organization.component.organization.listData')
@stop
