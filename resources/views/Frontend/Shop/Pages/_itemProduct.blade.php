
<div class="home__product__column">
    <div class="uk-card home__product__card uk-transition-toggle">
        <div class="uk-grid-match uk-grid-collapse uk-height-1-1 uk-flex-column" uk-grid>
            <div class="uk-width-1-1">
                <div class="uk-cover-container home__product__card__cover">
                    <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                        <img class="uk-responsive-height uk-responsive-width" src="{{getLinkImageShow(FOLDER_PRODUCT.'/'.$product->id,$product->product_image)}}" alt="{{$product->product_name}}">
                    </div>
                    <canvas width="468" height="360"></canvas>
                    @if($product->product_sale == STATUS_INT_MOT)
                        <div class="uk-transition-fade uk-position-cover home__product__card__stock uk-flex uk-flex-middle uk-flex-center">
                            <div>
                                {{--<a href="#modal-quickView" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>--}}
                                <a href="{{buildLinkDetailProduct($product->id,$product->product_name,$product->category_name)}}" title="{{$product->product_name}}" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>
                                <a href="javascript:void(0)" onclick="ActinSite.addOneProductToCart('{{setStrVar($product->id)}}',1);" class="home__product__card__stock__icon home__product__card__stock__icon--cart uk-border-circle"></a>
                                <a href="#modal-wishList" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--wishList uk-border-circle"></a>
                            </div>
                        </div>
                    @else
                        <div class="uk-position-cover home__product__card__outStock uk-flex uk-flex-middle uk-flex-center">
                            <div class="home__product__card__outStock__label uk-border-pill"><span>Hết hàng</span></div>
                        </div>
                    @endif

                    {{--<span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-success display-none-block">Mới</span>
                    <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-warning display-none-block">Hot</span>
                    <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-danger display-none-block">-20%</span>--}}
                </div>
            </div>
            <div class="uk-width-1-1 uk-flex-auto uk-padding-small">
                <div class="uk-grid-match uk-grid-12 uk-flex-column" uk-grid>
                    <div class="uk-width-1-1 uk-flex-auto">
                        <div>
                            <div class="uk-text-center">
                                <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                    <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                    <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: {{$product->product_rate_star}}%">
                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                        <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                    </div>
                                </div>
                            </div>
                            <h3 class="uk-h3 home__product__card__title"><a href="{{buildLinkDetailProduct($product->id,$product->product_name,$product->category_name)}}" title="{{$product->product_name}}">{{$product->product_name}}</a></h3>
                        </div>
                    </div>
                    <div class="uk-width-1-1">
                        @if($product->product_type_price == STATUS_INT_MOT)
                            <div class="home__product__card__price">{{numberFormat($product->product_price_sell)}} đ</div>
                        @else
                            <div class="home__product__card__contact">Liên hệ</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
