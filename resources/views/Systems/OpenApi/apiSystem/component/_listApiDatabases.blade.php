@if($is_root || $permission_edit || $permission_add)
    <div class="">
       <a href="javascript:void(0);" class="btn btn-info detailOtherCommon" onclick="jqueryCommon.getDataByAjax(this);" data-form-name="addFormOther" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetItemOther" data-input="{{json_encode(['type'=>$tabOtherItem1,'itemId'=>'','isDetail'=>STATUS_INT_MOT,'arrKey'=>['DataApiCode'=>$data]])}}" data-show="1" data-show-id="{{$tabOtherItem1}}" title="{{viewLanguage('Thêm database: ').$data->API_CODE}}" data-method="post" data-objectId="{{$data->API_CODE}}">
          <i class="pe-7s-plus"></i> {{viewLanguage('Add')}}
       </a>
    </div>
@endif
<div class="marginT5 table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thin-border-bottom">
        <tr class="table-background-header">
            <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
            <th width="3%" class="text-center">{{viewLanguage('TT')}}</th>
            <th width="20%" class="text-center">{{viewLanguage('DB code')}}</th>
            <th width="20%" class="text-center">{{viewLanguage('DB name')}}</th>
            <th width="25%" class="text-center">{{viewLanguage('Mô tả')}}</th>

            <th width="10%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
            <th width="15%" class="text-center">{{viewLanguage('Ngày')}}</th>
            <th width="15%" class="text-center">{{viewLanguage('User')}}</th>
        </tr>

        </thead>
        <tbody>
        @if(isset($dataOther) && !empty($dataOther))
            @foreach ($dataOther as $kb => $itemOther)
                <tr>
                    <td class="text-center middle">{{$kb+1}}</td>
                    <td class="text-center middle">
                        @if($is_root || $permission_view || $permission_add)
                            <a href="javascript:void(0);" style="color: green" onclick="jqueryCommon.getDataByAjax(this);" data-form-name="addFormOther" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetItemOther" data-input="{{json_encode(['type'=>$tabOtherItem1,'itemId'=>$itemOther->GID,'isDetail'=>STATUS_INT_MOT,'arrKey'=>['DataApiCode'=>$data]])}}" data-show="1" data-show-id="{{$tabOtherItem1}}" title="{{viewLanguage('View DB code: ').$itemOther->DB_CODE}}" data-method="post" data-objectId="{{$data->API_CODE}}">
                                <i class="pe-7s-look fa-2x"></i>
                            </a>
                        @endif
                    </td>
                    <td class="text-center middle">{{$itemOther->DB_CODE}}</td>
                    <td class="text-center middle">@if(isset($itemOther->DB_NAME)){{$itemOther->DB_NAME}}@endif</td>
                    <td class="text-center middle">{{$itemOther->DESCRIPTION}}</td>
                    <td class="text-center middle">@if($arrStatus[$itemOther->ISACTIVE]){{$arrStatus[$itemOther->ISACTIVE]}}@endif</td>
                    <td class="text-left middle">
                        @if(trim($itemOther->CREATEDATE) != ''){{convertDateDMY($itemOther->CREATEDATE)}} <br/>@endif
                        @if(trim($itemOther->MODIFIEDDATE) != '')<span class="red">{{convertDateDMY($itemOther->MODIFIEDDATE)}}</span>@endif
                    </td>
                    <td class="text-left middle">
                        @if(trim($itemOther->CREATEBY) != ''){{$itemOther->CREATEBY}}<br/>@endif
                        @if(trim($itemOther->MODIFIEDBY) != '')<span class="red">{{$itemOther->MODIFIEDBY}}</span>@endif
                    </td>
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