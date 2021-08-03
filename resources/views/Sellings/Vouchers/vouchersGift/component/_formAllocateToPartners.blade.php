<div class="div-other-background">
    <div class="div-background-child">
        <div class="div-other-right">

            <div class="btn-actions-pane-right col-lg-12">
            <div class="formEditItem" @if(count($dataOther) > 6)style="overflow: hidden; overflow-y: scroll; height: 90vh"@endif>
                <form id="form_{{$formName}}">
                    <div class="card-header">
                          Cấp phát voucher cho đối tác
                        <div class="btn-actions-pane-right">
                            <div class="btn-actions-pane-right">
                            @include('admin.AdminLayouts.listButtonActionFormOtherEdit')
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="objectId" name="objectId" value="0">
                    <input type="hidden" id="url_action" name="url_action" value="{{$urlActionOtherItem}}">
                    <input type="hidden" id="functionAction" name="functionAction" value="{{$functionAction}}">
                    <input type="hidden" id="formName" name="formName" value="{{$formName}}">
                    <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataOther)}}">
                    <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
                    <input type="hidden" id="typeTabAction" name="typeTabAction" value="{{$tabOtherItem1}}">
                    <input type="hidden" id="actionForm" name="actionForm" value="voucherAllocateToParter">

                    <input type="hidden" id="CAMPAIGN_CODE" name="CAMPAIGN_CODE" @if(isset($data->CAMPAIGN_CODE)) value="{{$data->CAMPAIGN_CODE}}" @endif >
                    <input type="hidden" id="GIFT_CODE" name="GIFT_CODE" @if(isset($data->GIFT_CODE)) value="{{$data->GIFT_CODE}}" @endif >
                    <input type="hidden" id="GIFT_TYPE" name="GIFT_TYPE" @if(isset($data->GIFT_TYPE)) value="{{$data->GIFT_TYPE}}" @endif >
                    <div class="marginT15">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Cấp phát cho đối tác')}} </label><span class="red"> (*)</span>
                                    <select  class="form-control input-sm" name="ORG_CODE" required>
                                        <option value="">---Chọn đối tác---</option>
                                        @foreach($arrOrg as $orgId => $ornName)
                                            <option value="{{$orgId}}">{{$ornName}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        @foreach($dataOther as $kk =>$itemOther)
                        <div class="form-group" >
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Mã gói')}} </label>
                                    <input type="text" class="form-control input-sm" name="{{$itemOther->BLOCK_CODE}}_PACK_CODE" readonly id="{{$formName}}_PACK_CODE" value="{{$itemOther->PACK_CODE}}">
                                    <input type="hidden" name="{{$itemOther->BLOCK_CODE}}_BLOCK_CODE" id="{{$formName}}_BLOCK_CODE" value="{{$itemOther->BLOCK_CODE}}">
                                </div>
                                <div class="col-lg-2">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Mã bắt đầu')}} </label>
                                    <input type="text" class="form-control input-sm" readonly name="{{$itemOther->BLOCK_CODE}}_MAX_SERY_NO" id="{{$formName}}_MAX_SERY_NO" value="{{$itemOther->MAX_SERY_NO}}">
                                </div>
                                <div class="col-lg-2">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('SL đã cấp phát')}} </label>
                                    <input type="text" class="form-control input-sm"  readonly name="{{$itemOther->BLOCK_CODE}}_COUNT_ACTIVATION_CODE" id="{{$formName}}_COUNT_ACTIVATION_CODE" value="{{$itemOther->COUNT_ACTIVATION_CODE}}">
                                </div>
                                <div class="col-lg-2">
                                    <?php
                                       $soluongcapphatchophep = (int)($itemOther->AMOUNT_ALLOCATE-$itemOther->COUNT_ACTIVATION_CODE);
                                    ?>
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('SL cấp phát')}} </label> <span class="red"> (*)</span>
                                    <input type="number" class="form-control input-sm" placeholder="{{$soluongcapphatchophep}}" @if($soluongcapphatchophep <=0) readonly value="0" @endif name="{{$itemOther->BLOCK_CODE}}_AMOUNT_ALLOCATE" id="{{$itemOther->BLOCK_CODE}}_AMOUNT_ALLOCATE" onchange="changPrice('{{$itemOther->BLOCK_CODE}}_AMOUNT_ALLOCATE','{{$itemOther->FEES}}','{{$itemOther->BLOCK_CODE}}_FEES')">
                                </div>
                                <div class="col-lg-3">
                                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tổng tiền')}} </label>
                                    <input type="text" class="form-control input-sm" name="{{$itemOther->BLOCK_CODE}}_FEES" readonly id="{{$itemOther->BLOCK_CODE}}_FEES" value="{{numberFormat($itemOther->FEES)}}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
    function changPrice(obj,price,id_show){
        var number = $('#'+obj).val();
        var price_show = number*price;
        Number.prototype.toCurrencyString = function(prefix, suffix) {
            if (typeof prefix === 'undefined') { prefix = ''; }//$
            if (typeof suffix === 'undefined') { suffix = ''; }
            var _localeBug = new RegExp((1).toLocaleString().replace(/^1/, '').replace(/\./, '\\.') + "$");
            return prefix + (~~this).toLocaleString().replace(_localeBug, '') + (this % 1).toFixed(0).toLocaleString().replace(/^[+-]?0+/,'') + suffix;
        }
        $('#'+id_show).val(price_show.toCurrencyString());
    }
</script>