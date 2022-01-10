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
                                        <?php $formIdInput = 'submitCommentNewSite'; ?>
                                        <form class="uk-grid-small uk-grid-30-m" uk-grid id="{{$formIdInput}}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="formId" name="formId" value="{{$formIdInput}}">
                                            <input type="hidden" id="partner_id" name="partner_id" value="{{$partner_id}}">
                                            <input type="hidden" id="object_id" name="object_id" value="{{$dataDetail->id}}">
                                            <input type="hidden" id="object_name" name="object_name" value="{{$dataDetail->news_title}}">
                                            <input type="hidden" id="actionInputSite" name="actionInputSite" value="inputCommentNewSite">

                                            <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                                <input class="uk-input chitiettintuc__boxComment__input" type="text" name="assessor" maxlength="150" placeholder="Họ tên">
                                            </div>
                                            <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                                <input class="uk-input chitiettintuc__boxComment__input" type="text" name="email" maxlength="150" placeholder="Email">
                                            </div>
                                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                <textarea class="uk-textarea chitiettintuc__boxComment__textarea" rows="3" name="content" maxlength="1000" placeholder="Bình luận"></textarea>
                                            </div>
                                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                <label class="chitiettintuc__boxComment__label"><input class="uk-checkbox chitiettintuc__boxComment__check" type="checkbox" checked> <span class="chitiettintuc__boxComment__checkTxt">Tôi đồng ý rằng dữ liệu của tôi đã gửi đang được thu thập và lưu trữ. Để biết thêm chi tiết về việc xử lý dữ liệu người dùng, hãy xem Chính sách quyền riêng tư của chúng tôi.</span></label>
                                            </div>
                                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                <button onclick="ActionSite.submitFormSite('{{$formIdInput}}','{{$urlPostSite}}','btnSubmitCommentNew')" id="btnSubmitCommentNew" type="button" class="uk-button uk-button-default chitiettintuc__boxComment__btn"><span>Đánh giá</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{----Bình luận tin---}}
                                @if(!empty($arrCommentNews))
                                    <div class="footer__center__item24">
                                        <h3 class="uk-h3 home__header__title">Bình luận</h3>
                                        <div class="uk-grid uk-grid-16" uk-grid="">
                                            @foreach($arrCommentNews as $kyc=>$comment)
                                                <div class="uk-width-1-1">
                                                    <div class="uk-grid uk-grid-16" uk-grid="">
                                                        <div class="uk-width-auto">
                                                            <div class="uk-cover-container uk-border-circle">
                                                                <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/icons/avatar-boy.png" alt="" uk-cover>
                                                                <canvas width="36" height="36"></canvas>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <h4 class="uk-h4 chitiettintuc__item8 chitiettintuc__boxComment__titleName">{{$comment->assessor}}</h4>
                                                            <div class="chitiettintuc__item8 chitiettintuc__boxComment__checkTxt">{!! $comment->content !!}</div>
                                                            <div class="chitiettintuc__item8 tintuc__card__desc">{{getDateShow($comment->created_at)}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{----tìm kiếm theo danh mục tin tức---}}
                    @if(!empty($arrCategoryNews))
                        @include('Frontend.Shop.Pages._listCateNew')
                    @endif
                </div>
            </div>

            <!--Tin tức liên quan-->
            @if(!empty($arrNewInvolve))
            <div class="home__item40">
                <div class="home__header">
                    <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                        <div class="uk-width-expand">
                            <h3 class="uk-h3 home__header__title">Tin tức</h3>
                        </div>
                        <div class="uk-width-auto">
                            <a href="{{buildLinkNewsWithCategory($dataDetail->news_category)}}" class="home__header__link uk-button uk-button-default uk-border-pill"><span>Xem tất cả</span></a>
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
