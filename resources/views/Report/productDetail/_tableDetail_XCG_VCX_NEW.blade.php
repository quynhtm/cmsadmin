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
                    <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Đối tác')}}</th>
                    <th width="12%" class="text-center middle">{{viewLanguage('Nhân viên cấp đơn')}}</th>

                    <th width="20%" class="text-center middle">{{viewLanguage('Thông tin khách hàng')}}</th>
                    <th width="18%" class="text-center middle">{{viewLanguage('Địa chỉ')}}</th>
                    <th width="12%" class="text-center middle">{{viewLanguage('Gói/ Sản phẩm')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Phí bh đã thanh toán')}}</th>
                    <th width="8%" class="text-center middle">{{viewLanguage('Ngày thanh toán')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-left middle">@if(isset($item->ORG_NAME)){{$item->ORG_NAME}}@endif</td>
                        <td class="text-left middle">@if(isset($item->SELLER_NAME)){{$item->SELLER_NAME}}@endif</td>

                        <td class="text-left middle">
                            @if(isset($item->NAME))<b>Tên: </b>{{$item->NAME}}<br>@endif
                            @if(isset($item->PHONE))<b>Phone: </b>{{$item->PHONE}}<br>@endif
                            @if(isset($item->EMAIL))<b>Email: </b>{{$item->EMAIL}}<br>@endif
                            @if(isset($item->NUMBER_PLATE))<b>BKS: </b>{{$item->NUMBER_PLATE}}<br>@endif
                            @if(isset($item->CHASSIS_NO))<b>SK: </b>{{$item->CHASSIS_NO}}<br>@endif
                            @if(isset($item->ENGINE_NO))<b>SM: </b>{{$item->ENGINE_NO}}<br>@endif
                        </td>
                        <td class="text-left middle">@if(isset($item->FULL_ADDRESS)){{$item->FULL_ADDRESS}}@endif</td>
                        <td class="text-left middle">@if(isset($item->PRODUCT_NAME)){{$item->PRODUCT_NAME}}@endif</td>

                        <td class="text-right middle">@if(isset($item->TOTAL_AMOUNT))<b class="red">{{numberFormat($item->TOTAL_AMOUNT)}}</b>@endif</td>
                        <td class="text-center middle">@if(isset($item->DATE_SIGN)){{$item->DATE_SIGN}}@endif</td>
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