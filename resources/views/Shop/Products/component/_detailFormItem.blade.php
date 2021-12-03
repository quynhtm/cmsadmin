{{----Edit và thêm mới----}}
<div class="formDetailItem" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="full_name"></span>
        @else
            Thông tin chung
        @endif
    </div>
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$urlPostData}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataDetail)}}">

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        <input type="hidden" id="actionUpdate" name="actionUpdate" value="updateData">
        {{ csrf_field() }}
        <div class="row form-group">
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('User name')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" required name="user_name" id="{{$formName}}user_name">
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Password')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" name="password" id="{{$formName}}password">
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Mã NV')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="user_code" id="{{$formName}}user_code">
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Full name')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" name="full_name" id="{{$formName}}full_name">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Email')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" name="user_email" id="{{$formName}}user_email">
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('CMND/CCCD')}}</label>
                <input type="text" class="form-control input-sm" name="user_card" id="{{$formName}}user_card">
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày sinh')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" name="user_birthday" id="{{$formName}}user_birthday">
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Giới tính')}}</label>
                <select  class="form-control input-sm" name="user_gender" id="user_gender">
                    {!! $optionGender !!}}
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Kiểu người dùng')}}</label><span class="red"> (*)</span>
                <select  class="form-control input-sm" name="user_type" id="user_type">
                    {!! $optionUserType !!}}
                </select>
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Chức vụ')}}</label><span class="red"> (*)</span>
                <select  class="form-control input-sm" name="user_position" id="user_position">
                    {!! $optionPosition !!}}
                </select>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                <select  class="form-control input-sm" name="is_active" id="is_active">
                    {!! $optionIsActive !!}}
                </select>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày bắt đầu')}}</label>
                <input type="text" class="form-control input-sm input-date" name="start_date" id="{{$formName}}start_date">
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày nghỉ việc')}}</label>
                <input type="text" class="form-control input-sm input-date" name="end_date" id="{{$formName}}end_date">
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        showDataIntoForm('{{$formName}}');
    });
</script>
