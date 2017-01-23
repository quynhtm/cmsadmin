<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.videoView')}}"> Video </a></li>
            <li class="active">@if($id > 0)Cập nhật Video @else Tạo mới Video @endif</li>
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
                        <label for="name" class="control-label">Name Video <span class="red"> (*) </span></label>
                        <input type="text" placeholder="Name Video" id="video_name" name="video_name"  class="form-control input-sm" value="@if(isset($data['video_name'])){{$data['video_name']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name" class="control-label">Link nguồn Video</label>
                        <input type="text" placeholder="Link nguồn Video" id="video_link" name="video_link"  class="form-control input-sm" value="@if(isset($data['video_link'])){{$data['video_link']}}@endif">
                    </div>
                </div>
                <div class="col-sm-12" style="display: none">
                    <div class="form-group">
                        <a href="javascript:;"class="btn btn-primary" onclick="Admin.uploadOneImages(3);">Upload Video </a>
                        <input name="image_primary" type="hidden" id="image_primary" value="@if(isset($data['banner_image'])){{$data['banner_image']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
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
                            <select name="video_status" id="video_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name" class="control-label">Detai video</label>
                        <textarea class="form-control input-sm"  name="video_content">@if(isset($data['video_content'])){{$data['video_content']}}@endif</textarea>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group col-sm-12 text-left">
                    <a class="btn btn-warning" href="{{URL::route('admin.videoView')}}"><i class="fa fa-reply"></i> Back</a>
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
    CKEDITOR.replace('video_content', {height:400});
    $(document).ready(function(){
        var checkin = $('#banner_start_time').datepicker({ });
        var checkout = $('#banner_end_time').datepicker({ });
    });
</script>
