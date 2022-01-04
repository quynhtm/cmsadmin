@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')
    <div class="quantam__section giohang__section" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="uk-container">
            <h1 class="uk-h1 quantam__title">Giỏ hàng</h1>
            <div class="uk-grid-30-m uk-grid-24" uk-grid>
                <div class="uk-width-expand">
                    <div class="uk-card uk-card-body quantam__card uk-table-responsive">
                        <table class="uk-table uk-table-divider uk-table-middle uk-table-hover quantam__table">
                            <thead>
                            <tr>
                                <th class="uk-table-expand">Sản phẩm</th>
                                <th class="uk-table-shrink">Đơn giá</th>
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
                                        <div class="uk-flex-middle uk-grid-small uk-grid-24-m" uk-grid>
                                            <div class="uk-width-auto">
                                                <a href="" class="quantam__table__close"></a>
                                            </div>
                                            <div class="uk-width-expand">
                                                <div class="uk-grid-small uk-grid-20-m uk-flex-middle" uk-grid>
                                                    <div class="uk-width-auto">
                                                        <div class="uk-cover-container quantam__table__cover">
                                                            <div class="uk-position-cover">
                                                                <a href="{{buildLinkDetailProduct($pro_cart->product_id,$pro_cart->product_name,$pro_cart->category_name)}}" title="{{$pro_cart->product_name}}" target="_blank">
                                                                    <img class="uk-responsive-height uk-responsive-width" src="{{getLinkImageShow(FOLDER_PRODUCT.'/'.$pro_cart->product_id,$pro_cart->product_image)}}" alt="{{$pro_cart->product_name}}">
                                                                </a>
                                                            </div>
                                                            <canvas width="80" height="80"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-expand">
                                                        <h4 class="uk-h4 quantam__table__title"><a href="{{buildLinkDetailProduct($pro_cart->product_id,$pro_cart->product_name,$pro_cart->category_name)}}" title="{{$pro_cart->product_name}}" target="_blank">{{$pro_cart->product_name}}</a></h4>
                                                        <div class="quantam__table__price">{{$pro_cart->category_name}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="quantam__table__price">{{numberFormat($pro_cart->product_price_sell)}}đ</span></td>
                                    <td>
                                        <div class="uk-position-relative uk-display-inline-block">
                                            <a href="javascript: void(0)" class="modal__quickView__btnCount modal__quickView__btnCount--minues"></a>
                                            <a href="javascript: void(0)" class="modal__quickView__btnCount modal__quickView__btnCount--plus"></a>
                                            <input class="uk-input uk-form-width-small modal__quickView__input" type="text" placeholder="" value="{{$pro_cart->number}}">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="quantam__table__price quantam__table__price--c1">{{numberFormat($price_item)}}đ</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{buildLinkHome()}}" class="quantam__btnBack uk-button uk-button-default"><span>Tiếp tục mua hàng</span></a>
                </div>
                <div class="uk-width-1-4@m">
                    <div class="giohang__card uk-card uk-card-default uk-card-body uk-padding-small">
                        <div class="footer__center__item24">
                            <h2 class="uk-h2 quantam__title">Hoá đơn</h2>
                        </div>
                        <div class="footer__center__item24">
                            <div class="uk-grid-small" uk-grid>
                                <div class="uk-width-expand">
                                    <input class="uk-input modal__wishList__form__input" type="text" placeholder="Số điện thoại *">
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
                                        <span class="quantam__table__price" id="totalMoneyCart1">{{numberFormat($totalMoneyCart)}}đ</span>
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
                                        <span class="quantam__table__price quantam__table__price--c1 quantam__table__price--c2" id="totalMoneyCart2">{{numberFormat($totalMoneyCart)}}đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer__center__item24">
                            <a href="{{URL::route('site.indexCartOrder1')}}" class="uk-button uk-button-default modal__wishList__form__btnSend uk-width-1-1"><span>Tiến hành đặt hàng</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
