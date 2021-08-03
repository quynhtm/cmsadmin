{{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Search')}}</h5>
        <div class="ibox-tools marginDownT6">
            <button class="btn btn-primary marginR20" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
            @if($total >0)
                <button class="btn btn-warning" type="submit" name="submit" value="2"><i class="fa fa-file-excel"></i> {{viewLanguage('Xuất excel')}}</button>
            @endif
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-4">
                <label for="user_name">{{viewLanguage('Tìm kiếm chung')}}</label>
                <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
            </div>
            <div class=" col-lg-4">
                <label for="user_email">{{viewLanguage('Ngày bắt đầu')}}</label>
                <input type="text" class="form-control input-sm input-date" id="p_from_date" name="p_from_date" autocomplete="off" @if(isset($search['p_from_date']))value="{{$search['p_from_date']}}" @else value="{{date('d/m/Y',strtotime(\Illuminate\Support\Carbon::now()->startOfMonth()))}}"@endif>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class=" col-lg-4">
                <label for="user_phone">{{viewLanguage('đến')}}</label>
                <input type="text" class="form-control input-sm input-date" id="p_to_date" name="p_to_date" autocomplete="off" @if(isset($search['p_to_date']))value="{{$search['p_to_date']}}"@else value="{{date('d/m/Y',strtotime(\Illuminate\Support\Carbon::now()))}}"@endif>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
        </div>

        <div class="row marginT10">
            <div class=" col-lg-4">
                <label for="user_group">{{viewLanguage('Sản phẩm')}}</label>
                <select  class="form-control input-sm" name="PRODUCT_CODE" id="PRODUCT_CODE">
                    {!! $optionProduct !!}
                </select>
            </div>
            <div class=" col-lg-4">
                <label for="user_group">{{viewLanguage('Chương trình')}}</label>
                <select  class="form-control input-sm" name="CAMPAIGN_CODE" id="CAMPAIGN_CODE">
                    {!! $optionCampaigns !!}
                </select>
            </div>
            <div class=" col-lg-4">
                <label for="user_group">{{viewLanguage('Đối tác')}}</label>
                <select  class="form-control input-sm chosen-select w-100" name="ORG_CODE" id="ORG_CODE">
                    {!! $optionOrg !!}}
                </select>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi, có tổng số tiền <b class="red font-20">{{numberFormat($totalMoney)}}</b> vnđ @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        {{--<th width="3%" class="text-center"><input type="checkbox" class="check" id="checkAll"></th>--}}
                        <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Đối tác')}}</th>
                        <th width="15%" class="text-center middle">{{viewLanguage('Chương trình')}}</th>
                        <th width="20%" class="text-center middle">{{viewLanguage('Thông tin khách hàng')}}</th>
                        <th width="20%" class="text-center middle">{{viewLanguage('Thông tin nhân viên')}}</th>

                        <th width="8%" class="text-center middle">{{viewLanguage('Gói/ Sản phẩm')}}</th>
                        <th width="8%" class="text-center middle">{{viewLanguage('Mã')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Số hiệu')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Giá')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Ngày đăng ký')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr data-form-name="detailItem" data-input="{{json_encode([])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}" data-method="get" data-url="" data-objectId="1">
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-left middle">@if(isset($item->ORG_NAME)){{$item->ORG_NAME}}@endif</td>
                            <td class="text-left middle">{{$item->CAMPAIGN_NAME}}</td>
                            <td class="text-left middle">
                                @if(isset($item->STAFF_NAME))<b>Tên:</b> {{$item->CUS_NAME}}<br/>@endif
                                @if(isset($item->EMAIL)){{$item->EMAIL}}<br/>@endif
                                @if(isset($item->PHONE))<b>Phone:</b> {{$item->PHONE}}<br/>@endif
                                @if(isset($item->DOB) && trim($item->DOB) != '')<b>Ngày sinh:</b> {{convertDateDMY($item->DOB)}}<br/>@endif
                                @if(isset($item->BANK_ACCOUNT_NUM))<b>Bank:</b> {{$item->BANK_ACCOUNT_NUM}}<br/>@endif
                                @if(isset($item->ADDRESS))<b>Add:</b> {{$item->ADDRESS}}<br/>@endif
                            </td>
                            <td class="text-left middle">
                                @if(isset($item->STAFF_NAME))<b>Tên:</b> {{$item->STAFF_NAME}}<br/>@endif
                                @if(isset($item->STAFF_CODE))<b>Code:</b> {{$item->STAFF_CODE}}<br/>@endif
                            </td>

                            <td class="text-left middle">
                                @if(isset($item->PACK_NAME) && trim($item->PACK_NAME) != '')<b>Gói</b>: {{$item->PACK_NAME}} <br/>@endif
                                @if(isset($item->PRODUCT_NAME) && trim($item->PRODUCT_NAME) != '')<b>SP</b>: {{$item->PRODUCT_NAME}}@endif
                            </td>
                            <td class="text-center middle">{{$item->GIFT_CODE}}</td>
                            <!--<td class="text-center middle">{{$item->ACTIVATION_CODE}}</td>-->
                            <td class="text-center middle">{{$item->SERY_NO}}</td>
                            <td class="text-right middle"><b class="red">{{numberFormat($item->AMOUNT)}}</b></td>
                            <td class="text-center middle">{{date('d/m/Y H:i', strtotime($item->CREATE_DATE))}}</td>
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
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
</script>
