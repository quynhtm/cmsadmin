{{---ID > 0 và có thông tin data---}}
<div class="formInforItem @if($objectId <= 0)display-none-block @endif">

    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="GIFT_CODE"></span>
        @endif
    </div>
    <div class="marginT15">
        <div class="form-group" style="position: relative">
            @include('admin.AdminLayouts.buttonShowFormEdit')
            <div class="row form-group">
                <div class="col-lg-3">
                    Đối tác: <b class="showInforItem">@if(isset($data->ORG_CODE) && $objectId > 0)@if(isset($arrOrg[$data->ORG_CODE])){{$arrOrg[$data->ORG_CODE]}} @endif @endif</b>
                </div>
                <div class="col-lg-3">
                    Voucher của: <b class="showInforItem" data-field="">@if(isset($data->GIFT_TYPE) && $objectId > 0)@if(isset($arrGiftType[$data->GIFT_TYPE])){{$arrGiftType[$data->GIFT_TYPE]}} @endif @endif</b>
                </div>
                <div class="col-lg-6">
                    Chiến dịch: <b class="showInforItem" data-field="">@if(isset($data->CAMPAIGN_CODE) && $objectId > 0)@if(isset($arrCampaigns[$data->CAMPAIGN_CODE])){{$arrCampaigns[$data->CAMPAIGN_CODE]}} @endif @endif</b>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-3">
                    Mã tiền tố: <b class="showInforItem" data-field="GIFT_CODE"></b>
                </div>
                <div class="col-lg-3">
                    Ngày áp dụng: <b class="showInforItem" data-field="">@if(isset($data->EFFECTIVE_DATE) && $objectId > 0){{convertDateDMY($data->EFFECTIVE_DATE)}}@endif</b>
                </div>
                <div class="col-lg-3">
                    Ngày hết hạn: <b class="showInforItem" data-field="">@if(isset($data->EXPIRATION_DATE) && $objectId > 0){{convertDateDMY($data->EXPIRATION_DATE)}}@endif</b>
                </div>
                <div class="col-lg-3">
                    Trạng thái: <b class="showInforItem" data-field="">@if(isset($data->STATUS) && $objectId > 0)@if(isset($arrStatus[$data->STATUS])){{$arrStatus[$data->STATUS]}} @endif @endif</b>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-3">
                    Dùng kèm với voucher khác: <b class="showInforItem">@if(isset($data->IS_COMBINED) && $objectId > 0)@if(isset($arrYesOrNo[$data->IS_COMBINED])){{$arrYesOrNo[$data->IS_COMBINED]}} @endif @endif</b>
                </div>
                <div class="col-lg-3">
                    Số lần sử dụng cho 1 mã code: <b class="showInforItem" data-field="USE_LIMIT"></b>
                </div>
                <div class="col-lg-3">
                    Kiểu mã voucher: <b class="showInforItem">@if(isset($data->TYPE_GENERATE) && $objectId > 0)@if(isset($arrTypeGenerate[$data->TYPE_GENERATE])){{$arrTypeGenerate[$data->TYPE_GENERATE]}} @endif @endif</b>
                </div>
                <div class="col-lg-3">
                    Số lượng voucher cấp phát: <b class="showInforItem" data-field="AMOUNT_ALLOCATE"></b>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-3">
                    Loại tiền: <b class="showInforItem">@if(isset($data->CURRENCY) && $objectId > 0)@if(isset($arrCurrency[$data->CURRENCY])){{$arrCurrency[$data->CURRENCY]}} @endif @endif</b>
                </div>
                <div class="col-lg-3">
                    Áp dụng cho ĐH từ: <b class="showInforItem" data-field="MIN_VALUE"></b>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-3">
                    Loại voucher: <b class="showInforItem" data-field="">@if(isset($data->DISCOUNT_UNIT) && $objectId > 0)@if(isset($arrDiscountUnit[$data->DISCOUNT_UNIT])){{$arrDiscountUnit[$data->DISCOUNT_UNIT]}} @endif @endif</b>
                </div>
                @if(isset($data->DISCOUNT_UNIT) && $objectId > 0)
                    @if($data->DISCOUNT_UNIT == 'M')
                        <div class="col-lg-3">
                            Số tiền giảm giá: <b class="showInforItem" data-field="DISCOUNT"></b>
                        </div>
                    @endif
                    @if($data->DISCOUNT_UNIT == 'P')
                        <div class="col-lg-3">
                            % giảm giá: <b class="showInforItem" data-field="DISCOUNT1">{{$data->DISCOUNT}}</b> %
                        </div>
                        <div class="col-lg-3">
                            Giảm giá tối đa: <b class="showInforItem" data-field="MAX_DISCOUNT_VALUE"></b>
                        </div>
                    @endif
                    @if($data->DISCOUNT_UNIT == 'G')
                        <div class="col-lg-3">
                            Giá trị quà tặng: <b class="showInforItem" data-field="DISCOUNT"></b>
                        </div>
                        <div class="col-lg-3">
                            Mô tả quà tặng: <b class="showInforItem" data-field="DESCRIPTION"></b>
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
</div>

