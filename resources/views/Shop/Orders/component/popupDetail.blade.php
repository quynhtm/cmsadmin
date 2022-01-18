<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div id="divDetailItem">
        <div class="card-header">
            Chi tiết đơn hàng @if($objectId > 0) - {{$objectId}} @endif
            <div class="btn-actions-pane-right">
                <button type="button"  class="btn color_hdi" onclick="jqueryCommon.hideContentRightPage()" title="{{viewLanguage('Close')}}">&nbsp;&nbsp;<i class="pe-7s-close fa-3x"></i>&nbsp;&nbsp;</button>
            </div>
        </div>

        <div class="div-infor-right">
            <div class="main-card mb-3" id="formShowEditSuccess">
                <div class="card-body paddingTop-unset">
                    {{---Block 1---}}
                    <form id="{{$formName}}" method="POST">
                        @include('Shop.Orders.component._detailFormItem')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        //chi tiết banks
        $('.detailOtherCommon').dblclick(function () {
            jqueryCommon.ajaxGetData(this);
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
