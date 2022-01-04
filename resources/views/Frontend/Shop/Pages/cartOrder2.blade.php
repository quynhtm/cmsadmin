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
                        <div class="xacnhandonhang__txt1">@if(isset($cartCustomer['customer_name'])) {{$cartCustomer['customer_name']}} @endif</div>
                        <div class="xacnhandonhang__txt1">@if(isset($cartCustomer['customer_address'])) {{$cartCustomer['customer_address']}} @endif</div>
                    </div>
                    <a href="{{URL::route('site.indexCartOrder1')}}" class="uk-position-top-right xacnhandonhang__edit">Chỉnh sửa</a>
                </div>
                <div class="dathang__box__item">
                    <div class="footer__center__item16">
                        <h3 class="uk-h3 dathang__box__title">2. Xác nhận đơn hàng</h3>
                    </div>
                    <div class="footer__center__item16">
                        <div class="uk-grid-small uk-grid-30-m" uk-grid>
                            <div class="uk-width-expand chitiettintuc__boxComment__column">
                                <div class="uk-padding-small xacnhandonhang__box">
                                    <table class="uk-table uk-table-responsive uk-table-divider uk-table-middle uk-table-hover quantam__table">
                                        <thead>
                                        <tr>
                                            <th class="uk-table-expand">Sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?
                                        $totalMoneyCart = 0;
                                        ?>
                                        @foreach($cartShop as $kyc => $pro_cart)
                                            <?
                                            $pro_cart = (object)$pro_cart;
                                            $price_item = $pro_cart->number*$pro_cart->product_price_sell;
                                            $totalMoneyCart = $totalMoneyCart + $price_item;
                                            ?>
                                            <tr>
                                                <td>
                                                    <h4 class="uk-h4 quantam__table__title">
                                                        <a href="{{buildLinkDetailProduct($pro_cart->product_id,$pro_cart->product_name,$pro_cart->category_name)}}" title="{{$pro_cart->product_name}}" target="_blank">
                                                            {{$pro_cart->product_name}}
                                                        </a>
                                                    </h4>
                                                    <div class="quantam__table__price">{{$pro_cart->category_name}}</div>
                                                </td>
                                                <td>
                                                    <span class="quantam__table__title">Số lượng: {{$pro_cart->number}}</span>
                                                </td>
                                                <td>
                                                    <span class="quantam__table__price quantam__table__price--c1">{{numberFormat($price_item)}}đ</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="uk-width-1-3@m chitiettintuc__boxComment__column">
                                <div class="footer__center__item24">
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-expand">
                                            <input class="uk-input modal__wishList__form__input" type="text" placeholder="Mã giảm giá">
                                        </div>
                                        <div class="uk-width-auto">
                                            <button class="uk-button uk-button-default giohang__card__btn"><span>Áp dụng</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer__center__item24">
                                    <div class="giohang__card__item">
                                        <div class="uk-grid uk-grid-small uk-flex-middle" uk-grid="">
                                            <div class="uk-width-expand">
                                                <span class="quantam__table__title">Tạm tính</span>
                                            </div>
                                            <div class="uk-width-auto">
                                                <span class="quantam__table__price">{{numberFormat($totalMoneyCart)}}đ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="giohang__card__item">
                                        <div class="uk-grid uk-grid-small uk-flex-middle" uk-grid="">
                                            <div class="uk-width-expand">
                                                <span class="quantam__table__title">Phí vận chuyển</span>
                                            </div>
                                            <div class="uk-width-auto">
                                                <span class="quantam__table__price">{{numberFormat($priceShip)}}đ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="giohang__card__item">
                                        <div class="uk-grid uk-grid-small uk-flex-middle" uk-grid="">
                                            <div class="uk-width-expand">
                                                <span class="quantam__table__title">Giảm giá</span>
                                            </div>
                                            <div class="uk-width-auto">
                                                <span class="quantam__table__price">-0đ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="giohang__card__item giohang__card__item--divider">
                                        <div class="uk-grid uk-grid-small uk-flex-middle" uk-grid="">
                                            <div class="uk-width-expand">
                                                <span class="quantam__table__title">Tổng tiền</span>
                                            </div>
                                            <div class="uk-width-auto">
                                                <span class="quantam__table__price quantam__table__price--c1 quantam__table__price--c2">{{numberFormat($totalMoneyCart+$priceShip)}}đ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-1 chitiettintuc__boxComment__column marginT20 text-center">
                                        <a href="{{URL::route('site.indexCartOrder3')}}" class="uk-button uk-button-default chitiettintuc__boxComment__btn"><span>Tiếp tục</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
