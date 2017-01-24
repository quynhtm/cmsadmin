<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Quản lý tin đăng</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-3">
                            <label for="item_id">Id tin đăng</label>
                            <input type="text" class="form-control input-sm" id="item_id" name="item_id" placeholder="ID tin đăng" @if(isset($search['item_id']) && $search['item_id'] > 0)value="{{$search['item_id']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="item_name">Tên tin đăng</label>
                            <input type="text" class="form-control input-sm" id="item_name" name="item_name" placeholder="Tên tin đăng" @if(isset($search['item_name']) && $search['item_name'] != '')value="{{$search['item_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="order_status">Trạng thái</label>
                            <select name="item_status" id="item_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="order_status">Loại tin</label>
                            <select name="item_is_hot" id="item_is_hot" class="form-control input-sm">
                                {{$optionType}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="order_status">Loại tin đăng</label>
                            <select name="item_type_action" id="item_type_action" class="form-control input-sm">
                                {{$optionTypeAction}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="order_status">Kiểu khóa SP</label>
                            <select name="item_block" id="item_block" class="form-control input-sm">
                                {{$optionBlock}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="item_category_id">Danh mục tin đăng</label>
                            <select name="item_category_id" id="item_category_id" class="form-control input-sm">
                                {{$optionCategory}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="order_status">Tin đăng của khách</label>
                            <select name="customer_id" id="customer_id" class="form-control input-sm chosen-select-deselect" tabindex="12" data-placeholder="Chọn tên khách hàng">
                                <option value=""></option>
                                @foreach($arrShop as $shop_id => $shopName)
                                    <option value="{{$shop_id}}" @if($search['customer_id'] == $shop_id) selected="selected" @endif>{{$shopName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if($is_root)
                    <div class="panel-footer text-right">
                        <a class="btn btn-warning btn-sm" href="javascript:void(0);" onclick="Admin.removeAllItems(1);"><i class="fa fa-trash"></i> Xóa nhiều SP </a>
                        <div class="col-lg-3">
                            <select name="product_status_update" id="product_status_update" class="form-control input-sm">
                                {{$optionStatusUpdate}}
                            </select>
                        </div>
                        <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="Admin.setStastusBlockItems();"><i class="fa fa-refresh"></i> Đổi trạng thái </a>
                        <span class="img_loading" id="img_loading_delete_all"></span>
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                    </div>
                    @endif
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> items @endif </div>
                    <br>
                    <div class="text-right">
                        {{$paging}}
                    </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="3%" class="text-center">STT <input type="checkbox" class="check" id="checkAll"></th>
                            <th width="7%" class="text-center">Ảnh</th>
                            <th width="35%">Tin đăng</th>
                            <th width="25%">Mô tả ngắn</th>
                            <th width="20%">Thông tin khác</th>
                            <th width="10%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr @if($item->is_customer == CGlobal::CUSTOMER_VIP)style="background-color: #d6f6f6"@endif>
                                <td class="text-center text-middle">
                                    {{ $stt + $key+1 }}<br/>
                                    <input class="check" type="checkbox" name="checkItems[]" id="sys_checkItems" value="{{$item->item_id}}">
                                </td>
                                <td class="text-center text-middle">
                                    <img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $item->item_id, $item->item_image, CGlobal::sizeImage_100)}}">
                                </td>
                                <td class="text-left text-middle">
                                    @if($item->item_status == CGlobal::status_show)
                                        <a href="#" target="_blank" title="Chi tiết sản phẩm">
                                            [<b>{{ $item->item_id }}</b>] {{ $item->item_name }}
                                        </a>
                                    @else
                                        [<b>{{ $item->item_id }}</b>] {{ $item->item_name }}
                                    @endif
                                    @if($item->item_category_name != '')
                                        <br/><b>Danh mục:</b> {{ $item->item_category_name }}
                                    @endif
                                    @if($item->item_price_sell > 0)
                                        <br/><b>Giá:</b> <b class="red">{{ FunctionLib::numberFormat($item->item_price_sell) }} đ</b>
                                    @endif
                                    @if(isset($arrTypeProduct[$item->item_is_hot]) && $item->item_is_hot != CGlobal::ITEMS_NOMAL)
                                        <br/><b class="red">{{ $arrTypeProduct[$item->item_is_hot] }}</b>
                                    @endif
                                    @if(isset($arrTypeAction[$item->item_type_action]))
                                        <br/><b class="@if($item->item_type_action == CGlobal::ITEMS_TYPE_ACTION_1) red @else green @endif">{{ $arrTypeAction[$item->item_type_action] }}</b>
                                    @endif
                                </td>
                                <td class="text-left text-middle">
                                    @if($item->item_content != ''){{ FunctionLib::substring($item->item_content,300) }}@endif
                                </td>
                                <td class="text-left text-middle">
                                        <b>KH:</b> [{{$item->customer_id}}] <a href="{{URL::route('admin.customerView',array('customer_id' => $item->customer_id))}}" target="_blank" title="view thông tin khách hàng">{{ $item->customer_name}}</a>
                                        <br/>Top: {{date ('d-m-Y H:i',$item->time_ontop)}}
                                        <br/>Tạo: {{date ('d-m-Y H:i',$item->time_created)}}
                                        <br/>Sửa: {{date ('d-m-Y H:i',$item->time_update)}}
                                </td>
                                <td class="text-center text-middle">
                                    @if($item->item_block == CGlobal::ITEMS_BLOCK)
                                        <i class="fa fa-lock fa-2x red" title="Bị khóa"></i>
                                    @else
                                        @if($item->item_status == CGlobal::status_show)
                                            <i class="fa fa-check fa-2x green" title="Hiển thị"></i>
                                        @endif
                                        @if($item->item_status == CGlobal::status_hide)
                                            <i class="fa fa-close fa-2x red" title="Đang ẩn"></i>
                                        @endif
                                        @if($item->item_status == CGlobal::IMAGE_ERROR)
                                            <i class="fa fa-bug fa-2x red" title="Sản phẩm bị lỗi"></i>
                                        @endif
                                    @endif
                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                        <a href="{{URL::route('admin.itemsEdit',array('id' => $item->item_id))}}" title="Sửa sản phẩm"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item->item_id}}"></span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        {{$paging}}
                    </div>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
            </div>
        </div>
    </div><!-- /.page-content -->
</div>
<script type="text/javascript">
    //tim kiem cho shop
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
        //      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>