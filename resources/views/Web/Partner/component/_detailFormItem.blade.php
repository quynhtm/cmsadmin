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
                <label for="NAME" class="text-right control-label">{{viewLanguage('Tên đối tác')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" required name="partner_name" id="{{$formName}}partner_name">
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Web')}}</label><span class="red"> (*)</span>
                <input type="text" class="form-control input-sm" maxlength="100" required name="partner_web" id="{{$formName}}partner_web">
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Phone')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="partner_phone" id="{{$formName}}partner_phone">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                <select  class="form-control input-sm" name="is_active" id="is_active">
                    {!! $optionIsActive !!}}
                </select>
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Zalo')}}</label>
                <input type="text" class="form-control input-sm" name="partner_zalo" id="{{$formName}}partner_zalo">
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Email')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="partner_email" id="{{$formName}}partner_email">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Ghi chú')}}</label>
                <input type="text" class="form-control input-sm" maxlength="100" name="note" id="{{$formName}}note">
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
