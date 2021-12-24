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
                                                            <img class="uk-responsive-height uk-responsive-width" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img3.png" alt="">
                                                        </div>
                                                        <canvas width="80" height="80"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 quantam__table__title"><a href="">EllaOne Film-Coated tablet Contraception</a></h4>
                                                    <div class="quantam__table__price">30ml</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="quantam__table__price">310.000đ</span></td>
                                <td>
                                    <div class="uk-position-relative uk-display-inline-block">
                                        <a href="javascript: void(0)" class="modal__quickView__btnCount modal__quickView__btnCount--minues"></a>
                                        <a href="javascript: void(0)" class="modal__quickView__btnCount modal__quickView__btnCount--plus"></a>
                                        <input class="uk-input uk-form-width-small modal__quickView__input" type="text" placeholder="" value="1">
                                    </div>
                                </td>
                                <td>
                                    <span class="quantam__table__price quantam__table__price--c1">19.000đ</span>
                                </td>
                            </tr>
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
                                                            <img class="uk-responsive-height uk-responsive-width" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img6.png" alt="">
                                                        </div>
                                                        <canvas width="80" height="80"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 quantam__table__title"><a href="">Ibuprofen 250mg capsules x18</a></h4>
                                                    <div class="quantam__table__price">Bottle</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="quantam__table__price">320.000đ</span></td>
                                <td>
                                    <div class="uk-position-relative uk-display-inline-block">
                                        <a href="javascript: void(0)" class="modal__quickView__btnCount modal__quickView__btnCount--minues"></a>
                                        <a href="javascript: void(0)" class="modal__quickView__btnCount modal__quickView__btnCount--plus"></a>
                                        <input class="uk-input uk-form-width-small modal__quickView__input" type="text" placeholder="" value="1">
                                    </div>
                                </td>
                                <td>
                                    <span class="quantam__table__price quantam__table__price--c1">27.000đ</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="" class="quantam__btnBack uk-button uk-button-default"><span>Tiếp tục mua hàng</span></a>
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
                                        <span class="quantam__table__price">402.000đ</span>
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
                                        <span class="quantam__table__price quantam__table__price--c1 quantam__table__price--c2">402.000đ</span>
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
