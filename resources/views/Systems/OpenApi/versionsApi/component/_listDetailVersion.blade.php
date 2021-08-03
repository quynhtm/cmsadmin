@if($is_root || $permission_edit || $permission_add)
    <div class="">
        <a href="javascript:void(0);" class="btn btn-info detailOtherCommon" onclick="jqueryCommon.getDataByAjax(this);" data-form-name="addFormOther" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetItemOther" data-input="{{json_encode(['type'=>$tabOtherItem1,'arrKey'=>['VER_ID'=>$data->VER_ID]])}}" data-show="1" data-show-id="{{$tabOtherItem1}}" title="{{viewLanguage('Thêm chi tiết version: ').$data->VERSION_CODE}}" data-method="post" data-objectId="0">
            <i class="pe-7s-plus"></i> {{viewLanguage('Add')}}
        </a>
    </div>
@endif
<div class="marginT5 table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thin-border-bottom">
        <tr>
            <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
            <th width="8%" class="text-center">{{viewLanguage('SERVER')}}</th>
            <th width="25%" class="text-center">{{viewLanguage('SCHEMA')}}</th>

            <th width="25%" class="text-center">{{viewLanguage('PACKAGES')}}</th>
            <th width="20%" class="text-center">{{viewLanguage('EDIT_NAME')}}</th>
            <th width="20%" class="text-center">{{viewLanguage('ACTION')}}</th>

            <th width="20%" class="text-center">{{viewLanguage('TYPE')}}</th>
            <th width="20%" class="text-center">{{viewLanguage('DESCRIPTION')}}</th>
            <th width="20%" class="text-center">{{viewLanguage('IS_ACTIVE')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($dataOther) && $dataOther)
        @foreach ($dataOther as $kb => $itemOther)
            <tr class="detailOtherCommon" onclick="jqueryCommon.getDataByAjax(this);" data-form-name="addFormOther" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetItemOther" data-input="{{json_encode(['type'=>$tabOtherItem1,'arrKey'=>['VER_ID'=>$data->VER_ID]])}}" data-show="1" data-show-id="{{$tabOtherItem1}}" title="{{viewLanguage('Thêm chi tiết version: ').$data->VERSION_CODE}}" data-method="post" data-objectId="{{$itemOther->DETAIL_ID}}">
                <td class="text-center">{{$kb+1}}</td>
                <td class="text-center">{{$itemOther->SERVER}}</td>
                <td class="text-center">{{$itemOther->SCHEMA}}</td>

                <td class="text-center">{{$itemOther->PACKAGES}}</td>
                <td class="text-center">{{$itemOther->EDIT_NAME}}</td>
                <td class="text-center">{{$itemOther->ACTION}}</td>

                <td class="text-center">{{$itemOther->TYPE}}</td>
                <td class="text-center">{{$itemOther->DESCRIPTION}}</td>
                <td class="text-center">@if($arrActive[$itemOther->IS_ACTIVE]){{$arrActive[$itemOther->IS_ACTIVE]}}@endif</td>
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