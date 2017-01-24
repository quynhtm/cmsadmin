<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.province')}}"> Danh sách tỉnh thành</a></li>
            <li class="active">@if($id > 0)Cập nhật tỉnh thành @else Tạo mới tỉnh thành @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content marginTop30">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST','role'=>'form','files' => true))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div style="float: left; width: 50%">
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên tỉnh thành<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Tên tỉnh thành" id="province_name" name="province_name"  class="form-control input-sm" value="@if(isset($data['province_name'])){{$data['province_name']}}@endif">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Vị trí hiển thị</label>
                            <input type="text" placeholder="Vị trí hiển thị" id="province_position" name="province_position"  class="form-control input-sm" value="@if(isset($data['province_position'])){{$data['province_position']}}@endif">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Trạng thái</label>
                            <select name="province_status" id="province_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12 text-left">
                        <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                    </div>
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                </div>
                <div style="float: left; width: 50%">
                    <div id="show_category_sub_campaign" class="body">
                        <div class="form-group">
                            <label for="textDescrip" class="control-label col-lg-12 font2">Danh sách quận huyện trực thuộc</label>
                            <div class="col-lg-13">
                                <a href="javascript:void(0);" class="btn btn-warning" onclick="Admin.getInforDistrictOfProvince({{$id}},0)" title="sửa">Thêm mới</a>
                            </div>
                        </div>
                        @if(isset($listDistrict) && !empty($listDistrict))
                            <table class="table-hover table table-bordered success font_14">
                                <thead>
                                <tr>
                                    <th width="5%">Stt</th>
                                    <th width="70%">Quận / Huyện</th>
                                    <th width="10%" class="text-center">Vị trí</th>
                                    <th width="15%" class="text-center">Trạng thái</th>
                                    <th width="10%" class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($listDistrict as $k=>$district)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{$district->district_name}}</td>
                                        <td class="text-center">{{$district->district_position}}</td>
                                        <td class="text-center">
                                            @if($district->district_status == 1)
                                                <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                            @else
                                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-info btn-xs" onclick="Admin.getInforDistrictOfProvince({{$id}},{{$district->district_id}})" title="sửa"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>

<div class="modal fade" id="sys_showPopupDistrict" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Thông tin quận huyện</h4>
            </div>
            <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading_district">
            <div class="modal-body" id="sys_show_infor">

            </div>
        </div>
    </div>
</div>

