{{----Edit và thêm mới----}}
<div class="formDetailItem" >
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$urlPostData}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataDetail)}}">

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_MOT}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        <input type="hidden" id="actionUpdate" name="actionUpdate" value="updateData">
        {{ csrf_field() }}

        <div class="row">
            @if(!empty($dataListProOrder))
            <div class="col-sm-12 col-lg-8 paddingRight-unset ">
                <div class="card mb-3">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon pe-7s-cart icon-gradient bg-happy-itmeo"></i>
                            Danh sách sản phẩm
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="table-background-header">
                                <th width="2%" class="text-center"></th>
                                <th width="56%" class="text-left">Sản phẩm</th>
                                <th width="15%" class="text-right">Giá bán</th>
                                <th width="10%" class="text-center">SL</th>
                                <th width="17%" class="text-right">Tổng tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $tongSoLuong = 0;
                                $tienBanSanPham = 0;
                                $tongTienHang = 0;
                                $tongTienThanhToan = 0;
                            ?>
                            @foreach ($dataListProOrder as $key => $item)
                                <?php
                                    $tongSoLuong = $tongSoLuong+$item->number_buy;
                                    $tienBanSanPham = $item->product_price_sell*$item->number_buy;
                                    $tongTienHang = $tongTienHang+$tienBanSanPham;
                                    $tongTienThanhToan = $tongTienHang;
                                ?>
                                <tr>
                                    <td class="text-center text-middle">{{$key+1}}</td>
                                    <td class="text-left text-middle">
                                        [{{$item->product_id}}]-
                                        <a href="{{buildLinkDetailProduct($item->product_id, $item->product_name, 'danh-muc')}}" title="{{$item->product_name}}" target="_blank">
                                            {{limit_text_word($item->product_name,8)}}
                                        </a>
                                    </td>
                                    <td class="text-right text-middle">{{numberFormat($item->product_price_sell)}}đ</td>
                                    <td class="text-center text-middle"><input class="form-control input-sm text-center" type="text" name="numberProduct" style="width: 50px!important;" value="{{$item->number_buy}}"></td>
                                    <td class="text-right text-middle red">{{numberFormat($tienBanSanPham)}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-right text-middle" colspan="4">Tổng số lượng hàng</td>
                                <td class="text-right text-middle paddingR10"><b>{{numberFormat($tongSoLuong)}}</b></td>
                            </tr>
                            <tr>
                                <td class="text-right text-middle" colspan="4">Tiền hàng</td>
                                <td class="text-right text-middle paddingR10"><b>{{numberFormat($tongTienHang)}}</b></td>
                            </tr>
                            <tr>
                                <td class="text-right text-middle" colspan="4">Tiền giảm giá</td>
                                <td class="text-right text-middle"><input class="form-control input-sm text-right font-bold" type="text" name="numberProduct" value="5.000" style="padding-right: 2px!important;"></td>
                            </tr>
                            <tr>
                                <td class="text-right text-middle" colspan="4">Tiền ship</td>
                                <td class="text-right text-middle"><input class="form-control input-sm text-right font-bold" type="text" name="numberProduct" value="5.000" style="padding-right: 2px!important;"></td>
                            </tr>
                            <tr>
                                <td class="text-right text-middle" colspan="4"><b>Tổng tiền thanh toán</b></td>
                                <td class="text-right text-middle paddingR10"><b class="red">{{numberFormat($tongTienThanhToan)}}</b></td>
                            </tr>
                            @if(isset($dataDetail['order_status']) && !in_array($dataDetail['order_status'],$arrStatusOrderNotEdit))
                            <tr>
                                <td class="text-right text-middle" colspan="5">
                                    <button class="btn btn-primary"><i class="pe-7s-diskette"></i> Cập nhật đơn hàng</button>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-sm-12 col-lg-4">
                <div class="card marginB15">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon pe-7s-id icon-gradient bg-happy-itmeo"></i>
                            Thông tin đơn hàng
                        </div>
                    </div>
                    <div class="card-body paddingB10">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                {{--<label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái đơn hàng')}}</label><span class="red"> (*)</span>--}}
                                <select  class="form-control input-sm" name="order_status" id="order_status" required>
                                    {!! $optionStatusOrder !!}
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                {{--<label for="NAME" class="text-right control-label">{{viewLanguage('Tình trạng vận chuyển')}}</label><span class="red"> (*)</span>--}}
                                <select  class="form-control input-sm" name="order_is_cod" id="order_is_cod" required>
                                    {!! $optionCodOrder !!}
                                </select>
                            </div>
                        </div>
                        {{--<div class="row form-group">
                            <div class="col-lg-12">
                                <label for="NAME" class="text-right control-label">{{viewLanguage('Đơn hàng từ')}}</label>
                                <select  class="form-control input-sm" name="order_type" id="order_type" required>
                                    {!! $optionTypeOrder !!}
                                </select>
                            </div>
                        </div>--}}
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <textarea type="text" placeholder="Ghi chú Admin" rows="2"  name="order_note" id="{{$formName}}order_note" class="text-left form-control"></textarea>
                            </div>
                        </div>
                        {{-----Thông tin khách hàng----}}
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="NAME" class="text-right control-label font-bold">{{viewLanguage('Thông tin khách hàng')}}</label>
                                <input type="text" placeholder="Tên khách hàng" @if($objectId > 0) readonly @endif name="order_customer_name" id="{{$formName}}order_customer_name" class="text-left form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <input type="text" placeholder="Số điện thoại" @if($objectId > 0) readonly @endif name="order_customer_phone" id="{{$formName}}order_customer_phone" class="text-left form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <input type="text" placeholder="Email" @if($objectId > 0) readonly @endif name="order_customer_email" id="{{$formName}}order_customer_email" class="text-left form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <textarea type="text" placeholder="Địa chỉ giao hàng" rows="2" @if($objectId > 0) readonly @endif name="order_customer_address" id="{{$formName}}order_customer_address" class="text-left form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <textarea type="text" placeholder="Khách hàng ghi chú" @if($objectId > 0) readonly @endif rows="2" name="order_customer_note" id="{{$formName}}order_customer_note" class="text-left form-control"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        showDataIntoForm('{{$formName}}');
    });
</script>
