{{Form::open(array('method' => 'POST','class'=>$formNameOther,'id'=>'form_'.$formNameOther,'role'=>'form','files' => true))}}
    @if($is_root || $permission_edit || $permission_add)
    <div class="row">
        <?php
            $groupCode = (isset($data->GROUP_CODE))?$data->GROUP_CODE:'';
            $orgCode = (isset($data->ORG_CODE))?$data->ORG_CODE:'';
        ?>
        <div class="form-group col-lg-4">
            <select name="s_project_code" id="s_project_code_menu" class="form-control input-sm" onchange="Admin.getListMenuPermission('{{$groupCode}}','{{$orgCode}}','{{URL::route('menuGroup.ajaxGetListMenuPermission')}}','groupMenu')">
                {!! $optionSearchProjectCode !!}}
            </select>
        </div>
        <div class="form-group col-lg-4">
            <button type="button" class="btn btn-primary" onclick="jqueryCommon.submitFormChildElement('{{$formNameOther}}','{{$url_action_other_item}}');">{{viewLanguage('Phân quyền')}}</button>
        </div>
    </div>
    @endif
    <div class="clear1"></div>
    <div class="clear1 marginT15">
        <input type="hidden" id="{{$formNameOther}}objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="{{$formNameOther}}url_action" name="url_action" value="{{$url_action}}">
        <input type="hidden" id="{{$formNameOther}}formName" name="formName" value="{{$formNameOther}}">
        <input type="hidden" id="{{$formNameOther}}data_item" name="data_item" value="{{json_encode($dataOther)}}">

        <input type="hidden" id="{{$formNameOther}}GROUP_CODE" name="GROUP_CODE" @if(isset($data->GROUP_CODE))value="{{$data->GROUP_CODE}}"@endif>
        <input type="hidden" id="{{$formNameOther}}ORG_CODE" name="ORG_CODE" @if(isset($data->ORG_CODE))value="{{$data->ORG_CODE}}"@endif>
        <input type="hidden" id="{{$formNameOther}}ACTION_FORM" name="ACTION_FORM" value="{{$actionEdit}}">
        <input type="hidden" id="{{$formNameOther}}typeTabAction" name="typeTabAction" value="{{$typeTab}}">
        <input type="hidden" id="{{$formNameOther}}divShowIdAction" name="divShowIdAction" value="{{$divShowId}}">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="table-responsive" style="height: 400px; overflow: hidden; overflow-y: scroll" id="div_list_menu_permission">
                @include('Systems.OpenId.menuGroup.component._listPermission')
            </div>
        </div>
    </div>
{{ Form::close() }}
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });

    //hiển thị data in form
    showDataIntoForm('form_{{$formNameOther}}');

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
