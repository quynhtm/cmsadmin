    @if($is_root || $permission_add || $permission_edit)
        <button type="button" class="btn btn-primary submitFormItem" style="margin-bottom: 12px;" onclick="jqueryCommon.submitFormOtherItem('{{$formName}}','{{$urlActionOtherItem}}');"><i class="pe-7s-diskette"></i> {{viewLanguage('Update')}}</button>
        &nbsp;&nbsp;&nbsp;
    @endif
    <a href="javascript:void(0);" class="color_hdi" onclick="jqueryCommon.hideContentOtherRightPage()" title="{{viewLanguage('Close')}}">&nbsp;&nbsp;<i class="pe-7s-close fa-3x"></i>&nbsp;&nbsp;</a>
    &nbsp;&nbsp;&nbsp;
