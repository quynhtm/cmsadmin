<?php
$formNameOther = 'formPermissGroup';
?>
{{Form::open(array('method' => 'POST','class'=>$formNameOther,'id'=>$formNameOther,'role'=>'form','files' => true))}}
@if($is_root || $permission_edit || $permission_add)
    <button type="button" class="btn btn-primary" onclick="jqueryCommon.submitFormChildElement('{{$formNameOther}}','{{$urlPostData}}');">{{viewLanguage('Phân theo nhóm')}}</button>
@endif
<div class="clearfix marginT15">
    <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
    <input type="hidden" id="formName" name="formName" value="{{$formNameOther}}">
    <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataDetail)}}">
    <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
    <input type="hidden" id="actionUpdate" name="actionUpdate" value="updatePermissUserGroup">
    <input type="hidden" id="{{$formNameOther}}str_group_id" name="str_group_id">
    {{ csrf_field() }}
    <div class="form-group">
        <div class="row">
            {{--@if(!empty($groupMenu))--}}
            @if(isset($arrCheckPer) && !empty($arrCheckPer))
                @foreach($arrCheckPer as $key => $group_id)
                    @foreach($groupMenu as $kgm2 => $itemGroup2)
                        @if($itemGroup2->group_id == $group_id)
                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="ace ace-checkbox-2" onclick="clickCheckGroupMenu('{{$formNameOther}}')" name="group_permiss_chose" id="group_permiss_chose_{{$itemGroup2->group_id}}" value="{{$itemGroup2->group_id}}" @if(isset($arrCheckPer) && in_array($itemGroup2->group_id,$arrCheckPer)) checked="checked" @endif>
                                        <span class="lbl"> {{$itemGroup2->group_name}}</span>
                                    </label>
                                </div>
                            </div>
                            <?php
                                unset($groupMenu[$kgm2]);
                            ?>
                        @endif
                    @endforeach
                @endforeach
            @endif
            @foreach($groupMenu as $kgm => $itemGroup)
                <div class="col-sm-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="ace ace-checkbox-2" onclick="clickCheckGroupMenu('{{$formNameOther}}')" name="group_permiss_chose" id="group_permiss_chose_{{$itemGroup->group_id}}" value="{{$itemGroup->group_id}}">
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
        $("input[name*='group_permiss_chose']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                i++;
            }
        });
        var str_check = dataId.join();
        $('#'+form+'str_group_id').val(str_check);
    }
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });

</script>
