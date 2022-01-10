@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')
    <div class="chitietsanpham__section" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="uk-container">
            <div class="home__item40">
                <div class="footer__center__item24">
                    <div class="uk-grid-small uk-grid-37-m" uk-grid>
                        <div class="uk-width-2-5@m">
                            <div class="uk-position-relative uk-visible-toggle uk-slideshow" tabindex="-1" uk-slideshow="ratio: 1:1;animation: fade;">
                                <div class="uk-position-relative modal__quickView__left__imgFor modal__wishList__item">
                                    <ul class="uk-slideshow-items" style="min-height: 436px;">
                                        @foreach($arrImagProduct as $kim =>$imgp)
                                        <li tabindex="-1">
                                            <div class="">
                                                <img src="{{getLinkImageShow(FOLDER_PRODUCT.'/'.$dataDetail->id,$imgp)}}" alt="{{$dataDetail->product_name}}" uk-cover>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="uk-slider modal__wishList__item" uk-slider="">
                                    <div class="uk-position-relative">
                                        <div class="uk-slider-container">
                                            <ul class="uk-thumbnav uk-slider-items uk-child-width-1-4 uk-child-width-1-4@m uk-child-width-1-5@l uk-grid-small uk-grid-16-m uk-grid" uk-grid="" style="transform: translate3d(-111.875px, 0px, 0px);">
                                                @foreach($arrImagProduct as $kyim =>$imgpr)
                                                    <li uk-slideshow-item="{{$kyim}}" tabindex="-1">
                                                        <div class="uk-cover-container modal__quickView__left__img">
                                                            <img src="{{getLinkImageShow(FOLDER_PRODUCT.'/'.$dataDetail->id,$imgpr)}}" alt="{{$dataDetail->product_name}}" uk-cover>
                                                            <canvas width="200" height="200"></canvas>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="">
                                            <a class="modal__quickView__nav modal__quickView__nav--prev uk-position-center-left uk-position-small uk-icon uk-slidenav-previous uk-slidenav" href="#" uk-slidenav-previous="" uk-slider-item="previous"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline></svg></a>
                                            <a class="modal__quickView__nav modal__quickView__nav--next uk-position-center-right uk-position-small uk-icon uk-slidenav-next uk-slidenav" href="#" uk-slidenav-next="" uk-slider-item="next"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 "></polyline></svg></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-expand">
                            <div class="modal__wishList__item">
                                <div class="uk-child-width-auto uk-grid-small" uk-grid>
                                    <div>
                                        <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                            <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                            <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                            <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                            <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                            <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                            <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="{{$dataDetail->product_rate_star}}%">
                                                <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="modal__quickView__desc">(1 đánh giá)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal__wishList__item">
                                <h1 class="uk-modal-title modal__quickView__title">{{$dataDetail->product_name}}</h1>
                                @if($dataDetail->product_sale == STATUS_INT_MOT)
                                    <div class="modal__quickView__price">{{numberFormat($dataDetail->product_price_sell)}} đ</div>
                                @else
                                    <div class="modal__quickView__price">Liên hệ</div>
                                @endif
                            </div>
                            <div class="modal__wishList__item">
                                <p class="modal__quickView__desc">{!! limit_text_word($dataDetail->product_sort_desc) !!}</p>
                            </div>
                            <div class="modal__wishList__item">
                                <div class="modal__quickView__box1">
                                    <div class="modal__wishList__item">
                                        <div class="uk-child-width-auto uk-grid-small uk-flex-middle" uk-grid>
                                            <div>
                                                <div class="modal__quickView__label">Số lượng:</div>
                                            </div>
                                            <div>
                                                <div class="uk-position-relative">
                                                    <a href="javascript: void(0)" class="modal__quickView__btnCount modal__quickView__btnCount--minues"></a>
                                                    <a href="javascript: void(0)" class="modal__quickView__btnCount modal__quickView__btnCount--plus"></a>
                                                    <input class="uk-input uk-form-width-small modal__quickView__input" type="text" placeholder="" value="1">
                                                </div>
                                            </div>
                                            <div class="">
                                                <button type="button" class="modal__quickView__addCart uk-button uk-button-default uk-border-rounded"><span>Thêm giỏ hàng</span></button>
                                            </div>
                                            <div class="uk-width-auto@s">
                                                <button class="uk-button uk-button-default chitietsanpham__btnwishList"><span class="uk-visible@m">Quan tâm</span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal__wishList__item">
                                        <div class="modal__quickView__label">Thành tiền: <span>{{numberFormat($dataDetail->product_price_sell)}} đ</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal__wishList__item" style="display: none">
                                <h3 class="uk-h3 modal__quickView__titleTag">Tags:</h3>
                                <div class="modal__quickView__boxTag">
                                    <a href="" class="uk-button uk-button-default uk-button-small uk-border-pill">Kem</a>
                                    <a href="" class="uk-button uk-button-default uk-button-small uk-border-pill">Bôi</a>
                                    <a href="" class="uk-button uk-button-default uk-button-small uk-border-pill">Dưỡng da</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer__center__item24">
                    <div class="uk-card chitietsanpham__cardContent">
                        <ul class="uk-margin-remove-bottom chitietsanpham__cardContent__tab" uk-tab="connect: #my-tab">
                            <li class="uk-active"><a href="#">Mô tả</a></li>
                            {{--<li><a href="#">Các thông tin khác</a></li>--}}
                            <li><a href="#">Đánh giá</a></li>
                        </ul>

                        <div class="uk-padding-small uk-card-body chitietsanpham__cardContent__body">
                            <ul class="uk-switcher" id="my-tab">
                                <li>{!! $dataDetail->product_content !!}</li>
                                <li>
                                    <div class="uk-child-width-1-2@m" uk-grid>
                                        @if(!empty($arrCommentProduct))
                                        <div>
                                            <div class="footer__center__item16">
                                                <h3 class="uk-h3 home__header__title">Đánh giá</h3>
                                            </div>

                                            <div class="footer__center__item16">
                                                <div class="uk-grid uk-grid-16" uk-grid="">
                                                    @foreach($arrCommentProduct as $kyc=>$comment)
                                                    <div class="uk-width-1-1">
                                                        <div class="uk-grid uk-grid-16" uk-grid="">
                                                            <div class="uk-width-auto">
                                                                <div class="uk-cover-container uk-border-circle">
                                                                    <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/icons/avatar-boy.png" alt="" uk-cover>
                                                                    <canvas width="36" height="36"></canvas>
                                                                </div>
                                                            </div>
                                                            <div class="uk-width-expand">
                                                                <div class="chitiettintuc__item8">
                                                                    <div class="uk-child-width-auto uk-flex-middle uk-grid-small" uk-grid>
                                                                        <div>
                                                                            <h4 class="uk-h4 chitiettintuc__boxComment__titleName">{{$comment->assessor}}</h4>
                                                                        </div>
                                                                        <div>
                                                                            <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: {{$comment->star_points}}%">
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                    <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="chitiettintuc__item8 chitiettintuc__boxComment__checkTxt">{!! $comment->content !!}</div>
                                                                <div class="chitiettintuc__item8 tintuc__card__desc">{{getDateShow($comment->created_at)}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="uk-width-1-1">
                                                        <div class="uk-grid uk-grid-16" uk-grid="">
                                                            <div class="uk-width-auto">
                                                                <div class="uk-cover-container uk-border-circle">
                                                                    <img hidden src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/lemanhhai_anhthe.jpg" alt="" uk-cover>
                                                                    <canvas width="36" height="36"></canvas>
                                                                </div>
                                                            </div>
                                                            <div class="uk-width-expand">
                                                                <div class="uk-text-center uk-padding-small chitiettintuc__box1">
                                                                    <a href="">Xem thêm</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div>
                                            <div class="footer__center__item16">
                                                <h3 class="uk-h3 home__header__title">Thêm đánh giá</h3>
                                            </div>
                                            <div class="footer__center__item16">
                                                <?php $formIdInput = 'submitCommentProductSite'; ?>
                                                <form class="uk-grid-small uk-grid-30-m" uk-grid id="{{$formIdInput}}" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" id="formId" name="formId" value="{{$formIdInput}}">
                                                    <input type="hidden" id="partner_id" name="partner_id" value="{{$partner_id}}">
                                                    <input type="hidden" id="object_id" name="object_id" value="{{$dataDetail->id}}">
                                                    <input type="hidden" id="object_name" name="object_name" value="{{$dataDetail->product_name}}">
                                                    <input type="hidden" id="actionInputSite" name="actionInputSite" value="inputCommentProductSite">
                                                    <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                        <div class="uk-grid-small uk-child-width-auto uk-flex-middle" uk-grid>
                                                            <div>
                                                                <span class="chitietsanpham__cardContent__body__form__label">Đánh giá</span>
                                                            </div>
                                                            <div>
                                                                <div id="rating">
                                                                    <input type="radio" id="star5" name="star_points" value="100" />
                                                                    <label class = "full" for="star5" title="Awesome - 5 stars"></label>

                                                                    <input type="radio" id="star4" name="star_points" value="80" />
                                                                    <label class = "full" for="star4" title="Pretty good - 4 stars"></label>

                                                                    <input type="radio" id="star3" name="star_points" value="60" />
                                                                    <label class = "full" for="star3" title="Meh - 3 stars"></label>

                                                                    <input type="radio" id="star2" name="star_points" value="40" />
                                                                    <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>

                                                                    <input type="radio" id="star1" name="star_points" value="20" />
                                                                    <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                                </div>
                                                                <div class="uk-clearfix"></div>
                                                                <script>
                                                                    function calcRate(r) {
                                                                        const f = ~~r,//Tương tự Math.floor(r)
                                                                            id = 'star' + f + (r % f ? 'half' : '')
                                                                        id && (document.getElementById(id).checked = !0)
                                                                    }
                                                                </script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                                        <input class="uk-input chitiettintuc__boxComment__input" type="text" name="assessor" maxlength="150" placeholder="Họ tên">
                                                    </div>
                                                    <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                                        <input class="uk-input chitiettintuc__boxComment__input" type="text" name="email" maxlength="150" placeholder="Email">
                                                    </div>
                                                    <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                        <textarea class="uk-textarea chitiettintuc__boxComment__textarea" rows="5" name="content" maxlength="1000" placeholder="Bình luận"></textarea>
                                                    </div>
                                                    <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                        <label class="chitiettintuc__boxComment__label"><input class="uk-checkbox chitiettintuc__boxComment__check" type="checkbox" checked> <span class="chitiettintuc__boxComment__checkTxt">Tôi đồng ý rằng dữ liệu của tôi đã gửi đang được thu thập và lưu trữ. Để biết thêm chi tiết về việc xử lý dữ liệu người dùng, hãy xem Chính sách quyền riêng tư của chúng tôi.</span></label>
                                                    </div>
                                                    <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                        <button onclick="ActionSite.submitFormSite('{{$formIdInput}}','{{$urlPostSite}}','btnSubmitCommentProduct')" id="btnSubmitCommentProduct" type="button" class="uk-button uk-button-default chitiettintuc__boxComment__btn"><span>Đánh giá</span></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-----Sản phẩm liên quan-----}}
            <div class="home__item40">
                <div class="home__header">
                    <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                        <div class="uk-width-expand">
                            <h3 class="uk-h3 home__header__title">Bán chạy</h3>
                        </div>
                        <div class="uk-width-auto">
                            <a href="" class="home__header__link uk-button uk-button-default uk-border-pill"><span>Xem tất cả</span></a>
                        </div>
                    </div>
                </div>
                <div class="uk-child-width-1-2 uk-grid-match uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-5@l uk-grid-small uk-grid-30-m" uk-grid>
                    @if(!empty($arrProductInvolve))
                        @foreach($arrProductInvolve as $k=>$product)
                            @include('Frontend.Shop.Pages._itemProduct')
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
