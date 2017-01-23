<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Manage Video</li>
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
                            <label for="video_name">Name Video</label>
                            <input type="text" class="form-control input-sm" id="video_name" name="video_name" placeholder="Name banner" @if(isset($search['video_name']) && $search['video_name'] != '')value="{{$search['video_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="banner_page">Language</label>
                            <select name="type_language" id="type_language" class="form-control input-sm">
                                {{$optionLanguage}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="category_status">Trạng thái</label>
                            <select name="video_status" id="video_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>

                        <div class="form-group col-lg-9 text-right">
                            @if($is_root || $permission_full ==1 || $permission_create == 1)
                                <a class="btn btn-danger btn-sm" href="{{URL::route('admin.videoEdit')}}">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                    Add Video
                                </a>
                            @endif
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                @if($data && sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Total  <b>{{$total}}</b> item @endif </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="2%" class="text-center">TT</th>
                            <th width="30%">Name Video</th>
                            <th width="40%">Infor Video</th>
                            <th width="10%" class="text-center">Language</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center text-middle">{{ $stt + $key+1 }}</td>
                                <td>
                                    [<b>{{ $item->video_id }}</b>] {{ $item->video_name }}
                                </td>
                                <td>
                                    {{$item->video_content}}
                                </td>

                                <td class="text-center text-middle">
                                    @if(isset($arrLanguage[$item->type_language])){{$arrLanguage[$item->type_language]}}@else ---- @endif
                                </td>

                                <td class="text-center text-middle">
                                    @if($item->video_status  == CGlobal::status_show)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                       &nbsp;&nbsp;&nbsp;<a href="{{URL::route('admin.videoEdit',array('id' => $item->video_id))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_full ==1 || $permission_delete == 1)
                                        &nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item->video_id}},2)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item->video_id}}"></span>
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