<div class="card-body">
    @if($data && sizeof($data) > 0)
        <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif </h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                    <th width="5%" class="text-center middle">{{viewLanguage('TT')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Số hợp đồng')}}</th>

                    <th width="15%" class="text-center middle">{{viewLanguage('Tên khách hàng')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Ngày tạo')}}</th>
                    <th width="15%" class="text-center middle">{{viewLanguage('Sản phẩm')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Đối tác')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Người cấp')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Trạng thái')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Phí BH')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-center middle">
                            @if($is_root || $permission_view || $permission_add)
                                {{----View detail with layout---}}
                                @if(isset($item->DATA_VEW))
                                    <a href="javascript:void(0);" style="color: green" onclick="viewDetailOrder(this);" data-channel="@if(isset($arrProductType[$product_code]['channel'])){{$arrProductType[$product_code]['channel']}}@endif" data-contract-code="{{$item->CONTRACT_CODE}}" data-category="{{$item->CATEGORY}}" data-detail-code="" data-product-code="{{$product_code}}">
                                        <i class="pe-7s-look fa-2x"></i>
                                    </a>

                                    {{--@if($item->DATA_VEW == 'CONTRACT')
                                        <a href="javascript:void(0);" style="color: green" onclick="viewDetailOrder(this);" data-channel="@if(isset($arrProductType[$product_code]['channel'])){{$arrProductType[$product_code]['channel']}}@endif" data-contract-code="{{$item->CONTRACT_CODE}}" data-category="{{$item->CATEGORY}}" data-detail-code="" data-product-code="{{$product_code}}">
                                            <i class="pe-7s-look fa-2x"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" style="color: green" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="detailItem" data-input="{{json_encode(['item'=>$item,'arrKey'=>['CONTRACT_CODE'=>$item->CONTRACT_CODE,'CATEGORY'=>$item->CATEGORY,'PRODUCT_CODE'=>$product_code]])}}" data-show="2" data-override="1" data-div-show="content-page-right" title="{{viewLanguage('Thông tin hợp đồng: ')}}{{$item->CONTRACT_CODE}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="1">
                                            <i class="pe-7s-look fa-2x"></i>
                                        </a>
                                    @endif--}}
                                @else
                                    @if($item->CONTRACT_MODE == 'TRUC_TIEP')
                                        <a href="javascript:void(0);" style="color: green" onclick="viewDetailOrder(this);" data-channel="@if(isset($arrProductType[$product_code]['channel'])){{$arrProductType[$product_code]['channel']}}@endif" data-contract-code="{{$item->CONTRACT_CODE}}" data-category="{{$item->CATEGORY}}" data-detail-code="" data-product-code="{{$product_code}}">
                                            <i class="pe-7s-look fa-2x"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" style="color: green" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="detailItem" data-input="{{json_encode(['item'=>$item,'arrKey'=>['CONTRACT_CODE'=>$item->CONTRACT_CODE,'CATEGORY'=>$item->CATEGORY,'PRODUCT_CODE'=>$product_code]])}}" data-show="2" data-override="1" data-div-show="content-page-right" title="{{viewLanguage('Thông tin hợp đồng: ')}}{{$item->CONTRACT_CODE}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="1">
                                            <i class="pe-7s-look fa-2x"></i>
                                        </a>
                                    @endif
                                @endif
                            @endif
                        </td>
                        <td class="text-left middle">@if(isset($item->CONTRACT_NO)){{$item->CONTRACT_NO}}@endif</td>

                        <td class="text-left middle">@if(isset($item->NAME)){{$item->NAME}}@endif</td>
                        <td class="text-center middle">@if(isset($item->MODIFIED_DATE)){{$item->MODIFIED_DATE}}@endif</td>
                        <td class="text-center middle">@if(isset($item->PRODUCT_NAME)){{$item->PRODUCT_NAME}}@endif</td>

                        <td class="text-center middle">@if(isset($item->ORG_SELLER_NAME)){{$item->ORG_SELLER_NAME}}@endif</td>
                        <td class="text-center middle">@if(isset($item->SELLER_NAME_ATTD)){{$item->SELLER_NAME_ATTD}}@endif</td>

                        <td class="text-center middle">@if(isset($item->LO_NAME)){{$item->LO_NAME}}@endif</td>
                        <td class="text-right middle"><b class="red">@if(isset($item->TOTAL_AMOUNT)){{numberFormat($item->TOTAL_AMOUNT)}}@endif</b></td>
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



