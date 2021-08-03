{{---ID > 0 và có thông tin data---}}
<div class="formInforItem @if($objectId <= 0)display-none-block @endif">

    <div class="card-header">
        @if($objectId > 0)
            Thông tin Api code: &nbsp;<span class="showInforItem" data-field="API_CODE"></span>
        @endif
    </div>
    <div class="marginT15">
        <div class="form-group" style="position: relative">
            @include('admin.AdminLayouts.buttonShowFormEdit')
            <div class="row form-group">
                <div class="col-lg-3">
                    Api code: <b class="showInforItem" data-field="API_CODE"></b>
                </div>
                <div class="col-lg-5">
                    Procedure: <b class="showInforItem" data-field="PRO_CODE"></b>
                </div>
                <div class="col-lg-4">
                    Ngày bắt đầu: <b>@if(isset($data->EFFECTIVEDATE) && $objectId != '0'){{convertDateDMY($data->EFFECTIVEDATE)}}@endif</b>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-3">
                    Api name: <b class="showInforItem" data-field="API_NAME"></b>
                </div>
                <div class="col-lg-5">
                    Description: <b class="showInforItem" data-field="DESCRIPTION"></b>
                </div>
                <div class="col-lg-4">
                    Ngày kết thúc: <b>@if(isset($data->EXPIRATIONDATE) && $objectId != '0'){{convertDateDMY($data->EXPIRATIONDATE)}}@endif</b>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-3">
                    Trạng thái: <b class="showInforItem">@if(isset($data->ISACTIVE) && $objectId != '0')@if(isset($arrStatus[$data->ISACTIVE])){{$arrStatus[$data->ISACTIVE]}} @endif @endif</b>
                </div>
                <div class="col-lg-5">
                    Behav cache: <b class="showInforItem">@if(isset($data->BEHAVIOSCACHE) && $objectId != '0')@if(isset($arrYesOrNo[$data->BEHAVIOSCACHE])){{$arrYesOrNo[$data->BEHAVIOSCACHE]}} @endif @endif</b>
                </div>
                <div class="col-lg-4">
                    Auto cache: <b class="showInforItem">@if(isset($data->AUTOCACHE) && $objectId != '0')@if(isset($arrYesOrNo[$data->AUTOCACHE])){{$arrYesOrNo[$data->AUTOCACHE]}} @endif @endif</b>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-3">
                    Action type: <b class="showInforItem">@if(isset($data->ACTION_TYPE) && $objectId != '0')@if(isset($arrActionType[$data->ACTION_TYPE])){{$arrActionType[$data->ACTION_TYPE]}} @endif @endif</b>
                </div>
                <div class="col-lg-4">
                    Crud: <b class="showInforItem">@if(isset($data->CRUD) && $objectId != '0')@if(isset($arrActionType[$data->CRUD])){{$arrActionType[$data->CRUD]}} @endif @endif</b>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-3">
                    Group code: <b class="showInforItem" data-field="APIGROUP_CODE"></b>
                </div>
                <div class="col-lg-5">
                    Group name: <b class="showInforItem" data-field="GROUP_NAME"></b>
                </div>
                <div class="col-lg-3">
                    Trạng thái group: <b class="showInforItem">@if(isset($data->ACTIVE_GROUP) && $objectId != '0')@if(isset($arrStatus[$data->ACTIVE_GROUP])){{$arrStatus[$data->ACTIVE_GROUP]}} @endif @endif</b>
                </div>
            </div>
        </div>
    </div>
</div>

{{----Edit và thêm mới----}}
<div class="formEditItem @if($objectId > 0)display-none-block @endif" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin&nbsp;<span class="showInforItem" data-field="API_CODE"></span>
        @else
            Thông tin Api
        @endif
    </div>
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="@if(isset($data->GID))1 @else0 @endif">
        <input type="hidden" name="GID" id="form_{{$formName}}_GID" value="@if(isset($data->GID)){{$data->GID}}@else @endif">
        <input type="hidden" id="url_action" name="url_action" value="{{$urlPostItem}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">

        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                @if($objectId > 0)
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Api Code')}}</label>
                    <input type="text" class="form-control input-sm" maxlength="100" name="API_CODE" id="form_{{$formName}}_API_CODE" @if($objectId > 0) readonly @endif>
                </div>
                @else
                    <input type="hidden" class="form-control input-sm" maxlength="100" name="API_CODE" id="form_{{$formName}}_API_CODE">
                @endif
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Api name')}} </label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="100" required name="API_NAME" id="form_{{$formName}}_API_NAME">
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tên thủ tục')}} </label> <span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" required name="PRO_CODE" id="form_{{$formName}}_PRO_CODE">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Description')}} </label>
                    <input type="text" class="form-control input-sm" maxlength="150" name="DESCRIPTION" id="form_{{$formName}}_DESCRIPTION">
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày bắt đầu')}} </label>
                    <input type="text" class="form-control input-sm input-date" data-valid = "text" required name="EFFECTIVEDATE" value="@if(isset($data->EFFECTIVEDATE)){{convertDateDMY($data->EFFECTIVEDATE)}} @else {{date('d/m/Y')}}@endif">
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày kết thúc')}} </label>
                    <input type="text" class="form-control input-sm input-date" data-valid = "text" name="EXPIRATIONDATE" value="@if(isset($data->EXPIRATIONDATE)){{convertDateDMY($data->EXPIRATIONDATE)}}@endif">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4">
                    <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label> <span class="red"> (*)</span>
                    <select  class="form-control input-sm" required name="ISACTIVE" id="form_{{$formName}}_ISACTIVE">
                        {!! $optionStatus !!}}
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Cache')}} </label>
                    <select  class="form-control input-sm" name="AUTOCACHE" id="form_{{$formName}}_AUTOCACHE">
                        {!! $optionAutoCache !!}}
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Behavios cache')}} </label>
                    <select  class="form-control input-sm" name="BEHAVIOSCACHE" id="form_{{$formName}}_BEHAVIOSCACHE">
                        {!! $optionBehavCache !!}}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Action type')}} </label>
                    <select  class="form-control input-sm" name="ACTION_TYPE" id="form_{{$formName}}_ACTION_TYPE">
                        {!! $optionActionType !!}}
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Crud')}} </label>
                    <select  class="form-control input-sm" name="CRUD" id="form_{{$formName}}_CRUD">
                        {!! $optionCrud !!}}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Group code')}} </label> <span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="150" required name="APIGROUP_CODE" @if(isset($data->GID))id="form_{{$formName}}_APIGROUP_CODE" @else value="GR_PORTAL" @endif>
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Group name')}} </label> <span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="150" required name="GROUP_NAME"@if(isset($data->GID)) id="form_{{$formName}}_GROUP_NAME" @else value="GR PORTAL" @endif>
                </div>
                <div class="col-lg-4">
                    <label for="status" class="control-label">{{viewLanguage('Trạng thái group')}}</label> <span class="red"> (*)</span>
                    <select  class="form-control input-sm" required name="ACTIVE_GROUP" id="form_{{$formName}}_ACTIVE_GROUP">
                        {!! $optionStatus !!}}
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        showDataIntoForm('form_{{$formName}}');
    });
</script>