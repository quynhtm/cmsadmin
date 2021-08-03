<form id="form_{{$formName}}">
    <div style="position: relative">
        <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

        <div class="card-header">
            @if($objectId > 0)
                Thông tin &nbsp;<span class="showInforItem" data-field="MENU_NAME"></span>
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
                                <input type="hidden" id="url_action" name="url_action" value="{{$url_action}}">
                                <input type="hidden" id="formName" name="formName" value="{{$formName}}">
                                <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">

                                <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_MOT}}">
                                <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
                                {{ csrf_field() }}
                                <div class="form_group">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="NAME" class="text-right control-label">{{viewLanguage('Menu name')}} <span class="red">(*)</span></label>
                                                <input type="text" class="form-control input-sm" required name="MENU_NAME" id="form_{{$formName}}_MENU_NAME">
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="NAME" class="text-right control-label">{{viewLanguage('Mã Project')}} <span class="red">(*)</span></label>
                                                <select class="form-control input-sm" required name="PROJECT_CODE" id="form_{{$formName}}_PROJECT_CODE"onchange="jqueryCommon.buildOptionCommon('form_{{$formName}}_PROJECT_CODE','OPTION_MENU_PARENT','form_{{$formName}}_PARENT_CODE')" >
                                                    {!! $optionProjectCode !!}
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <label for="NAME" class="text-right control-label">{{viewLanguage('Controller name')}} <span class="red">(*)</span></label>
                                                <input type="text" class="form-control input-sm" required name="CONTROL_NAME" id="form_{{$formName}}_CONTROL_NAME">
                                            </div>
                                            <div class="col-lg-5">
                                                <label for="NAME" class="text-right">{{viewLanguage('Thuộc menu cha')}} <span class="red">(*)</span></label>
                                                <select class="form-control input-sm" name="PARENT_CODE" id="form_{{$formName}}_PARENT_CODE" >
                                                    {!! $optionMenuParent !!}
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="NAME" class="text-right">{{viewLanguage('Có link')}}</label>
                                                <select class="form-control input-sm" name="IS_LINK" id="form_{{$formName}}_IS_LINK" >
                                                    {!! $optionIsLink !!}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="NAME" class="text-right control-label">{{viewLanguage('Menu path')}} <span class="red">(*)</span></label>
                                                <input type="text" class="form-control input-sm" required name="MENU_PATH" id="form_{{$formName}}_MENU_PATH">
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="NAME" class="text-right control-label">{{viewLanguage('Menu Param')}}</label>
                                                <input type="text" class="form-control input-sm" name="MENU_PARAM" id="form_{{$formName}}_MENU_PARAM">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label for="NAME" class="text-right">{{viewLanguage('Trạng thái')}} <span class="red">(*)</span></label>
                                                <select class="form-control input-sm" required name="IS_ACTIVE" id="form_{{$formName}}_IS_ACTIVE" >
                                                    {!! $optionStatus !!}
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="NAME" class="text-right control-label">{{viewLanguage('Icon')}}</label>
                                                <input type="text" class="form-control input-sm" name="ICON" value="@if(isset($data->ICON) && trim($data->ICON) !=''){{$data->ICON}} @else pe-7s-config @endif" >
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="NAME" class="text-right control-label">{{viewLanguage('Order')}}</label>
                                                <input type="text" class="form-control input-sm" name="SORT_ORDER" id="form_{{$formName}}_SORT_ORDER" value="1" >
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
