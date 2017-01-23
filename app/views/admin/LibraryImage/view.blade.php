<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Thư viện ảnh</li>
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
                            <label for="image_title">Tên ảnh</label>
                            <input type="text" class="form-control input-sm" id="image_title" name="image_title" placeholder="Tiêu đề tin tức" @if(isset($search['image_title']) && $search['image_title'] != '')value="{{$search['image_title']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="category_status">Status</label>
                            <select name="image_status" id="image_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        @if($is_root || $permission_full ==1 || $permission_create == 1)
                            <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.libraryImageEdit')}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Add new
                            </a>
                        </span>
                        @endif
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Search</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Total <b>{{$total}}</b> new @endif </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="5%" class="text-center">STT</th>
                            <th width="5%" class="text-center">Image</th>
                            <th width="40%">Title new</th>
                            <th width="8%">Language</th>
                            <th width="8%" class="text-center">Status</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $stt + $key+1 }}</td>
                                <td class="text-center"><img src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $item['image_id'], $item['image_image'], CGlobal::sizeImage_100,  '', true, CGlobal::type_thumb_image_banner, false)}}"></td>
                                <td>
                                    [<b>{{ $item['image_id'] }}</b>]<a href="{{FunctionLib::buildLinkDetailNews($item['image_id'],$item['image_title'])}}" target="_blank">{{ $item['image_title'] }}</a>
                                </td>
                                <td class="text-center">@if(isset($arrLanguage[$item['type_language']])){{$arrLanguage[$item['type_language']]}}@else -- @endif</td>
                                <td class="text-center">
                                    @if($item['image_status'] == 1)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                        <a href="{{URL::route('admin.libraryImageEdit',array('id' => $item['image_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_full ==1 || $permission_delete == 1)
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['image_id']}},4)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['image_id']}}"></span>
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
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>