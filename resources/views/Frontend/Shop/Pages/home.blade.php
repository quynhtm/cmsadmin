@extends('site.SiteLayouts.index')
@section('content')
    <div class="container">
        <div class="row">
            <div id="content" class="col-sm-12 col-xs-12 col-md-12">
                <div class="row">
                    {{--List danh sách sản phẩm mới---}}
                    @if($arrProductNew != null)
                        @foreach($arrProductNew as $depart_new=>$val_pro_new)
                            @if(!empty($val_pro_new['product']))
                                <section class="awe-section-3 " id="category_custom-1" style="margin-bottom: 0px!important;">
                                    <section class="section_like_product">
                                        <div class="container">
                                            <div class="row row-noGutter-2">
                                                <div class="heading tab_link_module">
                                                    <h2 class="title-head pull-left">
                                                        <span>
                                                            <a href="{{\Illuminate\Support\Facades\URL::route('site.listProductNew')}}" title="{{$val_pro_new['depart_name']}}" style="background:none">
                                                                {{$val_pro_new['depart_name']}}
                                                            </a>
                                                        </span>
                                                    </h2>
                                                    <div class="tabs-content tabs-content-featured col-md-12 col-sm-12 col-xs-12 no-padding">
                                                        <div id="content-tabb10" class="content-tab content-tab-proindex" style="">
                                                            <div class="row">
                                                                @foreach($val_pro_new['product'] as $key_new=>$pro_new)

                                                                    <?php $number_new = $key_new+1;?>
                                                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-20 custom-mobile">
                                                                        <div class="wrp_item_small product-col">
                                                                            <div class="product-box">
                                                                                <div class="product-thumbnail">
                                                                                    @if($pro_new['product_price_market'] > 0 && $pro_new['product_type_price'] == STATUS_INT_MOT && $pro_new['product_price_market'] > $pro_new['product_price_sell'])
                                                                                        <span class="sale-off">
                                                                                            -{{ number_format(100 - ((float)$pro_new['product_price_sell']/(float)$pro_new['product_price_market'])*100, 1) }}%
                                                                                        </span>
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

                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </section>
                            @endif
                        @endforeach
                    @endif

                    {{--List danh sách sản phẩm theo depart--}}
                    @if($arrProductHome != null)
                        @foreach($arrProductHome as $depart_id=>$val_depart)
                            {{--Quảng cáo--}}
                            <?php
                                $dataCampaignBlock = [];
                                if(isset($arrShowCampaign) && !empty($arrShowCampaign)){
                                    $dataCampaignBlock = array_shift($arrShowCampaign);
                                }
                            ?>
                            @if(!empty($dataCampaignBlock))
                                <section class="awe-section-2">
                                    <div class="sec_banner">
                                        <div class="container">
                                            <div class="row vc_row-flex">
                                                <div class="vc_column_container col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="vc_column-inner">
                                                        <div class="wpb_wrapper">
                                                            <div class="row vc_row-flex">
                                                                @foreach($dataCampaignBlock as $k_cam =>$cam_value)
                                                                    <div class="banner-item banner-right col-md-6 col-sm-6 col-xs-12 @if($k_cam == 1) hidden-sm hidden-xs @endif" id="banner_default-{{$cam_value['campaign_id']}}">
                                                                        <a href="{{buildLinkProductWithCampaign($cam_value['campaign_id'], $cam_value['campaign_name'])}}" title="{{\App\Library\AdminFunction\CGlobal::site_name}} - {{$cam_value['campaign_name']}}" target="_blank">
                                                                            <img class="img-responsive" src="{{getLinkImage(FOLDER_CAMPAIGN.'/'.$cam_value['campaign_id'], $cam_value['campaign_image'])}}" alt="{{\App\Library\AdminFunction\CGlobal::site_name}} - {{$cam_value['campaign_name']}}">
                                                                            <div class="hover_collection"></div>
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            @endif

                            {{--list sản phẩm--}}
                            @if(!empty($val_depart['product']))
                                <section class="awe-section-3 " id="category_custom-{{$depart_id}}" style="margin-bottom: 0px!important;">
                                    <section class="section_like_product">
                                        <div class="container">
                                            <div class="row row-noGutter-2">
                                                <div class="heading tab_link_module">
                                                    <h2 class="title-head pull-left">
                                                        <span>
                                                            <a href="{{buildLinkProductWithDepart($depart_id,$val_depart['depart_name'])}}" title="{{$val_depart['depart_name']}}" style="background:none">
                                                                {{$val_depart['depart_name']}}
                                                            </a>
                                                        </span>
                                                    </h2>
                                                    <div class="tabs-content tabs-content-featured col-md-12 col-sm-12 col-xs-12 no-padding">
                                                        <div id="content-tabb10" class="content-tab content-tab-proindex" style="">
                                                            <div class="row">
                                                                @foreach($val_depart['product'] as $key=>$item)
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
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop