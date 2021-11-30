{{Form::open(array('method' => 'POST','class'=>$form_id,'id'=>'other_'.$form_id,'role'=>'form','files' => true))}}
    @if($is_root || $permission_edit || $permission_add)
    <div class="row">
        <?php
            $objectId = (isset($dataDetail['group_id'])) ? $dataDetail['group_id'] : 0;
        ?>
        <div class="form-group col-lg-4">
            <select name="s_project_code" id="s_project_code_menu" class="form-control input-sm" onchange="Admin.getListMenuPermission('{{$objectId}}','{{$urlGetData}}','permissGroup')">
                {!! $optionTypeMenu !!}}
            </select>
        </div>
        <div class="form-group col-lg-4">
            <button type="button" class="btn btn-primary" onclick="jqueryCommon.submitFormChildElement('other_{{$form_id}}','{{$urlPostData}}');">{{viewLanguage('Phân quyền')}}</button>
        </div>
    </div>
    @endif
    <div class="clear1"></div>
    <div class="clear1 marginT15">
        <input type="hidden" id="group_id" name="group_id" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$urlPostData}}">
        <input type="hidden" id="formName" name="formName" value="other_{{$form_id}}">
        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_MOT}}">
        <input type="hidden" id="actionUpdate" name="actionUpdate" value="updatePermissGroupDetail">

        {{ csrf_field() }}
        <div class="form-group">
            <div class="table-responsive" style="height: 400px; overflow: hidden; overflow-y: scroll" id="div_list_menu_permission">
                @include('BackendCms.PermissGroup.component._listPermission')
            </div>
        </div>
    </div>
{{ Form::close() }}
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
