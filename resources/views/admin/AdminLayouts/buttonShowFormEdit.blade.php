@if($is_root || $permission_add || $permission_edit )
<div style="position: absolute; right: 0px; z-index: 10">
    <button type="button" class="btn btn-success" onclick="jqueryCommon.clickShowEditFormItem();"><i class="fa fa-edit"></i></button>
</div>
@endif