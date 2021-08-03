@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenId.provincial.component.formSearch')

    {{--list data---}}
    @include('Systems.OpenId.provincial.component.listData')
@stop
