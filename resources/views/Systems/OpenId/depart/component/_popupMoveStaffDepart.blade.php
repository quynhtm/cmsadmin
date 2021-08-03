<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{$titlePopup}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="formMoveDepart">
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Phòng ban cần chuyển')}} </label>
                <select class="form-control input-sm" name="STRUCT_CODE_NEW" id="STRUCT_CODE_NEW" >
                    {!! $optionDepart !!}
                </select>
            </div>
        </div>
    </div>
        <input type="hidden" name="strUserCode" id="strUserCode" value="{{$strUserCode}}">
        <input type="hidden" name="divLoadHtml" id="divLoadHtml" value="{{$divLoadHtml}}">
        <input type="hidden" required name="STRUCT_CODE_OLD" id="STRUCT_CODE_OLD" @if(isset($data->STRUCT_CODE))value="{{$data->STRUCT_CODE}}"@endif>
    </form>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        @if($is_root || $permission_edit || $permission_add)
        <a href="javascript:void(0);" class="btn btn-primary" onclick="Admin.actionMoveDepartOfStaff('formMoveDepart','{{$urlMoveDepart}}')">Save changes</a>
        @endif
    </div>
</div>