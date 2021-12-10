<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-4">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="menu_name" name="menu_name"placeholder="Tên menu" @if(isset($search['menu_name']))value="{{$search['menu_name']}}"@endif>
            </div>
            <div class=" col-lg-4">
                <label for="user_group">Project Code</label>
                <select class="form-control input-sm chosen-select w-100" name="project_code" id="project_code">
                    {!! $optionTypeMenu !!}
                </select>
            </div>
            <div class="col-lg-3 text-right marginT20">
                <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                @if($permission_full || $permission_edit || $permission_add)
                    <a href="javascript:void(0);"class="btn btn-success sys_show_popup_common" data-form-name="addForm" data-input="{{json_encode([])}}" title="{{viewLanguage('Thêm ')}}{{$pageTitle}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="0">
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
                    <th width="5%" class="text-center">{{viewLanguage('MenuId')}}</th>
                    <th width="20%" class="text-left">{{viewLanguage('Menu name')}}</th>
                    <th width="30%" class="text-left">{{viewLanguage('Router name')}}</th>

                    <th width="5%" class="text-center">{{viewLanguage('Link')}}</th>
                    <th width="5%" class="text-center">{{viewLanguage('Perm')}}</th>
                    <th width="5%" class="text-center">{{viewLanguage('Menu')}}</th>

                    <th width="5%" class="text-center">{{viewLanguage('Order')}}</th>
                    <th width="13%" class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-center middle">
                            <i class="{!! $item['menu_icons'] !!} fa-3x "></i>
                        </td>
                        <td class="text-center middle">{{$item['menu_id']}}</td>
                        <td class="text-left middle">
                            @if(in_array($item['router_name'],$arrRouter))
                                <a href="{{URL::route($item['router_name'])}}" target="_blank">
                                    {!! $item['padding_left'].$item['menu_name']!!}
                                </a>
                            @else
                                {!! $item['padding_left'].$item['menu_name'] !!}
                            @endif
                        </td>
                        <td class="text-left middle">{{$item['router_name']}}</td>

                        <td class="text-center middle">
                            @if($item['is_link'] == STATUS_INT_MOT)
                                <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-times fa-2x"></i></a>
                            @endif
                        </td>
                        <td class="text-center middle">
                            @if($item['show_permission'] == STATUS_INT_MOT)
                                <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-times fa-2x"></i></a>
                            @endif
                        </td>
                        <td class="text-center middle">
                            @if($item['show_menu'] == STATUS_INT_MOT)
                                <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-times fa-2x"></i></a>
                            @endif
                        </td>
                        <td class="text-center middle">{{$item['menu_order']}}</td>
                        <td class="text-center middle">
                            @if($item['is_active'] == STATUS_INT_MOT)
                                <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-times fa-2x"></i></a>
                            @endif
                            @if($permission_full || $permission_view || $permission_edit || $permission_add || $permission_remove)
                                @if($permission_full || $permission_view || $permission_edit || $permission_add)
                                        &nbsp;
                                        <a href="javascript:void(0);"class="color_hdi sys_show_popup_common" data-size="1" data-form-name="detailItem" title="{{viewLanguage('Cập nhật menu ')}} {{$item['menu_name']}}" data-method="get" data-url="{{$urlGetItem}}" data-input="{{json_encode(['item'=>$item])}}" data-objectId="{{$item['menu_id']}}">
                                        <i class="fa fa-pencil-square-o fa-2x"></i>
                                    </a>
                                @endif
                                @if($permission_remove)
                                    &nbsp;
                                    <a href="javascript:void(0);" style="color: red" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Xóa: ')}}{{$item['menu_name']}}" data-method="post" data-url="{{$urlDeleteItem}}" data-input="{{json_encode(['item'=>$item])}}">
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
