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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dathang__box__item">
                    <div class="footer__center__item24">
                        <div class="footer__center__item16">
                            <h3 class="uk-h3 dathang__box__title">3. Thanh toán</h3>
                        </div>
                        <div class="footer__center__item16">
                            <span class="quantam__table__price">Vui lòng chọn phương thức thanh toán</span>
                        </div>
                        <div class="footer__center__item16">
                            <div class="uk-grid-small uk-child-width-1-1 uk-grid">
                                <label><input class="uk-radio thanhtoan__radio" type="radio" name="radio2" checked> <span class="thanhtoan__txt">Thanh toán khi nhận hàng</span></label>
                                <label><input class="uk-radio thanhtoan__radio" type="radio" name="radio2"> <span class="thanhtoan__txt">Thanh toán bằng Thẻ Tín dụng / Ghi nợ</span></label>
                                <label><input class="uk-radio thanhtoan__radio" type="radio" name="radio2"> <span class="thanhtoan__txt">Thanh toán qua mã QR</span></label>
                                <label><input class="uk-radio thanhtoan__radio" type="radio" name="radio2"> <span class="thanhtoan__txt">Thanh toán bằng chuyển khoản bằng VNPay</span></label>
                                <label><input class="uk-radio thanhtoan__radio" type="radio" name="radio2"> <span class="thanhtoan__txt">Thanh toán bằng chuyển khoản qua ngân hàng</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="footer__center__item24">
                        <a href="#modal-order-success" uk-toggle class="uk-button uk-button-default chitiettintuc__boxComment__btn"><span>Đặt hàng</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{---Popup đặt hàng thành công---}}
    <div id="modal-order-success" uk-modal>
        <div class="uk-modal-dialog uk-modal-dialog-s">
            <button class="uk-modal-close-default header__bottom__close" type="button" uk-close></button>
            <div class="uk-modal-header modal__order__header">
                <h2 class="uk-modal-title modal__order__title">Thông báo</h2>
            </div>
            <div class="uk-modal-body modal__order__body uk-text-center">
                <div class="footer__center__item24">
                    <span class="modal__order__iconSuccess"></span>
                </div>
                <div class="footer__center__item24">
                    <div class="footer__center__item16">
                        <div class="modal__order__title1">Đặt hàng thành công</div>
                    </div>
                    <div class="footer__center__item16">
                        <div class="modal__order__txt">Cám ơn quý khách đã tin tưởng sử dụng dịch vụ và sản phẩm của chúng tôi.</div>
                    </div>
                    <div class="footer__center__item16">
                        <a href="{{URL::route('site.home')}}" uk-toggle class="uk-button uk-button-default chitiettintuc__boxComment__btn"><span>Quay lại trang chủ</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
