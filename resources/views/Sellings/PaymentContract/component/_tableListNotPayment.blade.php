<div class="form-group row col-md-12 display-none-block" id="show_button_move_pay">
    <hr class="marginL15 hr_admin">
    <?php
    $total_done_pay = 0;
    $total_money = 0;
    ?>
    @if(!empty($data))
         <?php $total_money = isset($data[0]['AMOUNT']) ?$data[0]['AMOUNT']:0;   ?>
        @if(isset($data[1]) && !empty($data[1]))
            @foreach ($data[1] as $keys_contracts => $contracts)
                <?php
                if(isset($contracts['TOTAL_PAY'])){
                    $total_done_pay = $total_done_pay +$contracts['TOTAL_PAY'];
                }
                ?>
            @endforeach
        @endif
    @endif

    <div class="col-md-4 marginT10">
        @if($total_money > 0)
            <label>Tổng tiền: <b>{{numberFormat($total_money)}} VNĐ</b></label>
            <div class="clearfix"></div>
        @endif
        @if($total_done_pay > 0)
            <label>Đã thanh toán: <b>{{numberFormat($total_done_pay)}}</b> VNĐ</label>
            <div class="clearfix"></div>
        @endif
        <label>Số tiền dự kiến: <b id="show-total-pay" class="red"></b> VNĐ</label>
    </div>
    <div class="col-lg-6 marginT10" >
        @if($is_root || $permission_edit || $permission_add)
            <button class="btn-transition btn btn-outline-success" type="button" name="approval_move_pay" id="approval_move_pay" onclick="clickApprovalMovePay('{{$urlMovePay}}','{{json_encode($arrKeyTab)}}')"><i class="fa fa-check"></i> {{viewLanguage('Xác nhận giao dịch')}}</button>
        @endif
    </div>
    <hr class="marginL15 hr_admin">
</div>

@if(isset($total_list) && $total_list > 0)<h5 class="clearfix col-md-12"> Có tổng số <b>{{$total_list}}</b> giao dịch </h5>@endif
<div class="col-md-12 table-responsive" id="table_show_ajax">
    <table class="table table-bordered table-hover">
        <thead class="thin-border-bottom">
        <tr class="table-background-header">
            <th width="2%" class="text-center middle">{{viewLanguage('STT')}}</th>
            @if(in_array($arrKeyTab['PAYMENT_CODE'],[STATUS_INT_KHONG,STATUS_INT_MOT]))
            <th width="5%" class="text-center middle">{{viewLanguage('TT')}}</th>
            @endif
            <th width="10%" class="text-center middle">{{viewLanguage('Mã giao dịch')}}</th>

            <th width="10%" class="text-center middle">{{viewLanguage('Ngày giao dịch')}}</th>
            <th width="10%" class="text-center middle">{{viewLanguage('Số tài khoản')}}</th>
            <th width="15%" class="text-center middle">{{viewLanguage('Chủ tài khoản')}}</th>

            <th width="10%" class="text-center middle">{{viewLanguage('Ngân hàng')}}</th>
            <th width="10%" class="text-center middle">{{viewLanguage('Số tiền')}}</th>
            <th width="15%" class="text-center middle">{{viewLanguage('Nội dung')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($listNotPayment as $keys_contracts => $contracts)
            <tr>
                <td class="text-center middle">{{$stt+$keys_contracts+1}}</td>
                @if(in_array($arrKeyTab['PAYMENT_CODE'],[STATUS_INT_KHONG,STATUS_INT_MOT]))
                <td class="text-center middle">
                    <input class="check" type="checkbox" name="checkItemsMovePay[]" value="@if(isset($contracts->TRANSFER_ID)){{$contracts->TRANSFER_ID}}@endif" data-total-pay="@if(isset($contracts->TOTAL_PAY) && trim($contracts->TOTAL_PAY)!=''){{trim($contracts->TOTAL_PAY)}}@endif" onchange="checkMoveOrder();">
                </td>
                @endif
                <td class="text-center middle">@if(isset($contracts->TRANSACTION_ID) && trim($contracts->TRANSACTION_ID)!=''){{trim($contracts->TRANSACTION_ID)}}@endif</td>

                <td class="text-center middle">@if(isset($contracts->DATE_PAY) && trim($contracts->DATE_PAY)!=''){{trim($contracts->DATE_PAY)}}@endif</td>
                <td class="text-center middle">@if(isset($contracts->CARD_NUMBER) && trim($contracts->CARD_NUMBER)!=''){{trim($contracts->CARD_NUMBER)}}@endif</td>
                <td class="text-left middle">@if(isset($contracts->CARD_NAME) && trim($contracts->CARD_NAME)!=''){{trim($contracts->CARD_NAME)}}@endif</td>

                <td class="text-center middle">@if(isset($contracts->BANK_NAME) && trim($contracts->BANK_NAME)!=''){{trim($contracts->BANK_NAME)}}@endif</td>
                <td class="text-right middle">@if(isset($contracts->TOTAL_PAY) && trim($contracts->TOTAL_PAY)!=''){{numberFormat(trim($contracts->TOTAL_PAY))}}@endif</td>
                <td class="text-center middle">@if(isset($contracts->CONTENT_PAY) && trim($contracts->CONTENT_PAY)!=''){{trim($contracts->CONTENT_PAY)}}@endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-6 ">
        <div class="paging_simple_numbers col-md-12">
            {!! $paging !!}
        </div>
    </div>
    <div class="col-md-6 text-right">
        @if(isset($total_list) && $total_list > 0)<h5 class="clearfix col-md-12"> Có tổng số <b>{{$total_list}}</b> giao dịch </h5>@endif
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        jqueryCommon.pagingAjaxWithForm('form_search_advanced','{{$urlSearchAdvanced}}');
    });
</script>