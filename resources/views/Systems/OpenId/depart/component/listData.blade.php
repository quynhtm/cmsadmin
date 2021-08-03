<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
        <div class="ibox-tools marginDownT6">
            @if($is_root || $permission_view)
                <button class="mb-2 mr-2 btn-icon btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
            @endif
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="form-group col-lg-4">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
            </div>
            <div class="form-group col-lg-6">
                <label for="depart_alias">{{viewLanguage('Đối tác')}}</label>
                <select class="form-control input-sm" name="ORG_CODE" id="ORG_CODE" >
                    {!! $optionOrg !!}
                </select>
            </div>
            <div class="form-group col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                <select  class="form-control input-sm" name="IS_ACTIVE" id="IS_ACTIVE">
                    {!! $optionStatus !!}}
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
                        {{--<th width="3%" class="text-center"><input type="checkbox" class="check" id="checkAll"></th>--}}
                        <th width="4%" class="text-center">{{viewLanguage('STT')}}</th>
                        <th width="8%" class="text-center">{{viewLanguage('Action')}}</th>
                        <th width="12%" class="text-center">{{viewLanguage('Mã phòng ban')}}</th>
                        <th width="31%" class="text-left">{{viewLanguage('Tên phòng ban')}}</th>
                        <th width="45%" class="text-left">{{viewLanguage('Địa chỉ')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr @if($is_root || $permission_view)class="detailCommon"@endif data-form-name="detailOrg" data-input="{{json_encode(['item'=>$item])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}{{$item->STRUCT_NAME}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="{{$item->ORG_CODE}}">
                            {{--<td class="text-center middle">
                                <input class="check" type="checkbox" name="checkItems[]" id="sys_checkItems" value="{{$item->ORG_CODE}}">
                            </td>--}}
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-center middle">
                                @if($is_root || $permission_edit || $permission_add)
                                    <a href="javascript:void(0);" style="color: red" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Xóa thông tin: ')}}{{$item->STRUCT_NAME}}" data-method="post" data-url="{{$urlDeleteItem}}" data-input="{{json_encode(['item'=>$item])}}">
                                        <i class="pe-7s-trash fa-2x"></i>
                                    </a>&nbsp;
                                @endif
                                @if($item->IS_ACTIVE == STATUS_INT_MOT)
                                    <a href="javascript:void(0);" class="green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                @else
                                    <a href="javascript:void(0);" class="red" title="Ẩn"><i class="fa fa-minus fa-2x"></i></a>
                                @endif
                            </td>
                            <td class="text-left middle">{{$item->STRUCT_CODE}}</td>
                            <td class="text-left middle">
                                <?php
                                    $level = getPrefixLevelName($item->ORG_LEVEL);
                                ?>
                                {{$level}}{{$item->STRUCT_NAME}}
                            </td>
                            <td class="text-left middle">{{$item->STRUCT_ADDRESS}}</td>
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
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
    //tim kiem
    var config = {
        '.chosen-select'           : {width: "100%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>