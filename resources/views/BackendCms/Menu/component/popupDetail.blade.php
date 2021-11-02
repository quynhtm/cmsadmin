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
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Menu name')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required name="menu_name" id="{{$form_id}}menu_name">
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right">{{viewLanguage('Mã project')}} <span class="red">(*)</span></label>
                            <select class="form-control input-sm" required name="project_code" id="project_code" >
                                {!! $optionTypeMenu !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Controller name')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required name="controller_name" id="{{$form_id}}controller_name">
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right">{{viewLanguage('Thuộc menu cha')}}</label>
                            <select class="form-control input-sm" name="menu_parent" id="menu_parent" >
                                {!! $optionParentMenu !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Router name')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required name="router_name" id="{{$form_id}}router_name">
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Url')}}</label>
                            <input type="text" class="form-control input-sm" name="menu_url" id="{{$form_id}}menu_url">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Icons')}}</label>
                            <input type="text" class="form-control input-sm" name="menu_icon" @if($objectId > 0) id="{{$form_id}}menu_icon" @else value="pe-7s-config" @endif>
                        </div>
                        <div class="col-lg-2">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Order')}}</label>
                            <input type="text" class="form-control input-sm" name="menu_order" @if($objectId > 0) id="{{$form_id}}menu_order" @else value="1" @endif>
                        </div>
                        <div class="col-lg-2">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Có link')}}</label>
                            <select class="form-control input-sm" name="is_link" id="is_link" >
                                {!! $optionIsLink !!}
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}}</label>
                            <select class="form-control input-sm" name="is_active" id="is_active" >
                                {!! $optionActive !!}
                            </select>
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
