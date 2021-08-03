@if(1==1)
    <div class="listTabWithAjax">
        <div class="tab-content">
            @if(!empty($detailInforDetail))
                <div class="form-group form-infor-detail">
                    <div class="row form-group">
                        <div class="col-lg-4">
                            Số HĐ vay: <b class="showInforItem" data-field="">@if(isset($detailInforDetail->LO_NO) && trim($detailInforDetail->LO_NO)!=''){{$detailInforDetail->LO_NO}}@endif</b>
                        </div>
                        <div class="col-lg-4">
                            Thời hạn vay: <b class="showInforItem" data-field="">@if(isset($detailInforDetail->DURATION) && trim($detailInforDetail->DURATION)!=''){{$detailInforDetail->DURATION}}@endif</b>
                        </div>
                        <div class="col-lg-4">
                            Số tiền vay: <b class="showInforItem" data-field="">@if(isset($detailInforDetail->TOTAL_AMOUNT) && trim($detailInforDetail->TOTAL_AMOUNT)!=''){{numberFormat($detailInforDetail->TOTAL_AMOUNT)}}@endif VNĐ</b>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-4">
                            Ngày ký hợp đồng: <b class="showInforItem">@if(isset($detailInforDetail->DATE_SIGN) && trim($detailInforDetail->DATE_SIGN)!=''){{convertDateDMY(trim($detailInforDetail->DATE_SIGN))}}@endif</b>
                        </div>
                        <div class="col-lg-8">
                            Trạng thái: <b class="showInforItem" data-field="">@if(isset($detailInforDetail->STATUS_NAME) && trim($detailInforDetail->STATUS_NAME)!=''){{$detailInforDetail->STATUS_NAME}}@endif</b>
                        </div>
                    </div>
                </div>
            @endif
            @if(!empty($listInforContract))
                <div class="table-responsive marginT15">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        <th width="25%" class="text-left">{{viewLanguage('Mã giải ngân')}}</th>
                        <th width="10%" class="text-left">{{viewLanguage('Lần giải ngân')}}</th>

                        <th width="20%" class="text-left">{{viewLanguage('Ngày')}}</th>
                        <th width="20%" class="text-left">{{viewLanguage('Số tiền giải ngân')}}</th>
                        <th width="15%" class="text-left">{{viewLanguage('Trạng thái')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($listInforContract as $keys_infor => $inforContract)
                        <tr>
                            <td class="text-left middle">{{$inforContract->DISBUR_CODE}}</td>
                            <td class="text-left middle">{{$inforContract->DISBUR_NUM}}</td>

                            <td class="text-left middle">@if(isset($inforContract->DISBUR_DATE) && trim($inforContract->DISBUR_DATE) != ''){{convertDateDMY($inforContract->DISBUR_DATE)}} @endif</td>
                            <td class="text-left middle">@if(isset($inforContract->DISBUR_AMOUNT) && trim($inforContract->DISBUR_AMOUNT) != ''){{numberFormat($inforContract->DISBUR_AMOUNT)}} VNĐ @endif</td>
                            <td class="text-left middle">{{$inforContract->STATUS_NAME}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
@else
    Chưa có nhân viên thuộc phòng ban này
@endif

<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        $("#checkAllAjax").click(function () {
            $(".checkAjax").prop('checked', $(this).prop('checked'));
        });
    });
    //tim kiem
    var config = {
        '.chosen-select'           : {width: "58%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
