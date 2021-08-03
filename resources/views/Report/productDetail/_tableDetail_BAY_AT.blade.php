<div class="card-body">
    @if($data && sizeof($data) > 0)
        <div class="row">
            <div class="col-lg-4 text-left">
                <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif @if($totalMoney >0), tổng doanh thu: <b class="red">{{numberFormat($totalMoney)}}</b>  @endif </h5>
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
                    <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                    <th width="15%" class="text-center middle">{{viewLanguage('Tên khách hàng')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Mã đặt chỗ')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Số ghế')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Loại khách hàng')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Loại vé')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Số hiệu chuyến bay')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Nơi đi')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Nơi đến')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Ngày khởi hành')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-left middle">@if(isset($item->NAME)){{$item->NAME}}@endif</td>

                        <td class="text-center middle">@if(isset($item->BOOKING_ID)){{$item->BOOKING_ID}}@endif</td>
                        <td class="text-center middle">@if(isset($item->SEAT)){{$item->SEAT}}@endif</td>

                        <td class="text-center middle">@if(isset($item->CUS_TYPE)){{$item->CUS_TYPE}}@endif</td>
                        <td class="text-center middle"> @if(isset($item->FARE_CLASS)){{$item->FARE_CLASS}}@endif</td>

                        <td class="text-center middle">@if(isset($item->FLI_NO)){{$item->FLI_NO}}@endif</td>
                        <td class="text-center middle">@if(isset($item->DEP)){{$item->DEP}}@endif</td>

                        <td class="text-center middle">@if(isset($item->ARR)){{$item->ARR}}@endif</td>
                        <td class="text-center middle">@if(isset($item->FLI_R_DATE)){{$item->FLI_R_DATE}}@endif</td>
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