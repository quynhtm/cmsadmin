<div class="modal-content" id="popupHistoryTimeLine" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_popupHistoryTimeLine">
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body" style="padding-left: 10px!important; padding-right: 10px!important;">
            <div class="form-group">
                <div class="table-responsive">
                    @if(isset($dataClaim) && !empty($dataClaim))
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="table-background-header">
                                <th width="3%" class="text-center middle">STT</th>
                                <th width="17%" class="text-center middle">{{viewLanguage('Thời gian xử lý')}}</th>

                                <th width="25%" class="text-center middle">{{viewLanguage('Bước xử lý')}}</th>
                                <th width="25%" class="text-center middle">{{viewLanguage('Người thực hiện')}}</th>
                                <th width="30%" class="text-center middle">{{viewLanguage('Ghi chú')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dataClaim as $key_h => $item_his)
                                <tr>
                                    <td class="text-center middle">{{$key_h+1}}</td>
                                    <td class="text-center middle">@if(isset($item_his['PROCESSING_DATE'])){{$item_his['PROCESSING_DATE']}}@endif</td>
                                    <td class="text-center middle">@if(isset( $arrStatus[$item_his['WORK_ID']])){{$arrStatus[$item_his['WORK_ID']]}}@endif</td>
                                    <td class="text-left middle">@if(isset($item_his['STAFF_NAME'])){{$item_his['STAFF_NAME']}}@endif</td>
                                    <td class="text-left middle">@if(isset($item_his['CONTENT'])){{$item_his['CONTENT']}}@endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        //var date_time = $('.input-date').datepicker({dateFormat: 'dd-mm-yy h:i'});
    });
</script>
