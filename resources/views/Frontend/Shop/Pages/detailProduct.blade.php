@extends('site.SiteLayouts.index')
@section('content')
    <section class="bread-crumb">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home">
                            <a href="{{buildLinkHome()}}">
                                <span>Trang chủ</span>
                            </a>
                            <span><i class="fa">/</i></span>
                        </li>
                        @if(isset($product->category_id))
                            <li>
                                <a href="{{buildLinkProductWithCategory($product->category_id,$product->category_name)}}">
                                    <span>{{$product->category_name}}</span>
                                </a>
                                <span><i class="fa">/</i></span>
                            </li>
                        @endif
                        @if(isset($product->product_name))
                            <li><strong>{{$product->product_name}}</strong></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="main-product-page">
            <div class="row">
                <div class="details-product">
                    <div id="content" class="col-sm-12 col-xs-12 col-md-12">
                        <div class="rows">
                            <!---image product-->
                            <div class="product-detail-left product-images col-xs-12 col-sm-6 col-md-5 col-lg-5">
                                <div class="row"> <!-- product images -->
                                    <div class="col_large_default large-image">
                                        <a href="javascript:void(0);" class="large_image_url checkurl" data-rel="prettyPhoto[product-gallery]">
                                            <div style="height:460.5px;width:460.5px;" class="zoomWrapper">
                                                <?php $url_img = \App\Library\PHPThumb\ThumbImg::getImageThumb(FOLDER_PRODUCT, $product->product_id, $product->product_image)?>
                                                <img id="img_product_big" class="img-responsive" alt="{{$product->product_name}}" src="{{$url_img}}" data-zoom-image="{{$url_img}}" style="position: absolute; width: 460.5px; height: 460.5px;">
                                            </div>
                                        </a>
                                        <div class="hidden"></div>
                                    </div>

                                    <!---list ảnh khác-->
                                    <?php
                                        $product_image_other = unserialize($product->product_image_other);
                                    ?>
                                    @if(!empty($product_image_other))
                                        <div class="product-detail-thumb">
                                            <div id="gallery_02"class="owl-carousel owl-theme thumbnail-product thumb_product_details not-dqowl owl-loaded owl-drag" data-loop="false" data-lg-items="4" data-md-items="4" data-sm-items="3" data-xs-items="3" data-xxs-items="3">
                                                @foreach($product_image_other as $key_other => $imge_other)
                                                    <?php $url_img_other = \App\Library\PHPThumb\ThumbImg::getImageThumb(FOLDER_PRODUCT, $product->product_id, $imge_other);?>
                                                    <div class="owl-stage-outer">
                                                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 116px;">
                                                            <div class="owl-item active" style="width: 115.625px;">
                                                                <div class="item">
                                                                    <a href="javascript:void(0);" onclick="Shopcuatui.onchangeViewImageDetail({{$product->product_id}},'{{$url_img_other}}')" data-image="{{$url_img_other}}" data-zoom-image="{{$url_img_other}}"class="active">
                                                                        <img data-img="{{$url_img_other}}" src="{{$url_img_other}}" alt="{{$product->product_name}}">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="owl-dots disabled"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7 details-pro">
                                <h1 class="title-product">{{$product->product_name}}</h1>
                                <div class="social-buttons">
                                    <a rel="nofollow" target="_blank"  href="https://www.facebook.com/sharer/sharer.php?u={{buildLinkDetailProduct($product->product_id, $product->product_name, $product->category_name)}}" title="Chia sẻ lên Facebook">
                                        <img alt="Chia sẻ lên Facebook" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/icon/facebook.png" width="25">
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a rel="nofollow" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&amp;fs=1&amp;to&amp;su=&amp;body={{$product->product_sort_desc}}" title="Chia sẻ lên Gmail">
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
                                    } </style>
                                {{--Link danh mục--}}
                                <div class="group-status">
                                    <span class="first_status">
                                        <a href="{{buildLinkProductWithCategory($product->category_id,$product->category_name)}}" title="{{$product->category_name}}">{{$product->category_name}}</a>
                                    </span>
                                </div>

                                <div class="price-box product-box">
                                    @if($product->product_type_price == STATUS_INT_MOT)
                                        <span class="special-price">
                                            <span class="price product-price">{{numberFormat($product->product_price_sell)}}đ</span>
                                            @if($product->product_price_market > 0 && $product->product_price_market > $product->product_price_sell)
                                                <span class="price product-price-old">{{numberFormat($product->product_price_market)}}đ</span>
                                            @endif
                                        </span>
                                    @else
                                        <span class="special-price">
                                            <span class="price product-price">Liên hệ</span>
                                            <p>
                                                <a class="rc yeloww" href="tel:0985101026">Ms. Giang: 0985.1010.26</a>
                                                <br/>
                                                <a class="rc yeloww" href="tel:0903187988">Ms. Bình: 0903.187.988</a>
                                            </p>
                                        </span>
                                    @endif
                                </div>

                                <div class="product-summary product_description margin-bottom-0">
                                    {{--<p>{!! $product->product_sort_desc !!}</p>--}}
                                    <p>{!! limit_text_word($product->product_sort_desc) !!}</p>
                                </div>

                                @if($product->product_type_price == STATUS_INT_MOT)
                                <div id="product" class="form-product col-sm-12">
                                    <div class="form-group form_button_details">
                                        <div class="form_hai ">
                                            <div class="custom input_number_product custom-btn-number form-control">
                                                <button class="btn_num num_1 button button_qty" type="button" onclick="var result = document.getElementById('input_quantity');var qtypro = result.value;if(!isNaN(qtypro) &amp;&amp; qtypro > 1) result.value--;return false;">
                                                    -
                                                </button>
                                                <input type="text" name="quantity" value="1" id="input_quantity" class="form-control prd_quantity">
                                                <button class="btn_num num_2 button button_qty" type="button" onclick="var result = document.getElementById('input_quantity');var qtypro = result.value;if(!isNaN(qtypro)) result.value++;return false;">
                                                    +
                                                </button>
                                            </div>
                                            <div class="button_actions">
                                                <input type="hidden" name="product_id" value="213">
                                                <button type="button" id="button-cart" data-loading-text="Đang tải..." onclick="Shopcuatui.detailAddtoCart('{{setStrVar($product->product_id)}}');" class="btn btn-lg btn-block btn-cart button_cart_buy_enable add_to_cart btn_buy">
                                                    <span class="btn-content">Thêm vào giỏ</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                {{--hash tag--}}
                                <?php
                                $arrHashtagChose = (isset($product->list_tag_id) && trim($product->list_tag_id) != '')? explode(',',$product->list_tag_id): [];
                                $count = count($arrHashtagChose);
                                ?>

                                <!--Thông tin người bán hàng--->
                                <div id="block-tab-infor" class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12 no-padding">
                                            <div class="product-tab e-tabs">
                                                <ul class="tabs tabs-title clearfix">
                                                    <li class="tab-link current" data-tab="tab-description">
                                                        <h3>
                                                            <span>Thông tin mua hàng</span>
                                                        </h3>
                                                    </li>
                                                </ul>
                                                <div class="tab-content current" id="tab-description">
                                                    <div class="rte2">
                                                        <p><b>Thông tin liên hệ: </b></p>
                                                        <p><a class="rc yeloww" href="tel:0985101026">Ms. Giang: 0985.1010.26</a></p>
                                                        <p><a class="rc yeloww" href="tel:0903187988">Ms. Bình: 0903.187.988</a></p>
                                                        <p>Địa chỉ: {{\App\Library\AdminFunction\CGlobal::address_shop}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--Quảng cáo--}}
                        <?php
                        $dataCampaignBlock = [];
                        if(isset($arrShowCampaign) && !empty($arrShowCampaign)){
                            $dataCampaignBlock = array_shift($arrShowCampaign);
                        }
                        ?>
                        @include('site.SiteShop.adverCampaign')

                        {{---Mô tả ngắn---}}
                        <div id="block-tab-infor" class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                            <div class="row margin-top-20 xs-margin-top-15">
                                <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12 no-padding">
                                    <div class="product-tab e-tabs">
                                        <ul class="tabs tabs-title clearfix">
                                            <li class="tab-link current" data-tab="tab-description">
                                                <h3>
                                                    <span>Mô tả</span>
                                                    @if(!empty($userAdmin))
                                                        <a href="{{URL::route('shop.productEdit',array('id' => $product->product_id))}}" style="color: red;" title="Sửa sản phẩm" target="_blank">(Sửa SP)</a>
                                                    @endif
                                                </h3>
                                            </li>
                                        </ul>
                                        <div class="tab-content current" id="tab-description">
                                            <div class="rte">
                                                {!! $product->product_content !!}

                                                {{--hash tag--}}
                                                @if(!empty($arrHashtagChose))
                                                    <div class="clearfix"></div>
                                                    <div class="group-status">
                                                        <span class="first_status">
                                                            @foreach($arrHashtagChose as $ke=>$tag_ids)
                                                                @if(isset($arrHashTag[$tag_ids]))
                                                                    <a style="color: #337ab7;" href="{{buildLinkProductWithTag($tag_ids,$arrHashTag[$tag_ids])}}" title="{{$arrHashTag[$tag_ids]}}">#{{$arrHashTag[$tag_ids]}}</a>
                                                                    @if($count > ($ke+1)), @endif
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>

        {{--Quảng cáo--}}
        <?php
        //$dataCampaignBlock = [];
        if(isset($arrShowCampaign) && !empty($arrShowCampaign)){
            $dataCampaignBlock = array_shift($arrShowCampaign);
        }
        ?>
        @include('site.SiteShop.adverCampaign')

        <!--Sản phẩm liên quan--->
        @if(isset($arrRelatedProducts) && !empty($arrRelatedProducts))
        <div class="row">
            <section class="awe-section-3 " id="category_custom-1">
                <section class="section_like_product">
                    <div class="container">
                        <div class="row row-noGutter-2">
                            <div class="heading tab_link_module">
                                <h2 class="title-head pull-left">
                                    <span>Sản phẩm liên quan</span>
                                </h2>

                                <div class="tabs-content tabs-content-featured col-md-12 col-sm-12 col-xs-12 no-padding">
                                    <div id="content-tabb10" class="content-tab content-tab-proindex" style="">
                                        <div class="row">
                                            @foreach($arrRelatedProducts as $key=>$item)
                                                <?php $number = $key+1;?>
                                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-20 custom-mobile">
                                                    <div class="wrp_item_small product-col">
                                                        <div class="product-box">
                                                            <div class="product-thumbnail">
                                                                @if($item->product_price_market > 0 && $item->product_type_price == STATUS_INT_MOT && $item->product_price_market > $item->product_price_sell)
                                                                    <span class="sale-off">
                                                                        -{{ number_format(100 - ((float)$item->product_price_sell/(float)$item->product_price_market)*100, 1) }}%
                                                                    </span>
                                                                @endif
                                                                <a class="image_link display_flex" href="{{buildLinkDetailProduct($item->product_id, $item->product_name, $item->category_name)}}" title="{{$item->product_name}}">
                                                                    <?php $url_img = \App\Library\PHPThumb\ThumbImg::getImageThumb(FOLDER_PRODUCT, $item->product_id, $item->product_image)?>
                                                                    <img src="{{$url_img}}" data-lazyload="{{$url_img}}" alt="{{$item->product_name}}">
                                                                </a>
                                                                @if($item->product_type_price == STATUS_INT_MOT)
                                                                <div class="product-action-grid clearfix">
                                                                    <form class="variants form-nut-grid">
                                                                        <div>
                                                                            <button class="btn-cart button_wh_40 left-to" title="Mua ngay" type="button" onclick="Shopcuatui.addOneProductToCart('{{setStrVar($item->product_id)}}',1);">
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
                                                                        <a href="{{buildLinkDetailProduct($item->product_id, $item->product_name, $item->category_name)}}" title="{{$item->product_name}}">{{$item->product_name}}</a>
                                                                    </h3>
                                                                    <div class="price-box clearfix">
                                                                        @if($item->product_type_price == STATUS_INT_MOT)
                                                                            <span class="price product-price">{{numberFormat($item->product_price_sell)}}đ</span>
                                                                            @if($item->product_price_market > 0 && $item->product_price_market > $item->product_price_sell)
                                                                                <span class="price product-price-old">{{numberFormat($item->product_price_market)}}đ</span>
                                                                            @endif
                                                                        @else
                                                                            <span class="price product-price">Liên hệ</span>
                                                                        @endif
                                                                    </div>
                                                                    <span class="product-category">
                                                                        <a href="{{buildLinkProductWithCategory($item->category_id, $item->category_name)}}" title="Danh sách sản phẩm {{$item->category_name}}">{{$item->category_name}}</a>
                                                                    </span>
                                                                    @if(!empty($userAdmin))
                                                                        <br/><a href="{{URL::route('shop.productEdit',array('id' => $item->product_id))}}" style="color: red;" title="Sửa sản phẩm" target="_blank">(Sửa SP)</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(($number%2)==0)
                                                    <div class="clearfix hidden-sm hidden-md hidden-lg"></div>
                                                @else
                                                    <div class="clearfix hidden-xs hidden-lg"></div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </div>
        @endif
    </div>
@stop
@include('site.SiteShop.chatOnline')