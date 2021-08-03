<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div id="divDetailItem">
        <div class="card-header">
            @if($objectId > 0)Cập nhật thông tin Voucher @else Thêm thông tin Voucher @endif
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
                                    @include('Sellings.Vouchers.vouchersGift.component._detailFormItem')
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
                                        <div class="card-header"> Cấp phát lô voucher</div>
                                        <div class="marginT15">
                                            Bạn cần thêm thông tin Voucher trước khi cấp phát theo lô
                                        </div>
                                    @else
                                        <div class="listTabWithAjax">
                                            <div class="card-header"> Cấp phát lô voucher</div>
                                            <div class="tab-content marginT10" >
                                                {{--listVoucherValue---}}
                                                <div class="tab-pane tabs-animation fade show active" id="{{$tabOtherItem1}}" role="tabpanel">
                                                    @include('Sellings.Vouchers.vouchersGift.component._listVoucherValue')
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