<div class="modal-content" id="{{$form_id}}" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_{{$form_id}}">
        <input type="hidden" id="objectId" name="objectId" @if($is_copy == STATUS_INT_MOT) value="0" @else value="{{$objectId}}"@endif>
        <input type="hidden" id="formName" name="formName" value="{{$form_id}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
        <input type="hidden" id="category_type" name="category_type" value="{{$category_type}}">
        <input type="hidden" id="strIndex" name="strIndex" value="{{$strIndex}}">
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
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Tên danh mục')}} <span class="red">(*)</span></label>
                            <input type="text" class="form-control input-sm" required name="category_name" id="{{$form_id}}category_name">
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right">{{viewLanguage('Danh mục cha')}}</label>
                            <select class="form-control input-sm" name="category_parent_id" id="category_parent_id" >
                                {!! $optionParentMenu !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Icons')}}</label>
                            <input type="text" class="form-control input-sm" name="category_icons" @if($objectId > 0) id="{{$form_id}}category_icons" @else value="pe-7s-config" @endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right">{{viewLanguage('Hiển thị header')}}</label>
                            <select class="form-control input-sm" name="category_menu_right" id="category_menu_right" >
                                {!! $optionShowMenu !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Order')}}</label>
                            <input type="text" class="form-control input-sm" name="category_order" @if($objectId > 0) id="{{$form_id}}category_order" @else value="1" @endif>
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
