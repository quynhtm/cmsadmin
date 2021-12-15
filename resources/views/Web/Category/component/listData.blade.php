<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-4">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" placeholder="Từ khóa" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
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
                <select  class="form-control input-sm" name="is_active" id="is_active">
                    {!! $optionActive !!}}
                </select>
            </div>
            <div class="col-lg-3 text-right marginT20">
                <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                @if($permission_full || $permission_edit || $permission_add)
                    <a href="javascript:void(0);"class="btn btn-success sys_show_popup_common" data-form-name="addForm" data-input="{{json_encode(['strIndex'=>$strIndex])}}" title="{{viewLanguage('Thêm ')}}{{$pageTitle}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="0">
                        <i class="fa fa-plus"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="ibox-content">
    @if($data && sizeof($data) > 0)
        <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                    <th width="5%" class="text-center">{{viewLanguage('Icons')}}</th>
                    <th width="3%" class="text-center">{{viewLanguage('Id')}}</th>
                    <th width="35%" class="text-left">{{viewLanguage('Danh mục')}}</th>

                    <th width="8%" class="text-center">{{viewLanguage('Show header')}}</th>
                    <th width="8%" class="text-center">{{viewLanguage('Danh mục cha')}}</th>

                    <th width="5%" class="text-center">{{viewLanguage('Order')}}</th>
                    <th width="10%" class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-center middle">
                            <i class="{!! $item['category_icons'] !!} fa-3x "></i>
                        </td>
                        <td class="text-center middle">{{$item['id']}}</td>
                        <td class="text-left middle">
                            {!! $item['padding_left'].$item['category_name'] !!}
                            @if($partner_id == 0) @if(isset($arrPartner[$item['partner_id']]))<br><span class="font_10">{{$arrPartner[$item['partner_id']]}}</span> @endif @endif
                        </td>
                        <td class="text-center middle">
                            @if($item['category_menu_right'] == STATUS_INT_MOT)
                                <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-times fa-2x"></i></a>
                            @endif
                        </td>

                        <td class="text-center middle">
                            @if($item['is_parent'] == STATUS_INT_MOT)
                                <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-times fa-2x"></i></a>
                            @endif

                        </td>
                        <td class="text-center middle">{{$item['category_order']}}</td>
                        <td class="text-center middle">
                            @if($item['is_active'] == STATUS_INT_MOT)
                                <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-times fa-2x"></i></a>
                            @endif
                            @if($permission_full || $permission_view || $permission_edit || $permission_add || $permission_remove)
                                @if($permission_full || $permission_view || $permission_edit || $permission_add)
                                        &nbsp;
                                        <a href="javascript:void(0);"class="color_hdi sys_show_popup_common" data-size="1" data-form-name="detailItem" title="{{viewLanguage('Cập nhật ')}} {{$item['category_name']}}" data-method="get" data-url="{{$urlGetItem}}" data-input="{{json_encode(['strIndex'=>$strIndex,'item'=>$item])}}" data-objectId="{{$item['id']}}">
                                        <i class="fa fa-pencil-square-o fa-2x"></i>
                                    </a>
                                @endif
                                @if($permission_remove)
                                    &nbsp;
                                    <a href="javascript:void(0);" style="color: red" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Xóa: ')}}{{$item['category_name']}}" data-method="post" data-url="{{$urlDeleteItem}}" data-input="{{json_encode(['urlIndex'=>$urlIndex,'item'=>$item])}}">
                                        <i class="pe-7s-trash fa-2x"></i>
                                    </a>
                                @endif
                            @endif
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
