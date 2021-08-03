<div class="card-body">
    @if($data && sizeof($data) > 0)

        <div class="row">
            <div class="col-lg-5 text-left">
                <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif @if($totalMoney >0), tổng doanh thu: <b class="red">{{numberFormat($totalMoney)}}</b>  @endif </h5>
            </div>
            <div class="col-lg-7 text-right">
                @if($total >0)
                    <button class="border-0 btn-transition btn btn-outline-success marginDownT15" type="submit" name="submit" value="2" title="Xuất excel"><i class="fa fa-file-excel fa-2x"></i></button>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="3%" class="text-center middle" >{{viewLanguage('STT')}}</th>
                    <th width="10%" class="text-center middle" >{{viewLanguage('Ngày khởi hành')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Số hiệu chuyến bay')}}</th>
                    <th width="10%" class="text-right middle">{{viewLanguage('Số lượng hành khách')}}</th>

                    <th width="10%" class="text-right middle" >{{viewLanguage('Em bé đi kèm')}}</th>
                    <th width="10%" class="text-right middle" >{{viewLanguage('Số khách loại vé C')}}</th>
                    <th width="15%" class="text-right middle" >{{viewLanguage('Tổng doanh thu')}}</th>

                    <th width="10%" class="text-right middle" >{{viewLanguage('Phí quyền lợi A')}}</th>
                    <th width="10%" class="text-right middle" >{{viewLanguage('Phí quyền lợi B, không VAT')}}</th>
                    <th width="10%" class="text-right middle" >{{viewLanguage('Thuế quyền lợi B')}}</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($dataTotal) && !empty($dataTotal))
                    <tr class="font-bold red">
                        <td class="text-right middle" colspan="3">Tổng</td>

                        <td class="text-right middle">@if(isset($dataTotal->NUM_OF_CUS))<b>{{numberFormat($dataTotal->NUM_OF_CUS)}}@endif</b></td>
                        <td class="text-right middle">@if(isset($dataTotal->NUM_OF_INFANT))<b>{{numberFormat($dataTotal->NUM_OF_INFANT)}}@endif</b></td>
                        <td class="text-right middle">@if(isset($dataTotal->NUM_CLASS_C))<b>{{numberFormat($dataTotal->NUM_CLASS_C)}}@endif</b></td>
                        <td class="text-right middle">@if(isset($dataTotal->TOTAL_AMOUNT))<b>{{numberFormat($dataTotal->TOTAL_AMOUNT)}}@endif</b></td>

                        <td class="text-right middle">@if(isset($dataTotal->FEES_BENEFIT_A))<b>{{numberFormat($dataTotal->FEES_BENEFIT_A)}}@endif</b></td>
                        <td class="text-right middle">@if(isset($dataTotal->FEES_BENEFIT_B))<b>{{numberFormat($dataTotal->FEES_BENEFIT_B)}}@endif</b></td>
                        <td class="text-right middle">@if(isset($dataTotal->VAT_BENEFIT_B))<b>{{numberFormat($dataTotal->VAT_BENEFIT_B)}}@endif</b></td>
                    </tr>
                @endif
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-center middle">@if(isset($item->FLI_R_DATE)){{$item->FLI_R_DATE}}@endif</td>

                        <td class="text-center middle">@if(isset($item->FLI_NO)){{$item->FLI_NO}}@endif</td>
                        <td class="text-right middle">@if(isset($item->NUM_OF_CUS)){{numberFormat($item->NUM_OF_CUS)}}@endif</td>

                        <td class="text-right middle">@if(isset($item->NUM_OF_INFANT)){{numberFormat($item->NUM_OF_INFANT)}}@endif</td>
                        <td class="text-right middle"> @if(isset($item->NUM_CLASS_C)){{numberFormat($item->NUM_CLASS_C)}}@endif</td>
                        <td class="text-right middle">@if(isset($item->TOTAL_AMOUNT))<span class="red">{{numberFormat($item->TOTAL_AMOUNT)}}</span>@endif</td>

                        <td class="text-right middle">@if(isset($item->FEES_BENEFIT_A))<span class="red">{{numberFormat($item->FEES_BENEFIT_A)}}</span>@endif</td>
                        <td class="text-right middle">@if(isset($item->FEES_BENEFIT_B))<span class="red">{{numberFormat($item->FEES_BENEFIT_B)}}</span>@endif</td>
                        <td class="text-right middle">@if(isset($item->VAT_BENEFIT_B))<span class="red">{{numberFormat($item->VAT_BENEFIT_B)}}</span>@endif</td>
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