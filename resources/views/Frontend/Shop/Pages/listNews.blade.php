@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')

    <div class="home__section paddingTop0" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="tintuc__section" uk-height-viewport="offset-top: true;offset-bottom: true">
            <div class="uk-container">
                <h1 class="uk-h1 tintuc__title">Tin tức</h1>
                <div class="uk-grid-24 uk-grid-30-m" uk-grid>
                    <div class="uk-width-expand">
                        <div class="uk-child-width-1-3@m uk-grid-16 uk-grid-30-m uk-grid-match" uk-grid>
                            @foreach($dataList as $kyn=>$new)
                            <div class="tintuc__column">
                                <div class="uk-card tintuc__card">
                                    <div class="uk-cover-container">
                                        <img src="{{getLinkImageShow(FOLDER_NEWS.'/'.$new->id,$new->news_image)}}" alt="{{$new->news_title}}" uk-cover>
                                        <canvas width="600" height="338"></canvas>
                                    </div>
                                    <div class="uk-card-body tintuc__card__body">
                                        <h3 class="uk-h3 tintuc__card__title"><a href="{{buildLinkDetailNew($new->id,$new->news_title,$new->news_category)}}" title="{{$new->news_title}}">{{$new->news_title}}</a></h3>
                                        <div class="home__tintuc__date">{{getDateShow($new->created_at)}}</div>
                                        <p class="tintuc__card__desc line-clamp-5">{!! limit_text_word($new->news_desc_sort) !!}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{--<div class="tintuc__box1">
                            <ul class="uk-pagination uk-flex-center pagination" uk-margin>
                                <li><a href="#"><span uk-pagination-previous></span></a></li>
                                <li><a href="#">1</a></li>
                                <li class="uk-disabled"><span>...</span></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">6</a></li>
                                <li class="uk-active"><span>7</span></li>
                                <li><a href="#">8</a></li>
                                <li><a href="#"><span uk-pagination-next></span></a></li>
                            </ul>
                        </div>--}}
                    </div>

                    {{----tìm kiếm theo danh mục tin tức---}}
                    @if(!empty($arrCategoryNews))
                        @include('Frontend.Shop.Pages._listCateNew')
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
