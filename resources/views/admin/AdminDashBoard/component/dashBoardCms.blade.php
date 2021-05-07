<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">New accounts</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <span class="opacity-10 text-success pr-2">
                                    <i class="fa fa-angle-up"></i>
                                </span>
                                {{numberFormat(random_int(10,999))}}
                                <small class="opacity-5 pl-1">%</small>
                            </div>
                            <div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
                                <div class="circle-progress circle-progress-gradient-alt-sm d-inline-block">
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-danger border-danger card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Total Expenses</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
        <span class="opacity-10 text-danger pr-2">
            <i class="fa fa-angle-down"></i>
        </span>
                                {{numberFormat(random_int(10,999))}}
                                <small class="opacity-5 pl-1">%</small>
                            </div>
                            <div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
                                <div class="circle-progress circle-progress-danger-sm d-inline-block">
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-warning border-warning card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Company Value</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <small class="opacity-5 pr-1">$</small>
                                {{numberFormat(random_int(10,999))}}
                            </div>
                            <div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
                                <div class="circle-progress circle-progress-warning-sm d-inline-block">
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">New Employees</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <small class="text-success pr-1">+</small>
                                {{numberFormat(random_int(10,99))}}
                                <small class="opacity-5 pl-1">hires</small>
                            </div>
                            <div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
                                <div class="circle-progress circle-progress-success-sm d-inline-block">
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-4">
        <div class="mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">Total Sales</div>
            </div>
            <div class="p-0 d-block">
                <div class="grid-menu grid-menu-2col">
                    <div class="no-gutters row">
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                <i class="lnr-car text-primary opacity-7 btn-icon-wrapper mb-2"></i> Admin
                            </button>
                        </div>
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                <i class="lnr-bullhorn text-danger opacity-7 btn-icon-wrapper mb-2"></i> Blog
                            </button>
                        </div>
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                <i class="lnr-bug text-success opacity-7 btn-icon-wrapper mb-2"></i> Register
                            </button>
                        </div>
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                <i class="lnr-heart text-warning opacity-7 btn-icon-wrapper mb-2"></i> Directory
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">Daily Sales</div>
            </div>
            <div class="p-0 d-block">
                <div class="grid-menu grid-menu-2col">
                    <div class="no-gutters row">
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                <i class="lnr-apartment text-dark opacity-7 btn-icon-wrapper mb-2"> </i> Overview
                            </button>
                        </div>
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                <i class="lnr-database text-dark opacity-7 btn-icon-wrapper mb-2"> </i> Support
                            </button>
                        </div>
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                <i class="lnr-printer text-dark opacity-7 btn-icon-wrapper mb-2"> </i> Activities
                            </button>
                        </div>
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                <i class="lnr-store text-dark opacity-7 btn-icon-wrapper mb-2"> </i> Marketing
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">Total Expenses</div>
            </div>
            <div class="p-0 d-block">
                <div class="grid-menu grid-menu-2col">
                    <div class="no-gutters row">
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-success">
                                <i class="lnr-lighter text-success opacity-7 btn-icon-wrapper mb-2"> </i>Accounts
                            </button>
                        </div>
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                <i class="lnr-construction text-warning opacity-7 btn-icon-wrapper mb-2"> </i> Contacts
                            </button>
                        </div>
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-info">
                                <i class="lnr-bus text-info opacity-7 btn-icon-wrapper mb-2"> </i> Products
                            </button>
                        </div>
                        <div class="p-2 col-sm-6">
                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-alternate">
                                <i class="lnr-gift text-alternate opacity-7 btn-icon-wrapper mb-2"> </i> Services
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<button class="btn btn-success marginT25" onclick="clickShowLayoutSite()">An tâm tín dụng</button>

<script src="https://beta-sdk.hdinsurance.com.vn/source/4874b3fae14c29fd43d9d7533651cb60/integrate.js"></script>
<script type="text/javascript">
    function clickShowLayoutSite(){
        $('#sys_showLayoutSite').modal('show');
        const config = {
            classId: "hdi-sdk",
            partnerId: "",
            publickey: ""
        }
        const hdisdk = new HDISdk(config)
        hdisdk.init((initresult)=>{
            if(initresult.sucess){
                //do something
            }
        })
        //khi submit xong
        hdisdk.onFormsubmit((data, result)=>{
            // when form is submit
        })
    }
</script>