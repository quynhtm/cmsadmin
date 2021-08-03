@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{--Search---}}
    @include('Systems.OpenId.calendarWorking.component.formSearch')

    {{--List data--}}
    @include('Systems.OpenId.calendarWorking.component.listData')
@stop

