{{----Edit và thêm mới----}}
<div class="formDetailItem" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="GROUP_NAME"></span>
        @else
            Thông tin nhóm chức năng
        @endif
    </div>
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$url_action}}">
        <input type="hidden" id="formName" name="formName" value="{{$form_id}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
        <input type="hidden" id="GROUP_CODE" name="GROUP_CODE" @if(isset($data->GROUP_CODE))value="{{$data->GROUP_CODE}}"@endif>

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tên nhóm chức năng')}}</label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="100" required name="GROUP_NAME" id="{{$form_id}}GROUP_NAME">
                </div>
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tổ chức')}} </label><span class="red"> (*)</span>
                    <select class="form-control input-sm" required name="ORG_CODE" id="{{$form_id}}ORG_CODE">
                        {!! $optionIsActive !!}
                    </select>
                </div>
                <div class="col-lg-2">
                    <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                    <select  class="form-control input-sm" name="IS_ACTIVE" id="IS_ACTIVE">
                        {!! $optionIsActive !!}}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả')}}</label>
                    <textarea class="form-control input-sm" name="DESCIRPTION" id="{{$form_id}}DESCIRPTION" rows="2"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        showDataIntoForm('{{$form_id}}');
    });
</script>
