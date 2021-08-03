<div class="div-other-background">
    <div class="div-background-child">
        <div class="div-other-right">

            <div id="divDetailItem">
                <div class="card-header">
                    Chi tiết hợp đồng GCN 123
                    <div class="btn-actions-pane-right">
                        <button type="button" class="btn btn-light" onclick="jqueryCommon.hideContentOtherRightPage()"><i class="pe-7s-close"></i> {{viewLanguage('Close')}}</button>
                    </div>
                </div>

                <div class="div-infor-right">
                    <div class="main-card mb-3">
                        <div class="card-body paddingTop-unset">
                            <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column" style="padding-top: 0px!important;">
                                {{---Block 1---}}
                                <div class="vertical-timeline-item vertical-timeline-element marginBottom-unset">
                                    <span class="vertical-timeline-element-icon bounce-in icon-timeline timeline-active">1</span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        @include('Sellings.InsurancePolicy.component._inforFormBlock1')
                                    </div>
                                </div>
                                {{---Block 2---}}
                                <div class="vertical-timeline-item vertical-timeline-element marginBottom-unset">
                                    <span class="vertical-timeline-element-icon bounce-in icon-timeline timeline-active">2</span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        @include('Sellings.InsurancePolicy.component._inforFormBlock2')
                                    </div>
                                </div>
                                {{---Block 3---}}
                                <div class="vertical-timeline-item vertical-timeline-element marginBottom-unset">
                                    <span class="vertical-timeline-element-icon bounce-in icon-timeline timeline-active">3</span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        @include('Sellings.InsurancePolicy.component._inforFormBlock3')
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

<script type="text/javascript">
    $(document).ready(function(){
        $(".a_edit_block").on('click', function () {
            jqueryCommon.clickEditBlock(this);
        });

        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        //showDataIntoForm('form_{{$formName}}');
    });
    function compareDate(){
        var startDate = $('#EFFECTIVE_DATE').val();
        alert(startDate);
        var job_start_date = "10-1-2014"; // Oct 1, 2014
        var job_end_date = "11-1-2014"; // Nov 1, 2014
        job_start_date = job_start_date.split('-');
        job_end_date = job_end_date.split('-');

        var new_start_date = new Date(job_start_date[2],job_start_date[0],job_start_date[1]);
        var new_end_date = new Date(job_end_date[2],job_end_date[0],job_end_date[1]);

        if(new_end_date <= new_start_date) {
            // your code
        }
    }
</script>