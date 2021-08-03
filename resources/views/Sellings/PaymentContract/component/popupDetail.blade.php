<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div id="divDetailItem">
        <div class="card-header">
            @if($objectId > 0)Thông tin giao dịch của đơn @else Thông tin giao dịch của đơn @endif
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
                                    @include('Sellings.PaymentContract.component._detailFormItem')
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
                                            Thông tin các giao dịch
                                        </div>
                                    </div>
                                    <div class="card-header card-header-tab-animation">
                                        <ul class="nav nav-justified">
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link active" data-toggle="tab" href="#{{$tabOtherItem1}}" @if($is_root || $permission_view)onclick="jqueryCommon.ajaxGetData(this);" @endif data-show-id="{{$tabOtherItem1}}" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetDataOfTab" data-input="{{json_encode(['type'=>$tabOtherItem1,'arrKey'=>$arrKeyDetail,'dataItem'=>[0=>$data,1=>$listDonePayment]])}}" data-object-id="1">
                                                    <span>{{viewLanguage('Các giao dịch với khách hàng')}}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" data-toggle="tab" href="#{{$tabOtherItem2}}" @if($is_root || $permission_view)onclick="jqueryCommon.ajaxGetData(this);" @endif data-show-id="{{$tabOtherItem2}}" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetDataOfTab" data-input="{{json_encode(['type'=>$tabOtherItem2,'arrKey'=>$arrKeyDetail,'dataItem'=>[0=>$data,1=>$listDonePayment]])}}" data-object-id="1">
                                                    <span>{{viewLanguage('Các giao dịch đến')}}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content marginT20" >
                                        {{--Các giao dịch chưa map với đơn---}}
                                        <div class="tab-pane tabs-animation fade show active" id="{{$tabOtherItem1}}" role="tabpanel">
                                            @include('Sellings.PaymentContract.component._detailFormItem3')
                                        </div>
                                        {{--Các giao dịch với khách hàng---}}
                                        <div class="tab-pane tabs-animation fade" id="{{$tabOtherItem2}}" role="tabpanel"></div>
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
</script>