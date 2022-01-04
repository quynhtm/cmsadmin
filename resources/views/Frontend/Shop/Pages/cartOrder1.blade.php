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
                        <form class="uk-grid-small uk-grid-30-m" uk-grid method="post" action="{{URL::route('site.indexCartOrder1')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                <div class="uk-grid-small uk-grid-30-m" uk-grid>
                                    <div class="uk-width-1-2 chitiettintuc__boxComment__column">
                                        <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                            <select name="customer_gender" id="customer_gender" required>
                                                {!! $optionGender !!}
                                            </select>
                                            <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                <span></span>
                                                <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2 chitiettintuc__boxComment__column">
                                        <input class="uk-input chitiettintuc__boxComment__input" type="text" required placeholder="Người nhận *" name="customer_name" id="customer_name" @if(isset($cartCustomer['customer_name'])) value="{{$cartCustomer['customer_name']}}" @endif>
                                    </div>
                                    <div class="uk-width-1-1 chitiettintuc__boxComment__column" >
                                        <input class="uk-input chitiettintuc__boxComment__input" type="text" required name="customer_address" id="customer_address" @if(isset($cartCustomer['customer_address'])) value="{{$cartCustomer['customer_address']}}" @endif placeholder="Số nhà, ngõ/ ngách, đường (địa chỉ giao hàng) *">
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                <div class="uk-grid-small uk-grid-30-m" uk-grid>
                                    <div class="uk-width-1-2 chitiettintuc__boxComment__column">
                                        <input class="uk-input chitiettintuc__boxComment__input" type="text" required placeholder="Số điện thoại *" name="customer_phone" id="customer_phone" @if(isset($cartCustomer['customer_phone'])) value="{{$cartCustomer['customer_phone']}}" @endif>
                                    </div>
                                    <div class="uk-width-1-2 chitiettintuc__boxComment__column">
                                        <input class="uk-input chitiettintuc__boxComment__input" type="text" required placeholder="Email *" name="customer_email" id="customer_email" @if(isset($cartCustomer['customer_email'])) value="{{$cartCustomer['customer_email']}}" @endif>
                                    </div>
                                    <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                        <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                            <select name="customer_wards" id="customer_wards" required>
                                                {!! $optionWards !!}
                                            </select>
                                            <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                <span></span>
                                                <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                        <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                            <select name="customer_district" id="customer_district" required>
                                                {!! $optionDistrict !!}
                                            </select>
                                            <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                <span></span>
                                                <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                        <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                            <select name="customer_province" id="customer_province" required>
                                                {!! $optionProvince !!}
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
                                <button type="submit" class="uk-button uk-button-default chitiettintuc__boxComment__btn"><span>Tiếp tục</span></button>
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
