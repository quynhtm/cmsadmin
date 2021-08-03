{{---ID > 0 và có thông tin data---}}
<div class="formInforItem @if($objectId <= 0)display-none-block @endif">

    <div class="card-header">
        @if($objectId > 0)
            Thông tin&nbsp;<span class="showInforItem" data-field="VERSION_CODE"></span>
        @endif
    </div>
    <div class="marginT15">
        <div class="form-group" style="position: relative">
            @include('admin.AdminLayouts.buttonShowFormEdit')
            <div class="row form-group">
                <div class="col-lg-12">
                    Version code: <b class="showInforItem" data-field="VERSION_CODE"></b>
                </div>
                <div class="col-lg-12">
                    Tình trạng: <b class="showInforItem">@if(isset($data->STATUS) && $objectId > 0)@if(isset($arrStatus[$data->STATUS])){{$arrStatus[$data->STATUS]}} @endif @endif</b>
                </div>
                <div class="col-lg-12">
                    Trạng thái: <b class="showInforItem">@if(isset($data->IS_ACTIVE) && $objectId > 0)@if(isset($arrActive[$data->IS_ACTIVE])){{$arrActive[$data->IS_ACTIVE]}} @endif @endif</b>
                </div>
            </div>
        </div>
    </div>
</div>

{{----Edit và thêm mới----}}
<div class="formEditItem @if($objectId > 0)display-none-block @endif" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="VERSION_CODE"></span>
        @else
            Thông tin version
        @endif
    </div>
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$urlActionPostItem}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
        <input type="hidden" id="form_{{$formName}}_VER_ID" name="VER_ID" value="0">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Version code')}}</label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="100" required name="VERSION_CODE" id="form_{{$formName}}_VERSION_CODE">
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tình trạng')}} </label><span class="red"> (*)</span>
                    <select class="form-control input-sm" required name="STATUS" id="form_{{$formName}}_STATUS">
                        {!! $optionStatus !!}
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                    <select  class="form-control input-sm" name="IS_ACTIVE" id="IS_ACTIVE">
                        {!! $optionActive !!}}
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