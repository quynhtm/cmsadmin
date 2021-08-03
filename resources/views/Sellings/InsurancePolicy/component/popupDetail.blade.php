<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div id="divDetailItem">
        <div class="card-header">
            @if($objectId > 0)Thông tin đơn bảo hiểm @else Thông tin đơn bảo hiểm @endif
            <div class="btn-actions-pane-right">
                @include('admin.AdminLayouts.listButtonActionFormEdit')
            </div>
        </div>

        <div class="div-infor-right">
            <div class="main-card mb-3">
                <div class="card-body paddingTop-unset">
                    <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column" style="padding-top: 0px!important;">

                        {{---Block 1---}}
                            <div class="vertical-timeline-item vertical-timeline-element marginBottom-unset">
                                <span class="vertical-timeline-element-icon bounce-in icon-timeline timeline-active">1</span>
                                <div class="vertical-timeline-element-content bounce-in" id="formShowEditSuccess">
                                    @include('Sellings.InsurancePolicy.component._detailFormItem')
                                </div>
                            </div>

                        {{---Block 2---}}
                        <div class="vertical-timeline-item vertical-timeline-element">
                            <div>
                                <span class="vertical-timeline-element-icon bounce-in icon-timeline @if($objectId > 0) timeline-active @endif">2</span>
                                <div class="vertical-timeline-element-content bounce-in">
                                    {{---Thông tin khác---}}
                                    <div class="card-header card-header-tab-animation paddingLeft-unset">
                                        <div class="text-left card-title-2 paddingLeft-unset">
                                            Thông tin khác
                                        </div>
                                    </div>
                                    <div class="card-header card-header-tab-animation">
                                        <ul class="nav nav-justified">
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link active" data-toggle="tab" href="#{{$tabOtherItem1}}" @if($is_root || $permission_view)onclick="jqueryCommon.ajaxGetData(this);" @endif data-show-id="{{$tabOtherItem1}}" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetDataOfTab" data-input="{{json_encode(['type'=>$tabOtherItem1,'item_id'=>0])}}" data-object-id="1">
                                                    <span>{{viewLanguage('Chi tiết hợp đồng')}}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" data-toggle="tab" href="#{{$tabOtherItem2}}" @if($is_root || $permission_view)onclick="jqueryCommon.ajaxGetData(this);" @endif data-show-id="{{$tabOtherItem2}}" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetDataOfTab" data-input="{{json_encode(['type'=>$tabOtherItem2,'item_id'=>0])}}" data-object-id="1">
                                                    <span>{{viewLanguage('Thông tin hợp đồng vay')}}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content marginT20" >
                                        {{--Chi tiết hợp đồng---}}
                                        <div class="tab-pane tabs-animation fade show active" id="{{$tabOtherItem1}}" role="tabpanel">
                                            @include('Sellings.InsurancePolicy.component._contractList')
                                        </div>
                                        {{--Thông tin hợp đồng vay---}}
                                        <div class="tab-pane tabs-animation fade" id="{{$tabOtherItem2}}" role="tabpanel">
                                            @include('Sellings.InsurancePolicy.component._inforListLoan')
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
    <div id="content-other-right" class="display-none-block">
        <div class="div-other-background">
            <div class="div-background-child">
                <div class="div-other-right">

                    <div id="divDetailItem">
                        <div class="card-header">
                            <span id="title_cap_don"></span>
                            <div class="btn-actions-pane-right">
                                <a href="javascript:void(0);" class="color_hdi" onclick="jqueryCommon.hideContentOtherRightPageLayout()" title="{{viewLanguage('Close')}}">&nbsp;&nbsp;<i class="pe-7s-close fa-3x"></i>&nbsp;&nbsp;</a>
                            </div>
                        </div>
                        <div class="div-infor-right">
                            <div class="card-body" id="body-insurance-policy-other">
                                {{-----Nội dung form cấp đơn hiển thị ở đây----}}
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
</script>