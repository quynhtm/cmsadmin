<div class="btn-actions-pane-right">
    @if($is_root || $permission_full || $permission_add || $permission_edit)
    <button type="button" class="btn btn-primary submitFormItem" onclick="jqueryCommon.doSubmitForm();"><i class="pe-7s-diskette"></i> {{viewLanguage('Update')}}</button>
    {{--<button type="button" class="btn btn-secondary cancelUpdate display-none-block" onclick="jqueryCommon.cancelUpdateFormItem();"><i class="pe-7s-back"></i> {{viewLanguage('Hủy bỏ')}}</button>--}}
    @endif
        <button type="button"  class="btn color_hdi" onclick="jqueryCommon.hideContentRightPage()" title="{{viewLanguage('Close')}}">&nbsp;&nbsp;<i class="pe-7s-close fa-3x"></i>&nbsp;&nbsp;</button>
    &nbsp;&nbsp;&nbsp;
</div>
