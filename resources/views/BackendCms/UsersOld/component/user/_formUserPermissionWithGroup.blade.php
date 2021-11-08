{{Form::open(array('method' => 'POST','class'=>$formNameOther,'id'=>'form_'.$formNameOther,'role'=>'form','files' => true))}}
    @if($is_root || $permission_edit || $permission_add)
        <!--<button type="submit" class="btn btn-primary" id="{{$formNameOther}}" >{{viewLanguage('Save')}}</button>-->
        {{--@if(!empty($groupMenu))--}}
            <button type="button" class="btn btn-primary" onclick="jqueryCommon.submitFormChildElement('{{$formNameOther}}','{{$url_action_other_item}}');">{{viewLanguage('Phân quyền nhóm')}}</button>
        {{--@endif--}}
    @endif
    <div class="clearfix marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$url_action}}">
        <input type="hidden" id="formName" name="formName" value="{{$formNameOther}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataOther)}}">

        <input type="hidden" id="{{$formNameOther}}USER_CODE" name="USER_CODE" value="{{$data->USER_CODE}}">
        <input type="hidden" id="{{$formNameOther}}ORG_CODE" name="ORG_CODE" value="{{$data->ORG_CODE}}">
        <input type="hidden" id="{{$formNameOther}}GROUP_CODE" name="GROUP_CODE" @if(isset($dataOther->GROUP_CODE))value="{{$dataOther->GROUP_CODE}}"@endif>

        <input type="hidden" id="{{$formNameOther}}ACTION_FORM" name="ACTION_FORM" value="{{$actionEdit}}">
        <input type="hidden" id="{{$formNameOther}}typeTabAction" name="typeTabAction" value="{{$typeTab}}">
        <input type="hidden" id="{{$formNameOther}}divShowIdAction" name="divShowIdAction" value="{{$divShowId}}">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                {{--@if(!empty($groupMenu))--}}
                    @if(isset($chooseGroupMenu) && !empty($chooseGroupMenu))
                        @foreach($chooseGroupMenu as $kgm2 => $itemGroup2)
                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="ace ace-checkbox-2" onclick="clickCheckGroupMenu('{{$formNameOther}}')" name="group_menu_chose" id="group_menu_chose_{{$itemGroup2->GROUP_CODE}}" value="{{$itemGroup2->GROUP_CODE}}" @if(isset($arrSelectGroupMenu) && in_array($itemGroup2->GROUP_CODE,$arrSelectGroupMenu)) checked="checked" @endif>
                                        <span class="lbl"> {{$itemGroup2->GROUP_NAME}}</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @foreach($groupMenu as $kgm => $itemGroup)
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="ace ace-checkbox-2" onclick="clickCheckGroupMenu('{{$formNameOther}}')" name="group_menu_chose" id="group_menu_chose_{{$itemGroup->GROUP_CODE}}" value="{{$itemGroup->GROUP_CODE}}">
                                    <span class="lbl"> {{$itemGroup->GROUP_NAME}}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                {{--@else
                    Chưa có chức năng nào để phân quyền
                @endif--}}
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
