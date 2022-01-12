<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div id="divDetailItem">
        <div class="card-header">
            @if($objectId > 0)Cập nhật thông tin nhóm @else Thêm thông tin nhóm @endif
            <div class="btn-actions-pane-right">
                @include('Layouts.AdminCms.listButtonActionFormEdit')
            </div>
        </div>

        <div class="div-infor-right">
            <div class="main-card mb-3" id="formShowEditSuccess">
                <div class="card-body paddingTop-unset">
                    <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column" style="padding-top: 0px!important;">

                        {{---Block 1---}}
                        <form id="{{$formName}}">
                            <div class="vertical-timeline-item vertical-timeline-element marginBottom-unset">
                                <span class="vertical-timeline-element-icon bounce-in icon-timeline timeline-active">1</span>
                                <div class="vertical-timeline-element-content bounce-in" >
                                    @include('BackendCms.ProviceDistrict.component._detailFormItem')
                                </div>
                            </div>
                        </form>

                        {{---Block 2---}}
                        <div class="vertical-timeline-item vertical-timeline-element">
                            <div>
                                <span class="vertical-timeline-element-icon bounce-in icon-timeline @if($objectId > 0) timeline-active @endif">2</span>
                                <div class="vertical-timeline-element-content bounce-in">
                                    {{---tạo mới tổ chứ---}}
                                    @if($objectId <= 0)
                                        <div class="card-header"> Thông tin khác</div>
                                        <div class="marginT15">
                                            Bạn cần thêm người dùng trước khi phân quyền
                                        </div>
                                    @else
                                        <div class="card-header">{{viewLanguage('Chi tiết phân quyền')}}</div>
                                        <div class="listTabWithAjax">
                                            <div class="tab-content marginT10" >
                                                {{--Thông tin cá nhân---}}
                                                <div class="tab-pane tabs-animation fade show active" id="tab-content-1" role="tabpanel">
                                                    @include('BackendCms.ProviceDistrict.component._formDetailPermission')
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
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
