<div class="modal-content" id="popupHistoryTimeLine" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_popupHistoryTimeLine">
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body" style="padding-top: -20px!important;">
            <div class="form-group">
                <div class="row">
                    <div class="card-body" style="margin-top: -10px!important;">
                        <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column marginL20">
                            @foreach ($listTimeLine as $date_timeLine => $item_timeLine)
                                <div class="vertical-timeline-item vertical-timeline-element">
                                    <div>
                                        <div class="vertical-timeline-element-content bounce-in">
                                        <span class="vertical-timeline-element-date" style="left: -110px">
                                            <h5 class="card-title">{{$date_timeLine}}</h5>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                @foreach ($item_timeLine as $key_tl => $valu_timeLine)
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <b>{{$valu_timeLine->WORK_NAME}}</b>
                                                <p>{{$valu_timeLine->CONTENT}}@if($valu_timeLine->STAFF_NAME != ''), bởi: <b class="text-danger">{{$valu_timeLine->STAFF_NAME}}</b>@endif</p>
                                                <span class="vertical-timeline-element-date">{{$valu_timeLine->HOURS}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        //var date_time = $('.input-date').datepicker({dateFormat: 'dd-mm-yy h:i'});
    });
</script>
