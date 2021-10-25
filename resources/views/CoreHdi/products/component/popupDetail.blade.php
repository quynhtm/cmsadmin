<form id="form_{{$formName}}">
<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="BANK_NAME"></span>
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

                            <input type="hidden" id="form_{{$formName}}_BANK_ID" name="BANK_ID" value="0">
                            <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_MOT}}">
                            <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Bank Code')}}</label><span class="red"> (*)</span>
                                        <input type="text" class="form-control input-sm"  required name="BANK_CODE" id="form_{{$formName}}_BANK_CODE">
                                    </div>
                                    <div class="col-lg-8">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Bank Name')}} </label><span class="red"> (*)</span>
                                        <input type="text" class="form-control input-sm" data-valid = "text" title="Tên tổ chức" required name="BANK_NAME" id="form_{{$formName}}_BANK_NAME">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}}</label>
                                        <select class="form-control input-sm" required name="IS_ACTIVE" id="form_{{$formName}}_IS_ACTIVE" >
                                            {!! $optionStatus !!}
                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Parent bank')}} </label><span class="red"> (*)</span>
                                        <select class="form-control input-sm" name="PARENT_CODE" id="form_{{$formName}}_PARENT_CODE" >
                                            {!! $optionBankParent !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Email')}} </label>
                                        <input type="text" class="form-control input-sm" name="EMAIL" id="form_{{$formName}}_EMAIL" >
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Website')}}</label>
                                        <input type="text" class="form-control input-sm" name="WEBSITE" id="form_{{$formName}}_WEBSITE">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Phone')}} </label>
                                        <input type="text" class="form-control input-sm" name="PHONE_SERVICE" id="form_{{$formName}}_PHONE_SERVICE">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Địa chỉ')}} </label><span class="red"> (*)</span>
                                        <input type="text" class="form-control input-sm" required name="BANK_ADDRESS" id="form_{{$formName}}_BANK_ADDRESS">
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