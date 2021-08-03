<div class="modal-content" id="{{$formNameOther}}" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_{{$formNameOther}}">
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        {!! $dataItem->REASON !!}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function() {

});

</script>