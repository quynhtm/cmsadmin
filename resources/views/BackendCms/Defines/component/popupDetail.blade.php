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
                            <input type="text" class="form-control input-sm" required @if($objectId > STATUS_INT_KHONG)readonly @endif name="project_code" @if($objectId > STATUS_INT_KHONG) id="{{$form_id}}project_code" @else value ="ALL" @endif>
                        </div>
                        <div class="col-lg-2">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Order')}}</label>
                            <input type="text" class="form-control input-sm" required name="sort_order" @if($objectId > STATUS_INT_KHONG) id="{{$form_id}}sort_order" @else value="1" @endif>
                        </div>
                        <div class="col-lg-4">
                            <label for="NAME" class="text-right">{{viewLanguage('Trạng thái')}} <span class="red">(*)</span></label>
                            <select class="form-control input-sm" name="is_active" id="is_active" >
                                {!! $optionStatus !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('DEFINE CODE')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required @if($objectId > STATUS_INT_KHONG)readonly @endif name="define_code" id="{{$form_id}}define_code">
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('DEFINE NAME')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required @if($objectId > STATUS_INT_KHONG)readonly @endif name="define_name" id="{{$form_id}}define_name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('TYPE CODE')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required @if($objectId > STATUS_INT_KHONG && $is_copy == STATUS_INT_KHONG)readonly @endif name="type_code" id="{{$form_id}}type_code" @if(isset($data->type_code) && $is_copy==STATUS_INT_KHONG)value="{{$data->type_code}}"@endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('TYPE NAME')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required name="type_name" id="{{$form_id}}type_name" @if(isset($data->type_name) && $is_copy==STATUS_INT_KHONG)value="{{$data->type_name}}"@endif>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('DESCRIPTION')}}</label>
                            <input type="text" class="form-control input-sm" name="description" id="{{$form_id}}description">
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('LANGUAGE')}}</label>
                            <input type="text" class="form-control input-sm" name="language" @if($objectId > STATUS_INT_KHONG) id="{{$form_id}}language" @else value ="VN" @endif>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
            @if($permission_full || $permission_edit || $permission_add)
            <button type="button" class="btn btn-primary" onclick="jqueryCommon.doActionPopup('{{$form_id}}','{{$urlPostItem}}');"><i class="pe-7s-diskette"></i> {{viewLanguage('Save')}}</button>
            @endif
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        //var date_time = $('.input-date').datepicker({dateFormat: 'dd-mm-yy h:i'});
        showDataIntoForm('{{$form_id}}');
    });
</script>
