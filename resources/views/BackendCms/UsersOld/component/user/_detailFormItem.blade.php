{{---ID > 0 và có thông tin data---}}
<div class="formInforItem @if($objectId <= 0)display-none-block @endif">

    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="FULL_NAME"></span>
        @endif
    </div>
    <div class="marginT15">
        <div class="form-group" style="position: relative">
            @include('admin.AdminLayouts.buttonShowFormEdit')
            <div class="row form-group">
                <div class="col-lg-4">
                    Họ tên: <b class="showInforItem" data-field="FULL_NAME"></b>
                </div>
                <div class="col-lg-4">
                    User name: <b class="showInforItem" data-field="USER_NAME"></b>
                    @if($objectId > 0 && ($is_root))
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0);"class="red" onclick="jqueryCommon.getDataByAjax(this)" data-form-name="changePass" data-load-page="0" data-input="{{json_encode(['item'=>$data])}}" title="{{viewLanguage('Đổi mật khẩu: ').$data->FULL_NAME}}" data-show="0" data-method="get" data-url="{{$urlAjaxChangePass}}" data-objectId="{{setStrVar($data->USER_CODE)}}">
                            Reset mật khẩu
                        </a>
                    @endif
                </div>
                <div class="col-lg-4">
                    Mã nhân viên: <b class="showInforItem" data-field="EMP_CODE"></b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-4">
                    Chức vụ: <b class="showInforItem">@if(isset($data->POSITION_CODE) && $objectId > 0)@if(isset($arrChucVu[$data->POSITION_CODE])){{$arrChucVu[$data->POSITION_CODE]}} @endif @endif</b>
                </div>
                <div class="col-lg-8">
                    Tổ chức: <b class="showInforItem">@if(isset($data->ORG_CODE) && $objectId > 0)@if(isset($arrOrg[$data->ORG_CODE])){{$arrOrg[$data->ORG_CODE]}} @endif @endif</b>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-4">
                    Trạng thái: <b class="showInforItem">@if(isset($data->IS_ACTIVE) && $objectId > 0)@if(isset($arrStatus[$data->IS_ACTIVE])){{$arrStatus[$data->IS_ACTIVE]}} @endif @endif</b>
                </div>
                <div class="col-lg-8">
                    Phòng\ban: <b class="showInforItem">@if(isset($data->STRUCT_CODE) && $objectId > 0)@if(isset($arrDepart[$data->STRUCT_CODE])){{$arrDepart[$data->STRUCT_CODE]}} @endif @endif</b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-4">
                    Kiểu xác thực: <b class="showInforItem">@if(isset($data->AUTH_TYPE) && $objectId > 0)@if(isset($arrAuthType[$data->AUTH_TYPE])){{$arrAuthType[$data->AUTH_TYPE]}} @endif @endif</b>
                </div>
                <div class="col-lg-4">
                    Email: <b class="showInforItem" data-field="EMAIL"></b>
                </div>
                <div class="col-lg-4">
                    Phone: <b class="showInforItem" data-field="PHONE"></b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-4">
                    Kiểu người dùng: <b class="showInforItem">@if(isset($data->USER_TYPE) && $objectId > 0)@if(isset($arrUserType[$data->USER_TYPE])){{$arrUserType[$data->USER_TYPE]}} @endif @endif</b>
                </div>
                <div class="col-lg-4">
                    Ngày làm việc: <b class="showInforItem">@if(isset($data->EFFECTIVE_DATE) && $objectId > 0){{convertDateDMY($data->EFFECTIVE_DATE)}}@endif</b>
                </div>
                <div class="col-lg-4">
                    Ngày nghỉ viêc: <b class="showInforItem">@if(isset($data->EXPIRATION_DATE) && $objectId > 0){{convertDateDMY($data->EXPIRATION_DATE)}}@endif</b>
                </div>
            </div>
        </div>
    </div>
</div>

