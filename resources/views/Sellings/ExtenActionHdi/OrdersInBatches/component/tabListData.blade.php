{{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
<div class="ibox">
    <div class="row">
        <div class=" col-lg-2 paddingRight-unset">
            <label for="user_group">Chương trình bảo hiểm</label>
            <select  class="form-control input-sm chosen-select w-100" name="p_search_programme_id" id="p_search_programme_id">
                {!! $optionProgrammes !!}
            </select>
        </div>
        <div class=" col-lg-2 paddingRight-unset">
            <label for="user_email">Sản phẩm</label>
            <select  class="form-control input-sm chosen-select w-100" name="p_search_product_id" id="p_search_product_id">
                {!! $optionProducts !!}
            </select>
        </div>
        <div class=" col-lg-2 paddingRight-unset">
            <label for="user_email">Số Phụ lục hợp đồng</label>
            <input type="text" class="form-control input-sm" id="p_search_contract_no" name="p_search_contract_no" placeholder="Số PLHĐ" @if(isset($search['p_search_contract_no']))value="{{$search['p_search_contract_no']}}"@endif>
        </div>
        <div class=" col-lg-2 paddingRight-unset">
            <label for="user_email">Người được bảo hiểm</label>
            <input type="text" class="form-control input-sm" id="p_search_user_bh" name="p_search_user_bh" placeholder="Họ tên" @if(isset($search['p_search_user_bh']))value="{{$search['p_search_user_bh']}}"@endif>
        </div>
        <div class=" col-lg-3 paddingRight-unset">
            <label for="user_email">Giấy chứng nhận</label>
            <input type="text" class="form-control input-sm" id="p_search_certificate_no" name="p_search_certificate_no" placeholder="GCN1; GCN2; GCN3.." @if(isset($search['p_search_certificate_no']))value="{{$search['p_search_certificate_no']}}"@endif>
        </div>
        <div class=" col-lg-1 marginT30 text-right">
            <button class="w_100 btn btn-primary" title="Tìm kiếm" type="submit" name="submit" value="1"><i class="fa fa-search fa-2x"></i></button>
        </div>
    </div>

    <hr class="marginT15">
</div>

@if($data && sizeof($data) > 0)
    <div class="row marginB10">
        <div class="col-lg-2 text-left paddingRight-unset">
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif</h5>
        </div>
        <div class="col-lg-10 text-right">
            <button class="btn-transition btn btn-outline-primary marginR15" type="button" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="detailItem" data-input="{{json_encode(['item'=>[],'arrKey'=>[]])}}" data-show="2" data-override="1" data-div-show="content-page-right" title="{{viewLanguage('cấp đơn qua file excel')}}" data-method="get" data-url="{{$urlGetFormExcel}}" data-objectId="0">
                <i class="fa fa-share-square"></i> {{viewLanguage('Import DS SĐBS')}}
            </button>
            <button class="btn-transition btn btn-outline-danger marginR15" type="button" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="detailItem" data-input="{{json_encode(['item'=>[],'arrKey'=>[]])}}" data-show="2" data-override="1" data-div-show="content-page-right" title="{{viewLanguage('cấp đơn qua file excel')}}" data-method="get" data-url="{{$urlGetFormExcel}}" data-objectId="0">
                <i class="fa fa-share-square"></i> {{viewLanguage('Import DS hủy đơn')}}
            </button>
            @if($total >0)
                <button class="btn-transition btn btn-outline-success marginL50"  type="submit" name="submit" value="2"><i class="fa fa-file-excel"></i> {{viewLanguage('Xuất Excel thu gọn')}}</button>
                <button class="btn-transition btn btn-outline-info"  type="submit" name="submit" value="3"><i class="fa fa-file-excel"></i> {{viewLanguage('Xuất Excel chi tiết')}}</button>
            @endif
            @if(isset($search['p_search_contract_no']) && $search['p_search_contract_no'] != '' && isset($search['p_search_product_id']) && $search['p_search_product_id'] != '' &&isset($search['p_search_programme_id']) && $search['p_search_programme_id'] != '')
                <button class="btn btn-danger" type="button" name="Xóa đơn test" onclick="ajaxRemoveOrder('{{$urlActionFunction}}');"><i class="fa fa-trash"></i> {{viewLanguage('Xóa đơn test')}}</button>
            @endif
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thin-border-bottom">
            <tr class="table-background-header">
                <!--<th width="3%" class="text-center middle"><input type="checkbox" class="check" id="checkAllOrder"></th>-->
                <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                <th width="13%" class="text-center middle">{{viewLanguage('Tên khách hàng')}}</th>
                <th width="18%" class="text-center middle">{{viewLanguage('Số HĐ/Số GCN/Serial')}}</th>

                <th width="20%" class="text-center middle">{{viewLanguage('Sản phẩm - gói')}}</th>
                <th width="18%" class="text-center middle">{{viewLanguage('Chương trình')}}</th>

                <th width="8%" class="text-right middle">{{viewLanguage('Phí BH')}}</th>
                <th width="6%" class="text-right middle">{{viewLanguage('VAT')}}</th>
                <th width="8%" class="text-right middle">{{viewLanguage('Tổng phí')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td class="text-center middle">
                        {{$stt+$key+1}}<br/>
                        <a @if(isset($item->URL_DOWN)) href="{{$item->URL_DOWN}}" @else href="javascript:void(0);"@endif @if(isset($item->CER_ENV) && $item->CER_ENV == 'LIVE')class="color_hdi" @else class="red" @endif target="_blank" title="Giấy chứng nhận">
                            <i class="pe-7s-note2 fa-2x"></i>
                        </a>
                    </td>
                    <td class="text-left middle">
                        @if(isset($item->NAME)){{$item->NAME}}<br/>@endif
                        @if(isset($item->DOB))<span class="font_10">{{$item->DOB}}</span>@endif
                    </td>
                    <td class="text-left middle">
                         @if(isset($item->CONTRACT_NO))<b class="font_10">PLHĐ</b>: {{$item->CONTRACT_NO}}<br/>@endif
                         @if(isset($item->CERTIFICATE_NO))<b class="font_10">SGN</b>: {{$item->CERTIFICATE_NO}}<br/>@endif
                         @if(isset($item->SERIAL) && $item->SERIAL != '')<b class="font_10">Serial</b>: {{$item->SERIAL}}@endif
                    </td>

                    <td class="text-left middle">@if(isset($item->PRODUCT_NAME)){{$item->PRODUCT_NAME}}@endif @if(isset($item->PACK_NAME)) - {{$item->PACK_NAME}}@endif</td>
                    <td class="text-left middle">
                        @if(isset($item->PROG_NAME)){{$item->PROG_NAME}}<br/>@endif
                        @if(isset($item->INSUR_TIME)){{$item->INSUR_TIME}}@endif</td>

                    <td class="text-right middle"><span class="red">@if(isset($item->AMOUNT)){{numberFormat($item->AMOUNT)}}@endif</span></td>
                    <td class="text-right middle"><span class="red">@if(isset($item->VAT)){{numberFormat($item->VAT)}}@endif</span></td>
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
{{ Form::close() }}

<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        var config = {
            '.chosen-select'           : {width: "100%"},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

    });

    function ajaxRemoveOrder(url){
        var contract_no = $('#p_search_contract_no').val();
        var programme_id = $('#p_search_programme_id').val();
        var product_id = $('#p_search_product_id').val();
        if(contract_no.trim() != '' && programme_id.trim() != '' && product_id.trim() != ''){
            var _token = $('input[name="_token"]').val();
            $('#loader').show();
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: url,
                data: {
                    '_token': _token,
                    'programme_id': programme_id,
                    'product_id': product_id,
                    'contract_no': contract_no,
                    'functionAction': 'ajaxRemoveOrder'
                },
                success: function (res) {
                    $('#loader').hide();
                    if (res.success == 1) {
                        window.location.load();
                    } else {
                        jqueryCommon.showMsgError(res.success, res.message);
                    }
                }
            });
        }else {
            jqueryCommon.showMsgError(0, 'Bạn chưa tìm số PLHĐ để xóa');
        }
    }
</script>




