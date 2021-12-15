{{----Edit và thêm mới----}}
<div class="formDetailItem" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="news_title"></span>
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
            <div class="col-lg-8">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Tên tin bài')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" required name="news_title" id="{{$formName}}news_title">
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Loại tin')}}</label><span class="red"> (*)</span>
                <select  class="form-control input-sm" name="news_type" id="news_type">
                    {!! $optionNewsType !!}}
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-8">
                <div class="row form-group">
                    @if($partner_id == 0)
                    <div class="col-lg-6">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Đối tác')}}</label>
                        <select  class="form-control input-sm" name="partner_id" id="partner_id">
                            {!! $optionPartner !!}}
                        </select>
                    </div>
                    @else
                        <input type="hidden" name="partner_id"  @if($objectId > 0) id="{{$formName}}partner_id" @else value="{{$partner_id}}" @endif>
                    @endif
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Vị trí hiển thị')}}</label>
                        <input type="text" class="form-control input-sm" maxlength="100" name="news_order" id="{{$formName}}news_order">
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="news_status" id="news_status">
                            {!! $optionIsActive !!}}
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả ngắn')}}</label>
                        <textarea rows="4" class="form-control input-sm" name="news_desc_sort" id="{{$formName}}news_desc_sort"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-4"><label for="NAME" class="text-right control-label">{{viewLanguage('Danh mục')}}</label><span class="red"> (*)</span>
                <select  class="form-control input-sm" name="news_category" id="news_category">
                    {!! $optionCategory !!}}
                </select>

                <label for="NAME" class="text-right control-label marginT10">{{viewLanguage('Ảnh')}}</label>
                <br/>
                <input type="file" name="file_image_upload" id="file_image_upload">
                @if($objectId > 0 && trim($dataDetail['news_image']) != '')
                    <div>
                        <img src="{{getLinkImageShow(FOLDER_NEWS.'/'.$objectId,$dataDetail['news_image'])}}" width="100%" height="200">
                    </div>
                @endif
                <input type="hidden" name="news_image" id="{{$formName}}news_image">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả chi tiết')}}</label>
                <textarea class="form-control input-sm" rows="10" name="news_content" id="news_content">@if(isset($dataDetail['news_content'])){{$dataDetail['news_content']}}@endif</textarea>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    CKEDITOR.replace(
        'news_desc_sort',
        {
            toolbar: [
                { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                { name: 'colors',      items : [ 'TextColor','BGColor' ] },
            ],
        },
        {height:600}
    );
    CKEDITOR.replace('news_content', {height:800});
    function insertImgContent(src, title){
        CKEDITOR.instances.news_content.insertHtml('<img src="'+src+'" alt="'+title+'"/>');
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        showDataIntoForm('{{$formName}}');
    });
</script>