{{----Edit và thêm mới----}}
<div class="formEditItem @if($objectId > 0)display-none-block @endif" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin&nbsp;<span class="showInforItem" data-field="FULL_NAME"></span>
        @else
            Thông tin người dùng
        @endif
    </div>
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$url_action}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
        <input type="hidden" id="USER_CODE" name="USER_CODE" value="@if(isset($data->USER_CODE)){{$data->USER_CODE}}@endif">
        <input type="hidden" id="IS_VALIDATE" name="IS_VALIDATE" value="1">

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Họ và tên')}}</label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="100" required name="FULL_NAME" id="form_{{$formName}}_FULL_NAME">
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('User name')}} </label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="100" required name="USER_NAME" id="form_{{$formName}}_USER_NAME" @if($objectId > 0) readonly @endif>
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Mã nhân sự')}} </label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="100" name="EMP_CODE" id="form_{{$formName}}_EMP_CODE" >
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tổ chức')}} </label><span class="red"> (*)</span>
                    <select class="form-control chosen-select w-100" required name="ORG_CODE" id="form_{{$formName}}_ORG_CODE" onchange="jqueryCommon.buildOptionCommon('form_{{$formName}}_ORG_CODE','DEPART','form_{{$formName}}_STRUCT_CODE')">
                        {!! $optionOrg !!}
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Phòng ban')}} </label><span class="red"> (*)</span>
                    <select class="form-control input-sm" required name="STRUCT_CODE" id="form_{{$formName}}_STRUCT_CODE" >
                        {!! $optionDepart !!}
                    </select>
                </div>
                @if($objectId > 0)
                    <input type="hidden" class="form-control input-sm" maxlength="100" required name="PASSWORD" id="form_{{$formName}}_USER_NAME">
                @else
                    <div class="col-lg-4">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Mật khẩu')}} </label><span class="red"> {{DEFINE_PASSWORD_DEFAULT}}</span>
                        <input type="password" class="form-control input-sm" minlength="6" maxlength="20" required name="PASSWORD" value="{{DEFINE_PASSWORD_DEFAULT}}">
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label for="status" class="control-label">{{viewLanguage('Kiểu người dùng')}}</label><span class="red"> (*)</span>
                    <select  class="form-control input-sm" required name="USER_TYPE" id="USER_TYPE">
                        {!! $optionUserType !!}}
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Chức vụ')}} </label>
                    <select class="form-control input-sm" required name="POSITION_CODE" id="form_{{$formName}}_POSITION_CODE" >
                        {!! $optionChucVu !!}
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                    <select  class="mb-2 form-control" name="IS_ACTIVE" id="IS_ACTIVE">
                        {!! $optionStatus !!}}
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày hiệu lực')}}</label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm input-date" maxlength="100" required name="EFFECTIVE_DATE" value="@if(isset($data->EFFECTIVE_DATE)){{convertDateDMY($data->EFFECTIVE_DATE)}} @else {{date('d/m/Y')}}@endif">
                    <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label for="status" class="control-label">{{viewLanguage('Kiểu xác thực')}}</label>
                    <select  class="form-control input-sm" name="AUTH_TYPE" id="AUTH_TYPE">
                        {!! $optionAuthType !!}}
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Email')}} </label>
                    <input type="text" class="form-control input-sm" name="EMAIL" id="form_{{$formName}}_EMAIL">
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Số điện thoại')}} </label>
                    <input type="text" class="form-control input-sm" name="PHONE" id="form_{{$formName}}_PHONE">
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày nghỉ việc')}}</label>
                    <input type="text" class="form-control input-sm input-date" maxlength="100" name="EXPIRATION_DATE"  value="@if(isset($data->EXPIRATION_DATE)){{convertDateDMY($data->EXPIRATION_DATE)}}@endif">
                    <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        showDataIntoForm('form_{{$formName}}');

        var config = {
            '.chosen-select'           : {width: "100%"},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });
</script>