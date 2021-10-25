<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-4">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="s_search" name="s_search" autocomplete="off" @if(isset($search['s_search']))value="{{$search['s_search']}}"@endif>
            </div>
            <div class=" col-lg-4">
                <label for="user_group">Define code</label>
<!--                <select class="multiselect-dropdown form-control" name="s_define_code" id="s_define_code">-->
                <select class="form-control input-sm chosen-select w-100" name="s_define_code" id="s_define_code">
                    {!! $optionSearchDefineCode !!}}
                </select>
            </div>
            <div class="col-lg-3 marginT20">
                <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
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
                <!--<th width="10%" class="text-left">{{viewLanguage('Desc')}}</th>-->
                    <th width="5%" class="text-center">{{viewLanguage('Lang')}}</th>

                    <th width="8%" class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-center middle">{{$item->PROJECT_CODE}}</td>
                        <td class="text-center middle">
                            <a href="{{URL::route('typeDefines.index',array('s_search' => $item->DEFINE_CODE))}}" title="tìm nhanh theo {{$item->DEFINE_CODE}}">{{$item->DEFINE_CODE}}</a>&nbsp;
                        </td>
                        <td class="text-left middle">
                            <a href="{{URL::route('typeDefines.index',array('s_search' => $item->DEFINE_CODE))}}" title="tìm nhanh theo {{$item->DEFINE_CODE}}">
                            {{$item->DEFINE_NAME}}
                            </a>
                        </td>

                        <td class="text-left middle">{{$item->TYPE_CODE}}</td>
                        <td class="text-left middle">{{$item->TYPE_NAME}}</td>
                        <td class="text-center middle">{{$item->SORTORDER}}</td>
                    <!--<td class="text-left middle">{{$item->DESCRIPTION}}</td>-->
                        <td class="text-center middle">{{$item->LANGUAGE}}</td>

                        <td class="text-center middle">
                            @if($item->IS_ACTIVE == STATUS_INT_MOT)
                                <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="pe-7s-check fa-2x"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="pe-7s-close-circle fa-2x"></i></a>
                            @endif
                            @if($is_root || $permission_edit || $permission_add)
                            {{--<a href="javascript:void(0);" style="color: red" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Xóa group: ')}}{{$item->TYPE_NAME}}" data-method="post" data-url="{{$urlDeleteItem}}" data-input="{{json_encode(['item'=>$item])}}">
                                <i class="pe-7s-trash fa-2x"></i>
                            </a>
                             <br/>--}}
                            <a href="javascript:void(0);"class="a_none_color sys_show_popup_common" data-size="1" data-form-name="detailItem" title="{{viewLanguage('Thêm định nghĩa')}}" data-method="get" data-url="{{$urlGetItem}}" data-input="{{json_encode(['item'=>$item,'is_copy'=>STATUS_INT_MOT])}}" data-objectId="{{$item->ID}}">
                                <i class="pe-7s-copy-file fa-2x"></i>
                            </a>
                            <a href="javascript:void(0);"class="a_none_color sys_show_popup_common" data-size="1" data-form-name="detailItem" title="{{viewLanguage('Cập nhật định nghĩa')}}" data-method="get" data-url="{{$urlGetItem}}" data-input="{{json_encode(['item'=>$item])}}" data-objectId="{{$item->ID}}">
                                <i class="pe-7s-note fa-2x"></i>
                            </a>
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