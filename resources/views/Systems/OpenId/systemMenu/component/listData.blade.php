{{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Search')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="form-group col-lg-4">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="s_search" name="s_search" autocomplete="off" @if(isset($search['s_search']))value="{{$search['s_search']}}"@endif>
            </div>
            <div class="form-group col-lg-4">
                <label for="status" class="control-label">{{viewLanguage('Menu Project')}}</label>
                <select name="s_project_code" id="s_project_code" class="form-control input-sm">
                    {!! $optionSearchProjectCode !!}}
                </select>
            </div>
            <div class="form-group col-lg-3">
                @if($is_root || $permission_view)
                    <button class="mb-2 mr-2 btn-icon btn btn-primary marginT25" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                @endif
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
{{ Form::close() }}
<div class="ibox-content">
    @if($data && sizeof($data) > 0)
        <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                    <th width="5%" class="text-center">{{viewLanguage('Icon')}}</th>
                    <th width="5%" class="text-center">{{viewLanguage('MenuId')}}</th>
                    <th width="30%" class="text-left">{{viewLanguage('Tên menu')}}</th>
                    <th width="35%" class="text-left">{{viewLanguage('Contronller')}}</th>

                    <th width="10%" class="text-center">{{viewLanguage('Mã dự án')}}</th>
                    <th width="5%" class="text-center">{{viewLanguage('Order')}}</th>
                    <th width="10%" class="text-center">{{viewLanguage('Thao tác')}}</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $stt_key = 1;
                ?>
                @foreach ($data as $key => $item)
                    <?php
                    $parent_id = ($item['parent_id'] == 0)? $item['menu_id']: $item['parent_id'];
                    $show_button_parent = ($item['parent_id'] == 0)? 1: 0;
                    ?>
                    @if($item['parent_id'] == 0)
                        <input type="hidden" value="0" id="parent_infor_{{$parent_id}}">
                    @endif
                    <tr @if($is_root || $permission_view)class="detailCommon @if($item['parent_id'] == 0) parent_infor_{{$parent_id}} @else tr_parent_id_{{$parent_id}} @endif" @else class="@if($item['parent_id'] == 0) parent_infor_{{$parent_id}} @else tr_parent_id_{{$parent_id}} @endif" @endif data-form-name="detailOrg" data-input="{{json_encode(['item'=>$item])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}{{$item['menu_name']}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="{{$item['menu_id']}}" @if($item['active'] == STATUS_INT_KHONG) style="background-color: #F8E0E6" @endif>
                        <td class="text-center text-middle">@if($show_button_parent > 0){!! $stt_key !!}@endif</td>
                        <td class="text-center text-middle">
                            @if($show_button_parent > 0)
                                <a href="javascript:void(0);" style="color: black!important;" onclick="showInfoBlock({{$parent_id}})" title="Xóa Item">
                                    <i class="{!! $item['menu_icons'] !!} fa-3x "></i>
                                </a>
                            @else
                                <i class="{!! $item['menu_icons'] !!} fa-2x"></i>
                            @endif
                        </td>
                        <td class="text-center text-middle">
                            {{$item['menu_id']}}
                        </td>
                        <td class="text-middle">
                            <span>
                                @if(in_array($item['menu_url'],$arrRouter))
                                    <a href="{{URL::route($item['menu_url'])}}" target="_blank">
                                        {!! $item['padding_left'].$item['padding_left'].$item['menu_name']!!}
                                    </a>
                                @else
                                    {!! $item['padding_left'].$item['padding_left'].$item['menu_name']!!}
                                @endif
                            </span>
                        </td>

                        <td class="text-left text-middle">
                            {!! $item['menu_url'] !!}
                        </td>
                        <td class="text-center text-middle">{!! $item['project_code'] !!}</td>
                        <td class="text-center text-middle">{!! $item['ordering'] !!}</td>

                        <td class="text-center text-middle">
                            @if($item['active'] == STATUS_INT_MOT)
                                <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-minus fa-2x"></i></a>
                            @endif
                            @if($is_root || $permission_edit || $permission_add)
                                {{--<a href="javascript:void(0);"class="a_none_color sys_show_popup_common" data-size="1" data-form-name="detailItem" title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{$urlGetItem}}" data-input="{{json_encode(['item'=>$item['object_menu']])}}" data-objectId="{{$item['menu_id']}}">
                                    <i class="pe-7s-note fa-2x"></i>
                                </a>--}}
                                <a href="javascript:void(0);" style="color: red" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Xóa menu: ')}}{{$item['menu_name']}}" data-method="post" data-url="{{$urlDeleteItem}}" data-input="{{json_encode(['item'=>$item['object_menu']])}}">
                                    <i class="fa fa-trash fa-2x"></i>
                                </a> &nbsp;
                            @endif
                        </td>
                    </tr>
                    <?php
                    if($item['parent_id'] == 0)
                        $stt_key = $stt_key+1;
                    ?>
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
<script type="text/javascript">
    function showInfoBlock(id) {
        var showhiden = $('#parent_infor_'+id).val();
        if(showhiden == 1){
            $('.parent_infor_'+id).css("background-color","#d6f6f6");
            $('.tr_parent_id_'+id).show();
            $('#parent_infor_'+id).val(0);
        }else{
            $('.parent_infor_'+id).css("background-color","");
            $('.tr_parent_id_'+id).hide();
            $('#parent_infor_'+id).val(1);
        }
    }
</script>
