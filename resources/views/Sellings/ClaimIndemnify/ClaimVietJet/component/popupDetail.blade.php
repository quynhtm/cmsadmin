<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div id="divDetailItem">
        <div class="card-header">
            @if($objectId > 0)Chi tiết hồ sơ bồi thường @else Chi tiết hồ sơ bồi thường @endif
            <div class="btn-actions-pane-right">
                @include('admin.AdminLayouts.listButtonActionFormEdit')
            </div>
        </div>

        <div class="div-infor-right">
            <div class="main-card mb-3">
                <div class="card-body paddingTop-unset">
                    <div class="form-group marginT10 col-lg-12">
                        @if($is_root || $permission_view)
                            <a href="javascript:void(0);" class="mb-2 mr-2 btn-transition btn btn-outline-success detailOtherCommon" onclick="jqueryCommon.getDataByAjax(this);" data-form-name="addFormOther" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxActionOther" data-input="{{json_encode(['type'=>'getChangeStatus','functionAction'=>'','dataClaim'=>$data])}}" data-show="1" data-show-id="" title="{{viewLanguage('Chuyển trạng thái: ')}}{{$data->CONTRACT_NO}}" data-method="post" data-objectId="">
                                <i class="fa fa-refresh"></i> {{viewLanguage('Chuyển trạng thái')}}
                            </a>
                            <a href="javascript:void(0);"  class="mb-2 mr-2 btn-transition btn btn-outline-info detailOtherCommon" onclick="jqueryCommon.getDataByAjax(this);" data-form-name="addFormOther" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxActionOther" data-input="{{json_encode(['type'=>'getHistory','functionAction'=>'','dataClaim'=>$listTimeLine])}}" data-show="1" data-show-id="" title="{{viewLanguage('Lịch sử bồi thường: ')}}{{$data->CONTRACT_NO}}" data-method="post" data-objectId="">
                                <i class="fa fa-search"></i> {{viewLanguage('Lịch sử xử lý hồ sơ')}}
                            </a>
                        @endif
                    </div>
                    <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column" style="padding-top: 0px!important;">
                        {{---Block 1---}}
                        <div class="vertical-timeline-item vertical-timeline-element marginBottom-unset">
                            <span class="vertical-timeline-element-icon bounce-in icon-timeline timeline-active">1</span>
                            <div class="vertical-timeline-element-content bounce-in" id="formShowEditSuccess">
                                @include('Sellings.ClaimIndemnify.ClaimVietJet.component._detailFormItem')
                            </div>
                        </div>

                        {{---Block 2---}}
                        <div class="vertical-timeline-item vertical-timeline-element">
                            <div>
                                <span class="vertical-timeline-element-icon bounce-in icon-timeline @if($objectId > 0) timeline-active @endif">2</span>
                                <div class="vertical-timeline-element-content bounce-in">
                                    <div class="card-header card-header-tab-animation">
                                        <ul class="nav nav-justified">
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link active" data-toggle="tab" href="#{{$tabOtherItem1}}" @if($is_root || $permission_view)onclick="jqueryCommon.ajaxGetData(this);" @endif data-show-id="{{$tabOtherItem1}}" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetDataOfTab" data-input="{{json_encode(['type'=>$tabOtherItem1,'arrKey'=>$arrKeyDetail,'dataItem'=>[0=>$data]])}}" data-object-id="1">
                                                    <span><b>{{viewLanguage('Thông tin chi tiết bồi thường')}}</b></span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" data-toggle="tab" href="#{{$tabOtherItem2}}" @if($is_root || $permission_view)onclick="jqueryCommon.ajaxGetData(this);" @endif data-show-id="{{$tabOtherItem2}}" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetDataOfTab" data-input="{{json_encode(['type'=>$tabOtherItem2,'arrKey'=>$arrKeyDetail,'dataItem'=>[0=>$data]])}}" data-object-id="1">
                                                    <span><b>{{viewLanguage('Tài liệu đính kèm')}}</b></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content marginT20" >
                                        {{--Các giao dịch chưa map với đơn---}}
                                        <div class="tab-pane tabs-animation fade show active" id="{{$tabOtherItem1}}" role="tabpanel">
                                            @include('Sellings.ClaimIndemnify.ClaimVietJet.component._detailFormItem2')
                                        </div>
                                        {{--Các giao dịch với khách hàng---}}
                                        <div class="tab-pane tabs-animation fade" id="{{$tabOtherItem2}}" role="tabpanel">
                                            @include('Sellings.ClaimIndemnify.ClaimVietJet.component._detailFormItem3')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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