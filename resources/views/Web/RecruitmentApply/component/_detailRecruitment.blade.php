{{----Edit và thêm mới----}}
<div class="formDetailItem" >
    <div class="card-header">
          Thông tin tuyển dụng
    </div>
    <div class="marginT15">
        <div class="row form-group">
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Tiêu đề tuyển dụng')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" readonly name="recruitment_title" id="{{$formName}}recruitment_title">
            </div>
            @if($partner_id == 0)
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Đối tác')}}</label>
                    <select  class="form-control input-sm" name="partner_id" id="partner_id" readonly>
                        {!! $optionPartner !!}}
                    </select>
                </div>
            @else
                <input type="hidden" name="partner_id"  @if($objectId > 0) id="{{$formName}}partner_id" @else value="{{$partner_id}}" @endif>
            @endif
        </div>
        <div class="row form-group">
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Vị trí ứng tuyển')}}</label>
                <select  class="form-control input-sm" name="recruitment_position" id="recruitment_position" readonly>
                    {!! $optionPosition !!}}
                </select>
            </div>
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Tỉnh thành')}}</label>
                <select  class="form-control input-sm" name="recruitment_province" id="recruitment_province" readonly>
                    {!! $optionProvince !!}}
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày bắt đầu')}}</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="recruitment_date_start" id="{{$formName}}recruitment_date_start" readonly>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày kết thúc')}}</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="recruitment_date_end" id="{{$formName}}recruitment_date_end" readonly>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Số lượng')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="recruitment_number" id="{{$formName}}recruitment_number" readonly>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Kinh nghiệm')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="recruitment_experience" id="{{$formName}}recruitment_experience" readonly>
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Mức lương')}}</label>
                <input type="text" class="form-control input-sm" maxlength="200" name="recruitment_salary" id="{{$formName}}recruitment_salary" readonly>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả')}}</label>
                <textarea class="form-control input-sm" disabled name="recruitment_description" id="recruitment_description">@if(isset($dataDetail['recruitment_description'])){!! $dataDetail['recruitment_description'] !!}@endif</textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Yêu cầu')}}</label>
                <textarea rows="10" class="form-control input-sm" disabled name="recruitment_request" id="recruitment_request">@if(isset($dataDetail['recruitment_request'])){!! $dataDetail['recruitment_request'] !!}@endif</textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Quyền lợi')}}</label>
                <textarea rows="10" class="form-control input-sm" disabled name="recruitment_benefits" id="recruitment_benefits">@if(isset($dataDetail['recruitment_benefits'])){!! $dataDetail['recruitment_benefits'] !!}@endif</textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Yêu cầu hồ sơ')}}</label>
                <textarea rows="10" class="form-control input-sm" disabled name="recruitment_request_profile" id="recruitment_request_profile">@if(isset($dataDetail['recruitment_request_profile'])){!! $dataDetail['recruitment_request_profile'] !!}@endif</textarea>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    CKEDITOR.replace(
        'recruitment_description',
        {
            toolbar: [
                { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                { name: 'colors',      items : [ 'TextColor','BGColor' ] },
            ],
        },
        {height:800}
    );
    CKEDITOR.replace(
        'recruitment_request',
        {
            toolbar: [
                { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                { name: 'colors',      items : [ 'TextColor','BGColor' ] },
            ],
        },
        {height:500}
    );
    CKEDITOR.replace(
        'recruitment_benefits',
        {
            toolbar: [
                { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                { name: 'colors',      items : [ 'TextColor','BGColor' ] },
            ],
        },
        {height:500}
    );
    CKEDITOR.replace(
        'recruitment_request_profile',
        {
            toolbar: [
                { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                { name: 'colors',      items : [ 'TextColor','BGColor' ] },
            ],
        },
        {height:500}
    );
</script>
<script type="text/javascript">

    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        showDataIntoForm('{{$formName}}');
    });
</script>
