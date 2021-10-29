<div class="modal-content" id="{{$form_id}}" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_{{$form_id}}">
        <input type="hidden" id="objectId" name="objectId" @if($is_copy == STATUS_INT_MOT) value="0" @else value="{{$objectId}}"@endif>
        <input type="hidden" id="formName" name="formName" value="{{$form_id}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
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
                            <label for="NAME" class="text-right control-label">{{viewLanguage('PROJECT CODE')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required @if($objectId > STATUS_INT_KHONG)readonly @endif name="PROJECT_CODE" id="PROJECT_CODE"  @if(isset($data->PROJECT_CODE))value="{{$data->PROJECT_CODE}}"@endif>
                        </div>
                        <div class="col-lg-2">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Order')}}</label>
                            <input type="text" class="form-control input-sm" required name="SORTORDER" id="SORTORDER" @if(isset($data->SORTORDER))value="{{$data->SORTORDER}}"@else value="1" @endif>
                        </div>
                        <div class="col-lg-4">
                            <label for="NAME" class="text-right">{{viewLanguage('Trạng thái')}} <span class="red">(*)</span></label>
                            <select class="form-control input-sm" required name="IS_ACTIVE" id="IS_ACTIVE" >
                                {!! $optionStatus !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('DEFINE CODE')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required @if($objectId > STATUS_INT_KHONG)readonly @endif name="DEFINE_CODE" id="DEFINE_CODE" @if(isset($data->DEFINE_CODE))value="{{$data->DEFINE_CODE}}"@endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('DEFINE NAME')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required @if($objectId > STATUS_INT_KHONG)readonly @endif name="DEFINE_NAME" id="DEFINE_NAME" @if(isset($data->DEFINE_NAME))value="{{$data->DEFINE_NAME}}"@endif>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('TYPE CODE')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required @if($objectId > STATUS_INT_KHONG && $is_copy == STATUS_INT_KHONG)readonly @endif name="TYPE_CODE" id="TYPE_CODE" @if(isset($data->TYPE_CODE) && $is_copy==STATUS_INT_KHONG)value="{{$data->TYPE_CODE}}"@endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('TYPE NAME')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required name="TYPE_NAME" id="TYPE_NAME" @if(isset($data->TYPE_NAME)  && $is_copy==STATUS_INT_KHONG)value="{{$data->TYPE_NAME}}"@endif>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('DESCRIPTION')}}</label>
                            <input type="text" class="form-control input-sm" name="DESCRIPTION" id="DESCRIPTION" @if(isset($data->DESCRIPTION))value="{{$data->DESCRIPTION}}"@endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('LANGUAGE')}}</label>
                            <input type="text" class="form-control input-sm" name="LANGUAGE" id="LANGUAGE" @if(isset($data->LANGUAGE))value="{{$data->LANGUAGE}}"@endif>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
            @if($is_root || $permission_edit || $permission_add)
            <button type="button" class="btn btn-primary" onclick="jqueryCommon.doActionPopup('{{$form_id}}','{{$url_action}}');"><i class="pe-7s-diskette"></i> {{viewLanguage('Save')}}</button>
            @endif
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        //var date_time = $('.input-date').datepicker({dateFormat: 'dd-mm-yy h:i'});
    });
</script>