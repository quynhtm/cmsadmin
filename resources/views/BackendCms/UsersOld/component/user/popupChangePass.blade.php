<div class="modal-content" id="{{$formChangePass}}"style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_{{$formChangePass}}">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="loadPage" name="loadPage" value="{{$loadPage}}">
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
                        <div class="col-lg-12">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Mật khẩu mới')}} </label> <span class="red">(*)</span>
                            <input type="password" class="form-control input-sm" required name="NEW_PASSWORD" id="NEW_PASSWORD" minlength="6" maxlength="20">
                        </div>
                        <div class="col-lg-12">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Xác nhận mật khẩu mới')}}</label> <span class="red">(*)</span>
                            <input type="password" class="form-control input-sm" required name="CONFIRM_NEW_PASSWORD" id="CONFIRM_NEW_PASSWORD" minlength="6" maxlength="20">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
            <button type="button" class="btn btn-primary" onclick="jqueryCommon.doActionPopup('{{$formChangePass}}','{{$url_action_change_pass}}');"><i class="pe-7s-diskette"></i> {{viewLanguage('Save')}}</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        //var date_time = $('.input-date').datepicker({dateFormat: 'dd-mm-yy h:i'});
    });
</script>