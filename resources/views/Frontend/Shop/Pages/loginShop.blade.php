@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')
    <div class="dangnhap__section uk-flex uk-flex-middle uk-background-norepeat uk-background-center-center uk-background-cover" data-src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/health-still-life-with-copy-space1.png" uk-img uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <div uk-grid>
                    <div class="uk-width-1-3@m">
                        <div class="dangnhap__card uk-card uk-card-default uk-card-body">
                            <div class="footer__center__item24">
                                <h1 class="uk-h1 quantam__title uk-margin-remove">Đăng nhập</h1>
                            </div>
                            <div class="footer__center__item24">
                                <div class="footer__center__item16">
                                    <input class="uk-input modal__wishList__form__input" type="tel" placeholder="Số điện thoại">
                                </div>
                                <div class="footer__center__item16">
                                    <input class="uk-input modal__wishList__form__input" type="password" placeholder="Mật khẩu">
                                </div>
                                <div class="footer__center__item16">
                                    <div uk-grid>
                                        <div class="uk-width-expand">
                                            <label class="chitiettintuc__boxComment__label">
                                                <input class="uk-checkbox chitiettintuc__boxComment__check" type="checkbox" checked="">
                                                <span class="chitiettintuc__boxComment__checkTxt">Ghi nhớ tài khoản</span>
                                            </label>
                                        </div>
                                        <div class="uk-width-auto">
                                            <a href="" class="xacnhandonhang__edit">Quên mật khẩu</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer__center__item24">
                                <div class="footer__center__item16">
                                    <button type="button" class="uk-button uk-button-default modal__wishList__form__btnSend uk-width-1-1"><span>Đăng nhập</span></button>
                                </div>
                                <div class="footer__center__item16">
                                    <a href="{{URL::route('site.indexRegistrationShop')}}" class="quantam__btnBack uk-button uk-button-default uk-width-1-1"><span>Đăng ký</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
