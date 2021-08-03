<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div id="divDetailItem">

    </div>
    {{-- Nội dung form Edit Other by ajax--}}
    <div id="content-other-right"></div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        //chi tiết banks
        $('.detailOtherCommon').dblclick(function () {
            jqueryCommon.ajaxGetData(this);
        });
    });
    function showHistoryClaim(){
        $('#popupHistoryTimeLine').modal('show');
        $( ".modal-dialog" ).removeClass( "modal-lg" );
    }
</script>