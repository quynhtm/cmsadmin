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
                    <th width="3%" class="text-center middle" rowspan="2">{{viewLanguage('STT')}}</th>
                    <th width="35%" class="text-center middle" rowspan="2">{{viewLanguage('Loại xe')}}</th>

                    <th width="27%" class="text-center middle" colspan="3">{{viewLanguage('Số lượng xe')}}</th>
                    <th width="35%" class="text-center middle" colspan="3">{{viewLanguage('Phí bảo hiểm')}}</th>
                </tr>
                <tr class="">
                    <th width="9%" class="text-center middle alert-warning">{{viewLanguage('Đầu kỳ')}}</th>
                    <th width="9%" class="text-center middle alert-warning">{{viewLanguage('Phát sinh')}}</th>
                    <th width="9%" class="text-center middle alert-warning">{{viewLanguage('Cuối kỳ')}}</th>
                    <th width="12%" class="text-center middle">{{viewLanguage('Đầu kỳ')}}</th>
                    <th width="12%" class="text-center middle">{{viewLanguage('Phát sinh')}}</th>
                    <th width="12%" class="text-center middle">{{viewLanguage('Cuối kỳ')}}</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total_C = $total_D = $total_E = $total_F = $total_G = $total_H = 0;
                ?>
                @foreach ($data as $key => $item)
                    <?php
                    $style_bold = $item->GROUPING == 1? 'font-bold red':'';
                    if($item->GROUPING == 1){
                        if(isset($item->DK_NUM_OF_VEH)){$total_C = (int)($total_C + $item->DK_NUM_OF_VEH);}
                        if(isset($item->PS_NUM_OF_VEH)){$total_D = (int)($total_D + $item->PS_NUM_OF_VEH);}
                        if(isset($item->EOT_NUM_OF_VEH)){$total_E = (int)($total_E + $item->EOT_NUM_OF_VEH);}

                        if(isset($item->DK_TOTAL_AMOUNT)){$total_F = (int)($total_F + $item->DK_TOTAL_AMOUNT);}
                        if(isset($item->PS_TOTAL_AMOUNT)){$total_G = (int)($total_G + $item->PS_TOTAL_AMOUNT);}
                        if(isset($item->EOT_TOTAL_AMOUNT)){$total_H = (int)($total_H + $item->EOT_TOTAL_AMOUNT);}

                        $stt = $stt+1;
                    }

                    ?>
                    <tr class="{{$style_bold}}">
                        <td class="text-center middle">@if(isset($item->GROUPING) && $item->GROUPING == 1){{$stt}}@endif</td>
                        <td class="text-left middle">@if(isset($item->VH_TYPE)){{$item->VH_TYPE}}@endif</td>

                        <td class="text-right middle">@if(isset($item->DK_NUM_OF_VEH)){{numberFormat($item->DK_NUM_OF_VEH)}}@endif</td>
                        <td class="text-right middle">@if(isset($item->PS_NUM_OF_VEH)){{numberFormat($item->PS_NUM_OF_VEH)}}@endif</td>
                        <td class="text-right middle">@if(isset($item->EOT_NUM_OF_VEH)){{numberFormat($item->EOT_NUM_OF_VEH)}}@endif</td>

                        <td class="text-right middle"> @if(isset($item->DK_TOTAL_AMOUNT)){{numberFormat($item->DK_TOTAL_AMOUNT)}}@endif</td>
                        <td class="text-right middle">@if(isset($item->PS_TOTAL_AMOUNT)){{numberFormat($item->PS_TOTAL_AMOUNT)}}@endif</td>
                        <td class="text-right middle">@if(isset($item->EOT_TOTAL_AMOUNT)){{numberFormat($item->EOT_TOTAL_AMOUNT)}}@endif</td>
                    </tr>
                @endforeach
                <tr class="font-bold red">
                    <td class="text-left middle" colspan="2">Tổng</td>

                    <td class="text-right middle">{{numberFormat($total_C)}}</td>
                    <td class="text-right middle">{{numberFormat($total_D)}}</td>
                    <td class="text-right middle">{{numberFormat($total_E)}}</td>

                    <td class="text-right middle">{{numberFormat($total_F)}}</td>
                    <td class="text-right middle">{{numberFormat($total_G)}}</td>
                    <td class="text-right middle">{{numberFormat($total_H)}}</td>
                </tr>
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