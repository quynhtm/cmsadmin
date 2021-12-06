<div class="tabs-animation">
    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                Thông tin chung tháng {{date('m')}}
            </div>
<!--            <div class="btn-actions-pane-right text-capitalize">
                <button class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">View All</button>
            </div>-->
        </div>
        <div class="no-gutters row">
            <div class="col-sm-6 col-md-3 col-xl-3">
                <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg opacity-10 bg-warning"></div>
                        <i class="ion-social-usd text-white opacity-8"></i>
                    </div>
                    <div class="widget-chart-content">
                        <div class="widget-subheading">Doanh thu (Triệu Vnd)</div>
                        <div class="widget-numbers">{{numberFormat(random_int(1000,9999))}}</div>
                    </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
            </div>
            <div class="col-sm-6 col-md-3 col-xl-3">
                <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg opacity-9 bg-danger"></div>
                        <i class="fa fa-check text-white"></i>
                    </div>
                    <div class="widget-chart-content">
                        <div class="widget-subheading">Đơn đã cấp</div>
                        <div class="widget-numbers"><span>{{numberFormat(random_int(100,999))}}</span></div>
                    </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
            </div>
            <div class="col-sm-6 col-md-3 col-xl-3">
                <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg opacity-9 bg-success"></div>
                        <i class="fa fa-hourglass text-white"></i>
                    </div>
                    <div class="widget-chart-content">
                        <div class="widget-subheading">Hồ sơ chờ duyệt</div>
                        <div class="widget-numbers"><span>{{numberFormat(random_int(100,999))}}</span></div>
                    </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
            </div>
            <div class="col-sm-12 col-md-3 col-xl-3">
                <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg opacity-9 bg-primary"></div>
                        <i class="fa fa-history text-white"></i>
                    </div>
                    <div class="widget-chart-content">
                        <div class="widget-subheading">Tái tục</div>
                        <div class="widget-numbers text-success"><span>{{numberFormat(random_int(10,99))}}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
