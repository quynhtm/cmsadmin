@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenId.userSystem.component.user.formSearch')

    {{--list data---}}
    @include('Systems.OpenId.userSystem.component.user.listData')
@stop
