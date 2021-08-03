<div class="tabs-animation">
    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <div class="card-header-title font-size-lg  font-weight-normal w_100 row">
                <div class="col-sm-10 text-left">
                    <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                    @if($search['p_accumulate'] == 1)
                        Số liệu tính đến tháng {{date('m')}} - {{date('Y')}}
                    @else
                        Số liệu tháng {{date('m')}} - {{date('Y')}}
                    @endif
                </div>

                <div class="col-sm-2 marginT10">
                {{ Form::open(array('method' => 'post', 'role'=>'form','id'=>'formSeachDashboard')) }}
                    <input type="hidden" id="p_accumulate" name="p_accumulate" value="{{$search['p_accumulate']}}">
                    <label for="is_success" class="float-right marginL10">Lũy kế</label>
                    <input type="checkbox" class="custom-checkbox float-right" id="is_success" name="is_success" onchange="changerRadio('formSeachDashboard');" @if($search['p_accumulate'] == 1) checked @endif>
                    {{ Form::close() }}
                </div>

            </div>
        </div>
        <div class="no-gutters row">
            <div class="col-sm-6 col-md-3 col-xl-3">
                <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg opacity-10 bg-warning"></div>
                        <i class="ion-social-usd text-white opacity-8"></i>
                    </div>
                    <div class="widget-chart-content paddingT10">
                        <div class="widget-subheading">Doanh thu (vnđ)</div>
                        <div class="widget-numbers">{{numberFormat($tongDoanhThu)}}</div>
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
                    <div class="widget-chart-content paddingT10">
                        <div class="widget-subheading">Đơn đã cấp</div>
                        <div class="widget-numbers"><span>{{numberFormat($tongContract)}}</span></div>
                    </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
            </div>
            <div class="col-sm-6 col-md-3 col-xl-3">
                <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg opacity-9 bg-success"></div>
                        <i class="fa fa-recycle text-white"></i>
                    </div>
                    <div class="widget-chart-content paddingT10">
                        <div class="widget-subheading">Hồ sơ chờ duyệt</div>
                        <div class="widget-numbers"><span>{{numberFormat($tongHoSoChoDuyet)}}</span></div>
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
                    <div class="widget-chart-content paddingT10">
                        <div class="widget-subheading">Tái tục</div>
                        <div class="widget-numbers"><span>{{numberFormat($tongTaiTuc)}}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{---Biểu đồ báo cáo ---}}
