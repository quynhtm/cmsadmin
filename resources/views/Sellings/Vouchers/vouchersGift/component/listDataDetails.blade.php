{{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Search')}}</h5>
        <div class="ibox-tools">

        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-3">
                <label for="user_name">Tìm kiếm chung</label>
                <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
            </div>
            <div class=" col-lg-3">
                <label for="user_name">Block code</label>
                <input type="text" class="form-control input-sm" id="p_block_code" name="p_block_code" autocomplete="off" @if(isset($search['p_block_code']))value="{{$search['p_block_code']}}"@endif>
            </div>
            <div class=" col-lg-3">
                <label for="user_name">Sort order</label>
                <input type="text" class="form-control input-sm" id="p_sort_order" name="p_sort_order" autocomplete="off" @if(isset($search['p_sort_order']))value="{{$search['p_sort_order']}}"@endif>
            </div>
            <div class=" col-lg-3">
                <label for="user_group">Trạng thái</label>
                <select  class="form-control input-sm" name="p_status" id="p_status">
                    {!! $optionStatusDetail !!}
                </select>
            </div>
            <div class=" col-lg-4">
                <label for="user_group">Chiến dịch</label>
                <select  class="form-control input-sm" name="CAMPAIGN_CODE" id="CAMPAIGN_CODE">
                    {!! $optionCampaigns !!}
                </select>
            </div>
            <div class=" col-lg-4">
                <label for="user_group">Đối tác</label>
                <select  class="form-control input-sm" name="ORG_CODE" id="ORG_CODE">
                    {!! $optionOrg !!}}
                </select>
            </div>
            <div class=" col-lg-3 marginT25">
                <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
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
                        <th width="20%" class="text-left middle">{{viewLanguage('Chiến dịch')}}</th>
                        <th width="20%" class="text-left middle">{{viewLanguage('Đối tác')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Mã gói')}}</th>

                        <th width="10%" class="text-center middle">{{viewLanguage('Block code')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Sort order')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Sery no')}}</th>
                        <th width="10%" class="text-center middle">{{viewLanguage('Sử dụng')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr data-form-name="detailItem" data-input="{{json_encode([])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}" data-method="get" data-url="" data-objectId="1">
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-left middle">
                                @if(isset($item->CAMPAIGN_CODE)){{$item->CAMPAIGN_CODE}}@endif
                            </td>
                            <td class="text-left middle">
                                @if(isset($item->ORG_CODE)){{$item->ORG_CODE}}@endif
                            </td>
                            <td class="text-center middle">
                                @if(isset($item->GIFT_CODE)){{$item->GIFT_CODE}}@endif
                            </td>
                            <td class="text-center middle">
                                @if(isset($item->BLOCK_CODE)){{$item->BLOCK_CODE}}@endif
                            </td>
                            <td class="text-center middle">
                                @if(isset($item->SORT_ORDER)){{$item->SORT_ORDER}}@endif
                            </td>
                            <td class="text-center middle">
                                @if(isset($item->SERY_NO)){{$item->SERY_NO}}@endif
                            </td>
                            <td class="text-center middle">
                                @if(isset($item->USE_NO)){{$item->USE_NO}}@endif
                            </td>
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
