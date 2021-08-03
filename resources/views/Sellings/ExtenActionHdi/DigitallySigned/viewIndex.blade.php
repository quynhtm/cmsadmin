@extends('admin.AdminLayouts.indexHDI')
@section('content')

    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

        {{--Search---}}
     @include('Sellings.ExtenActionHdi.DigitallySigned.component.formDigitallySigned')
    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
        {{--list data---}}
        @include('Sellings.ExtenActionHdi.DigitallySigned.component.listDigitallySigned')
    {{ Form::close() }}
@stop
