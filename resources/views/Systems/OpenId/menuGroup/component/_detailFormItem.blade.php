{{---ID > 0 và có thông tin data---}}
<div class="formInforItem @if($objectId <= 0)display-none-block @endif">

    <div class="card-header">
        @if($objectId > 0)
            Thông tin&nbsp;<span class="showInforItem" data-field="GROUP_NAME"></span>
        @endif
    </div>
    <div class="marginT15">
        <div class="form-group" style="position: relative">
            @include('admin.AdminLayouts.buttonShowFormEdit')
            <div class="row form-group">
                <div class="col-lg-4">
                    Mã nhóm: <b class="showInforItem" data-field="GROUP_CODE"></b>
                </div>
                <div class="col-lg-8">
                    Tên nhóm: <b class="showInforItem" data-field="GROUP_NAME"></b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-4">
                    Trạng thái: <b class="showInforItem">@if(isset($data->IS_ACTIVE) && $objectId > 0)@if(isset($arrStatus[$data->IS_ACTIVE])){{$arrStatus[$data->IS_ACTIVE]}} @endif @endif</b>
                </div>
                <div class="col-lg-8">
                    Tổ chức: <b class="showInforItem">@if(isset($data->ORG_CODE) && $objectId > 0)@if(isset($arrOrg[$data->ORG_CODE])){{$arrOrg[$data->ORG_CODE]}} @endif @endif</b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-8">
                    Mô tả: <b class="showInforItem" data-field="DESCIRPTION"></b>
                </div>
            </div>
        </div>
    </div>
</div>

{{----Edit và thêm mới----}}
<div class="formEditItem @if($objectId > 0)display-none-block @endif" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="GROUP_NAME"></span>
        @else
            Thông tin nhóm chức năng
        @endif
    </div>
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$url_action}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
        <input type="hidden" id="GROUP_CODE" name="GROUP_CODE" @if(isset($data->GROUP_CODE))value="{{$data->GROUP_CODE}}"@endif>

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tên nhóm chức năng')}}</label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="100" required name="GROUP_NAME" id="form_{{$formName}}_GROUP_NAME">
                </div>
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tổ chức')}} </label><span class="red"> (*)</span>
                    <select class="form-control input-sm" required name="ORG_CODE" id="form_{{$formName}}_ORG_CODE">
                        {!! $optionOrg !!}
                    </select>
                </div>
                <div class="col-lg-2">
                    <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                    <select  class="form-control input-sm" name="IS_ACTIVE" id="IS_ACTIVE">
                        {!! $optionStatus !!}}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả')}}</label>
                    <textarea class="form-control input-sm" name="DESCIRPTION" id="form_{{$formName}}_DESCIRPTION" rows="2"></textarea>
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