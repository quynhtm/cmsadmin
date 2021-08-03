<div class="card-body">
    @if($data && sizeof($data) > 0)
        <div class="row">
            <div class="col-lg-6 text-left">
                <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif</h5>
            </div>
            <div class="col-lg-6 text-right">
                @if($total >0)
                    <button class="border-0 btn-transition btn btn-outline-success marginDownT15" type="submit" name="submit" value="2" title="Xuất excel"><i class="fa fa-file-excel fa-2x"></i></button>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                    <th width="25%" class="text-left middle">{{viewLanguage('Đơn vị')}}</th>
                    <th width="20%" class="text-left middle">{{viewLanguage('Thông tin sản phẩm')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Ngày áp dụng')}}</th>
                    <th width="15%" class="text-center middle">{{viewLanguage('Số hợp đồng')}}</th>
                    <th width="15%" class="text-right middle">{{viewLanguage('Doanh thu')}}</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($dataTotalInfor))
                <tr>
                    <td colspan="4" class="text-right middle"> Tổng </td>
                    <td class="text-center middle">@if(isset($dataTotalInfor->NUM_OF_CONTRACT))<b>{{numberFormat($dataTotalInfor->NUM_OF_CONTRACT)}}</b>@endif</td>
                    <td class="text-right middle">@if(isset($dataTotalInfor->TOTAL_AMOUNT))<b class="red">{{numberFormat($dataTotalInfor->TOTAL_AMOUNT)}}</b>@endif</td>
                </tr>
                @endif
                @foreach ($data as $key => $item)
                    <tr data-form-name="detailItem" data-input="{{json_encode([])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}" data-method="get" data-url="" data-objectId="1">
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-left middle">@if(isset($item->ORG_NAME)){{$item->ORG_NAME}}@endif</td>
                        <td class="text-left middle">@if(isset($item->PRODUCT_NAME)){{$item->PRODUCT_NAME}}@endif</td>

                        <td class="text-center middle">@if(isset($item->EFFECTIVE_DATE)){{$item->EFFECTIVE_DATE}}@endif</td>
                        <td class="text-center middle">@if(isset($item->NUM_OF_CONTRACT)){{numberFormat($item->NUM_OF_CONTRACT)}}@endif</b></td>
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