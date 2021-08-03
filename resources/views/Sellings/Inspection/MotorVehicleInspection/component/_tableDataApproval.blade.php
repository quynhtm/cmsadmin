<div class="card-body">
    @if($data && sizeof($data) > 0)
        <div class="row">
            <div class="col-lg-4 text-left">
                <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif</h5>
            </div>
            <div class="col-lg-8 text-right">
                @if($total >0)
                    <button class="btn-transition btn btn-outline-warning btn-search-right marginDownT15 display-none-block" type="submit" name="submit" value="2" title="Xuất excel"><i class="fa fa-file-excel"></i></button>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="3%" class="text-center middle">STT</th>
                    <th width="4%" class="text-center middle">{{viewLanguage('Thao tác')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Tên khách hàng')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Đối tác')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Loại xe')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('BKS-SK-SM')}}</th>
                    <th width="8%" class="text-center middle">{{viewLanguage('Hãng xe')}}</th>

                    <th width="8%" class="text-center middle">{{viewLanguage('Thời gian giám định dự kiến')}}</th>
                    <th width="15%" class="text-center middle">{{viewLanguage('Địa chỉ giám định')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Người giám định')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Trạng thái')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-center middle">
                            @if($is_root || $permission_view || $permission_add)
                                <a href="javascript:void(0);" style="color: green" onclick="viewDetailOrder(this);" data-contract-code="{{$item->CONTRACT_CODE}}" data-category="XE" data-detail-code="{{$item->DETAIL_CODE}}" data-product-code="{{$product_code_vcx}}" title="{{viewLanguage('Chi tiết đơn: ')}}@if(isset($item->NAME)){{$item->NAME }}@endif">
                                    <i class="fa fa-eye fa-2x green"></i>
                                </a>
                            @endif
                        </td>

                        <td class="text-left middle">@if(isset($item->NAME)){{$item->NAME }}@endif</td>
                        <td class="text-left middle">@if(isset($item->AGENCY_NAME)){{$item->AGENCY_NAME }}@endif</td>
                        <td class="text-left middle">@if(isset($item->DETAIL_NAME)){{$item->DETAIL_NAME }}@endif</td>
                        <td class="text-left middle">
                            @if(isset($item->NUMBER_PLATE) && trim($item->NUMBER_PLATE) != '')<b>BKS: </b>{{$item->NUMBER_PLATE }} <br/>@endif
                            @if(isset($item->CHASSIS_NO) && trim($item->CHASSIS_NO) != '')<b>SK: </b>{{$item->CHASSIS_NO }}<br/> @endif
                            @if(isset($item->ENGINE_NO) && trim($item->ENGINE_NO) != '')<b>SM: </b>{{$item->ENGINE_NO }} <br/>@endif
                        </td>
                        <td class="text-left middle">@if(isset($item->MODEL)){{$item->MODEL }}@endif</td>

                        <td class="text-left middle">
                            @if(isset($item->CALENDAR)){{$item->CALENDAR }}@endif
                        </td>
                        <td class="text-left middle">@if(isset($item->FULL_ADDRESS)){{$item->FULL_ADDRESS }}@endif</td>
                        <td class="text-left middle">@if(isset($item->STAFF_NAME)){{$item->STAFF_NAME}}@endif</td>
                        <td class="text-left middle">
                            @if(isset($item->STATUS_NAME)){{$item->STATUS_NAME}}@endif
                            @if(isset($item->REASON) && trim($item->REASON) != '' && isset($item->STATUS) && $item->STATUS == 'GDL')
                                <br/>
                                <a href="javascript:void(0);" class="detailOtherCommon red" onclick="jqueryCommon.getDataByAjax(this);" data-form-name="addFormOther" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxActionOther" data-input="{{json_encode(['type'=>'getReason','dataItem'=>$item])}}" data-show="0" data-loading="1" data-show-id="" title="{{viewLanguage('Lý do giám định lại: ')}}@if(isset($item->NAME)){{$item->NAME }}@endif" data-method="post" data-objectId="">
                                    Lý do
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="paging_simple_numbers">
            {!! $paging !!}
        </div>
    @else
        <div class="alert">
            Không có dữ liệu
        </div>
    @endif
</div>
<script type="text/javascript">
    $(document).ready(function(){
        jqueryCommon.pagingAjaxWithForm('{{$formSeachIndex}}','{{$urlSearchAjax}}');
    });
</script>