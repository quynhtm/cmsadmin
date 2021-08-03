<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div class="card-header">
        @if($objectId > 0)Cập nhật thông tin phòng ban @else Thêm phòng ban @endif
        <div class="btn-actions-pane-right">
            @include('admin.AdminLayouts.listButtonActionFormEdit')
        </div>
    </div>

    <div class="div-infor-right">
        <div class="main-card mb-3">
            <div class="card-body paddingTop-unset">
                <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column" style="padding-top: 0px!important;">

                    {{---Block 1---}}
                    <form id="form_{{$formName}}">
                        <div class="vertical-timeline-item vertical-timeline-element marginBottom-unset">
                            <span class="vertical-timeline-element-icon bounce-in icon-timeline timeline-active">1</span>
                            <div class="vertical-timeline-element-content bounce-in" id="formShowEditSuccess">
                                @include('Systems.OpenId.depart.component._detailFormItem')
                            </div>
                        </div>
                    </form>

                    {{---Block 2---}}
                    <div class="vertical-timeline-item vertical-timeline-element">
                        <div>
                            <span class="vertical-timeline-element-icon bounce-in icon-timeline @if($objectId > 0) timeline-active @endif">2</span>
                            <div class="vertical-timeline-element-content bounce-in">
                                @include('Systems.OpenId.depart.component._listsOtherItem')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

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