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

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_MOT}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        <input type="hidden" id="actionUpdate" name="actionUpdate" value="updateData">
        {{ csrf_field() }}
        <div class="row form-group">
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Tiêu đề tuyển dụng')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" required name="recruitment_title" id="{{$formName}}recruitment_title">
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Vị trí ứng tuyển')}}</label><span class="red"> (*)</span>
                <select  class="form-control input-sm" name="recruitment_position" id="recruitment_position" required>
                    {!! $optionPosition !!}}
                </select>
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Tỉnh thành')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="recruitment_province" id="{{$formName}}recruitment_province">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày bắt đầu')}}</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="recruitment_date_start" id="{{$formName}}recruitment_date_start">
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày kết thúc')}}</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="recruitment_date_end" id="{{$formName}}recruitment_date_end">
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Số lượng')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="recruitment_number" id="{{$formName}}recruitment_number">
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Kinh nghiệm')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="recruitment_experience" id="{{$formName}}recruitment_experience">
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Mức lương')}}</label>
                <input type="text" class="form-control input-sm" maxlength="200" name="recruitment_salary" id="{{$formName}}recruitment_salary">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Nội dung tuyển dụng')}}</label>
                <textarea type="text" class="form-control input-sm" rows="10" name="recruitment_content" id="{{$formName}}recruitment_content"></textarea>
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
