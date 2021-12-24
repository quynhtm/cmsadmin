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
                        <div class="xacnhandonhang__txt1">Trần Văn A</div>
                        <div class="xacnhandonhang__txt1">Số 102, Hoàng Đạo Thuý, Trung Hoà Nhân Chính, Cầu Giấy, Hà Nội</div>
                    </div>
                    <a href="" class="uk-position-top-right xacnhandonhang__edit">Chỉnh sửa</a>
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
                                        <tr>
                                            <td>
                                                <h4 class="uk-h4 quantam__table__title"><a href="">Hand Creams for Dry, Sensitive Skin</a></h4>
                                                <div class="quantam__table__price">30ml</div>
                                            </td>
                                            <td>
                                                <span class="quantam__table__title">Số lượng: 1</span>
                                            </td>
                                            <td>
                                                <span class="quantam__table__price quantam__table__price--c1">310.000đ</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="uk-h4 quantam__table__title"><a href="">Ibuprofen 500mg Capsule</a></h4>
                                                <div class="quantam__table__price">30ml</div>
                                            </td>
                                            <td>
                                                <span class="quantam__table__title">Số lượng: 1</span>
                                            </td>
                                            <td>
                                                <span class="quantam__table__price quantam__table__price--c1">49.000đ</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="uk-h4 quantam__table__title"><a href="">Cetirizine 25mg Film-coated Tablets</a></h4>
                                                <div class="quantam__table__price">30ml</div>
                                            </td>
                                            <td>
                                                <span class="quantam__table__title">Số lượng: 1</span>
                                            </td>
                                            <td>
                                                <span class="quantam__table__price quantam__table__price--c1">27.000đ</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="uk-h4 quantam__table__title"><a href="">Film-coated tablet 250 mg 30 pieces</a></h4>
                                                <div class="quantam__table__price">Bottle</div>
                                            </td>
                                            <td>
                                                <span class="quantam__table__title">Số lượng: 1</span>
                                            </td>
                                            <td>
                                                <span class="quantam__table__price quantam__table__price--c1">320.000đ</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="uk-h4 quantam__table__title"><a href="">Solgar ESTER 250 PLUS Kapsul 500MG A50</a></h4>
                                                <div class="quantam__table__price">30ml</div>
                                            </td>
                                            <td>
                                                <span class="quantam__table__title">Số lượng: 1</span>
                                            </td>
                                            <td>
                                                <span class="quantam__table__price quantam__table__price--c1">19.000đ</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="uk-h4 quantam__table__title"><a href="">Ibuprofen 150mg Capsule</a></h4>
                                                <div class="quantam__table__price">Bottle</div>
                                            </td>
                                            <td>
                                                <span class="quantam__table__title">Số lượng: 1</span>
                                            </td>
                                            <td>
                                                <span class="quantam__table__price quantam__table__price--c1">32.000đ</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="uk-h4 quantam__table__title"><a href="">Ibuprofen 250mg capsules x18</a></h4>
                                                <div class="quantam__table__price">Bottle</div>
                                            </td>
                                            <td>
                                                <span class="quantam__table__title">Số lượng: 1</span>
                                            </td>
                                            <td>
                                                <span class="quantam__table__price quantam__table__price--c1">49.000đ</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="uk-h4 quantam__table__title"><a href="">EllaOne Film-Coated tablet Contraception</a></h4>
                                                <div class="quantam__table__price">30ml</div>
                                            </td>
                                            <td>
                                                <span class="quantam__table__title">Số lượng: 1</span>
                                            </td>
                                            <td>
                                                <span class="quantam__table__price quantam__table__price--c1">19.000đ</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="uk-h4 quantam__table__title"><a href="">VICHY LIFTACTIV Supreme Serum 10 30ML</a></h4>
                                                <div class="quantam__table__price">30ml</div>
                                            </td>
                                            <td>
                                                <span class="quantam__table__title">Số lượng: 1</span>
                                            </td>
                                            <td>
                                                <span class="quantam__table__price quantam__table__price--c1">32.000đ</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="uk-h4 quantam__table__title"><a href="">Bioderma Atoderm Intensive Gel 250ml</a></h4>
                                                <div class="quantam__table__price">30ml</div>
                                            </td>
                                            <td>
                                                <span class="quantam__table__title">Số lượng: 1</span>
                                            </td>
                                            <td>
                                                <span class="quantam__table__price quantam__table__price--c1">320.000đ</span>
                                            </td>
                                        </tr>
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
                                                <span class="quantam__table__price">402.000đ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="giohang__card__item">
                                        <div class="uk-grid uk-grid-small uk-flex-middle" uk-grid="">
                                            <div class="uk-width-expand">
                                                <span class="quantam__table__title">Phí vận chuyển</span>
                                            </div>
                                            <div class="uk-width-auto">
                                                <span class="quantam__table__price">20.000đ</span>
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
                                                <span class="quantam__table__price quantam__table__price--c1 quantam__table__price--c2">422.000đ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                <a href="{{URL::route('site.indexCartOrder3')}}" class="uk-button uk-button-default chitiettintuc__boxComment__btn"><span>Tiếp tục</span></a>
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
