@extends('site.SiteLayouts.index')
@section('content')
    <section class="bread-crumb">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home"><a href="{{buildLinkHome()}}"> <span>Trang chủ</span>
                            </a> <span><i class="fa">/</i></span></li>
                        <li><strong>Giỏ hàng</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div id="content" class="col-sm-12 col-xs-12 col-md-12">
                <div class="page-information margin-bottom-50"><h1 class="title-section-page">Giỏ hàng</h1>
                    @if(isset($cartShop) && !empty($cartShop))
                    <form action="{{URL::route('site.cartProduct')}}" method="post" class="" id="updateCart">
                        {{csrf_field()}}
                        <div class="table-responsive table-cart-content">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td class="text-center" width="10%"><strong>Ảnh</strong></td>
                                    <td class="text-center" width="50%"><strong>Sản phẩm</strong></td>
                                    <td class="text-center" width="10%"><strong>Số lượng</strong></td>
                                    <td class="text-center" width="12%"><strong>Đơn giá</strong></td>
                                    <td class="text-center" width="13%"><strong>Tổng</strong></td>
                                    <td class="text-center" width="5%"><strong>Xóa</strong></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                   $tong_tien_dh = 0;
                                ?>
                                @foreach($cartShop as $prod_id=>$pro_cart)
                                    <tr>
                                        <?
                                            $str_pro_id = setStrVar($pro_cart['product_id']);
                                            $tong = $pro_cart['number'] * $pro_cart['product_price_sell'];
                                            $tong_tien_dh = $tong_tien_dh + $tong;
                                        ?>

                                        <td class="text-center">
                                            <?php $url_img = \App\Library\PHPThumb\ThumbImg::getImageThumb(FOLDER_PRODUCT, $pro_cart['product_id'], $pro_cart['product_image'])?>
                                            <img src="{{$url_img}}" alt="{{$pro_cart['product_name']}}" title="{{$pro_cart['product_name']}}" width="80">
                                        </td>
                                        <td class="text-left">
                                            <a href="{{buildLinkDetailProduct($pro_cart['product_id'], $pro_cart['product_name'], $pro_cart['category_name'])}}" title="chi tiết sản phẩm này">{{$pro_cart['product_name']}}</a>
                                            <div class="clearfix"></div>
                                            <a href="{{buildLinkProductWithCategory($pro_cart['category_id'], $pro_cart['category_name'])}}" title="Danh sách sản phẩm {{$pro_cart['category_name']}}"><i>{{$pro_cart['category_name']}}</i></a>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" name="quantity[{{$pro_cart['product_id']}}]" value="{{$pro_cart['number']}}" size="4" id="qtyItem_{{$pro_cart['product_id']}}" class="form-control input-text text-center number-sidebar input_pop input_pop" style="padding: 0; width: 90px; display: inline">
                                        </td>
                                        <td class="text-right">{{numberFormat($pro_cart['product_price_sell'])}}đ</td>
                                        <td class="text-right">
                                            <span><b style="color: red!important;">{{numberFormat($tong)}}đ</b></span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger" onclick="Shopcuatui.removeOneItemCart('{{$str_pro_id}}');" title="Xóa">
                                                Xóa
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" data-toggle="tooltip" title="" class="btn btn-primary pull-right" style="margin-bottom: 20px;" data-original-title="Cập nhật">
                            Cập nhật
                        </button>
                    </form>

                    <!--Tổng tiền--->
                    <div class="row">
                        <div class="col-sm-12"></div>
                        <div class="col-sm-4 col-sm-offset-8">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td class="text-right">Thành tiền:</td>
                                    <td class="text-right"><strong>{{numberFormat($tong_tien_dh)}}đ</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Phí vận chuyển tính khi xử lý đơn hàng:</td>
                                    <td class="text-right"><strong>0đ</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Tổng số:</td>
                                    <td class="text-right"><strong style="color: red!important;">{{numberFormat($tong_tien_dh)}}đ</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6 col-xs-6 col_button_checkout">
                                    <a href="{{buildLinkHome()}}" class="btn btn-primary pull-left button_shopping">
                                        Tiếp tục mua hàng
                                    </a>
                                </div>
                                <div class="col-sm-6 col-xs-6 col_button_checkout">
                                    <a href="{{\Illuminate\Support\Facades\URL::route('site.inforRepaymentsOrder')}}" class="btn btn-primary pull-right button_checkout">
                                        Tiến hành thanh toán
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                        Chưa có sản phẩm nào trong giỏ hang.
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop