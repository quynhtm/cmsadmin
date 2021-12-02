@extends('Frontend.Shop.Layouts.index')
@section('content')
    <!--Header banner-->
    @include('Frontend.Shop.Layouts.header_banner')
    <div class="home__section" uk-height-viewport="offset-top: true;offset-bottom: true">
        @include('Frontend.Shop.Layouts.content_web')
    </div>
@stop
