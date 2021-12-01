{{--Quảng cáo--}}
@if(!empty($dataCampaignBlock))
    <div class="clearfix"></div>
    <section class="awe-section-2 ">
        <div class="sec_banner">
            <div class="container">
                <div class="row vc_row-flex" style="margin-top: 10px!important;">
                    <div class="vc_column_container col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="vc_column-inner ">
                            <div class="wpb_wrapper ">
                                <div class="row vc_row-flex">
                                    @foreach($dataCampaignBlock as $k_cam =>$cam_value)
                                        <div class="banner-item banner-right col-md-6 col-sm-6 col-xs-12 @if($k_cam == 1) hidden-sm hidden-xs @endif" id="banner_default-{{$cam_value['campaign_id']}}">
                                            <a href="{{buildLinkProductWithCampaign($cam_value['campaign_id'], $cam_value['campaign_name'])}}" title="{{\App\Library\AdminFunction\CGlobal::site_name}} - {{$cam_value['campaign_name']}}" target="_blank">
                                                <img class="img-responsive" src="{{getLinkImage(FOLDER_CAMPAIGN.'/'.$cam_value['campaign_id'], $cam_value['campaign_image'])}}" alt="{{\App\Library\AdminFunction\CGlobal::site_name}} - {{$cam_value['campaign_name']}}" height="150px">
                                                <div class="hover_collection"></div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif