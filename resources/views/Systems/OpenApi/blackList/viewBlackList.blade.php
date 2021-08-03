@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenApi.blackList.component.formSearchBlackList')

    {{--list data---}}
    @include('Systems.OpenApi.blackList.component.listDataBlackList')
@stop
