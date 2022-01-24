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
            <div class="col-lg-7">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Tên shop')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" required name="shop_name" id="{{$formName}}shop_name">
            </div>
            <div class="col-lg-2">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Danh xưng')}}</label>
                <select  class="form-control input-sm" name="shop_gender" id="shop_gender">
                    {!! $optionGender !!}}
                </select>
            </div>
            <div class="col-lg-3">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Người đại diện')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" required name="shop_representative" id="{{$formName}}shop_representative">
            </div>

        </div>
        <div class="row form-group">
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Phone')}}</label>
                <input type="text" class="form-control input-sm" name="shop_phone" id="{{$formName}}shop_phone">
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Email')}}</label>
                <input type="text" class="form-control input-sm" name="shop_email" id="{{$formName}}shop_email">
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('CMND/CCCD')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="shop_idcard" id="{{$formName}}shop_idcard">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Địa chỉ')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="shop_address" id="{{$formName}}shop_address">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('User đăng nhập')}}</label>
                <input type="text" class="form-control input-sm" name="user_shop" id="{{$formName}}user_shop">
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
