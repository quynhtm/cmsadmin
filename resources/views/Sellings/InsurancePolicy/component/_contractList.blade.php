@if(1==1)
    <div class="listTabWithAjax">
        <div class="tab-content">
            <div class="row marginT10">
                <div class="form-group row col-md-12">
                    <div class="text-left col-md-6">
                        @if($is_root || $permission_edit || $permission_add)
                            <a href="javascript:void(0);" class="mb-2 mr-2 btn-icon btn btn-success" data-input="{{json_encode(['item'=>$data])}}" title="Chuyển depart cho nhân viên" data-method="post" data-div-show="sys_show_infor_small" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetPopupMove">
                                <i class="pe-7s-plus"></i> {{viewLanguage('Cấp đơn bổ xung')}}
                            </a>
                            <a href="javascript:void(0);" class="mb-2 mr-2 btn-icon btn btn-success" data-input="{{json_encode(['item'=>$data])}}" title="Chuyển depart cho nhân viên" data-method="post" data-div-show="sys_show_infor_small" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetPopupMove">
                                <i class="pe-7s-check"></i> {{viewLanguage('Duyệt đơn')}}
                            </a>
                        @endif
                    </div>
                    <div class="col-md-4 text-right">
                        <input type="text" class="form-control input-sm" placeholder="Số GCN" name="ORG_CODE" id="ORG_CODE">
                    </div>
                    <div class="col-md-2 text-right">
                        @if($is_root || $permission_edit || $permission_add)
                            <button class="mb-2 mr-2 btn-icon btn btn-primary" type="button" name="searchStaff" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                        @endif
                    </div>
                </div>
                @if(!empty($listContracts))
                    <h5 class="clearfix marginL10"> Có tổng số <b>{{count($listContracts)}}</b> </h5>
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="table-background-header">
                                <th width="2%" class="text-center"><input type="checkbox" class="check" id="checkAllAjax"></th>
                                <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Thao tác')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Số GCN')}}</th>

                                <th width="11%" class="text-center">{{viewLanguage('Mã GN')}}</th>
                                <th width="15%" class="text-center">{{viewLanguage('Thời gian hiệu lực')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Gói BH')}}</th>

                                <th width="10%" class="text-center">{{viewLanguage('Loại')}}</th>
                                <th width="15%" class="text-center">{{viewLanguage('Phí BH')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($listContracts as $keys_contracts => $contracts)
                                <tr>
                                    <td class="text-center middle">
                                        <input class="checkAjax" type="checkbox" name="checkStaffCode[]" id="sys_checkItems" value="1">
                                    </td>
                                    <td class="text-center middle">{{$keys_contracts+1}}</td>
                                    <td class="text-center middle">
                                        <a href="javascript:void(0);" style="color: #329945" onclick="viewDetailOrder(this);" data-contract-code="{{$contracts->CONTRACT_CODE}}" data-category="{{$contracts->CATEGORY}}" data-detail-code="{{$contracts->DETAIL_CODE}}" data-product-code="{{PRODUCT_CODE_ATTD}}">
                                            <i class="pe-7s-look fa-2x"></i>
                                        </a>
                                        <!--
                                        <a href="javascript:void(0);" style="color: #329945" class="sys_delete_item_common2" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="addFormOther" data-show="2" data-loading="2" data-div-show="content-other-right" data-function-action="_getDetailContract" data-method="post" title="{{viewLanguage('Cập nhật: ')}}" data-input="{{json_encode(['itemOther'=>[],'action'=>'_getDetailContract','type'=>0,'arrKey'=>['CATEGORY'=>$contracts->CATEGORY,'PRODUCT_CODE'=>$contracts->PRODUCT_CODE,'CONTRACT_CODE'=>$contracts->CONTRACT_CODE,'DETAIL_CODE'=>$contracts->DETAIL_CODE]])}}" data-url="{{$urlAjaxGetData}}" data-objectId="1">
                                            <i class="pe-7s-look fa-2x"></i>
                                        </a>
                                        <a href="javascript:void(0);" style="color: #FFB600" class="sys_delete_item_common2" data-form-name="viewDetail" title="{{viewLanguage('Thông tin')}}" data-method="post" data-url="" data-input="{{json_encode([])}}">
                                            <i class="pe-7s-wallet fa-2x"></i>
                                        </a>
                                        <a href="javascript:void(0);" style="color: #008FFB" class="sys_delete_item_common2" data-form-name="viewDetail" title="{{viewLanguage('Thông tin')}}" data-method="post" data-url="" data-input="{{json_encode([])}}">
                                            <i class="pe-7s-print fa-2x"></i>
                                        </a>-->
                                    </td>
                                    <td class="text-center middle">@if(isset($contracts->CERTIFICATE_NO)){{$contracts->CERTIFICATE_NO}}@endif</td>

                                    <td class="text-center middle">@if(isset($contracts->DISBUR_CODE)){{$contracts->DISBUR_CODE}}@endif</td>
                                    <td class="text-center middle">
                                        @if(isset($contracts->EFFECTIVE_DATE) && trim($contracts->EFFECTIVE_DATE)!=''){{$contracts->EFFECTIVE_DATE}}@endif
                                        <br/>
                                        @if(isset($contracts->EXPIRATION_DATE) && trim($contracts->EXPIRATION_DATE)!=''){{$contracts->EXPIRATION_DATE}}@endif
                                    </td>
                                    <td class="text-left middle">@if(isset($contracts->PACK_NAME)){{$contracts->PACK_NAME}}@endif</td>

                                    <td class="text-center middle">@if(isset($contracts->CONTRACT_TYPE_NAME)){{$contracts->CONTRACT_TYPE_NAME}}@endif</td>
                                    <td class="text-right middle">@if(isset($contracts->TOTAL_AMOUNT)){{numberFormat($contracts->TOTAL_AMOUNT)}} VNĐ @endif</td>
                                    <td class="text-center middle">@if(isset($contracts->STATUS_NAME)){{$contracts->STATUS_NAME}}@endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@else
    Chưa có nhân viên thuộc phòng ban này
@endif

<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        $("#checkAllAjax").click(function () {
            $(".checkAjax").prop('checked', $(this).prop('checked'));
        });
    });
    //tim kiem
    var config = {
        '.chosen-select'           : {width: "58%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
