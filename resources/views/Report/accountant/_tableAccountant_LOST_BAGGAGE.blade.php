<div class="card-body">
    @if($data && sizeof($data) > 0)
        <div class="row">
            <div class="col-lg-4 text-left">
                <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif</h5>
            </div>
            <div class="col-lg-8 text-right">
                @if($total >0)
                    <button class="border-0 btn-transition btn btn-outline-success marginDownT15" type="submit" name="submit" value="2" title="Xuất excel" onclick="return checkExportExcel();"><i class="fa fa-file-excel fa-2x"></i></button>
                @endif
            </div>
        </div>
        <div class="table-responsive" style="height: 600px; overflow: hidden; overflow-y: scroll">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="3%" class="text-center middle th_sticky">{{viewLanguage('STT')}}</th>
                    <th width="3%" class="text-center middle th_sticky"><input type="checkbox" class="check" id="checkAllOrder" checked></th>
                    <th width="10%" class="text-center middle th_sticky">{{viewLanguage('Số hợp đồng')}}</th>

                    <th width="30%" class="text-center middle th_sticky">{{viewLanguage('Tên hợp đồng')}}</th>
                    <th width="8%" class="text-center middle th_sticky">{{viewLanguage('Thời gian cất cánh')}}</th>

                    <th width="8%" class="text-center middle th_sticky">{{viewLanguage('Thời gian hạ cánh')}}</th>
                    <th width="10%" class="text-center middle th_sticky">{{viewLanguage('Gói bảo hiểm')}}</th>
                    <th width="8%" class="text-right middle th_sticky">{{viewLanguage('Phí')}}</th>
                    <th width="8%" class="text-right middle th_sticky">{{viewLanguage('VAT')}}</th>
                    <th width="12%" class="text-right middle th_sticky">{{viewLanguage('Tổng tiền')}}</th>
                </tr>
                </thead>
                <tbody>

                @if(!empty($inforTotal))
                <tr>
                    <td class="text-right middle" colspan="8"></td>
                    <td class="text-right middle">
                        @if(isset($inforTotal->TOTAL_AMOUNT))<b class="red">{{numberFormat($inforTotal->TOTAL_AMOUNT)}}</b>@endif
                    </td>
                </tr>
                @endif

                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-center middle">
                            <input class="check" type="checkbox" @if(isset($item->FLAG) && $item->FLAG == STATUS_INT_KHONG) name="checkItems[]" checked @else disabled @endif value="@if(isset($item->CERTIFICATE_NO)){{$item->CERTIFICATE_NO}}@endif">
                        </td>
                        <td class="text-left middle">@if(isset($item->CERTIFICATE_NO)){{$item->CERTIFICATE_NO}}@endif</td>
                        <!--<td class="text-left middle">@if(isset($item->CUS_NAME)){{$item->CUS_NAME}}@endif</td>-->

                        <td class="text-left middle">@if(isset($item->CONTRACT_NAME)){{$item->CONTRACT_NAME}}@endif</td>
                        <td class="text-center middle">@if(isset($item->FLI_DATE)){{$item->FLI_DATE}}@endif</td>

                        <td class="text-center middle"> @if(isset($item->FLI_LAND_DATE)){{$item->FLI_LAND_DATE}}@endif</td>
                        <td class="text-left middle"> @if(isset($item->PACK_NAME)){{$item->PACK_NAME}}@endif</td>
                        <td class="text-right middle">@if(isset($item->AMOUNT))<b class="red">{{numberFormat($item->AMOUNT)}}</b>@endif</td>
                        <td class="text-right middle">@if(isset($item->VAT))<b class="red">{{numberFormat($item->VAT)}}</b>@endif</td>
                        <td class="text-right middle">@if(isset($item->TOTAL_AMOUNT))<b class="red">{{numberFormat($item->TOTAL_AMOUNT)}}</b>@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert">
            Không có dữ liệu
        </div>
    @endif
</div>