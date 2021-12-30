@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')
    <div class="tintuc__section chitiettintuc__section" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="uk-container">
            <div class="home__item40">
                <div class="uk-grid-24 uk-grid-30-m" uk-grid>
                    <div class="uk-width-expand">
                        <div class="chitiettintuc__card uk-card">
                            <div class="uk-cover-container">
                                <img src="{{getLinkImageShow(FOLDER_NEWS.'/'.$dataDetail->id,$dataDetail->news_image)}}" alt="" uk-cover>
                                <canvas width="960" height="541"></canvas>
                            </div>
                            <div class="uk-card-body chitiettintuc__card__body">
                                <div class="footer__center__item24">
                                    <h1 class="uk-h1 chitiettintuc__title">{{$dataDetail->news_title}}</h1>
                                    <div class="home__tintuc__date">{{getDateShow($dataDetail->created_at)}}</div>
                                </div>
                                <article class="chitiettintuc__article uk-article footer__center__item24">
                                    {!! $dataDetail->news_content !!}
                                </article>

                                <div class="footer__center__item24">
                                    <div class="chitiettintuc__boxComment">
                                        <h3 class="uk-h3 home__header__title">Để lại bình luận</h3>
                                        <form class="uk-grid-small uk-grid-30-m" uk-grid>
                                            <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                                <input class="uk-input chitiettintuc__boxComment__input" type="text" placeholder="Họ tên">
                                            </div>
                                            <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                                <input class="uk-input chitiettintuc__boxComment__input" type="text" placeholder="Email">
                                            </div>
                                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                <textarea class="uk-textarea chitiettintuc__boxComment__textarea" rows="3" placeholder="Bình luận"></textarea>
                                            </div>
                                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                <label class="chitiettintuc__boxComment__label"><input class="uk-checkbox chitiettintuc__boxComment__check" type="checkbox" checked> <span class="chitiettintuc__boxComment__checkTxt">Tôi đồng ý rằng dữ liệu của tôi đã gửi đang được thu thập và lưu trữ. Để biết thêm chi tiết về việc xử lý dữ liệu người dùng, hãy xem Chính sách quyền riêng tư của chúng tôi.</span></label>
                                            </div>
                                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                <button type="submit" class="uk-button uk-button-default chitiettintuc__boxComment__btn"><span>Đánh giá</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="footer__center__item24">
                                    <h3 class="uk-h3 home__header__title">Bình luận</h3>
                                    <div class="uk-grid uk-grid-16" uk-grid="">
                                        <div class="uk-width-1-1">
                                            <div class="uk-grid uk-grid-16" uk-grid="">
                                                <div class="uk-width-auto">
                                                    <div class="uk-cover-container uk-border-circle">
                                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/lemanhhai_anhthe.jpg" alt="" uk-cover>
                                                        <canvas width="36" height="36"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 chitiettintuc__item8 chitiettintuc__boxComment__titleName">Trần Văn A</h4>
                                                    <div class="chitiettintuc__item8 chitiettintuc__boxComment__checkTxt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                                    <div class="chitiettintuc__item8 tintuc__card__desc">12 phút trước</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <div class="uk-grid uk-grid-16" uk-grid="">
                                                <div class="uk-width-auto">
                                                    <div class="uk-cover-container uk-border-circle">
                                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/lemanhhai_anhthe.jpg" alt="" uk-cover>
                                                        <canvas width="36" height="36"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 chitiettintuc__item8 chitiettintuc__boxComment__titleName">Trần Văn A</h4>
                                                    <div class="chitiettintuc__item8 chitiettintuc__boxComment__checkTxt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                                    <div class="chitiettintuc__item8 tintuc__card__desc">12 phút trước</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <div class="uk-grid uk-grid-16" uk-grid="">
                                                <div class="uk-width-auto">
                                                    <div class="uk-cover-container uk-border-circle">
                                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/lemanhhai_anhthe.jpg" alt="" uk-cover>
                                                        <canvas width="36" height="36"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 chitiettintuc__item8 chitiettintuc__boxComment__titleName">Trần Văn A</h4>
                                                    <div class="chitiettintuc__item8 chitiettintuc__boxComment__checkTxt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                                    <div class="chitiettintuc__item8 tintuc__card__desc">12 phút trước</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <div class="uk-grid uk-grid-16" uk-grid="">
                                                <div class="uk-width-auto">
                                                    <div class="uk-cover-container uk-border-circle">
                                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/lemanhhai_anhthe.jpg" alt="" uk-cover>
                                                        <canvas width="36" height="36"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 chitiettintuc__item8 chitiettintuc__boxComment__titleName">Trần Văn A</h4>
                                                    <div class="chitiettintuc__item8 chitiettintuc__boxComment__checkTxt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                                    <div class="chitiettintuc__item8 tintuc__card__desc">12 phút trước</div>
                                                </div>
                                            </div>
                                        </div>
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
                        </div>
                    </div>

                    @if(!empty($arrCategoryNews))
                    <div class="uk-width-1-4@m">
                        <div class="uk-card tintuc__asideCard">
                            <div class="tintuc__asideCard__item">
                                <div class="uk-position-relative tintuc__asideCard__search">
                                    <input class="uk-input tintuc__asideCard__search__input" type="text" placeholder="Tìm kiếm">
                                    <button type="button" class="tintuc__asideCard__search__btn uk-button uk-button-default uk-position-right"></button>
                                </div>
                            </div>
                            <div class="tintuc__asideCard__item">
                                <ul class="uk-nav uk-nav-default tintuc__asideCard__nav">
                                    @foreach($arrCategoryNews as $kyc=>$catNew)
                                        <li @if($kyc == 0)class="uk-active"@endif><a href="#">{{$catNew->category_name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <!--Tin tức-->
            @if(!empty($arrNewInvolve))
            <div class="home__item40">
                <div class="home__header">
                    <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                        <div class="uk-width-expand">
                            <h3 class="uk-h3 home__header__title">Tin tức</h3>
                        </div>
                        <div class="uk-width-auto">
                            <a href="" class="home__header__link uk-button uk-button-default uk-border-pill"><span>Xem tất cả</span></a>
                        </div>
                    </div>
                </div>
                <div class="uk-child-width-1-2 uk-child-width-1-4@m uk-grid-16 uk-grid-30-m" uk-grid>
                    @foreach($arrNewInvolve as $kn =>$new)
                        @include('Frontend.Shop.Pages._itemNews')
                    @endforeach
                </div>
            </div>
            @endif
            <!--/Tin tức-->
        </div>
    </div>
@stop
