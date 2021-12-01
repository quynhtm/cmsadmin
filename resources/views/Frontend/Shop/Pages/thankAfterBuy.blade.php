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
                        @if(isset($departName) && isset($departId) && $departId > 0)
                        <li>
                            <a href="{{buildLinkProductWithDepart($departId,$departName)}}">
                                <span>{{$departName}}</span>
                            </a>
                            <span><i class="fa">/</i></span>
                        </li>
                        @endif
                        @if(isset($titleSearchName))
                        <li><strong>{{$titleSearchName}}</strong></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="main-category-page col-md-12 col-sm-12 col-xs-12 no-padding">

                <!--List sản phẩm tìm kiếm-->
                <div id="content" class="col-sm-12 col-xs-12 @if(isset($is_category) && $is_category == STATUS_INT_KHONG) col-md-9 col-md-push-3 @endif  section-main-products padding-small main_container collection margin-bottom-30">
                    <section class="awe-section-3 " id="category_custom-1" @if(isset($is_category) && $is_category == STATUS_INT_KHONG)style="border-left: 2px solid #FF5622" @endif>
                        <section class="section_like_product">
                            <div class="container">
                                <div class="row text-center">
                                    <h3>
                                        Cám ơn Quý khách đã đặt hàng trên Shopcuatui.<br>
                                        Chúng tôi sẽ liên hệ sớm nhất với Quý khách về đơn hàng vừa đặt.
                                    </h3>
                                </div>
                                <div class="row row-noGutter-2">
                                    <div class="heading tab_link_module">
                                        <h2 class="title-head pull-left title_search_pro">
                                            <span>Sản phẩm bạn có thể quan tâm</span>
                                        </h2>
                                        <!--item show-->
                                        <div class="tabs-content tabs-content-featured col-md-12 col-sm-12 col-xs-12 no-padding">
                                            <div id="content-tabb10" class="content-tab content-tab-proindex" style="">

                                                <div class="row">
                                                    @if(isset($dataSearch) && !empty($dataSearch))
                                                        @foreach($dataSearch as $key=>$item)
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
                                                                            @if(isset($is_category) && in_array($is_category, [STATUS_INT_KHONG,STATUS_INT_HAI]))
                                                                                <span class="product-category">
                                                                                    <a href="{{buildLinkProductWithCategory($item->category_id, $item->category_name)}}" title="Danh sách sản phẩm {{$item->category_name}}">{{$item->category_name}}</a>
                                                                                </span>
                                                                            @endif
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

                                                    @else
                                                        <h3>Không tồn tại sản phẩm này.</h3>
                                                    @endif
                                                </div>
                                                <div style="clear: both">
                                                    {!! $paging !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </section>
                </div>

                <!--List danh mục-->
                @if(isset($dataCateWithDepart) && !empty($dataCateWithDepart))
                <div class="col-sm-12 col-xs-12 col-md-3 sidebar section-main-sidebar padding-small margin-bottom-50 clearfix col-md-pull-9">
                    <aside id="column-left" class="left-column compliance dqdt-sidebar sidebar left-content article-sidebar left">
                        <aside class="aside-item sidebar-category collection-category " id="product_category-1">
                            <div class="aside-title">
                                <h2 class="title-head margin-top-0"><span>Danh mục</span></h2>
                            </div>
                            <div class="aside-content">
                                <nav class="nav-category navbar-toggleable-md">
                                    <ul class="nav navbar-pills">
                                        @foreach($dataCateWithDepart as $cat_id=>$val_cate)
                                        <li class="nav-item lv1">
                                            <a class="nav-link " href="{{buildLinkProductWithCategory($val_cate['category_id'],$val_cate['category_name'])}}">
                                                {{$val_cate['category_name']}} ({{$val_cate['total_cate']}})
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </aside>
                    </aside>
                    <div class="banner-right-one banner-item banner-right col-md-12 col-sm-12 hidden-xs">
                        <div class=" " id="banner_default-1837408231">
                            <a href="javascript:void(0)" title="">
                                <img class="img-responsive" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/cuatui/ss-banner-img-1-287x485.jpg" alt="" >
                                <div class="hover_collection"></div>
                            </a>
                        </div>
                        <div style="margin-top: 10px" id="banner_default-18374082312">
                            <a href="javascript:void(0)" title="">
                                <img class="img-responsive" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/cuatui/ss-banner-img-1-287x485.jpg" alt="" >
                                <div class="hover_collection"></div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@stop
@include('site.SiteShop.chatOnline')