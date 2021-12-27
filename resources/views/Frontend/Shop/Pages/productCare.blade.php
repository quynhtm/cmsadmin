@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')
    <div class="quantam__section" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="uk-container">
            <h1 class="uk-h1 quantam__title">Quan tâm</h1>
            <div class="uk-grid-30-m uk-grid-24" uk-grid>
                <div class="uk-width-expand">
                    <div class="uk-card uk-card-body quantam__card uk-table-responsive">
                        <table class="uk-table uk-table-divider uk-table-middle uk-table-hover quantam__table">
                            <thead>
                            <tr>
                                <th class="uk-table-expand">Sản phẩm</th>
                                <th class="uk-table-shrink">Đơn giá</th>
                                <th class="uk-width-small"></th>
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
                                                            <img class="uk-responsive-height uk-responsive-width" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img6.png" alt="">
                                                        </div>
                                                        <canvas width="80" height="80"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 quantam__table__title"><a href="">Ibuprofen 250mg capsules x18</a></h4>
                                                    <div class="quantam__table__price">30ml</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="quantam__table__price">310.000đ</span></td>
                                <td>
                                    <button type="button" class="modal__quickView__addCart uk-button uk-button-default uk-border-rounded"><span>Thêm giỏ hàng</span></button>
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
                                                            <img class="uk-responsive-height uk-responsive-width" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img4.png" alt="">
                                                        </div>
                                                        <canvas width="80" height="80"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 quantam__table__title"><a href="">Ibuprofen 150mg Capsule</a></h4>
                                                    <div class="quantam__table__price">Bottle</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="quantam__table__price">19.000đ</span></td>
                                <td>
                                    <button type="button" class="modal__quickView__addCart uk-button uk-button-default uk-border-rounded"><span>Thêm giỏ hàng</span></button>
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
                                                            <img class="uk-responsive-height uk-responsive-width" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img9.png" alt="">
                                                        </div>
                                                        <canvas width="80" height="80"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 quantam__table__title"><a href="">Film-coated tablet 250 mg 30 pieces</a></h4>
                                                    <div class="quantam__table__price">30ml</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="quantam__table__price">310.000đ</span></td>
                                <td>
                                    <button type="button" class="modal__quickView__addCart uk-button uk-button-default uk-border-rounded"><span>Thêm giỏ hàng</span></button>
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
                                                            <img class="uk-responsive-height uk-responsive-width" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img7.png" alt="">
                                                        </div>
                                                        <canvas width="80" height="80"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 quantam__table__title"><a href="">VICHY LIFTACTIV Supreme Serum 10 30ML</a></h4>
                                                    <div class="quantam__table__price">Bottle</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="quantam__table__price">19.000đ</span></td>
                                <td>
                                    <button type="button" class="modal__quickView__addCart uk-button uk-button-default uk-border-rounded"><span>Thêm giỏ hàng</span></button>
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
                                                            <img class="uk-responsive-height uk-responsive-width" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img8.png" alt="">
                                                        </div>
                                                        <canvas width="80" height="80"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 quantam__table__title"><a href="">Ibuprofen 500mg Capsule</a></h4>
                                                    <div class="quantam__table__price">30ml</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="quantam__table__price">19.000đ</span></td>
                                <td>
                                    <button type="button" class="modal__quickView__addCart uk-button uk-button-default uk-border-rounded"><span>Thêm giỏ hàng</span></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="{{URL::route('site.home')}}" class="quantam__btnBack uk-button uk-button-default"><span>Tiếp tục mua hàng</span></a>
                </div>
                <div class="uk-width-1-3@m">
                    <div class="home__header">
                        <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                            <div class="uk-width-auto">
                                <h3 class="uk-h3 home__header__title">Nổi bật</h3>
                            </div>
                            <div class="uk-width-expand">

                            </div>
                        </div>
                    </div>
                    <div uk-slider>
                        <div class="uk-position-relative">
                            <div class="uk-slider-container">
                                <ul class="uk-slider-items uk-child-width-1-1">
                                    <li>
                                        <div class="uk-grid-16" uk-grid>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img2.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-transition-fade uk-position-cover home__product__card__stock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div>
                                                                        <a href="#modal-quickView" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>
                                                                        <a href="" class="home__product__card__stock__icon home__product__card__stock__icon--cart uk-border-circle"></a>
                                                                        <a href="#modal-wishList" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--wishList uk-border-circle"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 20%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">Hand Creams for Dry, Sensitive Skin</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__price">320.000đ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img1.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-transition-fade uk-position-cover home__product__card__stock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div>
                                                                        <a href="#modal-quickView" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>
                                                                        <a href="" class="home__product__card__stock__icon home__product__card__stock__icon--cart uk-border-circle"></a>
                                                                        <a href="#modal-wishList" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--wishList uk-border-circle"></a>
                                                                    </div>
                                                                </div>
                                                                <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-warning">Hot</span>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 80%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">Solgar ESTER 250 PLUS Kapsul 500MG A50</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__contact">Liên hệ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img7.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-position-cover home__product__card__outStock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div class="home__product__card__outStock__label uk-border-pill"><span>Hết hàng</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 100%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">VICHY LIFTACTIV Supreme Serum 10 30ML</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__price">310.000đ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="uk-grid-16" uk-grid>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img4.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-position-cover home__product__card__outStock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div class="home__product__card__outStock__label uk-border-pill"><span>Hết hàng</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 100%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">Ibuprofen 150mg Capsule</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__contact">Liên hệ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img9.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-transition-fade uk-position-cover home__product__card__stock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div>
                                                                        <a href="#modal-quickView" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>
                                                                        <a href="" class="home__product__card__stock__icon home__product__card__stock__icon--cart uk-border-circle"></a>
                                                                        <a href="#modal-wishList" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--wishList uk-border-circle"></a>
                                                                    </div>
                                                                </div>

                                                                <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-danger">-10%</span>


                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 100%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">Film-coated tablet 250 mg 30 pieces</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__price">310.000đ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img10.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-position-cover home__product__card__outStock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div class="home__product__card__outStock__label uk-border-pill"><span>Hết hàng</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 80%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">Cetirizine 25mg Film-coated Tablets</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__contact">Liên hệ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="uk-grid-16" uk-grid>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img8.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-position-cover home__product__card__outStock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div class="home__product__card__outStock__label uk-border-pill"><span>Hết hàng</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 60%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">Ibuprofen 500mg Capsule</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__contact">Liên hệ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img5.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-position-cover home__product__card__outStock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div class="home__product__card__outStock__label uk-border-pill"><span>Hết hàng</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 100%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">Bioderma Atoderm Intensive Gel 250ml</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__contact">Liên hệ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img4.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-transition-fade uk-position-cover home__product__card__stock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div>
                                                                        <a href="#modal-quickView" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>
                                                                        <a href="" class="home__product__card__stock__icon home__product__card__stock__icon--cart uk-border-circle"></a>
                                                                        <a href="#modal-wishList" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--wishList uk-border-circle"></a>
                                                                    </div>
                                                                </div>




                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 20%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">Ibuprofen 150mg Capsule</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__contact">Liên hệ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="uk-grid-16" uk-grid>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img8.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-transition-fade uk-position-cover home__product__card__stock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div>
                                                                        <a href="#modal-quickView" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>
                                                                        <a href="" class="home__product__card__stock__icon home__product__card__stock__icon--cart uk-border-circle"></a>
                                                                        <a href="#modal-wishList" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--wishList uk-border-circle"></a>
                                                                    </div>
                                                                </div>

                                                                <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-warning">Hot</span>


                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 60%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">Ibuprofen 500mg Capsule</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__contact">Liên hệ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img7.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-transition-fade uk-position-cover home__product__card__stock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div>
                                                                        <a href="#modal-quickView" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>
                                                                        <a href="" class="home__product__card__stock__icon home__product__card__stock__icon--cart uk-border-circle"></a>
                                                                        <a href="#modal-wishList" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--wishList uk-border-circle"></a>
                                                                    </div>
                                                                </div>

                                                                <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-danger">-10%</span>


                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 80%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">VICHY LIFTACTIV Supreme Serum 10 30ML</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__contact">Liên hệ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <div class="uk-card home__product1__card uk-transition-toggle">
                                                    <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                        <div class="uk-width-2-5" style="width: 46.34%">
                                                            <div class="uk-cover-container">
                                                                <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                    <img class="uk-responsive-width uk-responsive-height" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/spnoibat/img10.png" alt="">
                                                                </div>
                                                                <canvas width="190" height="146"></canvas>
                                                                <div class="uk-transition-fade uk-position-cover home__product__card__stock uk-flex uk-flex-middle uk-flex-center">
                                                                    <div>
                                                                        <a href="#modal-quickView" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>
                                                                        <a href="" class="home__product__card__stock__icon home__product__card__stock__icon--cart uk-border-circle"></a>
                                                                        <a href="#modal-wishList" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--wishList uk-border-circle"></a>
                                                                    </div>
                                                                </div>

                                                                <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-warning">Hot</span>


                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                    <div class="uk-width-1-1 uk-flex-auto">
                                                                        <div>
                                                                            <div class="uk-text-left">
                                                                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 60%">
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <h3 class="uk-h3 home__product__card__title"><a href="">Cetirizine 25mg Film-coated Tablets</a></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-width-1-1">
                                                                        <div class="home__product__card__price">19.000đ</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="uk-position-top-right home__product1__position">
                                <a class="home__product1__nav home__product1__nav--prev" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                                <a class="home__product1__nav home__product1__nav--next" href="#" uk-slidenav-next uk-slider-item="next"></a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
