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
                <tr class="">
                    <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                    <th width="15%" class="text-left middle">{{viewLanguage('Đối tác')}}</th>
                    <th width="15%" class="text-left middle">{{viewLanguage('Nhân viên cấp đơn')}}</th>

                    <th width="25%" class="text-left middle">{{viewLanguage('Thông tin khách hàng')}}</th>
                    <th width="20%" class="text-left middle">{{viewLanguage('Gói/ Sản phẩm')}}</th>

                    <th width="10%" class="text-right middle">{{viewLanguage('Phí BH đã thanh toán')}}</th>
                    <th width="10%" class="text-center middle">{{viewLanguage('Ngày thanh toán')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr data-form-name="detailItem" data-input="{{json_encode([])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}" data-method="get" data-url="" data-objectId="1">
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-left middle">@if(isset($item->ORG_NAME)){{$item->ORG_NAME}}@endif</td>
                        <td class="text-left middle">
                            @if(isset($item->STAFF_CODE)){{$item->STAFF_CODE}} <br>@endif
                            @if(isset($item->STAFF_NAME)){{$item->STAFF_NAME}} <br>@endif
                        </td>

                        <td class="text-left middle">
                            @if(isset($item->CUS_NAME))<b>Tên:</b> {{$item->CUS_NAME}}<br/>@endif
                            @if(isset($item->EMAIL))<b>Email:</b> {{$item->EMAIL}}<br/>@endif
                            @if(isset($item->PHONE))<b>Phone:</b> {{$item->PHONE}}<br/>@endif
                            @if(isset($item->DOB) && trim($item->DOB) != '')<b>Ngày sinh:</b> {{convertDateDMY($item->DOB)}}<br/>@endif
                            @if(isset($item->ADDRESS))<b>Add:</b> {{$item->ADDRESS}}<br/>@endif
                            @if(isset($item->BANK_ACCOUNT_NUM))<b>Bank:</b> {{$item->BANK_ACCOUNT_NUM}}<br/>@endif
                        </td>

                        <td class="text-left middle">
                            @if(isset($item->PACK_NAME)  && trim($item->PACK_NAME) != '')<b>Gói</b>: {{$item->PACK_NAME}} <br/>@endif
                            @if(isset($item->PRODUCT_NAME)  && trim($item->PRODUCT_NAME) != '')<b>SP</b>: {{$item->PRODUCT_NAME}}@endif
                        </td>

                        <td class="text-right middle"><b class="red">{{numberFormat($item->AMOUNT)}}</b></td>
                        <td class="text-center middle">@if(isset($item->CREATE_DATE)){{date('d/m/Y H:i', strtotime($item->CREATE_DATE))}}@endif</td>
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