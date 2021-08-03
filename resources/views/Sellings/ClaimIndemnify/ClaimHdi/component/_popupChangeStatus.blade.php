<div class="modal-content" id="{{$formNameOther}}" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_{{$formNameOther}}">
        <input type="hidden" id="objectId" name="objectId" value="0">
        <input type="hidden" id="formName" name="formName" value="{{$formNameOther}}">
        <input type="hidden" id="typeTab" name="typeTab" value="{{$typeTab}}">
        <input type="hidden" id="dataClaim" name="dataClaim" value="{{json_encode($dataClaim)}}">
        <input type="hidden" id="dataItem" name="dataItem" value="{{json_encode($dataItem)}}">
        <input type="hidden" id="listBoiThuong" name="listBoiThuong" value="{{json_encode($listBoiThuong)}}">
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body paddingBottom-unset">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="NAME" class="text-right">{{viewLanguage('Trạng thái')}}</label> <span
                            class="red">(*)</span>
                        <select class="form-control input-sm" required id="CLAIM_STATUS_POPUP" name="CLAIM_STATUS" onchange="changeStatus(this);">
                            {!! $optionStatusPopup !!}
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label for="NAME" class="text-right">{{viewLanguage('Nhân viên xử lý')}}</label>
                        <span class="form-control">
                            {{$userAction['user_full_name']}}
                        </span>
                    </div>
                </div>
            </div>
            {{-----DYKH,TTBT-----}}
            @if(isset($listBoiThuong) && !empty($listBoiThuong))
                <div class="display-none-block" id="listboithuong">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 display-none-block" id="dateboithuong">
                                <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày xử lý')}}</label>
                                <span class="red">(*)</span>
                                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="PAY_DATE" id="PAY_DATE" @if(isset($dataClaim['PAY_DATE']) && trim($dataClaim['PAY_DATE']) !='')value="{{$dataClaim['PAY_DATE']}}" @else value="{{date('d/m/Y')}}" @endif>
                                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                            </div>
                            <div class="col-lg-6 display-none-block" id="chose_add_claim">
                                <label for="NAME" class="text-right">{{viewLanguage('Chọn quyền lợi bồi thường')}}</label>
                                <select class="form-control input-sm" id="option_claim" name="option_claim" onchange="changeOptionClaim(this,'{{$urlAjaxGetData}}');">
                                    {!! $optionBoiThuong !!}
                                </select>
                            </div>

                            @if(isset($dataItem['REQUIRED_AMOUNT']) && $dataItem['REQUIRED_AMOUNT'] > 0)
                            <div class="col-lg-6">
                                <label for="NAME" class="text-right control-label">{{viewLanguage('Số tiền KH yêu cầu bồi thường')}}</label>
                                <span class="red">(*)</span>
                                <input type="text" name="REQUIRED_AMOUNT" id="REQUIRED_AMOUNT" value="{{numberFormat($dataItem['REQUIRED_AMOUNT'])}}" readonly class="form-control input-sm text-right">
                                <input type="hidden" name="tong_money_yeu_cau" id="tong_money_yeu_cau" value="{{$dataItem['REQUIRED_AMOUNT']}}">
                            </div>
                            @endif

                        </div>
                    </div>

                    <!---Phần mới--->
                    <div class="form-group" id="table_list_claim">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="NAME" class="text-right">{{viewLanguage('Số tiền HDI bồi thường')}}</label> <span class="red">(*)</span>
                                <table class="table table-bordered table-hover marginBottom-unset">
                                    <thead class="thin-border-bottom">
                                    <tr class="table-background-header">
                                        <th width="70%" class="text-left middle">{{viewLanguage('Quyền lợi bồi thường')}}</th>
                                        <th width="30%" class="text-center middle">{{viewLanguage('Số tiền bồi thường')}}</th>
                                    </tr>
                                    </thead>

                                    <tbody id="table_claim">
                                        @foreach ($listBoiThuongChose as $keybt => $itembt)
                                            <tr id="tr_claim_chose_{{$itembt['BEN_CODE']}}">
                                                <td class="text-left middle">
                                                    <a href="javascript:void(0);" style="color: red" title="{{viewLanguage('Bỏ quyền lợi bồi thường này')}}" onclick="removeOptionClaim('{{$itembt['BEN_CODE']}}');"><i class="fa fa-trash fa-2x"></i></a>&nbsp;&nbsp;
                                                    {{$itembt['BEN_NAME']}}
                                                </td>
                                                <td class="text-center middle">
                                                    <input type="text" id="{{$itembt['BEN_CODE']}}" name="{{$itembt['BEN_CODE']}}" value="{{$itembt['AMOUNT']}}" class="form-control input-sm text-right input_money_boi_thuong" onchange="changeMoneyBoiThuong(this);">
                                                    <input type="hidden" class="input_money_bt" id="money_{{$itembt['BEN_CODE']}}" name="money_{{$itembt['BEN_CODE']}}" value="{{$itembt['AMOUNT']}}">
                                                    <input type="hidden" id="claim_chose_{{$itembt['BEN_CODE']}}" name="claim_chose[]" value="{{$itembt['BEN_CODE']}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tr>
                                        <td class="text-right middle">Tổng số tiền bồi thường</td>
                                        <td class="text-center middle">
                                            <span type="hidden" id="show_money_boi_thuong" class="form-control input-sm text-right"></span>
                                            <input type="hidden" id="tong_money_tu_choi" name="tong_money_tu_choi" value="0">
                                            <input type="hidden" id="tong_money" name="tong_money" value="0">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Ghi chú')}}</label> <span
                            class="red">(*)</span>
                        <textarea type="text" class="form-control input-sm" required name="NOTE_STATUS" placeholder="Hiển thị trên mail thông báo kết quả xử lý đến khách hàng"
                            rows="2"></textarea>
                    </div>
                </div>
            </div>

            {{-----TCKH,TCBT----}}
            <div class="form-group display-none-block" id="issendmail">
                <div class="row">
                    <div class="col-lg-12">
                        <input type="checkbox" class="custom-checkbox float-left" id="is_send_mail" name="is_send_mail"
                            onchange="changerRadio();">
                        <input type="hidden" id="IS_SEND_MAIL_ACTION" name="IS_SEND_MAIL_ACTION" value="0">
                        <label for="is_send_mail" class="float-left marginL10 red">**Gửi email cho người khai báo, người
                            được bảo hiểm</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            @if($is_root || $permission_edit || $permission_add)
            <button type="button" class="btn btn-primary"
                onclick="jqueryCommon.doActionPopup('{{$formNameOther}}','{{$urlChangeProcess}}');"><i
                    class="pe-7s-diskette"></i> {{viewLanguage('Save')}}</button>
            @endif
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i>
                {{viewLanguage('Cancel')}}</button>
        </div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var date_time = $('.input-date').datepicker({dateFormat: 'dd-mm-yy'});
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
            tong_boi_thuong = parseInt(tong_boi_thuong) + parseInt($(this).val());
        });
        if(valu_staus == 'TCBT' || valu_staus == 'TCKH') {
            $('#tong_money_tu_choi').val(parseInt(0));
        }
    }else{
        $('.input_money_boi_thuong').each(function(){
            $(this).removeAttr('disabled');
            tong_boi_thuong = parseInt(tong_boi_thuong) + parseInt($(this).val());
        });
        if(parseInt(tong_boi_thuong) > 0){
            var tong_money_tu_choi = parseInt(tong_money_yeu_cau) - parseInt(tong_boi_thuong);
            $('#tong_money_tu_choi').val(parseInt(tong_money_tu_choi));
            $('#tong_money').val(parseInt(tong_boi_thuong));
        }
    }
    if(parseInt(tong_boi_thuong) > 0){
        $('#show_money_boi_thuong').html(jqueryCommon.numberFormat(tong_boi_thuong, '.', '.'));
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

function changeOptionClaim(obj,url_action) {
    var valu_claim = $(obj).val();
    var listBoiThuong = $('#listBoiThuong').val();
    var _token = $('input[name="_token"]').val();

    var dataClaimChose = [];
    var i = 0;
    $("input[name*='claim_chose']").each(function () {
        var benCode = $(this).val();
        if(benCode.trim() != ''){
            dataClaimChose[i] = $(this).val();
        }
        i++;
    });
    $('#loaderPopup').show();
    $.ajax({
        dataType: 'json',
        type: 'post',
        url: url_action,
        data: {
            '_token': _token,
            'valu_claim_chose': valu_claim,
            'listBoiThuong': listBoiThuong,
            'dataClaimChose': dataClaimChose,
            'functionAction': '_ajaxActionOther',
            'type': 'addInforClaim',
        },
        success: function (res) {
            $('#loaderPopup').hide();
            if (res.success == 1) {
                $('#table_claim').append(res.html);
            } else {
                jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.message);
            }
        }
    });
    if(valu_claim == 'KHAC'){
        $("#option_claim").val("");
    }
}

