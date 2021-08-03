@if($is_root || $permission_edit || $permission_add)
    <div class="">
        @if($data->IS_EVENT == STATUS_INT_MOT)
            <a href="javascript:void(0);" class="btn btn-info detailOtherCommon" onclick="jqueryCommon.getDataByAjax(this);" data-form-name="addFormOther" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetItemOther" data-input="{{json_encode(['type'=>$tabOtherItem3,'itemId'=>0,'isDetail'=>STATUS_INT_MOT,'arrKey'=>['VER_ID'=>0]])}}" data-show="1" data-show-id="{{$tabOtherItem1}}" title="{{viewLanguage('Thêm event api: ').$data->API_CODE}}" data-method="post" data-objectId="{{$data->API_CODE}}">
                <i class="pe-7s-plus"></i> {{viewLanguage('Add')}}
            </a>
        @else
            Thông tin API phải có Is event là Có mới cập nhật được
        @endif
    </div>
@endif
<div class="marginT5 table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thin-border-bottom">
        <tr class="table-background-header">
            <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
            <th width="20%" class="text-center">{{viewLanguage('Api code')}}</th>
            <th width="23%" class="text-center">{{viewLanguage('Api event code')}}</th>

            <th width="25%" class="text-center">{{viewLanguage('Type event')}}</th>
            <th width="15%" class="text-center">{{viewLanguage('Is async')}}</th>
            <th width="15%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($dataOther) && $dataOther)
            @foreach ($dataOther as $kb => $itemOther)
                <tr class="detailOtherCommon" @if($data->IS_EVENT == STATUS_INT_MOT)onclick="jqueryCommon.getDataByAjax(this);" @endif data-form-name="addFormOther" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetItemOther" data-input="{{json_encode(['type'=>$tabOtherItem3,'itemId'=>$itemOther->AE_ID,'isDetail'=>STATUS_INT_MOT,'arrKey'=>['API_CODE'=>$data->API_CODE,'API_EVENT_CODE'=>$itemOther->API_EVENT_CODE,'TYPE_EVENT'=>$itemOther->TYPE_EVENT]])}}" data-show="1" data-show-id="{{$tabOtherItem1}}" title="{{viewLanguage('Sửa event api: ').$data->API_CODE}}" data-method="post" data-objectId="{{$data->API_CODE}}">
                    <td class="text-center">{{$kb+1}}</td>
                    <td class="text-center">{{$itemOther->API_CODE}}</td>
                    <td class="text-center">{{$itemOther->API_EVENT_CODE}}</td>

                    <td class="text-center">{{$itemOther->TYPE_EVENT}}</td>
                    <td class="text-center">{{$itemOther->IS_ASYNC}}</td>
                    <td class="text-center">@if($arrStatus[$itemOther->IS_ACTIVE]){{$arrStatus[$itemOther->IS_ACTIVE]}}@endif</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
<div class="paging_simple_numbers">

</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
    //tim kiem
    var config = {
        '.chosen-select'           : {width: "58%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>