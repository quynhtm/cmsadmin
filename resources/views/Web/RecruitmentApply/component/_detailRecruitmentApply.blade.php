{{----Edit và thêm mới----}}
<div class="formDetailItem" >
    <div class="card-header">
         Thông tin người ứng tuyển
    </div>
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$urlPostData}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataDetail)}}">

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_MOT}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        <input type="hidden" id="actionUpdate" name="actionUpdate" value="updateData">
        {{ csrf_field() }}
        <div class="row form-group">
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Người ứng tuyển')}}</label>  <span class="red"> (<a href="#">Click Xem file CV</a>) </span>
                <input type="text" class="form-control input-sm" maxlength="100" readonly name="full_name" id="{{$formName}}full_name">
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Số điện thoại')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" readonly name="phone" id="{{$formName}}phone">
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Email')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" readonly name="email" id="{{$formName}}email">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Vị trí ứng tuyển')}}</label>
                <select  class="form-control input-sm" name="recruitment_position" id="recruitment_position" readonly>
                    {!! $optionPosition !!}}
                </select>
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Tỉnh thành')}}</label>
                <select  class="form-control input-sm" name="recruitment_province" id="recruitment_province" readonly>
                    {!! $optionProvince !!}}
                </select>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Giới tính')}}</label>
                <select  class="form-control input-sm" name="gender" id="gender" readonly>
                    {!! $optionGender !!}}
                </select>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái ứng tuyển')}}</label>
                <select  class="form-control input-sm" name="is_active" id="is_active" >
                    {!! $optionIsActive !!}}
                </select>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        //showDataIntoForm('{{$formName}}');
    });
</script>
