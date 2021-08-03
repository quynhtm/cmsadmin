<div class="div-other-background">
    <div class="div-background-child">
        <div class="div-other-right">

            <div class="btn-actions-pane-right col-lg-12">
            <div class="formEditItem" >
                <form id="form_{{$formName}}">
                    <div class="card-header">
                          Cấp phát voucher
                        <div class="btn-actions-pane-right">
                            <div class="btn-actions-pane-right">
                            @if($is_root || $permission_approve)
                                @if(isset($dataOther->GCV_ID))
                                    @if(in_array($dataOther->STATUS,[STATUS_VOUCHER_WAIT]))
                                        <button type="button" class="btn btn-success" onclick="clickUpdateVoucherValue(this);"data-form-name="addFormOther" data-type-active="{{STATUS_VOUCHER_APPROVE}}" data-method="POST" data-url="{{$urlUpdateStatusOtherItem}}" data-objectId="{{$dataOther->GCV_ID}}" data-div-show="listOtherItemSearch"><i class="pe-7s-check"></i> {{viewLanguage('Duyệt')}}</button>
                                    @endif
                                    &nbsp;&nbsp;
                                    @if(in_array($dataOther->STATUS,[STATUS_VOUCHER_WAIT]))
                                        <button type="button" class="btn btn-warning" onclick="clickCancelVoucher();"><i class="pe-7s-close-circle"></i> {{viewLanguage('Từ chối')}}</button>
                                    @endif
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                @endif
                            @endif
                            @include('admin.AdminLayouts.listButtonActionFormOtherEdit')
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="objectId" name="objectId" value="@if(isset($dataOther->GCV_ID)){{$dataOther->GCV_ID}}@endif">
                    <input type="hidden" id="url_action" name="url_action" value="{{$urlActionOtherItem}}">
                    <input type="hidden" id="functionAction" name="functionAction" value="{{$functionAction}}">
                    <input type="hidden" id="formName" name="formName" value="{{$formName}}">
                    <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataOther)}}">
                    <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
                    <input type="hidden" id="typeTabAction" name="typeTabAction" value="{{$tabOtherItem1}}">
                    <input type="hidden" id="actionForm" name="actionForm" value="voucherValue">
                    <input type="hidden" id="amountAllocateValue" name="amountAllocateValue" value="{{$amountAllocateValue}}">

                    <input type="hidden" id="CAMPAIGN_CODE" name="CAMPAIGN_CODE" @if(isset($data->CAMPAIGN_CODE)) value="{{$data->CAMPAIGN_CODE}}" @endif >
                    <input type="hidden" id="GIFT_CODE" name="GIFT_CODE" @if(isset($data->GIFT_CODE)) value="{{$data->GIFT_CODE}}" @endif >
                    <input type="hidden" id="GIFT_TYPE" name="GIFT_TYPE" @if(isset($data->GIFT_TYPE)) value="{{$data->GIFT_TYPE}}" @endif >
                    <input type="hidden" id="ORG_CODE" name="ORG_CODE" @if(isset($data->ORG_CODE)) value="{{$data->ORG_CODE}}" @endif >
                    <input type="hidden" id="{{$formName}}_EFFECTIVE_DATE_CODE" name="EFFECTIVE_DATE_CODE" @if(isset($data->EFFECTIVE_DATE) && trim($data->EFFECTIVE_DATE) !='') value="{{convertDateDMY($data->EFFECTIVE_DATE)}}" @endif >
                    <input type="hidden" id="{{$formName}}_EFFECTIVE_DATE_CODE" name="EFFECTIVE_DATE_CODE" @if(isset($data->EXPIRATION_DATE) && trim($data->EXPIRATION_DATE) !='') value="{{convertDateDMY($data->EXPIRATION_DATE)}}" @endif >

                    <input type="hidden" id="GCV_ID" name="GCV_ID" @if(isset($dataOther->GCV_ID)) value="{{$dataOther->GCV_ID}}" @endif >
                    <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
                    <div class="marginT15">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Số lượng cấp phát')}} </label> <span class="red"> (*)</span>
                                    <input type="text" class="form-control input-sm" @if(isset($dataOther->GCV_ID)|| (isset($data->TYPE_GENERATE) && $data->TYPE_GENERATE == 'BYO')) readonly @endif required name="AMOUNT_ALLOCATE" id="form_{{$formName}}_AMOUNT_ALLOCATE" @if(isset($data->TYPE_GENERATE) && $data->TYPE_GENERATE == 'BYO') value="1" @endif>
                                </div>
                                <div class="col-lg-6">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Sản phẩm sử dụng')}}</label><span class="red"> (*)</span>
                                    <select  class="form-control input-sm"@if(isset($dataOther->GCV_ID)) disabled @endif required name="REF_CODE"  id="form_{{$formName}}_REF_CODE">
                                        {!! $optionProduct !!}}
                                    </select>
                                    @if(isset($dataOther->GCV_ID))
                                        <input type="hidden" name="REF_CODE" id="form_{{$formName}}_REF_CODE">
                                    @endif
                                </div>
                                <div class="col-lg-3">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Gói sử dụng')}}</label><span class="red"> (*)</span>
                                    <select  class="form-control input-sm"@if(isset($dataOther->GCV_ID)) disabled @endif required name="REF_DETAIL_CODE"  id="form_{{$formName}}_REF_DETAIL_CODE">
                                        {!! $optionPack !!}}
                                    </select>
                                    @if(isset($dataOther->GCV_ID))
                                        <input type="hidden" name="REF_DETAIL_CODE" id="form_{{$formName}}_REF_DETAIL_CODE">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                @if(isset($dataOther->GCV_ID))
                                    <div class="col-lg-3">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Lần cấp phát')}} </label> <span class="red"> (*)</span>
                                        <input type="text" class="form-control input-sm" @if(isset($dataOther->GCV_ID)) readonly @endif required name="TIMES" id="form_{{$formName}}_TIMES">
                                    </div>
                                @else
                                    <input type="hidden" class="form-control input-sm" name="TIMES">
                                @endif
                                @if(isset($dataOther->GCV_ID))
                                    <div class="col-lg-3">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Mã block')}} </label>
                                        <input type="text" class="form-control input-sm" @if(isset($dataOther->GCV_ID)) readonly @endif name="BLOCK_CODE" id="form_{{$formName}}_BLOCK_CODE">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}}</label>
                                        <select  class="form-control input-sm" disabled name="STATUS_">
                                            {!! $optionStatusValue !!}}
                                        </select>
                                    </div>
                                    @if($is_root || $permission_approve)
                                        @if($dataOther->STATUS == STATUS_VOUCHER_APPROVE)
                                            <div class="col-lg-3">
                                                <br>
                                                <a href="{{URL::route('vouchersGift.getExportExcel',array('id' => setStrVar($dataOther->GCV_ID)))}}" target="_blank" class="btn btn-info" title="{{viewLanguage('Export excel')}}">
                                                    <i class="fa fa-download"></i>
                                                    File DS voucher
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    <input type="hidden" class="form-control input-sm" name="BLOCK_CODE">
                                @endif
                            </div>
                        </div>

                        @if(isset($dataOther->GCV_ID) && $dataOther->STATUS == STATUS_VOUCHER_REFUSE)
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Lý do từ chối')}} </label> <span class="red"> (*)</span>
                                    <input type="text" class="form-control input-sm"  readonly name="AMOUNT_ALLOCATE" value="{{$dataOther->APPROVE_NOTE}}">
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày hiệu lực')}} </label> <span class="red"> (*)</span>
                                    <input type="text" class="form-control input-sm input-date" onchange="checkDateTrue('{{$formName}}');" required name="EFFECTIVE_DATE" id="{{$formName}}_EFFECTIVE_DATE" value="@if(isset($dataOther->EFFECTIVE_DATE)){{convertDateDMY($dataOther->EFFECTIVE_DATE)}}@else{{date('d/m/Y')}}@endif">
                                </div>
                                <?php
                                    $hours_1 = '';$minute_1 = '';
                                    $hours_2 = '';$minute_2 = '';
                                    if(isset($dataOther->EFFECTIVE_DATE) && trim($dataOther->EFFECTIVE_DATE) != ''){
                                        $hours_1 = date('h',strtotime($dataOther->EFFECTIVE_DATE));
                                        $minute_1 = date('i',strtotime($dataOther->EFFECTIVE_DATE));
                                    }
                                    if(isset($dataOther->EXPIRATION_DATE) && trim($dataOther->EXPIRATION_DATE) != ''){
                                        $hours_2 = date('h',strtotime($dataOther->EXPIRATION_DATE));
                                        $minute_2 = date('i',strtotime($dataOther->EXPIRATION_DATE));
                                    }
                                ?>
                                <div class="col-lg-2">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Giờ')}} </label>
                                    <select  class="form-control input-sm" name="EFFECTIVE_HOURS">
                                        @foreach($arrHours as $kh=>$nh)
                                            <option value="{{$kh}}" @if($kh == $hours_1) selected @endif>{{$nh}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Phút')}} </label>
                                    <select  class="form-control input-sm" name="EFFECTIVE_MINUTE">
                                        @foreach($arrMinute as $km=>$nm)
                                            <option value="{{$km}}" @if($km == $minute_1) selected @endif>{{$nm}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày hết hiệu lực')}} </label> <span class="red"> (*)</span>
                                    <input type="text" class="form-control input-sm input-date" onchange="checkDateTrue('{{$formName}}');" name="EXPIRATION_DATE" required id="{{$formName}}_EXPIRATION_DATE" value="@if(isset($dataOther->EXPIRATION_DATE)){{convertDateDMY($dataOther->EXPIRATION_DATE)}}@endif">
                                </div>
                                <div class="col-lg-2">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Giờ')}} </label>
                                    <select  class="form-control input-sm" name="EXPIRATION_HOURS">
                                        @foreach($arrHours as $kh=>$nh)
                                            <option value="{{$kh}}" @if($kh == $hours_2) selected @endif>{{$nh}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Phút')}} </label>
                                    <select  class="form-control input-sm" name="EXPIRATION_MINUTE">
                                        @foreach($arrMinute as $km=>$nm)
                                            <option value="{{$km}}" @if($km == $minute_2) selected @endif>{{$nm}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>

@if(isset($dataOther->GCV_ID))
    <div class="modal inmodal fade" id="sys_showPopupCancelVoucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 2100000!important;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="cancelVoucherValue">

                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="sysTitleModalCommon">Hủy voucher </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form_group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="NAME" class="text-right control-label">{{viewLanguage('Lý do từ chối duyệt')}} <span class="red">(*)</span></label>
                                        <textarea name="note_cancel" id="note_cancel" class="form-control input-sm" rows="5" maxlength="100"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
                        @if($is_root || $permission_edit || $permission_add)
                            <button type="button" class="btn btn-primary" onclick="clickUpdateVoucherValue(this);"data-form-name="addFormOther" data-type-active="{{STATUS_VOUCHER_REFUSE}}" data-method="POST" data-url="{{$urlUpdateStatusOtherItem}}" data-objectId="{{$dataOther->GCV_ID}}" data-div-show="listOtherItemSearch"><i class="pe-7s-check"></i> {{viewLanguage('Từ chối')}}</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        showDataIntoForm('form_{{$formName}}');
    });
    function checkDateTrue(form_name){
        var startDate = $('#'+form_name+'_EFFECTIVE_DATE_CODE').val();
        var startDate2 = $('#'+form_name+'_EFFECTIVE_DATE').val();

        var endDate = $('#'+form_name+'_EXPIRATION_DATE_CODE').val();
        var endDate2 = $('#'+form_name+'_EXPIRATION_DATE').val();

        if(startDate != '' && startDate2 != ''){
            var checkDate = jqueryCommon.compareDate(startDate,startDate2);
            if(checkDate){
                jqueryCommon.showMsg('error','','Thông báo lỗi','Ngày hiệu lực của mã voucher phải lớn hơn ngày '+startDate);
                $('#'+form_name+'_EFFECTIVE_DATE').val('');
            }
        }
        if(endDate != '' && endDate2 != ''){
            var checkDate2 = jqueryCommon.compareDate(endDate,endDate2);
            if(checkDate2){
                jqueryCommon.showMsg('error','','Thông báo lỗi','Ngày hết hiệu lực của mã voucher phải nhỏ hơn ngày  '+endDate);
                $('#'+form_name+'_EXPIRATION_DATE').val('');
            }
        }
    }
</script>