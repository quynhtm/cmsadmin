@extends('site.SiteLayouts.index')
@section('content')
    <section class="bread-crumb">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home"><a href="{{buildLinkHome()}}"> <span> Trang chủ</span>
                            </a> <span><i class="fa">/</i></span></li>
                        <li><strong>Liên hệ với chúng tôi</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="margin-top-0">
        <div class="container contact-page">
            <div class="row">
                <div id="content" class="col-sm-12 col-xs-12 col-md-12">
                    <div class="row"><h1 class="title-section-page hidden">Liên hệ với chúng tôi</h1>
                        <div class="section_maps col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: none">
                            <div class="box-maps">
                                <div class="iFrameMap">
                                    <div class="google-map">
                                        <div id="contact_map" class="map">
                                            <style> .container_iframe_google_map iframe {
                                                    width: 100% !important;
                                                    height: 300px !important;
                                                } </style>
                                            <div class="container_iframe_google_map">
                                                <iframe src="https://www.google.com/maps/place/Ph%E1%BB%91+L%E1%BB%87+M%E1%BA%ADt,+Vi%E1%BB%87t+H%C6%B0ng,+Long+Bi%C3%AAn,+H%C3%A0+N%E1%BB%99i/@21.0542646,105.8952319,16z/data=!4m5!3m4!1s0x3135a9a2189b546f:0x3c682688fc4a04c2!8m2!3d21.0533486!4d105.9009639" style="border:0"
                                                        allowfullscreen="" width="600" height="450"
                                                        frameborder="0">
                                                </iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="page_cotact"><h2 class="title-head-contact a-left">
                            <span>Địa chỉ của chúng tôi</span></h2></div>
                            <div class="content">
                                <div class="intro"><span><strong>Shopcuatui.com.vn</strong></span></div>
                                <div class="item_contact">
                                    <div class="body_contact">
                                        <span class="contact_info">
                                            <span>
                                                <strong>Địa chỉ: </strong>{{\App\Library\AdminFunction\CGlobal::address_shop}}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="body_contact item_2_contact">
                                        <span class="contact_info">
                                            <strong>Ms Giang:</strong>
                                            <a href="tel:0985101026">0985.1010.26</a>
                                            <div class="clear"></div>
                                            <strong>Ms Bình:</strong>
                                            <a href="tel:0903187988">0903.187.988</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="page-login page_cotact">
                                <h2 class="title-head-contact a-left">
                                    <span>Thông tin liên hệ</span>
                                </h2>
                                @if(trim($msg_succ) != '')
                                    <span style="color: #FF5622">
                                        {!! $msg_succ !!}
                                    </span>
                                @endif
                                <div id="pagelogin">
                                    <form action="{{URL::route('site.contactShop')}}" method="post" enctype="multipart/form-data" class="" id="contact">
                                        {{csrf_field()}}
                                        <div class="form-signup clearfix">
                                            <div class="row group_contact">
                                                <fieldset class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <input type="text" name="contact_user_name_send" id="contact_user_name_send" class="form-control form-control-lg" required="" placeholder="Tên của bạn">
                                                </fieldset>
                                                <fieldset class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <input type="text" name="contact_phone_send" class="form-control form-control-lg" placeholder="Số điện thoại" id="contact_phone_send" required="">
                                                </fieldset>
                                                <fieldset class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <input type="text" name="contact_email_send" class="form-control form-control-lg" placeholder="Địa chỉ Email" id="contact_email_send" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" data-validation="email" required="">
                                                </fieldset>
                                                <fieldset class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <input type="text" name="contact_title" class="form-control form-control-lg" placeholder="Tiêu đề liên hệ" id="contact_title" required="">
                                                </fieldset>
                                                <fieldset class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <textarea name="contact_content" rows="5" id="contact_content" placeholder="Nội dung" class="form-control content-area form-control-lg"  required=""></textarea>
                                                </fieldset>
                                                <fieldset class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"></fieldset>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-10">
                                                    <button type="submit" class="btn btn-primary">Gửi liên hệ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@include('site.SiteShop.chatOnline')