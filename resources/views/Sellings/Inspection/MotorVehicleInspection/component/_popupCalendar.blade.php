<div class="modal-content" id="{{$formNameOther}}" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_{{$formNameOther}}">
        <input type="hidden" id="objectId" name="objectId" value="0">
        <input type="hidden" id="formName" name="formName" value="{{$formNameOther}}">
        <input type="hidden" id="typeTab" name="typeTab" value="{{$typeTab}}">
        <input type="hidden" id="dataItem" name="dataItem" value="{{json_encode($dataItem)}}">
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="user_email" class="red">Sau khi gọi điện thoại liên hệ với khách hàng, vui lòng nhập các thông tin để xác nhận lịch hẹn giám định</label>
                    </div>
                </div>
                <div class="row marginT5">
                    <div class="col-lg-4">
                        <label for="user_email">Ngày hẹn</label><span class="red"> (*)</span>
                        <input type="text" class="form-control input-sm input-date" required data-valid = "text" name="p_appointment_date_calen" id="p_appointment_date_calen" @if(isset($dataItem->EFF))value="{{$dataItem->EFF}}"@endif>
                        <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                    <div class="col-lg-4">
                        <label for="user_email">Từ giờ</label><span class="red"> (*)</span>
                        <div class="row">
                            <select  class="form-control input-sm col-lg-4" name="p_start_hours" id="p_start_hours" required>
                                {!! $optionStartHours !!}
                            </select>
                            <select  class=" form-control col-lg-4 input-sm" name="p_start_minute" id="p_start_minute">
                                {!! $optionStartMinute !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label for="user_email">Đến giờ</label><span class="red"> (*)</span>
                        <div class="row">
                            <select  class="form-control input-sm col-lg-4" name="p_end_hours" id="p_end_hours" required>
                                {!! $optionStartHours !!}
                            </select>
                            <select  class=" form-control col-lg-4 input-sm" name="p_end_minute" id="p_end_minute">
                                {!! $optionStartMinute !!}
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="user_email">Tên liên hệ</label><span class="red"> (*)</span>
                        <input type="text" required class="form-control input-sm" data-valid = "text" name="p_customer_name" id="p_customer_name" @if(isset($dataItem->NAME_CONTACT))value="{{$dataItem->NAME_CONTACT}}"@endif>
                    </div>
                    <div class="col-lg-4">
                        <label for="user_email">Số điện thoại</label><span class="red"> (*)</span>
                        <input type="text" required class="form-control input-sm" data-valid = "text" name="p_phone" id="p_phone" @if(isset($dataItem->PHONE))value="{{$dataItem->PHONE}}"@endif>
                    </div>
                    <div class="col-lg-4">
                        <label for="user_email">Nhân viên giám định</label><span class="red"> (*)</span>
                        <select class="form-control input-sm chosen-select" name="p_staff" id="form_{{$formNameOther}}_p_staff" >
                            {!! $optionUser !!}
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="user_email">Tỉnh thành</label><span class="red"> (*)</span>
                        <select class="form-control input-sm chosen-select" name="p_provice_id" id="form_{{$formNameOther}}_PROVINCE_CODE" onchange="jqueryCommon.buildOptionCommon('form_{{$formNameOther}}_PROVINCE_CODE','OPTION_DISTRICT_CODE','form_{{$formNameOther}}_DISTRICT_CODE')">
                            {!! $optionProvince !!}
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="user_email">Quận huyện</label><span class="red"> (*)</span>
                        <select class="form-control input-sm" name="p_district_id" required id="form_{{$formNameOther}}_DISTRICT_CODE" onchange="jqueryCommon.buildOptionCommon('form_{{$formNameOther}}_DISTRICT_CODE','OPTION_WARD_CODE','form_{{$formNameOther}}_WARD_CODE')">
                            {!! $optionDistrict !!}
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="user_email">Phường xã</label><span class="red"> (*)</span>
                        <select class="form-control input-sm" required name="p_ward_id" id="form_{{$formNameOther}}_WARD_CODE" >
                            {!! $optionWard !!}
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="user_email">Địa chỉ</label><span class="red"> (*)</span>
                        <input type="text" class="form-control input-sm" required name="p_address" id="p_address" @if(isset($dataItem->ADDRESS))value="{{$dataItem->ADDRESS}}"@endif>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            @if($is_root || $permission_edit || $permission_add)
                <button type="button" class="btn btn-primary" onclick="jqueryCommon.doActionPopup('{{$formNameOther}}','{{$urlUpdateCalendarInspection}}');">
                    <i class="pe-7s-diskette"></i> {{viewLanguage('Xác nhận lịch hẹn')}}
                </button>
            @endif
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="pe-7s-back"></i>{{viewLanguage('Cancel')}}
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy',minDate: 0});
    var config = {
        '.chosen-select'           : {width: "100%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    jQuery('.formatMoney').autoNumeric('init');

    var valu_staus = $('#CLAIM_STATUS_POPUP').val();
    showInforBoiThuong(valu_staus);
    getMoneyBoiThuongDefaul(valu_staus);
});
function getMoneyBoiThuongDefaul(valu_staus){
    var tong_boi_thuong = 0;
    var tong_money_yeu_cau = $('#tong_money_yeu_cau').val();//1000000 KH yeeu caafu

    //từ chối thì bằng só tiền yêu cầu
    if(valu_staus == 'TCBT' || valu_staus == 'TCKH' || valu_staus == 'TTBT'){
        $('.input_money_boi_thuong').each(function(){
            $(this).attr('disabled','disabled');
        });
        if(valu_staus == 'TCBT' || valu_staus == 'TCKH') {
            $('#tong_money_tu_choi').val(parseInt(0));
            $('#show_money_boi_thuong').html(0);
        }
    }else{
        $('.input_money_boi_thuong').each(function(){
            $(this).removeAttr('disabled');
            tong_boi_thuong = parseInt(tong_boi_thuong) + parseInt($(this).val());
        });
        if(parseInt(tong_boi_thuong) > 0){
            var tong_money_tu_choi = parseInt(tong_money_yeu_cau) - parseInt(tong_boi_thuong);
            $('#show_money_boi_thuong').html(jqueryCommon.numberFormat(tong_boi_thuong, '.', '.'));
            $('#tong_money_tu_choi').val(parseInt(tong_money_tu_choi));
            $('#tong_money').val(parseInt(tong_boi_thuong));
        }
    }
}
function changeMoneyBoiThuong(obj) {
    var tong_money_yeu_cau = $('#tong_money_yeu_cau').val();//1000000 KH yeeu caafu
    var id_input = obj.id;
    var money_boi_thuong = $(obj).val();//1.000.000: moi

    var money_boi_thuong_cu = parseInt($('#money_'+id_input).val()); //cu
    var tong_money_tu_choi = $('#tong_money_tu_choi').val();//1000000
    var tong_money = $('#tong_money').val();//1000000
    if(money_boi_thuong > 0){
        if(tong_money == 0){
            tong_money_tu_choi = parseInt(tong_money_yeu_cau) - parseInt(money_boi_thuong);
            tong_money = parseInt(money_boi_thuong);
        }else {
            var tong_money_moi = parseInt(tong_money) - parseInt(money_boi_thuong_cu) + parseInt(money_boi_thuong);
            if(parseInt(tong_money_moi) < 0 ||parseInt(tong_money_moi) > parseInt(tong_money_yeu_cau) || parseInt(tong_money_moi) == parseInt(tong_money_yeu_cau)){
                tong_money_tu_choi = 0;
                tong_money_tu_choi = parseInt(tong_money_yeu_cau) - parseInt(tong_money_yeu_cau);
                tong_money = parseInt(tong_money_moi);
            }else {
                tong_money_tu_choi = parseInt(tong_money_yeu_cau) - parseInt(tong_money_moi);
                tong_money = parseInt(tong_money_moi);
            }
        }
        $('#show_money_boi_thuong').html(jqueryCommon.numberFormat(tong_money, '.', '.'));
        $('#tong_money_tu_choi').val(parseInt(tong_money_tu_choi));

        $('#tong_money').val(parseInt(tong_money));
        $('#money_'+id_input).val(parseInt(money_boi_thuong));
    }else {
        tong_money_tu_choi = parseInt(tong_money_tu_choi) + parseInt(money_boi_thuong_cu);
        tong_money = parseInt(tong_money_yeu_cau) - parseInt(tong_money_tu_choi);

        $('#show_money_boi_thuong').html(jqueryCommon.numberFormat(tong_money, '.', '.'));
        $('#tong_money_tu_choi').val(parseInt(tong_money_tu_choi));

        $('#tong_money').val(parseInt(tong_money));
        $('#money_'+id_input).val(parseInt(0));
    }

}

function changeStatus(obj) {
    var valu_staus = $(obj).val();
    showInforBoiThuong(valu_staus);
}
function showInforBoiThuong(valu_staus) {

    if(valu_staus == 'TCBT' || valu_staus == 'TCKH' || valu_staus == 'TTBT'){
        var tong_money_yeu_cau = $('#tong_money_yeu_cau').val();//1000000 KH yeeu caafu
        $('.input_money_boi_thuong').each(function(){
            $(this).attr('disabled','disabled');
        });
        if(valu_staus == 'TCBT' || valu_staus == 'TCKH') {
            $('#tong_money_tu_choi').val(0);
            $('#show_money_boi_thuong').html(0);
        }
    }else {
        $('.input_money_boi_thuong').each(function () {
            $(this).removeAttr('disabled');
        });
        getMoneyBoiThuongDefaul(valu_staus);
    }
    //send email: TCKH,TCBT
    if (valu_staus == 'TCBT' || valu_staus == 'TTBT') {
        $("#dateboithuong").removeClass('display-none-block');
    }else {
        $("#dateboithuong").addClass('display-none-block');
    }

    //'TCBT','TTBT','TCKH','DYKH'
    if (valu_staus == 'TCBT' || valu_staus == 'TTBT'|| valu_staus == 'TCKH'|| valu_staus == 'DYKH') {
        $("#issendmail").removeClass('display-none-block');
        $("#listboithuong").removeClass('display-none-block');
    }
    else {
        $("#issendmail").addClass('display-none-block');
        $("#listboithuong").addClass('display-none-block');
    }
}

function changerRadio() {
    var is_send_mail_defaul = $("#is_send_mail_defaul").val();
    if (is_send_mail_defaul == 1) {
        $("#IS_SEND_MAIL_ACTION").val(0);
    } else {
        $("#IS_SEND_MAIL_ACTION").val(1);
    }
}
</script>