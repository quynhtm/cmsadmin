<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
        <div class="ibox-tools marginDownT6">
            @if($permission_full || $permission_view)
                <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
            @endif
            @if($permission_full || $permission_edit || $permission_add)
                {{--<a href="javascript:void(0);"  class="btn btn-success" onclick="jqueryCommon.getDataByAjax(this);" data-loading="1" data-show="2" data-div-show="content-page-right" data-form-name="addFormItem" data-url="{{$urlGetData}}" data-function-action="_functionGetData" data-method="post" data-input="{{json_encode(['funcAction'=>'getDetailItem','dataItem'=>[]])}}" data-objectId="0" title="{{viewLanguage('Thêm mới')}}">
                    <i class="fa fa-plus"></i>
                </a>--}}
            @endif
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="form-group col-lg-2">
                <label for="depart_name">{{viewLanguage('Mã sản phẩm')}}</label>
                <input type="text" class="form-control input-sm" id="order_product_id" name="order_product_id" placeholder="1111" autocomplete="off" @if(isset($search['order_product_id']))value="{{$search['order_product_id']}}"@endif>
            </div>
            <div class="form-group col-lg-4">
                <label for="depart_name">{{viewLanguage('Mã đơn hàng')}}</label>
                <input type="text" class="form-control input-sm" id="order_id" name="order_id" placeholder="111,222,333" autocomplete="off" @if(isset($search['order_id']))value="{{$search['order_id']}}"@endif>
            </div>
            <div class="form-group col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Loại đơn')}}</label>
                <select  class="form-control input-sm" name="order_type" id="order_type">
                    {!! $optionTypeOrder !!}}
                </select>
            </div>
            <div class="form-group col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Tình trạng')}}</label>
                <select  class="form-control input-sm" name="order_is_cod" id="order_is_cod">
                    {!! $optionCodOrder !!}}
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" placeholder="Tên KH, số điện thoại, email, địa chỉ, note" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
            </div>
            @if($partner_id == STATUS_INT_KHONG)
            <div class="form-group col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Đối tác')}}</label>
                <select  class="form-control input-sm" name="partner_id" id="partner_id">
                    {!! $optionPartner !!}}
                </select>
            </div>
            @endif
            <div class="form-group col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                <select  class="form-control input-sm" name="order_status" id="order_status">
                    {!! $optionStatusOrder !!}}
                </select>
            </div>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        <th width="4%" class="text-center">TT</th>
                        <th width="10%">Thông tin đơn</th>
                        <th width="10%">Thông tin khác</th>

                        <th width="30%" class="text-center">DS Sản phẩm</th>
                        <th width="30%" class="text-left">Thông tin khách hàng</th>
                        <th width="10%" class="text-center">Tình trạng</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr @if($item->order_status == STATUS_INT_MOT) style="background: #c0a16b" @endif>
                            <td class="text-center text-middle">{{ $stt + $key+1 }}</td>
                            <td class="text-middle">
                                Mã ĐH: <b>{{ $item->id }}</b>
                                <br/>Tổng SL: <b>{{ $item->order_total_buy }}</b> sp
                                <div class="clearfix"></div>
                                <b class="red"> {{ numberFormat($item->order_total_money) }} đ</b>
                            </td>
                            <td class="text-middle">
                                @if(trim($item->order_discount_code) != '')
                                    Voucher: <b>{{ $item->order_discount_code }}</b>
                                    <div class="clearfix"></div>
                                @endif
                                @if($item->order_discount_price > 0)
                                    Giảm: <b>{{ numberFormat($item->order_discount_price) }} đ</b>
                                    <div class="clearfix"></div>
                                @endif
                                @if($item->order_shipping_fee > 0)
                                    Ship: <b>{{ numberFormat($item->order_shipping_fee) }} đ</b>
                                @endif
                            </td>
                            <td class="text-left text-middle">
                                @foreach ($item->list_pro->orders_item as $key2 => $pro_order)
                                    {{$key2+1}}-<a class="image_link display_flex" target="_blank" href="{{buildLinkDetailProduct($pro_order->product_id, $pro_order->product_name, 'danh-muc')}}" title="{{$pro_order->product_name}}">
                                        [<b>{{$pro_order->product_id}}</b>](<b>{{$pro_order->number_buy}}</b>sp) {{$pro_order->product_name}}
                                    </a><br>
                                @endforeach
                                @if($item->order_note != '')
                                    Note ĐH:<span class="red"> {{$item->order_note}}</span>
                                @endif
                            </td>
                            <td class="text-left text-middle">
                                @if($item->order_customer_name != '')N: <b>{{ $item->order_customer_name }}</b><br/>@endif
                                @if($item->order_customer_phone != '')P: <a href="tel:{{ $item->order_customer_phone }}">{{ $item->order_customer_phone }}</a><br/>@endif
                                @if($item->order_customer_email != '')E: {{ $item->order_customer_email }}<br/>@endif
                                @if($item->order_customer_address != '')Add: {{ $item->order_customer_address }}<br/>@endif
                                @if($item->order_customer_note != '')<span class="red">**KH Ghi chú: {{ $item->order_customer_note }}</span>@endif
                            </td>

                            <td class="text-center text-middle">
                                <!--Thao tác--->
                                @if($permission_view || $permission_full || $permission_edit)
                                    <a href="javascript:void(0);"  class="color_hdi" onclick="jqueryCommon.getDataByAjax(this);" data-loading="1" data-show="2" data-div-show="content-page-right" data-form-name="addFormItem" data-url="{{$urlGetData}}" data-function-action="_functionGetData" data-method="post" data-input="{{json_encode(['funcAction'=>'getDetailItem','dataItem'=>$item])}}" data-objectId="{{$item->id}}" title="{{viewLanguage('Thông tin chi tiết')}}">
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/order/eye.png" width="25">
                                    </a>
                                @endif
                                <span class="img_loading" id="img_loading_{{$item->id}}"></span>
                                &nbsp;
                                <!--Trạng thái--->
                                @if($item->order_status == STATUS_INT_MOT)
                                    <a href="javascript:void(0);" title="Đơn hàng mới -{{$item->order_status}}">
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/order/new2.png">
                                    </a>
                                @endif
                                @if($item->order_status == STATUS_INT_HAI)
                                    <a href="javascript:void(0);" title="Đơn hàng đã xác nhận -{{$item->order_status}}">
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/order/da-xac-nhan.png" width="20">
                                    </a>
                                @endif
                                @if($item->order_status == STATUS_INT_BA)
                                    <a href="javascript:void(0);" title="Đơn hàng hoàn thành -{{$item->order_status}}">
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/order/hoan-thanh.png" width="20">
                                    </a>
                                @endif
                                @if($item->order_status == STATUS_INT_BON)
                                    <a href="javascript:void(0);" title="Đơn hàng hủy -{{$item->order_status}}">
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/order/huy.png" width="25">
                                    </a>
                                @endif
                                &nbsp;
                            <!--Vận chuyển-->
                                @if($item->order_is_cod == STATUS_INT_KHONG)
                                    <a href="javascript:void(0);" title="Chưa chuyển hàng -{{$item->order_is_cod}}">
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/order/delivery_miss.png" width="25">
                                    </a>
                                @endif
                                @if($item->order_is_cod == STATUS_INT_MOT)
                                    <a href="javascript:void(0);" title="Đã gán cho COD -{{$item->order_is_cod}}">
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/order/COD.png" width="20">
                                    </a>
                                    <br/>{{$item->order_user_shipper_name}}
                                @endif
                                @if($item->order_is_cod == STATUS_INT_HAI)
                                    <a href="javascript:void(0);" title="COD đang giao hàng -{{$item->order_is_cod}}" >
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/order/delivery_move.png" width="20">
                                    </a>
                                    <br/>{{$item->order_user_shipper_name}}
                                @endif
                                @if($item->order_is_cod == STATUS_INT_BA)
                                    <a href="javascript:void(0);" title="COD đã giao hàng -{{$item->order_is_cod}} ">
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/order/delivery_suss.png" width="20">
                                    </a>
                                    <br/>{{$item->order_user_shipper_name}}
                                @endif
                                @if($item->order_is_cod == STATUS_INT_BON)
                                    <a href="javascript:void(0);" title="COD hoàn trả hàng-{{$item->order_is_cod}}">
                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/order/icon-delivery-cancel.png" width="20">
                                    </a>
                                    <br/>{{$item->order_user_shipper_name}}
                                @endif

                                <div class="clearfix"></div>
                                {{ date ('H:i:s d-m-Y',$item->order_time_creater) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="paging_simple_numbers">
                {!! $paging !!}
            </div>
        @else
            <div class="alert">
                Không có dữ liệu
            </div>
        @endif
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var config = {
            '.chosen-select'           : {width: "100%"},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });
</script>
