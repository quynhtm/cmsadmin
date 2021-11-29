<?php
$formNameOther = 'formPermissGroup';
?>
{{Form::open(array('method' => 'POST','class'=>$formNameOther,'id'=>'form_'.$formNameOther,'role'=>'form','files' => true))}}
@if($is_root || $permission_edit || $permission_add)
    <button type="button" class="btn btn-primary" onclick="jqueryCommon.submitFormChildElement('{{$formNameOther}}','{{$urlPostData}}');">{{viewLanguage('Phân theo nhóm')}}</button>
@endif
<div class="clearfix marginT15">
    <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
    <input type="hidden" id="url_action" name="url_action" value="{{$urlPostData}}">
    <input type="hidden" id="formName" name="formName" value="{{$formNameOther}}">
    <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataDetail)}}">
    <input type="hidden" id="{{$formNameOther}}GROUP_CODE" name="GROUP_CODE">
    {{ csrf_field() }}
    <div class="form-group">
        <div class="row">
            {{--@if(!empty($groupMenu))--}}
            @if(isset($chooseGroupMenu) && !empty($chooseGroupMenu))
                @foreach($chooseGroupMenu as $kgm2 => $itemGroup2)
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="ace ace-checkbox-2" onclick="clickCheckGroupMenu('{{$formNameOther}}')" name="group_menu_chose" id="group_menu_chose_{{$itemGroup2->group_id}}" value="{{$itemGroup2->group_id}}" @if(isset($arrSelectGroupMenu) && in_array($itemGroup2->group_id,$arrSelectGroupMenu)) checked="checked" @endif>
                                <span class="lbl"> {{$itemGroup2->group_name}}</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            @endif
            @foreach($groupMenu as $kgm => $itemGroup)
                <div class="col-sm-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="ace ace-checkbox-2" onclick="clickCheckGroupMenu('{{$formNameOther}}')" name="group_menu_chose" id="group_menu_chose_{{$itemGroup->group_id}}" value="{{$itemGroup->group_id}}">
                            <span class="lbl"> {{$itemGroup->group_name}}</span>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
{{ Form::close() }}
<script type="text/javascript">
    function clickCheckGroupMenu(form){
        var dataId = [];
        var i = 0;
        $("input[name*='group_menu_chose']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                i++;
            }
        });
        var str_check = dataId.join();
        $('#'+form+'GROUP_CODE').val(str_check);
    }
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });

</script>
