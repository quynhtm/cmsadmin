<form id="form_{{$formName}}">
<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="DB_NAME"></span>
        @else
            Thông tin {{$title_popup}}
        @endif
        <div class="btn-actions-pane-right">
            <div class="btn-actions-pane-right">
                @if($is_root || $permission_edit || $permission_add)
                <button type="button" class="btn btn-primary submitFormItem22 @if($objectId > 0)display-none-block22 @endif" onclick="jqueryCommon.doSubmitForm();"><i class="pe-7s-diskette"></i> {{viewLanguage('Update')}}</button>
                <button type="button" class="btn btn-success cancelUpdate display-none-block" onclick="jqueryCommon.cancelUpdateFormItem();"><i class="pe-7s-refresh"></i> {{viewLanguage('Bỏ cập nhật')}}</button>
                @endif
                <button type="button" class="btn btn-secondary" onclick="jqueryCommon.hideContentRightPage()"><i class="pe-7s-back"></i> {{viewLanguage('Close')}}</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </div>
    </div>

    <div class="div-infor-right">
        <div class="main-card mb-3">
            <div class="card-body paddingTop-unset">
                {{---Block 1---}}
                <div class="" id="formShowEditSuccess">
                    <div class="formEditItem" >
                        <div class="marginT15">
                            <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
                            <input type="hidden" id="url_action" name="url_action" value="{{$urlActionPostItem}}">
                            <input type="hidden" id="formName" name="formName" value="{{$formName}}">
                            <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">

                            <input type="hidden" id="form_{{$formName}}_GID" name="GID" value="">
                            <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_MOT}}">
                            <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('DB_CODE')}}</label><span class="red"> (*)</span>
                                        <input type="text" class="form-control input-sm" required name="DB_CODE" id="form_{{$formName}}_DB_CODE">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('DB_NAME')}} </label><span class="red"> (*)</span>
                                        <input type="text" class="form-control input-sm" data-valid = "text" required name="DB_NAME" id="form_{{$formName}}_DB_NAME">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('ENVIROMENT_CODE')}}</label><span class="red"> (*)</span>
                                        <input type="text" class="form-control input-sm" required name="ENVIROMENT_CODE" @if(isset($data->GID)) id="form_{{$formName}}_ENVIROMENT_CODE" @else value="DEV" @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                                        <select class="form-control input-sm" required name="ISACTIVE" id="form_{{$formName}}_ISACTIVE" >
                                            {!! $optionStatus !!}
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('DB_MODE')}} </label>
                                        <input type="text" class="form-control input-sm" name="DB_MODE"  @if(isset($data->GID)) id="form_{{$formName}}_DB_MODE" @else value="ORACLE" @endif>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('SCHEMA')}} </label>
                                        <input type="text" class="form-control input-sm" name="SCHEMA" id="form_{{$formName}}_SCHEMA" >
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('PACKAGES')}}</label>
                                        <input type="text" class="form-control input-sm" name="PACKAGES" id="form_{{$formName}}_PACKAGES">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12  @if(isset($data->GID))display-none-block @endif">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Chuỗi connection')}} </label><span class="red"> (*)</span>
                                        <textarea type="text" class="form-control input-sm" required name="DATA" id="form_{{$formName}}_DATA" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
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