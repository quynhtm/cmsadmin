@extends('site.SiteLayouts.index')
@section('content')
    <section class="bread-crumb">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home"><a href="{{buildLinkHome()}}"> <span> Trang chủ</span>
                            </a> <span><i class="fa">/</i></span></li>
                        <li><strong>Thông tin thanh toán</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <link href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/cuatui/checkout.css')}}" rel="stylesheet">
    <div class="container">
        <div class="page-information margin-bottom-50">
            <div class="row">
                <div id="content" class="col-sm-12">
                    <div class="row">
                        <form method="post" action="{{\Illuminate\Support\Facades\URL::route('site.sendOrderToCart')}}" name="checkout_form" id="checkout_form" enctype="multipart/form-data" class="form-horizontal">
                            {{csrf_field()}}
                            <div class="col-sm-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> Địa chỉ nhận hàng </h3>
                                    </div>
                                    <div class="panel-body"> <!-- Apply for VN -->
                                        <div class="form-group required">
                                            <label class="control-label col-md-2" for="input-firstname">Tên đầy đủ <span style="color: red!important;">**</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="firstname" id="input-firstname" placeholder="Ví dụ: Trương Mạnh Quỳnh"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group required">
                                                    <label class="control-label col-sm-4" for="input-telephone">Điện thoại <span style="color: red!important;">**</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="telephone" id="input-telephone" placeholder="Ví dụ: 01234567890" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group required">
                                                    <label class="control-label col-sm-4" for="input-email">Email</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" name="email" id="input-email"  placeholder="contact@yourdomain.com" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display: none">
                                            <div class="col-sm-6">
                                                <div class="form-group required">
                                                    <label class="control-label col-md-4"for="input-zoneid" id="label-zone">Tỉnh/ TP</label>
                                                    <div class="col-md-8">
                                                        <span id="load-ajax-zone">
                                                            <select name="zone_id" id="input-zoneid" onchange="getWard()" class="form-control">
                                                                <option value="3751" selected="selected">An Giang</option>
                                                                <option value="3756">Bà Rịa - Vũng Tàu</option>
                                                                <option value="3752">Bắc Giang</option>
                                                                <option value="3753">Bắc Kạn</option>
                                                            </select>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group required">
                                                    <label class="control-label col-md-4" for="input-address">Quận / Huyện</label>
                                                    <div class="col-sm-8">
                                                        <span id="load-ajax-ward">
                                                            <select name="ward_id" onchange="loadListShipping()" id="input-wardid" class="form-control">
                                                                <option value="3" selected="selected">An Phú</option>
                                                                <option value="2">Châu Đốc</option>
                                                            </select>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label class="control-label col-md-2" for="input-address">Địa chỉ <span style="color: red!important;">**</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="address" id="input-address" placeholder="Ví dụ: Số 247, Cầu Giấy, Q. Cầu Giấy" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-2" for="input-zoneid" id="label-zone">Lời nhắn</label>
                                            <div class="col-sm-10">
                                                <textarea name="comment" id="input-comment" rows="3" class="form-control" placeholder="Ví dụ: Chuyển hàng ngoài giờ hành chính"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="adr-oms checkbox">
                                                    <input type="checkbox" name="same_info_as_buyer_toggle" id="is-delivery-address" onclick="showHideDeliveryAddress()" checked="checked">
                                                    <label for="is-delivery-address"><strong>Địa chỉ nhận hàng và thanh toán giống nhau</strong></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="container-form-address-ship" style="display: none;">
                                            <h4>Thông tin thanh toán</h4>
                                            <div class="form-group required">
                                                <label class="control-label col-md-2" for="input-payment-firstname">Tên đầy đủ</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="payment_firstname" id="input-payment-firstname" placeholder="Ví dụ: Nguyễn Văn A" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label class="control-label col-md-2" for="input-payment-telephone">Điện thoại</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="payment_telephone" id="input-payment-telephone" placeholder="Ví dụ: 01234567890" class="form-control">
                                                </div>
                                                <label class="control-label col-md-2" for="input-payment-email">Email</label>
                                                <div class="col-md-4">
                                                    <input type="email" name="payment_email" id="input-payment-email" placeholder="contact@yourdomain.com" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label class="control-label col-md-2" for="input-countryid">Quốc gia</label>
                                                <div class="col-md-4">
                                                    <select name="payment_country_id" id="input-payment-countryid" class="form-control">
                                                        <option value="244">Aaland Islands</option>
                                                        <option value="1">Afghanistan</option>
                                                        <option value="2">Albania</option>
                                                    </select></div>
                                                <label class="control-label col-md-2" for="input-payment-zoneid" id="label-payment-zone">Tỉnh / TP</label>
                                                <div class="col-md-4">
                                                    <span id="load-ajax-payment-zone">
                                                        <select name="payment_zone_id" id="input-payment-zoneid" class="form-control">
                                                            <option value="3751" selected="selected">An Giang</option>
                                                            <option value="3756">Bà Rịa - Vũng Tàu</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label class="control-label col-md-2" for="input-payment-address">Địa chỉ chi tiết</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="payment_address_1" id="input-payment-address" placeholder="Ví dụ: Số 247, Cầu Giấy, Q. Cầu Giấy" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="adr-oms checkbox">
                                                        <input type="checkbox" name="update_address" id="update-address" checked="checked">&nbsp;&nbsp;
                                                        <label for="update-address">Cập nhật thông tin trên làm địa chỉ hiện tại của tôi</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Phương thức thanh toán </h3>
                                    </div>
                                    <div class="panel-body" id="form_payment_method">
                                        <div class="group">
                                            <div class="adr-oms radio select-method">
                                                <input type="radio" id="payment-method-cod" name="payment_method" value="{{STATUS_INT_MOT}}" checked>
                                                <label for="payment-method-cod">
                                                    <div class="adr-oms payment-method">
                                                        <div class="thumbnail">
                                                            <img alt="Thu tiền tại nhà (COD)" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/icon/cod.png">
                                                        </div>
                                                        <div class="description">
                                                            <div class="title">Thu tiền tại nhà (COD)</div>
                                                            <div class="subtitle">Khách hàng thanh toán bằng tiền mặt cho nhân viên giao hàng khi sản phẩm được chuyển tới địa chỉ nhận hàng</div>
                                                            <div class="tkz-selection-info"></div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="group">
                                            <div class="adr-oms radio select-method">
                                                <input type="radio"id="payment-method-bank_transfer" name="payment_method" value="{{STATUS_INT_HAI}}">
                                                <label for="payment-method-bank_transfer">
                                                    <div class="adr-oms payment-method">
                                                        <div class="thumbnail">
                                                            <img alt="Chuyển khoản" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/icon/bank_transfer.png">
                                                        </div>
                                                        <div class="description">
                                                            <div class="title">Chuyển khoản</div>
                                                            <div class="subtitle">Sử dụng thẻ ATM hoặc dịch vụ Internet Banking để tiến hành chuyển khoản cho chúng tôi</div>
                                                            <div class="tkz-selection-info"></div>
                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="payment-method-toggle box-installment installment-disabled" id="payment-method-info-bank_transfer" style="display: none;">
                                                    <div class="disabled-cod-body">Thông tin ngân hàng<br> Ngân hàng TMCP Ngoại thương Việt Nam - Vietcombank&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default" style="display: none">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <div class="adr-oms checkbox">
                                                <input type="checkbox" name="invoice" id="request-invoice" onclick="showHideInvoice();">
                                                <label for="request-invoice">Yêu cầu xuất hoá đơn GTGT</label>
                                            </div>
                                        </h3>
                                    </div>
                                    <div class="panel-body" id="container-form-invoice" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label col-md-2" for="input-taxcode">Mã số thuế</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="tax_code" id="input-taxcode" placeholder="Ví dụ: 398473094385" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2" for="input-company">Tên công ty</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="company" id="input-company" placeholder="Ví dụ: Công ty Cổ phần ASIA"class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2" for="input-company-address">Địa chỉ công ty</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="company_address" id="input-company-address" placeholder="Ví dụ: 247 Cầu Giấy, Hà Nội, P. Dịch Vọng, Q. Cầu Giấy, TP. Hà Nội" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12"><i>Lưu ý: Giá trị hóa đơn không bao gồm giá trị của Mã giảm giá</i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Danh sách SP trong đơn hàng-->
                            <div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> Đơn hàng có {{count($cartShop)}} sản phẩm </h3>
                                    </div>
                                    <div class="panel-body">
                                        <table class="adr-oms table table_order_items">
                                            <tbody id="orderItem">
                                            <?php
                                            $tong_tien_dh = 0;
                                            ?>
                                            @foreach($cartShop as $prod_id=>$pro_cart)
                                                <tr class="group-type-1 item-child-0">
                                                    <td>
                                                        <div class="table_order_items-cell-thumbnail">
                                                            <div class="thumbnail">
                                                                <a target="_blank" rel="noopener" href="{{buildLinkDetailProduct($pro_cart['product_id'], $pro_cart['product_name'], $pro_cart['category_name'])}}" title="{{$pro_cart['product_name']}}">
                                                                    <?php $url_img = \App\Library\PHPThumb\ThumbImg::getImageThumb(FOLDER_PRODUCT, $pro_cart['product_id'], $pro_cart['product_image'])?>
                                                                    <img src="{{$url_img}}" data-lazyload="{{$url_img}}" alt="{{$pro_cart['product_name']}}">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="table_order_items-cell-detail">
                                                            <div class="table_order_items-cell-title">
                                                                <div class="table_order_items_product_name">
                                                                    <a target="_blank" rel="noopener" href="{{buildLinkDetailProduct($pro_cart['product_id'], $pro_cart['product_name'], $pro_cart['category_name'])}}" title="{{$pro_cart['product_name']}}">
                                                                        <span class="title">{{$pro_cart['product_name']}}</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?
                                                        $str_pro_id = setStrVar($pro_cart['product_id']);
                                                        $tong = $pro_cart['number'] * $pro_cart['product_price_sell'];
                                                        $tong_tien_dh = $tong_tien_dh + $tong;
                                                        ?>
                                                        <div class="table_order_items-cell-price">
                                                            <div class="tt-price">{{numberFormat($pro_cart['product_price_sell'])}}đ</div>
                                                            <div class="quantity">x {{$pro_cart['number']}}</div>
                                                            <div class="tt-price"><b style="color: red!important;">{{numberFormat($tong)}}đ</b></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel panel-default" id="ajax-load-total">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td class="text-left">Tổng tiền</td>
                                            <td class="text-right" style="color: #d60c0c; font-size: 16px; font-weight: bold;">{{numberFormat($tong_tien_dh)}}đ
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">Vận chuyển</h3></div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <span id="ajax-load-shipping-method">
                                                    <div><strong>Tính sau</strong></div>
                                                    <div class="radio">
                                                        <label style="font-weight: inherit;">
                                                            <input type="radio" name="shipping_method" onclick="updateFee()" value="postpaid.postpaid" checked="checked">Phí vận chuyển được tính khi xử lý đơn hàng
                                                        </label>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-primary pull-left" href="{{\Illuminate\Support\Facades\URL::route('site.cartProduct')}}" title="Quay lại giỏ hàng"> Quay lại giỏ hàng </a>
                                    <button class="btn btn-primary pull-right" type="button" id="submit_form_button"onclick="$('form#checkout_form').submit();">Đặt hàng </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@include('site.SiteShop.chatOnline')