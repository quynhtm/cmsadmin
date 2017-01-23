<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Manage Banner</li>
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
                            <label for="banner_name">Name banner</label>
                            <input type="text" class="form-control input-sm" id="banner_name" name="banner_name" placeholder="Name banner" @if(isset($search['banner_name']) && $search['banner_name'] != '')value="{{$search['banner_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="banner_page">Language</label>
                            <select name="type_language" id="type_language" class="form-control input-sm">
                                {{$optionLanguage}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="category_status">Trạng thái</label>
                            <select name="banner_status" id="banner_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="banner_type">Vị trí</label>
                            <select name="banner_type" id="banner_type" class="form-control input-sm">
                                {{$optionType}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="banner_category_id">Loại</label>
                            <select name="banner_category_id" id="banner_category_id" class="form-control input-sm">
                                {{$optionCategoryBanner}}
                            </select>
                        </div>
                        <div class="form-group col-lg-9 text-right">
                            @if($is_root || $permission_full ==1 || $permission_create == 1)
                                <a class="btn btn-danger btn-sm" href="{{URL::route('admin.bannerEdit')}}">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                    Add banner
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
                            <th width="10%" class="text-center">Image</th>
                            <th width="20%">Name banner</th>
                            <th width="15%">Infor banner</th>
                            <th width="13%">Type banner</th>
                            <th width="13%" class="text-center">Language</th>
                            <th width="10%" class="text-center">Date time</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center text-middle">{{ $stt + $key+1 }}</td>
                                <td class="text-center text-middle">
                                    <img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_BANNER, $item->banner_id, $item->banner_image, CGlobal::sizeImage_100)}}">
                                </td>
                                <td>
                                   [<b>{{ $item->banner_id }}</b>] {{ $item->banner_name }}
                                </td>
                                <td>
                                    {{$item->banner_intro}}
                                </td>
                                <td>
                                    @if(isset($arrTypeBanner[$item->banner_type])){{$arrTypeBanner[$item->banner_type]}} <br/> @endif
                                    @if($item->banner_order > 0)Thứ tự: {{$item->banner_order}} <br/>@endif
                                    @if($item->banner_category_id == CGlobal::BANNER_CATEGORY_QC)
                                        <b>Banner quảng cáo</b>
                                    @endif
                                    @if($item->banner_category_id == CGlobal::BANNER_CATEGORY_DOITAC)
                                        <b>Banner đối tác</b>
                                    @endif
                                </td>

                                <td class="text-center text-middle">
                                    @if(isset($arrLanguage[$item->type_language])){{$arrLanguage[$item->type_language]}}@else ---- @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if($item->banner_is_run_time == CGlobal::BANNER_IS_RUN_TIME)
                                        <b style="color: green">{{date('d-m-Y',$item->banner_start_time)}}</b>
                                        <br/><b style="color:red;">{{date('d-m-Y',$item->banner_end_time)}}</b>
                                    @else
                                        Không giới hạn
                                    @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                        <a href="{{URL::route('admin.bannerEdit',array('id' => $item->banner_id))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                        &nbsp;&nbsp;&nbsp;<a href="{{URL::route('admin.bannerCopy',array('id' => $item->banner_id))}}" title="Copy item" target="_blank"><i class="fa fa-files-o fa-2x"></i></a>
                                    @endif
                                        <br/>
                                    @if($item->banner_status  == CGlobal::status_show)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_full ==1 || $permission_delete == 1)
                                        &nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item->banner_id}},3)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item->banner_id}}"></span>
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