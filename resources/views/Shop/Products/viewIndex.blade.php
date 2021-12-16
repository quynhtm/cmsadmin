@extends('Layouts.AdminCms.indexAdmin')
@section('content')
    {{---breadcrumbs---}}
    @include('Layouts.AdminCms.breadcrumbs')
    {{ Form::open(array('method' => 'POST', 'role'=>'form')) }}
        {{ csrf_field() }}

    {{--Search---}}
        @include('Shop.PartnerRegistration.component.formSearch')

        {{--list data---}}
        @include('Shop.PartnerRegistration.component.listData')
    {{ Form::close() }}
@stop
