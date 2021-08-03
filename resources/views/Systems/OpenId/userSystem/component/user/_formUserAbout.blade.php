{{Form::open(array('method' => 'POST','class'=>$formNameOther,'id'=>'form_'.$formNameOther,'role'=>'form','files' => true))}}
    @if($is_root || $permission_add)
     <button type="submit" class="btn btn-primary" id="{{$formNameOther}}" >{{viewLanguage('Lưu thông tin cá nhân')}}</button>
    @endif
    <div class="clear1 marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$url_action}}">
        <input type="hidden" id="formName" name="formName" value="{{$formNameOther}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataOther)}}">

        <input type="hidden" id="{{$formNameOther}}USER_CODE" name="USER_CODE" value="{{$data->USER_CODE}}">
        <input type="hidden" id="{{$formNameOther}}ORG_CODE" name="ORG_CODE" value="{{$data->ORG_CODE}}">
        <input type="hidden" id="{{$formNameOther}}POSITION_CODE" name="POSITION_CODE" value="{{$data->POSITION_CODE}}">
        <input type="hidden" id="{{$formNameOther}}EMAIL" name="EMAIL" value="{{$data->EMAIL}}">
        <input type="hidden" id="{{$formNameOther}}PHONE" name="PHONE" value="{{$data->PHONE}}">
        <input type="hidden" id="{{$formNameOther}}MENU_CODE" name="MENU_CODE" value="-1">

        <input type="hidden" id="{{$formNameOther}}ACTION_FORM" name="ACTION_FORM" value="{{$actionEdit}}">
        <input type="hidden" id="{{$formNameOther}}typeTabAction" name="typeTabAction" value="{{$typeTab}}">
        <input type="hidden" id="{{$formNameOther}}divShowIdAction" name="divShowIdAction" value="{{$divShowId}}">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <!--<div class="col-lg-4">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('First name')}}</label><span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" maxlength="100" required name="FIRST_NAME" id="form_{{$formNameOther}}_FIRST_NAME">
                        </div>
                        <div class="col-lg-4">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Last name')}} </label><span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" data-valid = "text" maxlength="100" required name="LAST_NAME" id="form_{{$formNameOther}}_LAST_NAME">
                        </div>-->
                        <input type="hidden" class="form-control input-sm" maxlength="100" name="FIRST_NAME" id="form_{{$formNameOther}}_FIRST_NAME">
                        <input type="hidden" class="form-control input-sm" data-valid = "text" maxlength="100" name="LAST_NAME" id="form_{{$formNameOther}}_LAST_NAME">
                        <div class="col-lg-6 marginT5">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày sinh')}} </label><span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm input-date" data-valid = "text" required name="BIRTHDAY" id="form_{{$formNameOther}}_BIRTHDAY">
                            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        <div class="col-lg-6 marginT5">
                            <label for="status" class="control-label">{{viewLanguage('Giới tính')}}</label>
                            <select  class="form-control input-sm" name="GENDER" id="GENDER">
                                {!! $optionGender !!}}
                            </select>
                        </div>
                        <div class="col-lg-6 marginT5">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số CMT')}} </label>
                            <input type="text" class="form-control input-sm" data-valid = "text" name="ID_CARD" id="form_{{$formNameOther}}_ID_CARD">
                        </div>
                        <div class="col-lg-6 marginT5">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số hộ chiếu')}} </label>
                            <input type="text" class="form-control input-sm" data-valid = "text" name="PASSPORT_NO" id="form_{{$formNameOther}}_PASSPORT_NO">
                        </div>
                    </div>
                </div>
                {{--Ảnh cá nhân--}}
                <div class="col-lg-3">
                    <div class="control-group">
                        <div class="controls">
                            <div id="sys_show_image_one" style="width:100%; height: 115px; overflow: hidden; text-align: center">
                                @if(isset($dataOther->IMAGE) && trim($dataOther->IMAGE) != '')
                                    <img src="{{getLinkFileToStore($dataOther->IMAGE,false)}}" width="120"/>
                                @else
                                    <img src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/icon/no-profile-image.gif" width="120"/>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="control-group text-center" style="margin-top: 10px">
                        <input type="hidden" name="IMAGE" id="form_{{$formNameOther}}_IMAGE">
                        <div>
                            <input type="file" name="inputFile" id="inputImage">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}
<script type="text/javascript">
    $("form#form_{{$formNameOther}}").submit(function(e) {
        e.preventDefault();
        var dataForm = new FormData(this);
        var msg = 'Bạn có chắc chắc cập nhật thông tin này?';
        $('#loaderRight').show();
        $.ajax({
            type: 'POST',
            url: "{{URL::route('userSystem.ajaxUpdateUserRelation')}}",
            data: dataForm,
            success: function (res) {
                $('#loaderRight').hide();
                if (res.success == 1) {
                    jqueryCommon.showMsg('success',res.message);
                    $('#'+res.divShowAjax).html(res.html);
                } else {
                    jqueryCommon.showMsg('error','','Thông báo lỗi',res.message);
                }
            },
            contentType: false,
            processData: false,
            cache: false
        });
        return false;
    });

    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
    //hiển thị data in form
    showDataIntoForm('form_{{$formNameOther}}');
</script>
