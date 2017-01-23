<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách tài khoản</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        {{--<div class="page-header">--}}
        {{--<h1>--}}
        {{--<small>--}}
        {{--Danh sách khách hàng--}}
        {{--</small>--}}
        {{--</h1>--}}
        {{--</div><!-- /.page-header -->--}}

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-3">
                            <label for="user_name"><i>Tên đăng nhập</i></label>
                            <input type="text" class="form-control input-sm" id="user_name" name="user_name" autocomplete="off" placeholder="Tên đăng nhập" @if(isset($dataSearch['user_name']))value="{{$dataSearch['user_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="user_email"><i>Email</i></label>
                            <input type="text" class="form-control input-sm" id="user_email" name="user_email" autocomplete="off" placeholder="Địa chỉ email" @if(isset($dataSearch['user_email']))value="{{$dataSearch['user_email']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="user_phone"><i>Di động</i></label>
                            <input type="text" class="form-control input-sm" id="user_phone" name="user_phone" autocomplete="off" placeholder="Số di động" @if(isset($dataSearch['user_phone']))value="{{$dataSearch['user_phone']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="user_group"><i>Nhóm quyền</i></label>
                            <select name="user_group" id="user_group" class="form-control input-sm" tabindex="12" data-placeholder="Chọn nhóm quyền">
                                <option value="0">--- Chọn nhóm quyền ---</option>
                                @foreach($arrGroupUser as $k => $v)
                                    <option value="{{$k}}" @if($dataSearch['user_group'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.user_edit')}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Thêm mới
                            </a>
                        </span>
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($size >0) Có tổng số <b>{{$size}}</b> tài khoản  @endif </div>
                    <br>
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="5%" class="text-center">STT</th>
                            <th width="30%">Thông tin đăng nhập</th>
                            <th width="30%">Thông nhân viên</th>
                            <th width="10%" class="text-center">Trạng thái</th>
                            <th width="10%" class="text-center">Ngày tạo</th>
                            <th width="15%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr @if($item['user_status'] == -1)class="red bg-danger" @endif>
                                <td class="text-center text-middle">{{ $start+$key+1 }}</td>
                                <td>
                                    Tài khoản :<b class="green"> {{ $item['user_name'] }}</b>
                                    @if($item['user_last_login'] > 0)<br/> Online gần nhất: {{date('d-m-Y H:i',$item['user_last_login'])}} @endif
                                </td>
                                <td>
                                    <div><b>Họ tên : </b>{{ $item['user_full_name'] }}</div>
                                    <div><b>Chức vụ : </b>{{ $item['user_service'] }}</div>
                                    <div><b>Phone : </b>{{ $item['user_phone'] }}</div>
                                    <div><b>Email : </b>{{ $item['user_email'] }}</div>
                                </td>
                                <td class="text-center text-middle">
                                    @if($item->user_status == CGlobal::status_show)
                                        <i class="fa fa-check fa-2x green" title="Hoạt động"></i>
                                    @endif
                                    @if($item->user_status == CGlobal::status_block)
                                        <i class="fa fa-lock fa-2x red" title="Bị khóa"></i>
                                    @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if($item['user_created'])
                                        {{ date("d-m-Y",$item['user_created']) }}
                                    @endif
                                </td>
                                <td class="text-center text-middle" >
                                    @if($is_root || $permission_edit)
                                        <a href="{{URL::route('admin.user_edit',array('id' => $item['user_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_change_pass)
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="{{URL::route('admin.user_change',array('id' => base64_encode($item['user_id'])))}}" title="Đổi mật khẩu"><i class="fa fa-refresh fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_remove)
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0)" class="sys_delete_user" data-content="Xóa tài khoản" data-placement="bottom" data-trigger="hover" data-rel="popover" data-id="{{$item['user_id']}}">
                                            <i class="fa fa-trash fa-2x"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        {{$paging}}
                    </div>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
                            <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
{{HTML::script('assets/admin/js/user.js');}}
<script type="text/javascript">
    $('[data-rel=popover]').popover({container: 'body'});
</script>