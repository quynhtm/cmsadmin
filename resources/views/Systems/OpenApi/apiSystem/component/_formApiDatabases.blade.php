<div class="modal-content" id="{{$formNameOther}}" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_{{$formNameOther}}">
        <input type="hidden" id="objectId" name="objectId" value="{{$obj_id}}">
        <input type="hidden" id="formName" name="formName" value="{{$formNameOther}}">
        <input type="hidden" id="typeTab" name="typeTab" value="{{$typeTab}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataOther)}}">

        <input type="hidden" id="API_CODE" name="API_CODE" @if(isset($data->API_CODE))value="{{$data->API_CODE}}"@endif>
        <input type="hidden" id="form_{{$formNameOther}}_GID" name="GID">
        <input type="hidden" id="{{$formNameOther}}ACTION_FORM" name="ACTION_FORM" value="{{$actionEdit}}">
        <input type="hidden" id="{{$formNameOther}}typeTabAction" name="typeTabAction" value="{{$typeTab}}">
        <input type="hidden" id="{{$formNameOther}}divShowIdAction" name="divShowIdAction" value="{{$divShowId}}">

        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body">
            <div class="form_group">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right">{{viewLanguage('Database')}} <span class="red">(*)</span></label>
                            <select class="form-control input-sm chosen-select" required name="DB_CODE" id="form_{{$formNameOther}}_DB_CODE">
                                {!! $optionDatabase !!}
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right">{{viewLanguage('Trạng thái')}} <span class="red">(*)</span></label>
                            <select class="form-control input-sm" required name="ISACTIVE" id="form_{{$formNameOther}}_ISACTIVE" >
                                {!! $optionStatus !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả')}}</label>
                            <input type="text" class="form-control input-sm" required name="DESCRIPTION" id="form_{{$formNameOther}}_DESCRIPTION">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
            @if($is_root || $permission_edit || $permission_add)
                <button type="button" class="btn btn-primary" onclick="jqueryCommon.doActionPopup('{{$formNameOther}}','{{$urlActionOtherItem}}');"><i class="pe-7s-diskette"></i> {{viewLanguage('Save')}}</button>
            @endif
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        //var date_time = $('.input-date').datepicker({dateFormat: 'dd-mm-yy h:i'});

        showDataIntoForm('form_{{$formNameOther}}');
    });
    //tim kiem
    var config = {
        '.chosen-select'           : {width: "100%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
