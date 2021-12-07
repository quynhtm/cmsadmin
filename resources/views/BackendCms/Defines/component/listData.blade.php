<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-4">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="define_name" name="define_name" autocomplete="off" @if(isset($search['define_name']))value="{{$search['define_name']}}"@endif>
            </div>
            <div class=" col-lg-4">
                <label for="user_group">Define code</label>
                <select class="form-control input-sm chosen-select w-100" name="define_code" id="define_code">
                    {!! $optionDefineCode !!}}
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
                    <th width="5%" class="text-center">{{viewLanguage('ProjectCode')}}</th>
                    <th width="10%" class="text-left">{{viewLanguage('Define code')}}</th>
                    <th width="15%" class="text-left">{{viewLanguage('Define name')}}</th>

                    <th width="15%" class="text-left">{{viewLanguage('Type code')}}</th>
                    <th width="15%" class="text-left">{{viewLanguage('Type name')}}</th>
                    <th width="5%" class="text-center">{{viewLanguage('Order')}}</th>
                    <th width="5%" class="text-center">{{viewLanguage('Lang')}}</th>
                    <th width="12%" class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-center middle">{{$item->project_code}}</td>
                        <td class="text-center middle">
                            <a href="{{URL::route('defines.index',array('define_code' => $item->define_code))}}" title="tìm nhanh theo {{$item->define_code}}">{{$item->define_code}}</a>&nbsp;
                        </td>
                        <td class="text-left middle">
                            <a href="{{URL::route('defines.index',array('define_code' => $item->define_code))}}" title="tìm nhanh theo {{$item->define_code}}">
                            {{$item->define_name}}
                            </a>
                        </td>

                        <td class="text-left middle">{{$item->type_code}}</td>
                        <td class="text-left middle">{{$item->type_name}}</td>
                        <td class="text-center middle">{{$item->sort_order}}</td>
                        <td class="text-center middle">{{$item->language}}</td>

                        <td class="text-center middle">
                            @if($item->is_active == STATUS_INT_MOT)
                                <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-times fa-2x"></i></a>
                            @endif
                            @if($permission_full || $permission_edit || $permission_add || $permission_remove)
                                @if($permission_full || $permission_remove)
                                    &nbsp;
                                    <a href="javascript:void(0);" style="color: red" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Xóa group: ')}}{{$item->TYPE_NAME}}" data-method="post" data-url="{{$urlDeleteItem}}" data-input="{{json_encode(['item'=>$item])}}">
                                        <i class="pe-7s-trash fa-2x"></i>
                                    </a>
                                @endif
                                @if($permission_full || $permission_edit || $permission_add)
                                    &nbsp;
                                    <a href="javascript:void(0);"class="color_warning sys_show_popup_common" data-size="1" data-form-name="detailItem" title="{{viewLanguage('Thêm định nghĩa')}}" data-method="get" data-url="{{$urlGetItem}}" data-input="{{json_encode(['item'=>$item,'is_copy'=>STATUS_INT_MOT])}}" data-objectId="{{$item->id}}">
                                        <i class="fa fa-copy fa-2x"></i>
                                    </a>
                                    &nbsp;
                                    <a href="javascript:void(0);"class="color_hdi sys_show_popup_common" data-size="1" data-form-name="detailItem" title="{{viewLanguage('Cập nhật định nghĩa')}}" data-method="get" data-url="{{$urlGetItem}}" data-input="{{json_encode(['item'=>$item])}}" data-objectId="{{$item->id}}">
                                        <i class="fa fa-pencil-square-o fa-2x"></i>
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
