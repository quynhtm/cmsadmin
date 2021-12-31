@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')

    <div class="catalog__section" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="uk-container">
            @if($pageType == STATUS_INT_MOT)
            <div class="home__item40">
                @if(!empty($arrBannerContent))
                    <div class="uk-child-width-1-4@m uk-grid-small uk-grid-30-m" uk-grid>
                        @foreach($arrBannerContent as $kb=>$banner)
                            @include('Frontend.Shop.Pages._itemBannerContent')
                        @endforeach
                    </div>
                @endif
            </div>
            @endif
            <div class="home__item40">
                <div class="uk-grid-small uk-grid-30-m" uk-grid>
                    <div class="uk-width-1-4@m uk-visible@m">
                        <div class="uk-card uk-card-body catalog__card">
                            @include('Frontend.Shop.Pages.listProductFillter')
                        </div>
                    </div>

                    <div class="uk-width-expand">
                        <div class="uk-flex-middle uk-grid-small catalog__grid" uk-grid>
                            <div class="uk-width-expand">
                                <div class="catalog__txtSearch">@if($total > 0) Hiển thị 12/{{$total}} kết quả @endif</div>
                            </div>
                            <div class="uk-width-auto">
                                <div class="" uk-form-custom="target: > * > span:first-child">
                                    <select>
                                        <option value="">Sắp xếp</option>
                                        <option value="1">Ông (Mr.)</option>
                                        <option value="2">Bà (Mrs.)</option>
                                    </select>
                                    <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                        <span></span>
                                        <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="uk-width-auto uk-hidden@m">
                                <div class="boloc__btnFillter" uk-toggle="target: #offcanvas-flip-boloc"></div>
                            </div>
                        </div>

                        @if(!empty($dataList))
                            <div class="uk-child-width-1-2 uk-grid-match uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-4@l uk-grid-small uk-grid-30-m" uk-grid>
                                @if(!empty($dataList))
                                    @foreach($dataList as $k=>$product)
                                        @include('Frontend.Shop.Pages._itemProduct')
                                    @endforeach
                                @endif
                                <div class="home__product__column uk-width-1-1">
                                    {!! $paging !!}
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="offcanvas-flip-boloc" uk-offcanvas="flip: true; overlay: true">
        <div class="uk-offcanvas-bar">
            <button class="uk-offcanvas-close header__bottom__close header__bottom__close--text" type="button" uk-close></button>
            @include('Frontend.Shop.Pages.listProductFillter')
        </div>
    </div>
@stop

