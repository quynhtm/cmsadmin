{{----Block thông tin----}}
<div class="row marginT10">
    @if(!empty($listDonePayment))
        <div class="col-md-12 table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="2%" class="text-center middle">{{viewLanguage('STT')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Mã giao dịch')}}</th>

                    <th width="12%" class="text-center middle">{{viewLanguage('Ngày giao dịch')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Số tài khoản')}}</th>
                    <th width="15%" class="text-center middle">{{viewLanguage('Chủ tài khoản')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Ngân hàng')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Số tiền')}}</th>
                    <th width="15%" class="text-center middle">{{viewLanguage('Nội dung')}}</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $total_done_pay = 0;
                ?>
                @foreach ($listDonePayment as $keys_contracts => $contracts)
                    <?php
                        if(isset($contracts->TOTAL_PAY)){
                            $total_done_pay = $total_done_pay +$contracts->TOTAL_PAY;
                        }
                    ?>
                    <tr>
                        <td class="text-center middle">
                            {{$keys_contracts+1}}
                            <a href="javascript:void(0);" class="display-none-block" style="color: #329945" data-contract-code="" data-category="" data-detail-code="" data-product-code="{{PRODUCT_CODE_ATTD}}">
                                <i class="pe-7s-close fa-3x"></i>
                            </a>
                        </td>
                        <td class="text-center middle">@if(isset($contracts->TRANSACTION_ID)){{trim($contracts->TRANSACTION_ID)}}@endif</td>

                        <td class="text-center middle">@if(isset($contracts->DATE_PAY) && trim($contracts->DATE_PAY)!=''){{trim($contracts->DATE_PAY)}}@endif</td>
                        <td class="text-center middle">@if(isset($contracts->CARD_NUMBER) && trim($contracts->CARD_NUMBER)!=''){{trim($contracts->CARD_NUMBER)}}@endif</td>
                        <td class="text-left middle"> @if(isset($contracts->CARD_NAME) && trim($contracts->CARD_NAME)!=''){{trim($contracts->CARD_NAME)}}@endif</td>

                        <td class="text-center middle"> @if(isset($contracts->BANK_NAME) && trim($contracts->BANK_NAME)!=''){{trim($contracts->BANK_NAME)}}@endif</td>
                        <td class="text-right middle"> @if(isset($contracts->TOTAL_PAY) && trim($contracts->TOTAL_PAY)!=''){{numberFormat(trim($contracts->TOTAL_PAY))}} VNĐ @endif </td>
                        <td class="text-center middle"> @if(isset($contracts->CONTENT_PAY) && trim($contracts->CONTENT_PAY)!=''){{trim($contracts->CONTENT_PAY)}}@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <?php
        $total_con_lai = 0;
        if(isset($contracts->TOTAL_PAY)){
            $total_con_lai = $data->AMOUNT - $total_done_pay;
        }
        ?>
        <div class="form-group row col-md-12">
            <div class="col-md-5" id="block-infor-price-order">
                <label class="col-md-12">Tổng tiền: <b>@if(isset($data->AMOUNT)){{numberFormat($data->AMOUNT)}}@endif VNĐ</b></label>
                <label class="col-md-12">Đã thanh toán: <b>{{numberFormat($total_done_pay)}}</b> VNĐ</label>
                @if($total_con_lai > 0)
                    <label class="col-md-12">Số tiền còn lại: <b class="red">{{numberFormat($total_con_lai)}} VNĐ</b></label>
                @endif
            </div>
            <div class="col-md-12 display-none-block">
                @if($is_root || $permission_edit || $permission_add)
                    <button class="btn-transition btn btn-outline-success btn-search-right col-md-4" type="button" name="approval_payment" id="approval_payment" value="0"><i class="fa fa-check"></i> {{viewLanguage('Xác nhận giao dịch')}}</button>
                @endif
            </div>
        </div>
    @endif
</div>

<script type="text/javascript">
    $(document).ready(function(){

    });
</script>