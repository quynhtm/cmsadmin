@extends('Frontend.Shop.Layouts.index')
@section('content')
    <!--Header banner-->
    @include('Frontend.Shop.Layouts.header_banner')
    <div class="home__section2" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="home__item40">
            <div class="uk-container">
                <!--Nổi bật-->
                <div class="home__item40">
                    <div class="home__header home__header--switch">
                        <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                            <div class="uk-width-auto">
                                <h3 class="uk-h3 home__header__title">Nổi bật</h3>
                            </div>
                            <div class="uk-width-expand">
                                <div class="uk-child-width-auto uk-flex-middle uk-flex-right uk-flex-between@m" uk-grid>
                                    <div>
                                        <a href="" class="home__header__link uk-button uk-button-default uk-border-pill"><span>Xem tất cả</span></a>
                                    </div>
                                    <div class="uk-visible@m">
                                        <ul class="uk-subnav uk-subnav-pill home__header__switch uk-grid-16" uk-grid uk-switcher="connect: .switcher-container">
                                            <li><a href="#">Hãng A</a></li>
                                            <li><a href="#">Hãng B</a></li>
                                            <li><a href="#">Hãng C</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-hidden@m home__header__mbSwitch">
                        <ul class="uk-subnav uk-subnav-pill home__header__switch uk-grid-16" uk-grid uk-switcher="connect: .switcher-container">
                            <li><a href="#">Hãng A</a></li>
                            <li><a href="#">Hãng B</a></li>
                            <li><a href="#">Hãng C</a></li>
                        </ul>
                    </div>
                    <div class="uk-child-width-1-2 uk-grid-match uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-5@l uk-grid-small uk-grid-30-m" uk-grid>
                        @if(!empty($arrProductNew))
                            @foreach($arrProductNew as $k=>$product)
                                @include('Frontend.Shop.Pages._itemProduct')
                            @endforeach
                        @endif
                    </div>
                </div>
                <!--/Nổi bật-->

                <!--banner home-->
                <div class="home__item40">
                    @if(!empty($arrBannerContent))
                        <div class="uk-child-width-1-4@m uk-grid-small uk-grid-30-m" uk-grid>
                            @foreach($arrBannerContent as $kb=>$banner)
                                @include('Frontend.Shop.Pages._itemBannerContent')
                            @endforeach
                        </div>
                    @endif
                </div>
                <!--/banner-->

                <!--bán chạy, mới,khác-->
                <div class="home__item40">
                    <div class="uk-child-width-1-3@m uk-grid-40 uk-grid-30-m" uk-grid>
                        @foreach($arrProductAd as $key =>$inforPro)
                        <div>
                            <div class="home__header">
                                <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                                    <div class="uk-width-auto">
                                        <h3 class="uk-h3 home__header__title">{{$inforPro['title']}}</h3>
                                    </div>
                                    <div class="uk-width-expand"></div>
                                </div>
                            </div>
                            <div uk-slider>
                                <div class="uk-position-relative">
                                    <div class="uk-slider-container">
                                        <ul class="uk-slider-items uk-child-width-1-1">
                                            @for ($i=0;$i<=3;$i++)
                                                <li>
                                                    <div class="uk-grid-16" uk-grid>
                                                        @foreach($inforPro['arrProduct'] as $kpro => $product)
                                                            @if($kpro <= 2)
                                                                @include('Frontend.Shop.Pages._itemProduct2')
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                    <div class="uk-position-top-right home__product1__position">
                                        <a class="home__product1__nav home__product1__nav--prev" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                                        <a class="home__product1__nav home__product1__nav--next" href="#" uk-slidenav-next uk-slider-item="next"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!--/bán chạy, mới,khác-->

                <!--Bạn đang cần tư vấn ?-->
                <div class="home__item40">
                    <div class="uk-card home__tuvan__card uk-card-body uk-background-norepeat uk-background-center-center uk-background-cover" data-src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/bg_tuvan.jpg" uk-img>
                        <div class="uk-grid-16 uk-grid-30-m" uk-grid>
                            <div class="uk-width-2-5@m">
                                <h3 class="uk-h3 home__tuvan__title">Bạn đang cần tư vấn ?</h3>
                                <p class="home__tuvan__desc">Hãy để lại thông tin và đội ngũ CSKH của chúng tôi sẽ liên lạc để hỗ trợ, tư vấn quý khác 1 cách nhiệt tình nhất</p>
                            </div>
                            <div class="uk-width-expand">

                                <?php $form_id_contact = 'submitContactSite'; ?>
                                <form class="uk-grid-16 uk-grid-30-m" uk-grid id="{{$form_id_contact}}" enctype="multipart/form-data">
                                    <input type="hidden" id="formId" name="formId" value="{{$form_id_contact}}">
                                    <input type="hidden" id="partner_id" name="partner_id" value="{{$partner_id}}">
                                    <input type="hidden" id="actionInputSite" name="actionInputSite" value="inputContactSite">
                                    {{ csrf_field() }}
                                    <div class="uk-width-1-2 home__tuvan__column">
                                        <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                            <select name="contact_gender">
                                                {!! $optionGender !!}
                                            </select>
                                            <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                <span></span>
                                                <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2 home__tuvan__column">
                                        <input class="uk-input modal__wishList__form__input" type="text" required name="contact_user_name_send" maxlength="100" placeholder="Họ tên *">
                                    </div>
                                    <div class="uk-width-1-2 home__tuvan__column">
                                        <input class="uk-input modal__wishList__form__input" type="text" name="contact_phone_send" maxlength="15" placeholder="Số điện thoại *">
                                    </div>
                                    <div class="uk-width-1-2 home__tuvan__column">
                                        <input class="uk-input modal__wishList__form__input" type="text" name="contact_email_send" maxlength="150" placeholder="Email">
                                    </div>
                                    <div class="uk-width-1-1 home__tuvan__column">
                                        <textarea class="uk-textarea modal__wishList__form__input" name="contact_content" rows="5" placeholder="Lời nhắn *"></textarea>
                                    </div>
                                    <div class="uk-width-1-2@s home__tuvan__column">
                                        <button onclick="ActionSite.submitFormSite('{{$form_id_contact}}','{{$urlPostSite}}','btnSubmitContact')" id="btnSubmitContact" type="button" class="uk-button uk-button-default modal__wishList__form__btnSend"><span>Gửi</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/Bạn đang cần tư vấn ?-->

                <!--Tin tức-->
                <div class="home__item40">
                    <div class="home__header">
                        <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                            <div class="uk-width-expand">
                                <h3 class="uk-h3 home__header__title">Tin tức</h3>
                            </div>
                            <div class="uk-width-auto">
                                <a href="" class="home__header__link uk-button uk-button-default uk-border-pill"><span>Xem tất cả</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-child-width-1-2 uk-child-width-1-4@m uk-grid-16 uk-grid-30-m" uk-grid>
                        @foreach($arrNewCommon as $kn =>$new)
                            @include('Frontend.Shop.Pages._itemNews')
                        @endforeach
                    </div>
                </div>
                <!--/Tin tức-->

                <!--Thông tin y dược-->
                <div class="home__item40">
                    <div class="home__header">
                        <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                            <div class="uk-width-expand">
                                <h3 class="uk-h3 home__header__title">Thông tin y dược</h3>
                            </div>
                            <div class="uk-width-auto">
                                <a href="" class="home__header__link uk-button uk-button-default uk-border-pill"><span>Xem tất cả</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-child-width-1-2 uk-child-width-1-4@m uk-grid-16 uk-grid-30-m" uk-grid>
                        @foreach($arrNewSite as $ks =>$new)
                            @include('Frontend.Shop.Pages._itemNews')
                        @endforeach
                    </div>
                </div>
                <!--/Thông tin y dược-->
            </div>
        </div>
    </div>
@stop
