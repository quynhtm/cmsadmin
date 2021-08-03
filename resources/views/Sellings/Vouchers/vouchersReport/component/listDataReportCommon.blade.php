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
            <div class=" col-lg-2">
                <label for="user_email">Ngày bắt đầu</label>
                <input type="text" class="form-control input-sm input-date" id="p_from_date" name="p_from_date" autocomplete="off" @if(isset($search['p_from_date']))value="{{$search['p_from_date']}}" @else value="{{date('d/m/Y',strtotime(\Illuminate\Support\Carbon::now()->startOfMonth()))}}"@endif>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class=" col-lg-2">
                <label for="user_phone">đến</label>
                <input type="text" class="form-control input-sm input-date" id="p_to_date" name="p_to_date" autocomplete="off" @if(isset($search['p_to_date']))value="{{$search['p_to_date']}}"@else value="{{date('d/m/Y',strtotime(\Illuminate\Support\Carbon::now()))}}"@endif>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class=" col-lg-3">
                <label for="user_group">Chiến dịch</label>
                <select  class="form-control input-sm" name="CAMPAIGN_CODE" id="CAMPAIGN_CODE">
                    {!! $optionCampaigns !!}
                </select>
            </div>
            <div class=" col-lg-3">
                <label for="user_group">Đối tác</label>
                <select  class="form-control input-sm" name="ORG_CODE" id="ORG_CODE">
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
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        {{--<th width="3%" class="text-center"><input type="checkbox" class="check" id="checkAll"></th>--}}
                        <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                        <th width="15%" class="text-center middle">{{viewLanguage('Đối tác')}}</th>
                        <th width="15%" class="text-center middle">{{viewLanguage('Chiến dịch')}}</th>

                        <th width="10%" class="text-center middle">{{viewLanguage('Sản phẩm')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Gói')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Mã')}}</th>

                        <th width="10%" class="text-center middle">{{viewLanguage('Tổng kích hoạt')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Tổng cấp phát')}}</th>
                        <th width="10%" class="text-right middle">{{viewLanguage('Doanh thu')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr data-form-name="detailItem" data-input="{{json_encode([])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}" data-method="get" data-url="" data-objectId="1">
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-left middle">@if(isset($item->ORG_NAME)){{$item->ORG_NAME}}@endif</td>
                            <td class="text-left middle">@if(isset($item->CAMPAIGN_NAME)){{$item->CAMPAIGN_NAME}}@endif</td>

                            <td class="text-left middle">@if(isset($item->PRODUCT_NAME)){{$item->PRODUCT_NAME}}@endif</td>
                            <td class="text-left middle">@if(isset($item->PACK_NAME)){{$item->PACK_NAME}}@endif</td>
                            <td class="text-left middle">@if(isset($item->REF_CODE)){{$item->REF_CODE}}@endif</td>

                            <td class="text-center middle">@if(isset($item->NUM_OF_ACTIVE)){{numberFormat($item->NUM_OF_ACTIVE)}}@endif</td>
                            <td class="text-center middle">@if(isset($item->AMOUNT_ALLOCATE)){{numberFormat($item->AMOUNT_ALLOCATE)}}@endif</td>
                            <td class="text-right middle"><b class="red">@if(isset($item->REF_CODE)){{numberFormat($item->REVENUE)}}@endif</b></td>
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