{{----Edit và thêm mới----}}
<div class="formEditItem @if($objectId > 0)display-none-block @endif" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin&nbsp;<span class="showInforItem" data-field="GIFT_CODE"></span>
        @else
            Thông tin Voucher
        @endif
    </div>
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$urlPostItem}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        <input type="hidden" id="_STATUS" name="STATUS" @if(isset($data->STATUS))value="{{$data->STATUS}}" @else value="INACTIVE" @endif>

        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Voucher dành cho')}}</label><span class="red"> (*)</span>
                    <select  class="form-control input-sm" @if($objectId > 0) disabled @else name="GIFT_TYPE" required id="form_{{$formName}}_GIFT_TYPE"@endif>
                        {!! $optionGiftType !!}}
                    </select>
                    @if($objectId > 0)
                        <input type="hidden" name="GIFT_TYPE" required id="form_{{$formName}}_GIFT_TYPE">
                    @endif
                </div>
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Chiến dịch')}}</label><span class="red"> (*)</span>
                    <select  class="form-control input-sm" @if($objectId > 0) disabled @else name="CAMPAIGN_CODE" required id="form_{{$formName}}_CAMPAIGN_CODE" @endif onchange="jqueryCommon.buildOptionCommon('form_{{$formName}}_CAMPAIGN_CODE','ORG_BY_CAMPAIGN_CODE','form_{{$formName}}_ORG_CODE')">
                        {!! $optionCampaigns !!}}
                    </select>
                    @if($objectId > 0)
                        <input type="hidden" name="CAMPAIGN_CODE" required id="form_{{$formName}}_CAMPAIGN_CODE">
                    @endif
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Đối tác')}}</label><span class="red"> (*)</span>
                    <select  class="form-control input-sm" name="ORG_CODE" required id="form_{{$formName}}_ORG_CODE">
                        {!! $optionOrgByCampCode !!}}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Mã tiền tố voucher')}} </label> <span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" @if($objectId > 0) readonly @endif minlength="1" maxlength="4" required name="GIFT_CODE" id="form_{{$formName}}_GIFT_CODE">
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày áp dụng')}} </label> <span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm input-date" data-valid = "text" required name="EFFECTIVE_DATE" id="{{$formName}}_EFFECTIVE_DATE" value="@if(isset($data->EFFECTIVE_DATE)){{convertDateDMY($data->EFFECTIVE_DATE)}} @else {{date('d/m/Y')}}@endif">
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày hết hạn')}} </label>
                    <input type="text" class="form-control input-sm input-date" data-valid = "text" name="EXPIRATION_DATE" id="{{$formName}}_EXPIRATION_DATE" id="EXPIRATION_DATE" value="@if(isset($data->EXPIRATION_DATE)){{convertDateDMY($data->EXPIRATION_DATE)}}@endif">
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Loại tiền')}} </label>
                    <select  class="form-control input-sm" name="CURRENCY" id="form_{{$formName}}_CURRENCY">
                        {!! $optionCurrency !!}}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Dùng kèm với voucher khác')}} </label>
                    <select  class="form-control input-sm" name="IS_COMBINED" required id="form_{{$formName}}_IS_COMBINED">
                        {!! $optionIsCombined !!}}
                    </select>
                </div>
                <div class="col-lg-2">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Kiểu sinh mã')}}</label><span class="red"> (*)</span>
                    <select  class="form-control input-sm" name="TYPE_GENERATE" required id="form_{{$formName}}_TYPE_GENERATE">
                        {!! $optionTypeGenerate !!}}
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Số lần sử dụng cho 1 mã voucher')}} </label> <span class="red"> (*)</span>
                    <input type="number" class="form-control input-sm" required  minlength="1" name="USE_LIMIT" id="form_{{$formName}}_USE_LIMIT">
                </div>
                <div class="col-lg-2">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('SL cấp phát')}} </label><span class="red"> (*)</span>
                    <input type="number" class="form-control input-sm" required name="AMOUNT_ALLOCATE" id="form_{{$formName}}_AMOUNT_ALLOCATE">
                </div>
                <div class="col-lg-2">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Áp dụng cho ĐH từ')}} </label>
                    <input type="number" class="form-control input-sm" name="MIN_VALUE" id="form_{{$formName}}_MIN_VALUE">
                </div>
            </div>
        </div>

        {{--Loại voucher---}}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Loại voucher')}} </label> <span class="red"> (*)</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <input type="radio" class="marginT10" id="DISCOUNT_UNIT_M" name="DISCOUNT_UNIT" @if(isset($data->DISCOUNT_UNIT) && $data->DISCOUNT_UNIT == 'M') checked @endif value="M">
                    <label for="DISCOUNT_UNIT_M">{{viewLanguage('Giảm giá theo số tiền')}}</label>
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{viewLanguage('Số tiền giảm giá')}} </span>
                        </div>
                        <input type="text" class="form-control formatMoney text-left" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" " data-p-sign="s" placeholder="Số tiền giảm giá" name="DISCOUNT_M" @if(isset($data->DISCOUNT_UNIT) && $data->DISCOUNT_UNIT == 'M') value="{{$data->DISCOUNT}}" @endif>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <input type="radio" class="marginT10" id="DISCOUNT_UNIT_D" name="DISCOUNT_UNIT" @if(isset($data->DISCOUNT_UNIT) && $data->DISCOUNT_UNIT == 'P') checked @endif value="P">
                    <label for="DISCOUNT_UNIT_D">{{viewLanguage('Giảm giá theo %')}}</label>
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{viewLanguage('% giảm giá')}} </span>
                        </div>
                        <input type="number" class="form-control" name="DISCOUNT_P" @if(isset($data->DISCOUNT_UNIT) && $data->DISCOUNT_UNIT == 'P') value="{{$data->DISCOUNT}}" @endif>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{viewLanguage('Giảm tối đa')}} </span>
                        </div>
                        <input type="number" class="form-control" name="MAX_DISCOUNT_VALUE" @if(isset($data->DISCOUNT_UNIT) && $data->DISCOUNT_UNIT == 'P')id="form_{{$formName}}_MAX_DISCOUNT_VALUE"@endif>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <input type="radio" class="marginT10" id="DISCOUNT_UNIT_G" name="DISCOUNT_UNIT" @if(isset($data->DISCOUNT_UNIT) && $data->DISCOUNT_UNIT == 'G') checked @endif value="G">
                    <label for="DISCOUNT_UNIT_G">{{viewLanguage('Tặng quà khi mua')}}</label>
                </div>
                <div class="col-lg-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{viewLanguage('Giá trị quà tặng')}} </span>
                        </div>
                        <input type="number" class="form-control" name="DISCOUNT_G" @if(isset($data->DISCOUNT_UNIT) && $data->DISCOUNT_UNIT == 'G') value="{{$data->DISCOUNT}}" @endif>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{viewLanguage('Mô tả quà tặng')}} </span>
                        </div>
                        <input type="text" class="form-control" maxlength="100" name="DESCRIPTION" id="form_{{$formName}}_DESCRIPTION">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        jQuery('.formatMoney').autoNumeric('init');
        showDataIntoForm('form_{{$formName}}');
    });
    function compareDate(){
        var startDate = $('#EFFECTIVE_DATE').val();
        alert(startDate);
        var job_start_date = "10-1-2014"; // Oct 1, 2014
        var job_end_date = "11-1-2014"; // Nov 1, 2014
        job_start_date = job_start_date.split('-');
        job_end_date = job_end_date.split('-');

        var new_start_date = new Date(job_start_date[2],job_start_date[0],job_start_date[1]);
        var new_end_date = new Date(job_end_date[2],job_end_date[0],job_end_date[1]);

        if(new_end_date <= new_start_date) {
            // your code
        }
    }
    //tim kiem
    var config = {
        '.chosen-select'           : {width: "100%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>