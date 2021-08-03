<div>
    <div class="card-header paddingLeft-unset">
        <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
             Thông tin vay, NĐBH, cán bộ ngân hàng
        </div>
        <div class="col-lg-2 text-right card-title-2">
            <input type="hidden" id="show_block_infor_2" name="show_block_infor_2" value="1">
            <a href="javascript:;" data-block="infor_2" data-infor="formInforBlock2" data-edit="formEditBlock2" class="a_edit_block color_hdi"> Sửa</a>
        </div>
    </div>
    <?php $formName2 = 'form_InforBlock2'; ?>
    <form id="form_InforBlock2">
    {{----Block thông tin----}}
        <div class="formInforBlock2 @if($objectId <= 0)display-none-block @endif" >
            <div class="marginT15">
                <div class="form-group form-infor-detail">
                    <div class="row form-group">
                        <div class="col-lg-12">
                            Thông tin vay
                        </div>
                        <div class="col-lg-3">
                            Số HĐ vay: <b class="showInforItem" data-field="LO_NO"></b>
                        </div>
                        <div class="col-lg-3">
                            Ngày ký HD vay: <b class="showInforItem" data-field="BORROW_DATE_SIGN"></b>
                        </div>
                        <div class="col-lg-3">
                            Số tiền vay: <b class="showInforItem" data-field="">@if(isset($inforFormBlock2->LO_TOTAL_AMOUNT) && trim($inforFormBlock2->LO_TOTAL_AMOUNT)!=''){{numberFormat(trim($inforFormBlock2->LO_TOTAL_AMOUNT))}} VNĐ @endif</b>
                        </div>
                        <div class="col-lg-3">
                            Thời hạn vay: <b class="showInforItem" data-field="">
                                @if(isset($inforFormBlock2->DURATION) && trim($inforFormBlock2->DURATION)!=''){{$inforFormBlock2->DURATION}} @endif
                                @if(isset($inforFormBlock2->TYPE_NAME) && trim($inforFormBlock2->TYPE_NAME)!=''){{$inforFormBlock2->TYPE_NAME}} @endif
                            </b>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-12">
                            Thông tin người được BH
                        </div>
                        <div class="col-lg-4">
                            Người được BH: <b class="showInforItem" data-field="NAME"></b>
                        </div>
                        <div class="col-lg-8">
                            Địa chỉ: <b class="showInforItem" data-field="ADDRESS"></b>
                        </div>

                        <div class="col-lg-4">
                            Số CMND/CCCD: <b class="showInforItem" data-field="IDCARD"></b>
                        </div>
                        <div class="col-lg-4">
                            Ngày cấp: <b class="showInforItem" data-field="IDCARD_D"></b>
                        </div>
                        <div class="col-lg-4">
                            Nơi cấp: <b class="showInforItem" data-field="IDCARD_P"></b>
                        </div>

                        <div class="col-lg-4">
                            Số điện thoại: <b class="showInforItem" data-field="PHONE"></b>
                        </div>
                        <div class="col-lg-4">
                            Email: <b class="showInforItem" data-field="EMAIL"></b>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-12">
                            Đơn vị thụ hưởng
                        </div>
                        <div class="col-lg-4">
                            ĐV thụ hưởng: <b class="showInforItem" data-field="BEN_NAME"></b>
                        </div>
                        <div class="col-lg-4">
                            CBNH cấp đơn:
                            <b class="showInforItem" data-field="TELLER_CODE"></b> -
                            <b class="showInforItem" data-field="TELLER_NAME"></b>
                        </div>
                        <div class="col-lg-4">
                            Email CBNH: <b class="showInforItem" data-field="TELLER_EMAIL"></b>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{----Form Edit----}}
        <div class="formEditBlock2 @if($objectId > 0)display-none-block @endif" >
            <div class="">
                <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
                <input type="hidden" id="url_action" name="url_action" value="{{$urlPostItem}}">
                <input type="hidden" id="formName" name="formName" value="{{$formName2}}">
                <input type="hidden" id="data_item" name="data_item" value="{{json_encode($inforFormBlock2)}}">
                <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
                {{ csrf_field() }}
                <div class="card-header-2 paddingLeft-unset">
                    <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
                        Thông tin vay
                    </div>
                </div>
                <div class="form-group marginT10">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số hợp đồng vay')}} </label>
                            <div class="input-group">
                                <input placeholder="Số hợp đồng" type="text" class="form-control" name="LO_NO" id="form_{{$formName2}}_LO_NO">
                                <div class="input-group-append">
                                    <span class="input-group-text color_hdi" style="color: #329945">Kiểm tra</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Loại thời hạn vay')}} </label> <span class="red"> (*)</span>
                            <select class="form-control input-sm paddingNone" name="UNIT" id="form_{{$formName2}}_UNIT">
                                {!! $optionDonViThoiGianContract !!}
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Thời hạn vay')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="50" required name="DURATION" id="form_{{$formName2}}_DURATION">
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số tiền vay')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="50" required name="LO_TOTAL_AMOUNT" id="form_{{$formName2}}_LO_TOTAL_AMOUNT">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày ký hợp đồng vay')}} </label>
                            <input type="text" class="form-control input-sm input-date" data-valid = "text" name="BORROW_DATE_SIGN" id="{{$formName2}}_BORROW_DATE_SIGN">
                            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số lần giải ngân')}} </label>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="20" name="DISBUR_NUM" id="form_{{$formName2}}_DISBUR_NUM">
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Mã khế ước nhận nợ')}} </label>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="50" name="DISBUR_CODE" id="form_{{$formName2}}_DISBUR_CODE">
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số tiền giải ngân')}} </label>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="50" name="DISBUR_AMOUNT" id="form_{{$formName2}}_DISBUR_AMOUNT">
                        </div>
                    </div>
                </div>

                <div class="card-header-2 paddingLeft-unset">
                    <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
                        Người được bảo hiểm
                    </div>
                </div>
                <div class="form-group marginT10">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Danh xưng')}} </label><span class="red"> (*)</span>
                            <select  class="form-control input-sm" name="GENDER" id="form_{{$formName2}}_GENDER">
                                {!! $optionDanhXungContract !!}}
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Tên')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="50" required name="NAME" id="form_{{$formName2}}_NAME">
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số điện thoại')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="50" required name="PHONE" id="form_{{$formName2}}_PHONE">
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Mail')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="50" required name="EMAIL" id="form_{{$formName2}}_EMAIL">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số CMND/CCCD')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="20" required name="IDCARD" id="form_{{$formName2}}_IDCARD">
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày cấp')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm input-date" data-valid = "text" required name="IDCARD_D" id="{{$formName2}}_IDCARD_D" >
                            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Nơi cấp')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="50" required name="IDCARD_P" id="form_{{$formName2}}_IDCARD_P">
                        </div>
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày sinh')}} </label>
                            <input type="text" class="form-control input-sm input-date" data-valid = "text" name="DOB" id="{{$formName2}}_DOB" >
                            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số nhà, ngõ, nghách, đường')}} </label> <span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" minlength="1" maxlength="350" required name="ADDRESS" id="form_{{$formName2}}_ADDRESS">
                        </div>
                        <div class="col-lg-2 paddingRight-unset">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Tỉnh/TP')}}</label>
                            <select class="form-control input-sm paddingNone" name="PROVINCE_C" id="form_{{$formName2}}_PROVINCE_C" onchange="jqueryCommon.buildOptionCommon('form_{{$formName2}}_PROVINCE_C','OPTION_DISTRICT_CODE','form_{{$formName2}}_DISTRICT_C')">
                                {!! $optionProvinceContract !!}
                            </select>
                        </div>
                        <div class="col-lg-2 paddingNone">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Quận huyện')}}</label>
                            <select class="form-control input-sm paddingNone" name="DISTRICT_C" id="form_{{$formName2}}_DISTRICT_C" onchange="jqueryCommon.buildOptionCommon('form_{{$formName2}}_DISTRICT_C','OPTION_WARD_CODE','form_{{$formName2}}_WARDS_C')">
                                {!! $optionDistrictContract !!}
                            </select>
                        </div>
                        <div class="col-lg-2 paddingLeft-unset">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Phường xã')}}</label>
                            <select class="form-control input-sm paddingNone" name="WARDS_C" id="form_{{$formName2}}_WARDS_C" >
                                {!! $optionWardContract !!}
                            </select>
                        </div>
                    </div>
                </div>

                {{--Upload file---}}
                <div class="card-header-2 paddingLeft-unset">
                    <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
                        Thụ hưởng
                    </div>
                </div>
                <div class="form-group marginT10">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Đơn vị thụ hưởng')}} </label><span class="red"> (*)</span>
                            <select  class="form-control input-sm" name="BEN_ORG_CODE" id="form_{{$formName2}}_BEN_ORG_CODE">
                                {!! $optionDonViThuHuongContract !!}}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group marginT15">
                    <div class="row">
                        <div class="col-lg-3">
                            <button type="button" class="col-lg-12 btn-transition  btn btn-success">Tiếp tục</button>
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="col-lg-12 btn-transition btn btn-outline-success a_edit_block" data-block="infor_2" data-infor="formInforBlock2" data-edit="formEditBlock2">Hủy bỏ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        showDataIntoForm('{{$formName2}}');
    });
</script>