@extends('admin.AdminLayouts.login')
@section('content')
    <div class="bg_login_center {{$bg_login}}">

        <div class="form_login" id="form_login">
            {{ Form::open(array('class'=>'form-signin', 'method'=>'POST', 'url'=>URL::route('admin.login',['url'=>$url]))) }}
            <div class="form_login_content">
                <div class="dangnhap">Đăng nhập</div>
                @if(isset($error) && $error != '')
                    <div class="clear"></div>
                    <span class="float-L marginB10 msg_error"> ** {{$error}}</span>
                @endif

                <div class="form_login_input">
                    <div class="label_input">Tên đăng nhập</div>
                    <!--<div class="label_input w_100">
                        <input type="radio" id="USER_NAME" name="type_user" value="USER_NAME" checked>
                        <label for="USER_NAME" class="marginR20">Tên đăng nhập</label>

                        <input type="radio" id="EMAIL" name="type_user" value="EMAIL">
                        <label for="EMAIL" class="marginR20">Email</label>

                        <input type="radio" id="EMP_CODE" name="type_user" value="EMP_CODE">
                        <label for="EMP_CODE">Mã nhân viên</label>
                    </div>-->
                    <input type="text" class="login_input marginB20" name="user_name" placeholder="Tên đăng nhập" @if(isset($username)) value="{{$username}}" @endif>

                    <div class="label_input">Mật khẩu</div>
                    <input type="password" class="login_input" name="user_password" placeholder="Mật khẩu">

                    <button type="submit" name="submit" class="button_login" >
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                        Đăng nhập
                    </button>
                    <div class="label_forgot_pass">
                        <a href="javascript:void(0);" onclick="show_form_login(0);" >Quên mật khẩu?</a>
                    </div>
                    <div class="horizontal_line"></div>
                    <button type="button" name="submit" class="button_creat_user bg-primary" onclick="request_creater_user();">
                        Yêu cầu tạo tài khoản
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>


        {{--Form quên mật khẩu--}}
        <div class="form_login" id="form_forgot_password" style="display: none">
            <div class="form_login_content">
                <div class="dangnhap">Quên mật khẩu</div>
                @if(isset($error) && $error != '')
                    <div class="clear"></div>
                    <span class="float-L marginB10 msg_error"> ** {{$error}}</span>
                @endif
                <div class="form_login_input">
                    <div class="label_input">Tên đăng nhập</div>
                    <input type="text" class="login_input marginB20" name="user_name_forgot" id="user_name_forgot" placeholder="Tên đăng nhập" >
                    <div class="label_input">Email đăng ký</div>
                    <input type="text" class="login_input marginB20" name="email_forgot" id="email_forgot" placeholder="Email đăng ký">
                    <button type="button" name="submit" class="button_forgot" onclick="submit_forgot_password()">
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                        Đổi mật khẩu
                    </button>
                    <div class="label_forgot_pass">
                        <a href="javascript:void(0);" onclick="show_form_login(1);" >Đăng nhập</a>
                    </div>
                    <div class="horizontal_line"></div>
                    <button type="button" name="submit" class="button_creat_user bg-primary" onclick="request_creater_user();">
                        Yêu cầu tạo tài khoản
                    </button>
                </div>
            </div>

        </div>

        <div class="footer_login">
            <div class="label_left">
                {!! \App\Library\AdminFunction\CGlobal::copy_right !!}
            </div>
            <div class="label_right">
                <i class="lnr-envelope" aria-hidden="true"></i>
                Email: <span class="text-hdi">{{\App\Library\AdminFunction\CGlobal::email_cskh}}</span>
            </div>
            <div class="label_right">
                <i class="fa fa-headphones" aria-hidden="true"></i>
                Hotline: <span class="text-hdi">{{\App\Library\AdminFunction\CGlobal::phone_holine}}</span>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function() {
            $('.phpdebugbar').css('display', 'none');
        });
    </script>

    <script>
        function show_form_login(type) {
            if(type == 0){
                $('#form_forgot_password').show();
                $('#form_login').hide();
                $('#user_name_forgot').val('');
                $('#email_forgot').val('');
            }else {
                $('#form_login').show();
                $('#form_forgot_password').hide();
            }
        }
        function request_creater_user(){
            jqueryCommon.showMsg('success','Liên hệ với Admin của HDI');
        }
        function submit_forgot_password() {
            var user_name_forgot = $('#user_name_forgot').val();
            var email_forgot = $('#email_forgot').val();
            var _token = $('input[name="_token"]').val();
            if(user_name_forgot !='' && email_forgot !=''){
                if(Admin.isEmailAddress(email_forgot)){
                    $('#loader').show();
                    $.ajax({
                        type: "POST",
                        url:'<?php echo e(URL::route('admin.forgot_password')); ?>',
                        data: {email_forgot: email_forgot,user_name_forgot: user_name_forgot, _token: _token},
                        dataType: 'json',
                        success: function (res) {
                            $('#loader').hide();
                            if(res.isOk == 1){
                                jqueryCommon.showMsg('success',res.msg);
                                location.reload();
                            }else {
                                jqueryCommon.showMsg('error','','Thông báo lỗi',res.msg);
                            }
                        }
                    });
                }else {
                    jqueryCommon.showMsg('error','','Thông báo lỗi','Bạn nhập sai định dạng mai');
                }
            }else{
                jqueryCommon.showMsg('error','','Thông báo lỗi','Chưa nhập đủ thông tin');
            }
        }
    </script>
@stop
