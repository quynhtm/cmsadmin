<div class="modal-content" id="{{$formName}}" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_{{$formName}}">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="typeTab" name="typeTab" value="{{$typeTab}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($inforItem)}}">

        <input type="hidden" id="form_{{$formName}}_DETAIL_ID" name="DETAIL_ID" value="{{$objectId}}">
        <input type="hidden" id="VERSION_CODE" name="VERSION_CODE" @if(isset($dataParent->VERSION_CODE))value="{{$dataParent->VERSION_CODE}}"@endif>
        <input type="hidden" id="VER_ID" name="VER_ID" @if(isset($dataParent->VER_ID))value="{{$dataParent->VER_ID}}"@endif>
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body">
            <div class="form_group">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('SERVER')}}</label> <span class="red">(*)</span>
                            <input type="text" class="form-control input-sm" maxlength="100" required name="SERVER" id="form_{{$formName}}_SERVER" @if($objectId > 0) readonly @endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('SCHEMA')}}</label> <span class="red">(*)</span>
                            <input type="text" class="form-control input-sm" maxlength="100" required name="SCHEMA" id="form_{{$formName}}_SCHEMA" @if($objectId > 0) readonly @endif>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('PACKAGES')}}</label> <span class="red">(*)</span>
                            <input type="text" class="form-control input-sm" maxlength="100" required name="PACKAGES" id="form_{{$formName}}_PACKAGES" @if($objectId > 0) readonly @endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right">{{viewLanguage('Trạng thái')}} <span class="red">(*)</span></label>
                            <select class="form-control input-sm" required name="IS_ACTIVE" id="form_{{$formName}}_IS_ACTIVE" >
                                {!! $optionActive !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('EDIT NAME')}}</label>
                            <input type="text" class="form-control input-sm" maxlength="100" name="EDIT_NAME" id="form_{{$formName}}_EDIT_NAME">
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('ACTION')}}</label>
                            <input type="text" class="form-control input-sm" maxlength="100" name="ACTION" id="form_{{$formName}}_ACTION">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('TYPE')}}</label>
                            <input type="text" class="form-control input-sm" maxlength="100" name="TYPE" id="form_{{$formName}}_TYPE">
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('DESCRIPTION')}}</label>
                            <input type="text" class="form-control input-sm" maxlength="100" required name="DESCRIPTION" id="form_{{$formName}}_DESCRIPTION">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
            @if($is_root || $permission_edit || $permission_add)
            <button type="button" class="btn btn-primary" onclick="jqueryCommon.doActionPopup('{{$formName}}','{{$urlActionOtherItem}}');"><i class="pe-7s-diskette"></i> {{viewLanguage('Save')}}</button>
            @endif
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        //var date_time = $('.input-date').datepicker({dateFormat: 'dd-mm-yy h:i'});

        showDataIntoForm('form_{{$formName}}');
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