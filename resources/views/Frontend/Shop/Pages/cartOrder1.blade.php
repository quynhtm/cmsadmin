@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')
    <div class="dathang__section" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="uk-container">
            <h1 class="uk-h1 quantam__title">Đặt hàng</h1>
            <div class="dathang__box">
                <div class="dathang__box__item">
                    <div class="footer__center__item16">
                        <h3 class="uk-h3 dathang__box__title">1. Người đặt & địa chỉ giao hàng</h3>
                    </div>
                    <div class="footer__center__item16">
                        <form class="uk-grid-small uk-grid-30-m" uk-grid>
                            <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                <div class="uk-grid-small uk-grid-30-m" uk-grid>
                                    <div class="uk-width-1-2 chitiettintuc__boxComment__column">
                                        <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                            <select>
                                                <option value="">Danh xưng *</option>
                                                <option value="1">Ông (Mr.)</option>
                                                <option value="2">Bà (Mrs.)</option>
                                            </select>
                                            <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                <span></span>
                                                <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2 chitiettintuc__boxComment__column">
                                        <input class="uk-input chitiettintuc__boxComment__input" type="text" placeholder="Người nhận *">
                                    </div>
                                    <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                        <input class="uk-input chitiettintuc__boxComment__input" type="text" placeholder="Số nhà, ngõ/ ngách, đường (địa chỉ giao hàng) *">
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                <div class="uk-grid-small uk-grid-30-m" uk-grid>
                                    <div class="uk-width-1-2 chitiettintuc__boxComment__column">
                                        <input class="uk-input chitiettintuc__boxComment__input" type="text" placeholder="Số điện thoại *">
                                    </div>
                                    <div class="uk-width-1-2 chitiettintuc__boxComment__column">
                                        <input class="uk-input chitiettintuc__boxComment__input" type="text" placeholder="Email *">
                                    </div>
                                    <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                        <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                            <select>
                                                <option value="">Phường/Xã *</option>
                                                <option value="1">Ông (Mr.)</option>
                                                <option value="2">Bà (Mrs.)</option>
                                            </select>
                                            <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                <span></span>
                                                <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                        <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                            <select>
                                                <option value="">Quận/ Huyện *</option>
                                                <option value="1">Ông (Mr.)</option>
                                                <option value="2">Bà (Mrs.)</option>
                                            </select>
                                            <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                <span></span>
                                                <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                        <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                            <select>
                                                <option value="">Tỉnh/ Thành phố</option>
                                                <option value="1">Ông (Mr.)</option>
                                                <option value="2">Bà (Mrs.)</option>
                                            </select>
                                            <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                <span></span>
                                                <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                <a href="{{URL::route('site.indexCartOrder2')}}" class="uk-button uk-button-default chitiettintuc__boxComment__btn"><span>Tiếp tục</span></a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="dathang__box__item">
                    <div class="footer__center__item16">
                        <h3 class="uk-h3 dathang__box__title">2. Xác nhận đơn hàng</h3>
                    </div>
                </div>
                <div class="dathang__box__item">
                    <div class="footer__center__item16">
                        <h3 class="uk-h3 dathang__box__title">3. Thanh toán</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
