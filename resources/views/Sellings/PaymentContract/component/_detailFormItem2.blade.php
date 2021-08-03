    {{----Block thông tin----}}
    <div class="row marginT10">
        <form id="form_search_advanced" class="marginT10 col-md-12">
            <input type="hidden" id="div_show" name="div_show" value="table_show_ajax">
            <input type="hidden" id="arrKey" name="arrKey" value="{{json_encode($arrKeyTab)}}">
            {{ csrf_field() }}
            <div class="row">

                <div class="col-md-4 text-right">
                    <input type="text" class="form-control input-sm" placeholder="Mã giao dịch" name="p_trans_id" id="p_trans_id">
                </div>
                <div class="col-md-2 text-right">
                    <input type="text" class="form-control input-sm input-date" placeholder="Ngày giao dịch từ" name="p_from_date" id="p_from_date">
                </div>
                <div class="col-md-2 text-right">
                    <input type="text" class="form-control input-sm input-date" placeholder="đến" name="p_to_date" id="p_to_date">
                </div>
                <div class="col-md-4 text-right">
                    @if($is_root || $permission_edit || $permission_add)
                        <a href="javascript:;" class="mb-2 mr-2 btn-icon btn btn-primary" onclick="jqueryCommon.searchAjaxWithForm('form_search_advanced','{{$urlSearchAdvanced}}')"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</a>
                        &nbsp;&nbsp;&nbsp;
                        <input type="hidden" id="show_block_search_nangcao" name="show_block_search_nangcao" value="0">
                        <a href="javascript:;" data-block="search_nangcao" data-infor="form_search_advanced" data-edit="formEditBlock1" class="mb-2 mr-2 btn-transition btn btn-outline-success a_edit_block">{{viewLanguage('Tìm kiếm nâng cao')}}</a>
                    @endif
                </div>
            </div>
            <div class="row form_search_advanced display-none-block">
                <div class="col-md-3 text-right">
                    <input type="text" class="form-control input-sm" placeholder="Số tài khoản" name="p_cardnum" id="p_cardnum">
                </div>
                <div class="col-md-3 text-right">
                    <input type="text" class="form-control input-sm" placeholder="Chủ tài khoản" name="p_cardname" id="p_cardname">
                </div>
                <div class="col-md-3 text-right">
                    <input type="text" class="form-control input-sm formatMoney text-left" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" " data-p-sign="s" placeholder="Số tiền" name="p_amount" id="p_amount">
                </div>
                <div class="col-md-3 text-right">
                    <input type="text" class="form-control input-sm" placeholder="Nội dung" name="p_content" id="p_content">
                </div>
            </div>
        </form>
        @if(isset($listNotPayment) && !empty($listNotPayment))
            <div id="table_show_ajax" class="col-md-12 paddingLeft-unset paddingRight-unset marginT10">
                @include('Sellings.PaymentContract.component._tableListNotPayment')
            </div>
        @endif
    </div>

<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        jQuery('.formatMoney').autoNumeric('init');
        $(".a_edit_block").on('click', function () {
            jqueryCommon.clickEditBlock(this);
        });
    });

    function checkMoveOrder(){
        var changeColor = 0;
        var dataTotalPay = 0;
        $("input[name*='checkItemsMovePay']").each(function () {
            if ($(this).is(":checked")) {
                changeColor = 1;
                dataTotalPay = dataTotalPay+ parseInt($(this).attr('data-total-pay'));
            }
        });
        $('#show-total-pay').html(jqueryCommon.numberFormat(dataTotalPay, '.', ','));
        if(changeColor == 1){
            $('#show_button_move_pay').removeClass("display-none-block");
        }else {
            $('#show_button_move_pay').addClass("display-none-block");
        }
    }

    function clickApprovalMovePay(url_ajax,arrKey){
        var dataId = [];
        var dataTotalPay = 0;
        var i = 0;
        $("input[name*='checkItemsMovePay']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                dataTotalPay = dataTotalPay+ parseInt($(this).attr('data-total-pay'));
                i++;
            }
        });
        if (dataId.length == 0 || dataTotalPay <= 0) {
            alert('Bạn chưa chọn đơn để thao tác.');
            return false;
        }

        var msg = 'Bạn có muốn chuyển các đơn thanh toán này?';
        jqueryCommon.isConfirm(msg).then((confirmed) => {
            $('#loaderRight').show();
            $.ajax({
                type: "post",
                url: url_ajax,
                data: {dataId: dataId, dataTotalPay: dataTotalPay, arrKey: arrKey},
                dataType: 'json',
                success: function (res) {
                    $('#loaderRight').hide();
                    if (res.success == 1) {
                        $('#'+res.divShowInfor).html(res.html);
                    } else {
                        jqueryCommon.showMsgError(0,'Không thể thực hiện được thao tác.');
                    }
                }
            });
        });
    }
</script>