<link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/css/css_news.css')}}">
@extends('site.SiteLayouts.index')
@section('content')
    <section class="bread-crumb" style="margin-bottom: 10px!important;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12" >
                    <ul class="breadcrumb">
                        <li class="home">
                            <a href="{{buildLinkHome()}}">
                                <span>Trang chủ</span>
                            </a>
                            <span><i class="fa">/</i></span>
                        </li>
                        <li>
                            <a href="{{\Illuminate\Support\Facades\URL::route('site.indexNew')}}"><span>Tin tức</span></a>
                            <span><i class="fa">/</i></span>
                        </li>
                        @if(isset($inforNew->news_title))
                            <li><strong>{{$inforNew->news_title}}</strong></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <main class="main_content">
        <div class="container">
            <!--block chi tiết tin tưc tin-->
            <section class="block_white d-flex mb20">
                @if(!empty($inforNew))
                    <div class="col620 mr20">
                        <div class="news_focus">
                            <article class="">
                                <a href="{{buildLinkDetailNew($inforNew->news_id, $inforNew->news_title, $inforNew->news_type)}}" class="fbold fs24" title="{{$inforNew->news_title}}">
                                    {{$inforNew->news_title}}
                                </a>
                                <div class="social-buttons">
                                    <a rel="nofollow" target="_blank"  href="https://www.facebook.com/sharer/sharer.php?u={{buildLinkDetailNew($inforNew->news_id, $inforNew->news_title, $inforNew->news_type)}}" title="Chia sẻ lên Facebook">
                                        <img alt="Chia sẻ lên Facebook" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/icon/facebook.png" width="25">
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a rel="nofollow" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&amp;fs=1&amp;to&amp;su=&amp;body={{$inforNew->news_desc_sort}}" title="Chia sẻ lên Gmail">
                                        <img alt="Chia sẻ lên Gmail" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/icon/gmail.png" width="25">
                                    </a>
                                </div>
                                <style type="text/css"> .social-buttons {
                                        display: block;
                                        width: 100%;
                                    }
                                    .social-buttons a {
                                        display: inline-block;
                                        border-radius: 5px;
                                    }
                                </style>

                                <div class="sapo_thumb_news mt20">{!! $inforNew->news_content !!}</div>
                            </article>
                        </div>
                        {{---Tin liên quan----}}
                        @if($dataCenter != null)
                            <div class="col620 mr20">
                                <div class="fs20 fbold mb20 d-flex align-items-center">
                                    <a href="javascript:;" class="cl_blue text-uppercase">Tin mới nhất</a>
                                </div>
                                <ul class="list_news_home list_news_cate d-flex">
                                    @foreach($dataCenter as $key_center=>$new_center)
                                        <?php $url_img_cent = \App\Library\PHPThumb\ThumbImg::getImageThumb(FOLDER_NEWS, $new_center->news_id, $new_center->news_image)?>
                                        <?php $url_detail_center = buildLinkDetailNew($new_center->news_id, $new_center->news_title, $new_center->news_type);?>
                                        <li>
                                            <article class="d-flex">
                                                <div class="thumbblock thumb145x100">
                                                    <a href="{{$url_detail_center}}" class="" title="{{$new_center->news_title}}">
                                                        <img class="" src="{{$url_img_cent}}" width="145" height="100" alt="{{$new_center->news_title}}"/>
                                                    </a>
                                                </div>
                                                <div class="desc_145">
                                                    <h3 class="h_news">
                                                        <a href="{{$url_detail_center}}" class="fbold fs16 max-line-2" title="{{$new_center->news_title}}">
                                                            {{$new_center->news_title}}
                                                        </a>
                                                    </h3>
                                                    <div class="sapo_thumb_news max-line-3  pt1">
                                                        {!! limit_text_word($new_center->news_desc_sort,60) !!}
                                                    </div>
                                                </div>
                                            </article>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
            <!--block top tin-->
                @if($dataTop != null)
                    <div class="col300">
                        <ul class="list_news_home none_bottom block_new_hot">
                            @foreach($dataTop as $key_top=>$new_top)
                                <li>
                                    <article class="d-flex">
                                        <div class="thumbblock thumb145x100">
                                            <?php $url_img_top = \App\Library\PHPThumb\ThumbImg::getImageThumb(FOLDER_NEWS, $new_top->news_id, $new_top->news_image)?>
                                            <?php $url_detail_top = buildLinkDetailNew($new_top->news_id, $new_top->news_title, $new_top->news_type);?>
                                            <a href="{{$url_detail_top}}" class="" title="{{$new_top->news_title}}">
                                                <img class="" src="{{$url_img_top}}" width="145" height="100" alt="{{$new_top->news_title}}"/>
                                            </a>
                                        </div>
                                        <div class="desc_145">
                                            <a href="{{$url_detail_top}}" class="fbold fs16 max-line-4" title="{{$new_top->news_title}}">
                                                {{limit_text_word($new_top->news_title,25)}}
                                            </a>
                                            <div class="desc_left block_new_hot">{!! limit_text_word($new_top->news_desc_sort,60) !!}</div>
                                        </div>
                                    </article>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mb20"  style="padding-top: 15px">
                            {{--TIn tức nôi bật---}}
                            @if($dataLeft != null)
                                <div class="col-lg-6 block_new_hot">
                                    <ul class="list_news_home none_bottom">
                                        @foreach($dataLeft as $key_left=>$new_left)
                                            <?php $url_img_cent = \App\Library\PHPThumb\ThumbImg::getImageThumb(FOLDER_NEWS, $new_left->news_id, $new_left->news_image)?>
                                            <?php $url_detail_center = buildLinkDetailNew($new_left->news_id, $new_left->news_title, $new_left->news_type);?>
                                            <li>
                                                <article class="d-flex">
                                                    <a href="{{$url_detail_center}}" class="thumbblock thumb145x100" title="{{$new_left->news_title}}">
                                                        <img class="div" src="{{$url_img_cent}}" width="210" height="100" alt="{{$new_left->news_title}}"/>
                                                    </a>
                                                    <div class="desc_1455">
                                                        <a href="{{$url_detail_center}}" class="fbold fs16 max-line-4" title="{{$new_left->news_title}}">
                                                            {{limit_text_word($new_left->news_title,20)}}
                                                        </a>
                                                    </div>
                                                </article>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {{--Sản phẩm nổi bật---}}
                            <div class="col-lg-6">
                                @foreach($arrProductNew as $key_new=>$pro_new)
                                    <?php $number_new = $key_new+1;?>
                                    <div class="wrp_item_small product-col col-xs-6 col-sm-12" style="padding-left: 0px; padding-right: 0px">
                                        <div class="product-box" style="margin-bottom: 0px">
                                            <div class="product-thumbnail">
                                                @if( $pro_new['product_price_market'] > 0 && $pro_new['product_type_price'] == STATUS_INT_MOT && $pro_new['product_price_market'] > $pro_new['product_price_sell'])
                                                    <span class="sale-off">-{{ number_format(100 - ((float)$pro_new['product_price_sell']/(float)$pro_new['product_price_market'])*100, 1) }}%</span>
                                                @endif
                                                <a class="image_link display_flex" href="{{buildLinkDetailProduct($pro_new['product_id'], $pro_new['product_name'], $pro_new['category_name'])}}" title="{{$pro_new['product_name']}}">
                                                    <?php $url_img = \App\Library\PHPThumb\ThumbImg::getImageThumb(FOLDER_PRODUCT, $pro_new['product_id'], $pro_new['product_image'])?>
                                                    <img src="{{$url_img}}" data-lazyload="{{$url_img}}" alt="{{$pro_new['product_name']}}">
                                                </a>
                                                @if($pro_new['product_type_price'] == STATUS_INT_MOT)
                                                    <div class="product-action-grid clearfix">
                                                        <form class="variants form-nut-grid">
                                                            <div>
                                                                <button class="btn-cart button_wh_40 left-to" title="Mua ngay" type="button" onclick="Shopcuatui.addOneProductToCart('{{setStrVar($pro_new['product_id'])}}',1);">
                                                                    Mua ngay
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-info effect a-left">
                                                <div class="info_hhh">
                                                    <h3 class="product-name ">
                                                        <a href="{{buildLinkDetailProduct($pro_new['product_id'], $pro_new['product_name'], $pro_new['category_name'])}}" title="{{$pro_new['product_name']}}">{{$pro_new['product_name']}}</a>
                                                    </h3>
                                                    <div class="price-box clearfix">
                                                        @if($pro_new['product_type_price'] == STATUS_INT_MOT)
                                                            <span class="price product-price">{{numberFormat($pro_new['product_price_sell'])}}đ</span>
                                                            @if($pro_new['product_price_market'] > 0 && $pro_new['product_price_market'] > $pro_new['product_price_sell'])
                                                                <span class="price product-price-old">{{numberFormat($pro_new['product_price_market'])}}đ</span>
                                                            @endif
                                                        @else
                                                            <span class="price product-price">Liên hệ</span>
                                                        @endif
                                                    </div>
                                                    <span class="product-category">
                                                    <a href="{{buildLinkProductWithCategory($pro_new['category_id'], $pro_new['category_name'])}}" title="Danh sách sản phẩm {{$pro_new['category_name']}}">{{$pro_new['category_name']}}</a>
                                                </span>
                                                    @if(!empty($userAdmin))
                                                        <br/><a href="{{URL::route('shop.productEdit',array('id' => $pro_new['product_id']))}}" style="color: red;" title="Sửa sản phẩm" target="_blank">(Sửa SP)</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(($number_new%2)==0)
                                        <div class="clearfix hidden-sm hidden-md hidden-lg"></div>
                                    @else
                                        <div class="clearfix hidden-xs hidden-lg"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </main>

@stop