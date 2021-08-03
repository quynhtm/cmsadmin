{{Form::open(array('method' => 'POST','class'=>$formNameOther,'id'=>'form_'.$formNameOther,'role'=>'form','files' => true))}}
@if($is_root || $permission_add)
    @if($data->AUTO_CACHE == STATUS_INT_MOT && $data->BEHAV_CACHE == STATUS_INT_MOT)
        <button type="submit" class="btn btn-primary" id="{{$formNameOther}}" >{{viewLanguage('Lưu thông tin Behaviours Api')}}</button>
    @else
        Thông tin API phải có Auto cache là Có và Behav cache là Có mới cập nhật được
    @endif
@endif
<div class="clear1 marginT15">
    <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
    <input type="hidden" id="url_action" name="url_action" value="{{$urlActionOtherItem}}">
    <input type="hidden" id="formName" name="formName" value="{{$formNameOther}}">
    <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataOther)}}">

    <input type="hidden" id="{{$formNameOther}}ACTION_FORM" name="ACTION_FORM" value="{{$actionEdit}}">
    <input type="hidden" id="{{$formNameOther}}typeTabAction" name="typeTabAction" value="{{$typeTab}}">
    <input type="hidden" id="{{$formNameOther}}divShowIdAction" name="divShowIdAction" value="{{$divShowId}}">
    {{ csrf_field() }}
    <div class="form-group">
        <div class="row">
            <input type="hidden" id="{{$formNameOther}}API_CODE" name="API_CODE" value="{{$data->API_CODE}}">
            <div class="col-lg-4 ">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Behav code')}} </label>
                <input type="text" class="form-control input-sm" @if($actionEdit == STATUS_INT_MOT) readonly @endif name="BEHAV_CODE" id="form_{{$formNameOther}}_BEHAV_CODE">
            </div>
            <div class="col-lg-4 ">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Behav appear')}} </label>
                <input type="text" class="form-control input-sm" maxlength="5" name="BEHAV_APPEAR" id="form_{{$formNameOther}}_BEHAV_APPEAR">
            </div>
            <div class="col-lg-4 ">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Description')}} </label>
                <input type="text" class="form-control input-sm" name="DESCRIPTION" id="form_{{$formNameOther}}_DESCRIPTION">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-lg-4 ">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Time appear')}} </label>
                <input type="text" class="form-control input-sm" maxlength="7" name="TIME_APPEAR" id="form_{{$formNameOther}}_TIME_APPEAR">
            </div>
            <div class="col-lg-4 ">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Client tracking')}} </label>
                <input type="text" class="form-control input-sm" maxlength="1" name="CLIENT_TRACKING" id="form_{{$formNameOther}}_CLIENT_TRACKING">
            </div>
            <div class="col-lg-4 ">
                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                <select  class="form-control input-sm" required name="IS_ACTIVE" id="IS_ACTIVE">
                    {!! $optionStatus !!}}
                </select>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<script type="text/javascript">
    $("form#form_{{$formNameOther}}").submit(function(e) {
        e.preventDefault();
        var dataForm = new FormData(this);
        //var msg = 'Bạn có chắc chắc cập nhật thông tin này?';
        //$('#loaderRight').show();
        $.ajax({
            type: 'POST',
            url: "{{$urlActionOtherItem}}",
            data: dataForm,
            success: function (res) {
                $('#loaderRight').hide();
                if (res.success == 1) {
                    jqueryCommon.showMsg('success',res.message);
                    $('#'+res.divShowAjax).html(res.html);
                } else {
                    jqueryCommon.showMsg('error','','Thông báo lỗi',res.message);
                }
            },
            contentType: false,
            processData: false,
            cache: false
        });
        return false;
    });

    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
    //hiển thị data in form
    showDataIntoForm('form_{{$formNameOther}}');

    //tim kiem
    var config = {
        '.chosen-select'           : {width: "58%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
