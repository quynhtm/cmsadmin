{{----Edit và thêm mới----}}
<div class="formDetailItem" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="group_name"></span>
        @else
            Thông tin nhóm chức năng
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
            <div class="col-lg-10">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Tên nhóm chức năng')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" required name="group_name" id="{{$formName}}group_name">
            </div>
            <div class="col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                <select  class="form-control input-sm" name="is_active" id="is_active">
                    {!! $optionIsActive !!}}
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-10">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả')}}</label>
                <textarea class="form-control input-sm" name="description" id="{{$formName}}description" rows="2"></textarea>
            </div>

            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Vị trí')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" required name="sort_order" @if($objectId > STATUS_INT_KHONG) id="{{$formName}}sort_order" @else value="1" @endif>
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
