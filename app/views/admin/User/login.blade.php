<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1 class="text-italic">
                            <span class="red">CMS</span>
                            <span class="white" id="id-text2">Control Panel</span>
                        </h1>
                        <h4 class="blue" id="id-company-text">&copy;{{CGlobal::web_name}}</h4>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger line-title-form ">
                                        <i class="ace-icon fa fa-coffee green"></i>
                                        Vui lòng nhập thông tin
                                    </h4>

                                    <div class="space-6"></div>
                                    @if(isset($error))
                                        <div class="alert alert-danger">{{$error}}</div>
                                    @endif
                                    {{ Form::open(array('class'=>'form-signin')) }}
                                        <fieldset>
                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" name="user_name" placeholder="Tên đăng nhập"  @if(isset($username)) value="{{$username}}" @endif/>
															<i class="ace-icon fa fa-user"></i>
														</span>
                                            </label>

                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" name="user_password" placeholder="Mật khẩu" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
                                            </label>

                                            <div class="clearfix">
                                                {{--<label class="inline">--}}
                                                    {{--<input type="checkbox" class="ace" />--}}
                                                    {{--<span class="lbl"> Remember Me</span>--}}
                                                {{--</label>--}}

                                                <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                    <i class="ace-icon fa fa-key"></i>
                                                    <span class="bigger-110">Login</span>
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                    {{ Form::close() }}
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.login-box -->
                    </div><!-- /.position-relative -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->
