<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách nhóm quyền</li>
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
                            <label for="group_user_name"><i>Tên nhóm</i></label>
                            <input type="text" class="form-control input-sm" id="group_user_name" name="group_user_name" placeholder="Nhóm người dùng" @if(isset($dataSearch['group_user_name']) && $dataSearch['group_user_name'] != '')value="{{$dataSearch['group_user_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="group_user_status"><i>Trạng thái</i></label>
                            <select name="group_user_status" id="group_user_status" class="form-control input-sm">
                                @foreach($arrStatus as $k => $v)
                                    <option value="{{$k}}" @if($dataSearch['group_user_status'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.groupUser_create')}}">
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
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> nhóm quyền @endif </div>
                    <br>
                    <table class="table-hover table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="10%" class="text-center">STT</th>
                            <th width="20%" class="">Tên nhóm</th>
                            <th width="50%">Danh sách quyền</th>
                            <th width="10%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $start + $key+1 }}</td>
                                <td>
                                    {{ $item['group_user_name'] }}
                                </td>
                                <td>
                                    @if(!empty($item['permissions']))
                                        @foreach($item['permissions'] as $permission)
                                            <div class="checkbox disabled">
                                                <label title="{{$permission->permission_name}}">
                                                    <input type="checkbox" value="" disabled checked="checked">
                                                    {{$permission->permission_name}}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($is_root || $permission_edit || $permission_view)
                                        <a href="{{URL::route('admin.groupUser_edit',array('id' => $item['group_user_id']))}}" class="btn btn-xs btn-primary" data-content="Sửa nhóm" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-edit bigger-120"></i>
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
<script type="text/javascript">
    $('[data-rel=popover]').popover({container: 'body'});
</script>