<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách quyền</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-3">
                            <label for="permission_code"><i>Mã quyền</i></label>
                            <input type="text" class="form-control input-sm" id="permission_code" name="permission_code" placeholder="Mã quyền" @if(isset($dataSearch['permission_code']) && $dataSearch['permission_code'] != '')value="{{$dataSearch['permission_code']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="permission_name"><i>Tên quyền</i></label>
                            <input type="text" class="form-control input-sm" id="permission_name" name="permission_name" placeholder="Tên quyền" @if(isset($dataSearch['permission_name']) && $dataSearch['permission_name'] != '')value="{{$dataSearch['permission_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="permission_status"><i>Trạng thái</i></label>
                            <select name="permission_status" id="permission_status" class="form-control input-sm" tabindex="12">
                                @foreach($arrStatus as $k => $v)
                                    <option value="{{$k}}" @if($dataSearch['permission_status'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.permission_create')}}">
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
                    <div class="span clearfix">
                        @if($total >0) Có tổng số <b>{{$total}}</b> quyền  @endif
                    </div>
                    <br>
                    <table class="table-hover table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="10%" class="text-center">STT</th>
                            <th width="20%" class="">Mã quyền</th>
                            <th width="40%" >Tên quyền</th>
                            <th width="20%" >Danh mục</th>
                            <th width="10%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr @if($item['permission_status'] == -1) class="warning" @endif>
                                <td class="text-center">{{ $start + $key+1 }}</td>
                                <td>
                                    {{ $item['permission_code'] }}
                                </td>
                                <td class="">
                                    {{ $item['permission_name'] }}
                                </td>
                                <td>
                                    {{ $item['permission_group_name'] }}
                                </td>
                                <td class="text-center">
                                    @if($is_root || $permission_full)
                                        <a href="{{URL::route('admin.permission_edit',array('id' => $item['permission_id']))}}" title="Sửa quyền"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif

                                    @if($is_root || $permission_full ==1 )
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['permission_id']}},9)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['permission_id']}}"></span>
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
            </div>
        </div>
    </div><!-- /.page-content -->
</div>