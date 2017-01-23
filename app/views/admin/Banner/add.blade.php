<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.bannerView')}}"> Banner </a></li>
            <li class="active">@if($id > 0)Cập nhật banner @else Tạo mới banner @endif</li>
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
                <div style="float: left;width: 60%">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name" class="control-label">Name banner <span class="red"> (*) </span></label>
                        <input type="text" placeholder="Name banner" id="banner_name" name="banner_name"  class="form-control input-sm" value="@if(isset($data['banner_name'])){{$data['banner_name']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name" class="control-label">Infor banner</label>
                        <input type="text" placeholder="Name banner" id="banner_intro" name="banner_intro"  class="form-control input-sm" value="@if(isset($data['banner_intro'])){{$data['banner_intro']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name" class="control-label">Link URL <span class="red"> (*) </span></label>
                        <input type="text" placeholder="url banner" id="banner_link" name="banner_link"  class="form-control input-sm" value="@if(isset($data['banner_link'])){{$data['banner_link']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name" class="control-label">Type banner</label>
                        <div class="form-group">
                            <select name="banner_category_id" id="banner_category_id" class="form-control input-sm">
                                {{$optionCategoryBanner}}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Position banner</label>
                        <div class="form-group">
                            <select name="banner_type" id="banner_type" class="form-control input-sm">
                                {{$optionTypeBanner}}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Language</label>
                        <div class="form-group">
                            <select name="type_language" id="type_language" class="form-control input-sm">
                                {{$optionLanguage}}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Status</label>
                        <div class="form-group">
                            <select name="banner_status" id="banner_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Taget bank</label>
                            <div class="form-group">
                                <select name="banner_is_target" id="banner_is_target" class="form-control input-sm">
                                    {{$optionTarget}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Nofollow</label>
                            <div class="form-group">
                                <select name="banner_is_rel" id="banner_is_rel" class="form-control input-sm">
                                    {{$optionRel}}
                                </select>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Order</label>
                        <input type="text" placeholder="Thứ tự hiển thị" id="banner_order" name="banner_order"  class="form-control input-sm" value="@if(isset($data['banner_order'])){{$data['banner_order']}}@endif">
                    </div>
                </div>


                <div class="clearfix"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Type run time</label>
                        <div class="form-group">
                            <select name="banner_is_run_time" id="banner_is_run_time" class="form-control input-sm">
                                {{$optionRunTime}}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Start time banner</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="banner_start_time" name="banner_start_time"  data-date-format="dd-mm-yyyy" value="@if(isset($data['banner_start_time']) && $data['banner_start_time'] > 0){{date('d-m-Y',$data['banner_start_time'])}}@endif">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">End time banner</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="banner_end_time" name="banner_end_time"  data-date-format="dd-mm-yyyy" value="@if(isset($data['banner_end_time']) && $data['banner_end_time'] > 0){{date('d-m-Y',$data['banner_end_time'])}}@endif">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                </div>

                <div style="float: left;width: 40%">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <a href="javascript:;"class="btn btn-primary" onclick="Admin.uploadOneImages(3);">Upload Image </a>
                            <input name="image_primary" type="hidden" id="image_primary" value="@if(isset($data['banner_image'])){{$data['banner_image']}}@endif">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <!--hien thi anh-->
                        <div id="block_img_upload">
                            @if(isset($data['banner_image']) && $data['banner_image']!= '')
                                <img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_BANNER, $data['banner_id'], $data['banner_image'], CGlobal::sizeImage_300, '', true, CGlobal::type_thumb_image_banner, false)}}">
                                <div class="clearfix"></div>
                                <a href="javascript: void(0);"  style="display: none" onclick="Common.removeImageItem({{$data['banner_id']}},'{{$data['banner_image']}}',3);">Xóa ảnh</a>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="clearfix"></div>
                <div class="form-group col-sm-12 text-left">
                    <a class="btn btn-warning" href="{{URL::route('admin.bannerView')}}"><i class="fa fa-reply"></i> Back</a>
                    <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                </div>
                <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                {{ Form::close() }}
                <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>


<!--Popup upload ảnh-->
<div class="modal fade" id="sys_PopupUploadImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Upload ảnh</h4>
            </div>
            <div class="modal-body">
                <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                <div class="form_group">
                    <div id="sys_mulitplefileuploader" class="btn btn-primary">Upload ảnh</div>
                    <div id="status"></div>

                    <div class="clearfix"></div>
                    <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                        <div id="div_image"></div>
                    </div>
                </div>
               </form>
            </div>
        </div>
    </div>
</div>
<!--Popup upload ảnh-->

<script>
    $(document).ready(function(){
        var checkin = $('#banner_start_time').datepicker({ });
        var checkout = $('#banner_end_time').datepicker({ });
    });
</script>