@if($totalReport >0)
<div class="row">
    @if(isset($dataTableInfor) && !empty($dataTableInfor))
    <div class="col-sm-12 col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
            <h5 class="card-title">Thống kê theo sản phẩm</h5>
                <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="table-background-header">
                                <th width="3%" class="text-center middle">{{viewLanguage('TT')}}</th>
                                <th width="30%" class="text-center middle">{{viewLanguage('Sản phẩm')}}</th>
                                <th width="25%" class="text-center middle">{{viewLanguage('Đối tác')}}</th>

                                <th width="10%" class="text-center middle">{{viewLanguage('Tổng đơn')}}</th>
                                <th width="8%" class="text-center middle">{{viewLanguage('Chờ duyệt')}}</th>
                                <th width="8%" class="text-center middle">{{viewLanguage('Tái tục')}}</th>
                                <th width="15%" class="text-center middle">{{viewLanguage('Doanh thu')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $stt = 1; $tongDoanhThu = $tongContract = $tongHoSoChoDuyet = $tongTaiTuc = 0;?>
                            @foreach ($dataTableInfor as $key => $inforDash)
                                <tr>
                                    <td class="text-center middle">{{$stt++}}</td>
                                    <td class="text-left middle">
                                        @if($permiss_view_detail== STATUS_INT_MOT)
                                            @if(isset($inforDash['PRODUCT_NAME']))
                                                <a class="black_a" href="{{URL::route('report.indexReportProduct',['p_product_code'=>$inforDash['PRODUCT_CODE']])}}" title="Chi tiết theo sản phẩm" target="_blank">
                                                    {{$inforDash['PRODUCT_NAME']}}
                                                </a>
                                            @endif
                                        @else
                                            @if(isset($inforDash['PRODUCT_NAME'])){{$inforDash['PRODUCT_NAME']}}@endif
                                        @endif
                                    </td>
                                    <td class="text-left middle">
                                        @if($permiss_view_detail== STATUS_INT_MOT)
                                            @if(isset($inforDash['ORG_NAME']))
                                                <a class="black_a" href="{{URL::route('report.indexReportProduct',['p_org_code'=>$inforDash['ORG_CODE']])}}" title="Chi tiết theo đối tác" target="_blank">
                                                    @if(isset($inforDash['ORG_NAME'])){{$inforDash['ORG_NAME']}}@endif
                                                </a>
                                            @endif
                                        @else
                                            @if(isset($inforDash['ORG_NAME'])){{$inforDash['ORG_NAME']}}@endif
                                        @endif
                                    </td>

                                    <td class="text-right middle"><b>@if(isset($inforDash['TOTAL_CONTRACT'])){{numberFormat($inforDash['TOTAL_CONTRACT'])}}@endif</b></td>
                                    <td class="text-right middle"><b>@if(isset($inforDash['TOTAL_WAITS'])){{numberFormat($inforDash['TOTAL_WAITS'])}}@endif</b></td>
                                    <td class="text-right middle"><b>@if(isset($inforDash['TOTAL_REINSURENCE'])){{numberFormat($inforDash['TOTAL_REINSURENCE'])}}@endif</b></td>
                                    <td class="text-right middle"><b>@if(isset($inforDash['TOTAL_REVENUE'])){{numberFormat($inforDash['TOTAL_REVENUE'])}}@endif</b></td>
                                </tr>
                                <?php
                                    $tongContract = $tongContract + $inforDash['TOTAL_CONTRACT'];
                                    $tongHoSoChoDuyet = $tongHoSoChoDuyet + $inforDash['TOTAL_WAITS'];
                                    $tongTaiTuc = $tongTaiTuc + $inforDash['TOTAL_REINSURENCE'];
                                    $tongDoanhThu = $tongDoanhThu + $inforDash['TOTAL_REVENUE'];
                                ?>
                            @endforeach
                                <tr>
                                    <td class="text-right middle" colspan="3">Tổng</td>
                                    <td class="text-right middle"><b class="red">{{numberFormat($tongContract)}}</b></td>
                                    <td class="text-right middle"><b class="red">{{numberFormat($tongHoSoChoDuyet)}}</b></td>
                                    <td class="text-right middle"><b class="red">{{numberFormat($tongTaiTuc)}}</b></td>
                                    <td class="text-right middle"><b class="red">{{numberFormat($tongDoanhThu)}}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(!empty($arrMoney))
    <div class="col-sm-12 @if($totalReport < 7)col-lg-6 @else col-lg-12 @endif">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Thống kê doanh thu</h5>
                <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                    <div>
                        <div id="container_report_line"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(!empty($arrContract))
    <div class="col-sm-12 @if($totalReport < 7)col-lg-6 @else col-lg-12 @endif">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Thống kê hợp đồng</h5>
                <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                    <div>
                        <div id="container_report_col"></div>
                        <input type="hidden" name="data_report_col" id="data_report_col" value="{{json_encode($arrContract)}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endif
<script type="text/javascript">
    function changerRadio(formId){
        var status_defaul = $("#p_accumulate").val();
        if(status_defaul == 1){
            $("#p_accumulate").val(0);
        }else {
            $("#p_accumulate").val(1);
        }
        document.getElementById(formId).submit();
        //location.reload();
    }

    $(function () {
        $('#container_report_line').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: ''
            },
            subtitle: {
                //text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: [
                    @if(!empty($arrDate))
                        @foreach($arrDate as $kd=>$named)
                        '{{$named}}',
                        @endforeach
                    @endif
                    ]
            },
            yAxis: {
                title: {
                    text: 'Số tiền'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'Doanh thu',
                data: [
                        @if(!empty($arrMoney))
                                @foreach($arrMoney as $km=>$namem)
                            {{$namem}},
                        @endforeach
                        @endif
                    ]
            },
                /*{
                name: 'London',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                }*/
            ]
        });

        var contract = JSON.parse($('#data_report_col').val());
        var arrChartCol = [];
        var temp = [];
        contract.forEach(function(element){
            temp = {name:element.name, y:element.total_contract, drilldown:element.name};
            arrChartCol.push(temp);
        });
        console.log(arrChartCol);
        $('#container_report_col').highcharts ({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Số hợp đồng'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        //format: '{point.y:.1f}%'
                    }
                }
            },
            tooltip: {
                headerFormat: '',
                pointFormat: '<span">Ngày {point.name}</span> <br/> Có <b>{point.y}</b> hợp đồng<br/>'
            },
            series: [{
                type: 'column',
                colorByPoint: true,
                data: arrChartCol,
                showInLegend: false
            }]
        });
    });
</script>