function removeOptionClaim(benCode) {
    var tong_money_yeu_cau = $('#tong_money_yeu_cau').val();
    var money_boi_thuong_cu = parseInt($('#money_'+benCode).val());
    var tong_money = $('#tong_money').val();//1000000

    var tong_money_sau = tong_money-money_boi_thuong_cu;
    $('#tong_money').val(parseInt(tong_money_sau));
    $('#show_money_boi_thuong').html(jqueryCommon.numberFormat(tong_money_sau, '.', '.'));
    var tong_money_tu_choi = tong_money_yeu_cau - tong_money_sau;
    $('#tong_money_tu_choi').val(tong_money_tu_choi);

    $('#tr_claim_chose_'+benCode).addClass("display-none-block");
    $('#claim_chose_'+benCode).val('');
    $('#money_'+benCode).val(0);
    $('#'+benCode).val(0);
}

function changeStatus(obj) {
    var valu_staus = $(obj).val();
    showInforBoiThuong(valu_staus);
}
function showInforBoiThuong(valu_staus) {

    if(valu_staus == 'TCBT' || valu_staus == 'TCKH' || valu_staus == 'TTBT'){
        $('.input_money_boi_thuong').each(function(){
            $(this).attr('disabled','disabled');
        });
        if(valu_staus == 'TCBT' || valu_staus == 'TCKH') {
            $('#tong_money_tu_choi').val(0);
        }
    }else {
        $('.input_money_boi_thuong').each(function () {
            $(this).removeAttr('disabled');
        });
        getMoneyBoiThuongDefaul(valu_staus);
    }
    //option add claim detail
    if(valu_staus == 'DYKH'){
        $("#chose_add_claim").removeClass('display-none-block');
    }else {
        $("#chose_add_claim").addClass('display-none-block');
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