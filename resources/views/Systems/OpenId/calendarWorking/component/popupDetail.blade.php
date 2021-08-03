<div class="modal-content" id="{{$form_id}}" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_{{$form_id}}">
        <input type="hidden" id="oject_id" name="oject_id" value="{{$oject_id}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$url_action}}">
        <input type="hidden" id="form_id" name="form_id" value="{{$form_id}}">
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body">
            <div class="form_group">
                @include('Systems.OpenId.calendarWorking.component._popupBlockOne')
                <div class="clearfix"></div>
                @include('Systems.OpenId.calendarWorking.component._popupBlockTwo')
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
            @if($is_root || $permission_edit || $permission_add)
            <button type="button" class="btn btn-primary" onclick="jqueryCommon.doActionPopup('{{$form_id}}');"><i class="pe-7s-diskette"></i> {{viewLanguage('Save')}}</button>
            @endif
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd-mm-yy'});
        /*$(".input-date").datetimepicker({format: 'd-m-yy h:i'});
        $('.input-date-hour').datetimepicker({
            format: 'LT'
        });*/
    });
    function onchangeTyleCalendar() {
        var type = $('#type_calendar').val();
        if(type == 1){
            $('#calender_2').hide();
            $('#calender_1').show();
        }else{
            $('#calender_1').hide();
            $('#calender_2').show();
        }
    }
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