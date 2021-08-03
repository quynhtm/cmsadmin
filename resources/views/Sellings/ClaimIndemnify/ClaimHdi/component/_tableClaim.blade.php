<div class="card-body">
    @if($data && sizeof($data) > 0)
        <div class="row">
            <div class="col-lg-4 text-left">
                <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif</h5>
            </div>
            <div class="col-lg-8 text-right">
                @if($total >0)
                    <button class="border-0 btn-transition btn btn-outline-success marginDownT15" type="submit" name="submit" value="2" title="Xuất excel"><i class="fa fa-file-excel fa-2x"></i></button>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="3%" class="text-center middle">STT</th>
                    <th width="2%" class="text-center middle">{{viewLanguage('TT')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Sản phẩm')}}</th>
                <!--                            <th width="8%" class="text-center middle">{{viewLanguage('Hồ sơ bồi thường')}}</th>-->
                    <th width="8%" class="text-center middle">{{viewLanguage('HĐ bảo hiểm')}}</th>

                    <th width="12%" class="text-center middle">{{viewLanguage('KH bồi thường')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Số tiền yêu cầu')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Số tiền bồi thường')}}</th>
                    <th width="8%" class="text-center middle">{{viewLanguage('Kênh tiếp nhận')}}</th>

                    <th width="8%" class="text-center middle">{{viewLanguage('Ngày yêu cầu')}}</th>
                    <th width="12%" class="text-center middle">{{viewLanguage('Người xử lý')}}</th>
                    <th width="15%" class="text-center middle">{{viewLanguage('Trạng thái')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-center middle">
                            @if($is_root || $permission_view || $permission_add)
                                <a href="javascript:void(0);" style="color: green" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="detailItem" data-input="{{json_encode(['item'=>$item,'arrKey'=>['ORG_CODE'=>$item->ORG_CODE,'PRODUCT_CODE'=>$item->PRODUCT_CODE,'CLAIM_CODE'=>$item->CLAIM_CODE]])}}" data-show="2" data-override="1" data-div-show="content-page-right" title="{{viewLanguage('Thông tin bồi thường: ')}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="1">
                                    <i class="pe-7s-look fa-2x"></i>
                                </a>
                            @endif
                        </td>

                        <td class="text-center middle">@if(isset($item->PRODUCT_NAME)){{$item->PRODUCT_NAME}}@endif</td>
                        <!--                            <td class="text-left middle"></td>-->
                        <td class="text-left middle">@if(isset($item->CONTRACT_NO)){{$item->CONTRACT_NO}}@endif</td>

                        <td class="text-left middle">@if(isset($item->INSURED_NAME)){{$item->INSURED_NAME }}@endif</td>
                        <td class="text-right middle"><b class="red">@if(isset($item->REQUIRED_AMOUNT)){{numberFormat($item->REQUIRED_AMOUNT)}}@endif</b></td>
                        <td class="text-right middle"><b class="red">@if(isset($item->AMOUNT)){{numberFormat($item->AMOUNT)}}@endif</b></td>
                        <td class="text-center middle">@if(isset($item->CHANNEL)){{$item->CHANNEL}}@endif</td>

                        <td class="text-center middle">@if(isset($item->CLAIM_DATE)){{$item->CLAIM_DATE}}@endif</td>
                        <td class="text-center middle">@if(isset($item->STAFF_NAME)){{$item->STAFF_NAME}}@endif</td>
                        <td class="text-center middle">@if(isset($item->STATUS_NAME)){{$item->STATUS_NAME}}@endif </td>
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