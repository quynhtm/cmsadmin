<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Quản lý tin tức</li>
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
                            <label for="news_title">Name News</label>
                            <input type="text" class="form-control input-sm" id="news_title" name="news_title" placeholder="Tiêu đề tin tức" @if(isset($search['news_title']) && $search['news_title'] != '')value="{{$search['news_title']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="category_status">Status</label>
                            <select name="news_status" id="news_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        @if($is_root || $permission_full ==1 || $permission_create == 1)
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.newsEdit')}}">
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
                            <th width="5%" class="text-center">Ảnh</th>
                            <th width="20%">Tiêu đề</th>
                            <th width="8%">Ngôn ngữ</th>
                            <th width="15%">Danh mục</th>
                            <th width="8%">Nổi bật</th>
                            <th width="8%" class="text-center">Trạng thái</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $stt + $key+1 }}</td>
                                <td class="text-center"><img src="{{$item['url_image']}}"></td>
                                <td>
                                    [<b>{{ $item['news_id'] }}</b>]<a href="{{FunctionLib::buildLinkDetailNews($item['news_id'],$item['news_title'])}}" target="_blank">{{stripcslashes($item['news_title'])}}</a>
                                </td>
                                <td class="text-left">@if(isset($arrLanguage[$item['type_language']])){{$arrLanguage[$item['type_language']]}}@else -- @endif</td>
                                <td class="text-left">{{$item['news_category_name']}}</td>
                                <td class="text-center">
                                    @if($item['news_hot'] == 1)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item['news_status'] == 1)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                        <a href="{{URL::route('admin.newsEdit',array('id' => $item['news_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_full ==1 || $permission_delete == 1)
                                       &nbsp;&nbsp;&nbsp;
                                       <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['news_id']}},1)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['news_id']}}"></span>
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