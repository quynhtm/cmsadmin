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
        <input type="hidden" id="isFormFile" name="isFormFile" value="{{STATUS_INT_MOT}}">
        <input type="hidden" id="actionUpdate" name="actionUpdate" value="updateData">
        {{ csrf_field() }}
        <div class="row form-group">
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Kiểu banner')}}</label><span class="red"> (*)</span>
                <select  class="form-control input-sm" name="banner_type" id="banner_type">
                    {!! $optionBannerType !!}}
                </select>
            </div>
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Tên banner')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" required name="banner_name" id="{{$formName}}banner_name">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Ảnh banner')}}</label>
                <br/>
                <input type="file" name="banner_image" id="banner_image">
                @if($objectId > 0 && trim($dataDetail['banner_image']) != '')
                    <div>
                        <img src="{{getLinkImageShow(FOLDER_BANNER.'/'.$objectId,$dataDetail['banner_image'])}}" width="350" height="200">
                    </div>
                @endif
                <input type="hidden" name="banner_image_old" id="banner_image_old" @if($objectId > 0)value="{{$dataDetail['banner_image']}}" @endif>
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Link banner')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" required name="banner_link" id="{{$formName}}banner_link">
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Is follow?')}}</label>
                <select  class="form-control input-sm" name="banner_is_rel" id="banner_is_rel">
                    {!! $optionIsRel !!}}
                </select>
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Mở thêm tab?')}}</label>
                <select  class="form-control input-sm" name="banner_is_target" id="banner_is_target">
                    {!! $optionIsTarget !!}}
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Thời gian bắt đầu')}}</label>
                <input type="text" class="form-control input-sm input-date" name="banner_start_time" id="{{$formName}}banner_start_time">
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Thời gian kết thúc')}}</label>
                <input type="text" class="form-control input-sm input-date" name="banner_end_time" id="{{$formName}}banner_end_time">
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Vị trí hiển thị')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="banner_order" id="{{$formName}}banner_order">
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                <select  class="form-control input-sm" name="is_active" id="is_active">
                    {!! $optionIsActive !!}}
                </select>
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
