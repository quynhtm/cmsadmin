{{---ID > 0 và có thông tin data---}}
<div class="formInforItem @if($objectId <= 0)display-none-block @endif">
    <div class="card-header">
        @if($objectId > 0)
            Thông tin&nbsp;<span class="showInforItem" data-field="STRUCT_NAME"></span>
        @endif
    </div>
    <div class="marginT15">
        <div class="form-group" style="position: relative">
            @include('admin.AdminLayouts.buttonShowFormEdit')
            <div class="row form-group">
                <div class="col-lg-3">
                    Mã phòng: <b class="showInforItem" data-field="STRUCT_CODE"></b>
                </div>
                <div class="col-lg-9">
                    Tên phòng: <b class="showInforItem" data-field="STRUCT_NAME">f</b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-3">
                    Loại: <b class="showInforItem">@if(isset($data->ORG_STRUCT))@if(isset($arrOrgStruct[$data->ORG_STRUCT])){{$arrOrgStruct[$data->ORG_STRUCT]}} @endif @endif</b>
                </div>
                <div class="col-lg-9">
                    Thuộc phòng ban: <b class="showInforItem" >@if(isset($data->PARENT_STRUCT))@if(isset($arrDepart[$data->PARENT_STRUCT])){{$arrDepart[$data->PARENT_STRUCT]}} @endif @endif</b>
                </div>
                <div class="col-lg-3">
                    Trạng thái: <b class="showInforItem">@if(isset($data->IS_ACTIVE))@if(isset($arrStatus[$data->IS_ACTIVE])){{$arrStatus[$data->IS_ACTIVE]}} @endif @endif</b>
                </div>
                <div class="col-lg-9">
                    Thuộc tổ chức: <b class="showInforItem" >@if(isset($data->ORG_CODE))@if(isset($arrOrg[$data->ORG_CODE])){{$arrOrg[$data->ORG_CODE]}} @endif @endif</b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-12">
                    Địa chỉ: <b class="showInforItem" data-field="STRUCT_ADDRESS"></b>
                </div>
                <div class="col-lg-12">
                    Mô tả: <b class="showInforItem" data-field="DESCRIPTION"></b>
                </div>
            </div>
        </div>
    </div>
</div>

{{----Edit và thêm mới----}}
<div class="formEditItem @if($objectId > 0)display-none-block @endif" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin <span class="showInforItem" data-field="STRUCT_NAME"></span>
        @else
            Thông tin phòng ban
        @endif
    </div>
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$url_action}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
        <input type="hidden" id="STRUCT_CODE" name="STRUCT_CODE" @if(isset($data->STRUCT_CODE))value="{{$data->STRUCT_CODE}}"@endif>

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
<!--                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Mã phòng ban')}}</label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm"  @if($objectId > 0) readonly @endif  required name="STRUCT_CODE" id="form_{{$formName}}_STRUCT_CODE">
                </div>-->
                <div class="col-lg-9">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tên phòng ban')}} </label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" data-valid = "text" title="Tên phòng ban" required name="STRUCT_NAME" id="form_{{$formName}}_STRUCT_NAME">
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Loại phòng ban')}} </label><span class="red"> (*)</span>
                    <select class="form-control input-sm" @if($objectId == STATUS_INT_MOT) disabled @else required name="ORG_STRUCT" id="form_{{$formName}}_ORG_STRUCT" @endif >
                        {!! $optionOrgStruct !!}
                    </select>
                    @if($objectId == STATUS_INT_MOT)
                        <input type="hidden" name="ORG_STRUCT" id="form_{{$formName}}_ORG_STRUCT">
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}} </label><span class="red"> (*)</span>
                    <select class="form-control input-sm" name="IS_ACTIVE" id="form_{{$formName}}_IS_ACTIVE" >
                        {!! $optionStatus !!}
                    </select>
                </div>
                <div class="col-lg-5">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Thuộc phòng ban')}} </label>
                    <select class="form-control input-sm" name="PARENT_STRUCT" id="form_{{$formName}}_PARENT_STRUCT" >
                        {!! $optionDepart !!}
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Thuộc tổ chức')}} </label><span class="red"> (*)</span>
                    <select class="form-control input-sm" @if($objectId == STATUS_INT_MOT) disabled @else required name="ORG_CODE" id="form_{{$formName}}_ORG_CODE" @endif >
                        {!! $optionOrg !!}
                    </select>
                    @if($objectId == STATUS_INT_MOT)
                        <input type="hidden" name="ORG_CODE" id="form_{{$formName}}_ORG_CODE">
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Địa chỉ')}} </label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" required name="STRUCT_ADDRESS" id="form_{{$formName}}_STRUCT_ADDRESS">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả')}} </label>
                    <textarea class="form-control" name="DESCRIPTION" id="form_{{$formName}}_DESCRIPTION" rows="2"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        showDataIntoForm('form_{{$formName}}');
    });
</script>