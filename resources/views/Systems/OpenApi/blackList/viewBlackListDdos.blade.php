@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenApi.blackList.component.formSearchBlackListDdos')

    {{--list data---}}
    @include('Systems.OpenApi.blackList.component.listDataBlackListDdos')
@stop
