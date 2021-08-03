<div>
    <div class="card-header paddingLeft-unset">
        <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
             Thông tin gói
        </div>
        <div class="col-lg-2 text-right card-title-2">
            <input type="hidden" id="show_block_infor_1" name="show_block_infor_1" value="1">
            <a href="javascript:;" data-block="infor_1" data-infor="formInforBlock1" data-edit="formEditBlock1" class="a_edit_block color_hdi"> Sửa</a>
        </div>
    </div>
    <?php $formName1 = 'form_InforBlock1'; ?>
    <form id="{{$formName1}}">
        {{----Block thông tin----}}
        <div class="formInforBlock1 @if($objectId <= 0)display-none-block @endif" >
            <div class="marginT15">
                <div class="form-group form-infor-detail">
                    <div class="row form-group">
                        <div class="col-lg-4">
                            Ngày hiệu lực: <b class="showInforItem" data-field="EFFECTIVE_DATE"></b>
                        </div>
                        <div class="col-lg-4">
                            Ngày kết thúc: <b class="showInforItem" data-field="EXPIRATION_DATE"></b>
                        </div>
                        <div class="col-lg-4">
                            Phạm vi BH-địa lý: <b class="showInforItem" data-field="">
                                @if(isset($inforFormBlock1->PACK_NAME) && trim($inforFormBlock1->PACK_NAME)!=''){{$inforFormBlock1->PACK_NAME}}@endif
                                @if(isset($inforFormBlock1->REGION_NAME) && trim($inforFormBlock1->REGION_NAME)!='') - {{trim($inforFormBlock1->REGION_NAME)}} @endif
                            </b>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-4">
                            Số tiền BH: <b class="showInforItem" data-field="">@if(isset($inforFormBlock1->INSUR_TOTAL) && trim($inforFormBlock1->INSUR_TOTAL)!=''){{numberFormat(trim($inforFormBlock1->INSUR_TOTAL))}} VNĐ@endif </b>
                        </div>
                        <div class="col-lg-4">
                            Phí bảo hiểm: <b class="showInforItem">@if(isset($inforFormBlock1->AMOUNT) && trim($inforFormBlock1->AMOUNT)!=''){{numberFormat(trim($inforFormBlock1->AMOUNT))}} VNĐ@endif </b>
                        </div>
                        <!--<div class="col-lg-4">
                            Giảm phí: <b class="showInforItem">Có giảm phí</b>
                        </div>-->
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-4">
                            Tổng thanh toán: <b class="showInforItem">@if(isset($inforFormBlock1->TOTAL_AMOUNT) && trim($inforFormBlock1->TOTAL_AMOUNT)!=''){{numberFormat(trim($inforFormBlock1->TOTAL_AMOUNT))}} VNĐ@endif</b>
                        </div>
                        <div class="col-lg-8">
                            Kỳ TT gần nhất:
                            <b class="showInforItem" data-field="MIN_VALUE">
                                @if(isset($inforFormBlock1->PERIOD_AMOUNT) && trim($inforFormBlock1->PERIOD_AMOUNT)!=''){{numberFormat(trim($inforFormBlock1->PERIOD_AMOUNT))}} VNĐ @endif
                                @if(isset($inforFormBlock1->PERIOD_DATE) && trim($inforFormBlock1->PERIOD_DATE)!='')({{$inforFormBlock1->PERIOD_DATE}})@endif
                            </b>
                                <!--[<a href="#" class="color_hdi">Xem chi tiết</a>]-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{----Form Edit----}}
        <div class="formEditBlock1 @if($objectId > 0)display-none-block @endif" >
            <div class="">
                <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
                <input type="hidden" id="url_action" name="url_action" value="{{$urlPostItem}}">
                <input type="hidden" id="formName" name="formName" value="{{$formName1}}">
                <input type="hidden" id="data_item" name="data_item" value="{{json_encode($inforFormBlock1)}}">
                <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
                {{ csrf_field() }}
                <div class="form-group marginT10">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Chọn loại cấp đơn')}} </label><span class="red"> (*)</span>
                        </div>
                        <div class="col-lg-3">
                            <div class="position-relative form-check">
                                <label class="form-check-label" style="line-height: 25px; color: #319945">
                                    <input id="LO_TYPE1" name="LO_TYPE" type="radio" class="form-check-input" checked value="{{LO_TYPE_TOTAL}}">
                                    Cấp đơn theo hạn mức
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-check-label" style="line-height: 25px">
                                <input id="LO_TYPE2" name="LO_TYPE" type="radio" class="form-check-input" value="{{LO_TYPE_DISBUR}}">
                                Cấp đơn theo khế ước nhận nợ
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-check-label" style="line-height: 25px">
                                <input id="LO_TYPE3" name="LO_TYPE" type="radio" class="form-check-input" value="{{LO_TYPE_DECREASE}}">
                                Ngân hàng mua tặng KH
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày hiệu lực')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm input-date" data-valid = "text" required name="EFFECTIVE_DATE" id="{{$formName1}}_EFFECTIVE_DATE" >
                            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày kết thúc')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm input-date" data-valid = "text" name="EXPIRATION_DATE" id="{{$formName1}}_EXPIRATION_DATE" >
                            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Thời gian bảo hiểm')}} </label>
                            <br/><b>24 tháng 0 ngày</b>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số tiền BH (VNĐ)')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="50" required name="INSUR_TOTAL" id="form_{{$formName1}}_INSUR_TOTAL">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Phạm vi địa lý')}} </label><span class="red"> (*)</span>
                            <select  class="form-control input-sm" name="REGION" id="form_{{$formName1}}_REGION">
                                {!! $optionPhamViDiaLy !!}}
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Phạm vi bảo hiểm')}} </label><span class="red"> (*)</span>
                            <select  class="form-control input-sm" name="PACK_CODE" id="form_{{$formName1}}_PACK_CODE">
                                {!! $optionPhamViBaoHiem !!}}
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Tổng tiền thanh toán')}} </label>
                            <br/><b>@if(isset($inforFormBlock1->TOTAL_AMOUNT) && trim($inforFormBlock1->TOTAL_AMOUNT)!=''){{numberFormat(trim($inforFormBlock1->TOTAL_AMOUNT))}} VNĐ@endif</b>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Hình thức thanh toán')}} </label> <span class="red"> (*)</span>
                            <select  class="form-control input-sm" name="DURATION_PAYMENT" id="form_{{$formName1}}_DURATION_PAYMENT">
                                {!! $optionHinhThucThanhToan !!}}
                            </select>
                        </div>
                    </div>
                </div>

                {{---Lịch sử thanh toán--}}
                @if(!empty($historyPayment4))
                <div class="form-group marginT15">
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-bordered table-hover">
                                <thead class="thin-border-bottom">
                                <tr style="background-color: #E7FCEE!important; color: #329945">
                                    <th width="2%" class="text-left">{{viewLanguage('STT')}}</th>
                                    <th width="50%" class="text-left">{{viewLanguage('Ngày thanh toán dự kiến')}}</th>
                                    <th width="38%" class="text-left">{{viewLanguage('Số tiền')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($historyPayment4 as $keys_his => $historyPay)
                                <tr>
                                    <td class="text-left">{{$keys_his+1}}</td>
                                    <td class="text-left">
                                        @if(isset($historyPay->EFFECTIVE_DATE) && trim($historyPay->EFFECTIVE_DATE)!=''){{convertDateDMY(trim($historyPay->EFFECTIVE_DATE))}}@endif
                                    </td>
                                    <td class="text-left">@if(isset($historyPay->AMOUNT) && trim($historyPay->AMOUNT)!=''){{numberFormat($historyPay->AMOUNT)}} VNĐ @endif</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                {{---Action form---}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3">
                            <button type="button" class="col-lg-12 btn-transition  btn btn-success">Tiếp tục</button>
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="col-lg-12 btn-transition btn btn-outline-success a_edit_block" data-block="infor_1" data-infor="formInforBlock1" data-edit="formEditBlock1">Hủy bỏ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        showDataIntoForm('{{$formName1}}');
    });
</script>