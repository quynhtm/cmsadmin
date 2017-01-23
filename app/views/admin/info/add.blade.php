<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.info')}}"> Danh sách thông tin chung</a></li>
            <li class="active">@if($id > 0)Cập nhật thông tin chung @else Tạo mới thông tin chung @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content marginTop30">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST','role'=>'form','files' => true))}}
                @if(isset($error) && is_array($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @else
                    @if($error != '')
                    <div class="alert alert-danger" role="alert">{{$error}}</div>
                    @endif
                @endif
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Title site</i>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" name="info_title" value="@if(isset($data['info_title'])){{$data['info_title']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Loại thông tin</i>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        @if(isset($id) && $id > 0)
                            <select class="form-control input-sm" name="sye_info_type" id="sye_info_type" @if(isset($id) && $id > 0) disabled @endif>
                                {{$optionInforSite}}
                            </select>
                            <input type="hidden" id="info_type" name="info_type" value="{{$data['info_type']}}"/>
                        @else
                            <select class="form-control input-sm" name="info_type" id="info_type" onchange="Admin.changeTypeInfor()">
                                {{$optionInforSite}}
                            </select>
                        @endif
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Language</i>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <select class="form-control input-sm" name="type_language" >
                            {{$optionLanguage}}
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Trạng thái</i>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <select class="form-control input-sm" name="info_status" >
                            {{$optionStatus}}
                        </select>
                    </div>
                </div>

                <div id="block_show_{{CGlobal::INFOR_FOOTER}}" class="block_show" 
                @if(isset($data['info_type']) && ($data['info_type'] == CGlobal::INFOR_FOOTER 
                || $data['info_type'] == CGlobal::INFOR_CONTACT 
                || $data['info_type'] == CGlobal::INFOR_ADDRESS_HEADER
                || $data['info_type'] == CGlobal::INFOR_MAIL_HEADER
                || $data['info_type'] == CGlobal::INFOR_PHONE_HEADER
                || $data['info_type'] == CGlobal::INFOR_SOLOGAN_HEADER
                )) style="display: block"@else style="display: none" @endif>
                    <div class="clearfix"></div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <i>Nội dung</i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <textarea class="form-control input-sm" name="info_content">@if(isset($data['info_content'])){{stripslashes($data['info_content'])}}@endif</textarea>
                        </div>
                    </div>
                </div>

                <!--
                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Mô tả</i>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <textarea class="form-control input-sm" name="info_intro">@if(isset($data['info_intro'])){{stripslashes($data['info_intro'])}}@endif</textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Thứ tự</i>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" name="info_order_no" value="@if(isset($data['info_order_no'])){{$data['info_order_no']}}@endif">
                    </div>
                </div>
                -->
                <div id="block_show_{{CGlobal::INFOR_SEO}}" class="block_show" @if(isset($data['info_type']) && $data['info_type'] == CGlobal::INFOR_SEO) style="display: block"@else style="display: none" @endif>
                    <div class="clearfix"></div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <i>Meta title</i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="meta_title" value="@if(isset($data['meta_title'])){{$data['meta_title']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <i>Meta keyword</i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <textarea class="form-control input-sm" name="meta_keywords">@if(isset($data['meta_keywords'])){{$data['meta_keywords']}}@endif</textarea>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <i>Meta description</i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <textarea class="form-control input-sm" name="meta_description">@if(isset($data['meta_description'])){{$data['meta_description']}}@endif</textarea>
                        </div>
                    </div>
                </div>

                <div id="block_show_{{CGlobal::INFOR_IMAGE_LOGO}}" class="block_show" @if(isset($data['info_type']) && $data['info_type'] == CGlobal::INFOR_IMAGE_LOGO) style="display: block"@else style="display: none" @endif>
                    <div class="clearfix"></div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <i>Upload ảnh</i>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <a href="javascript:;"class="btn btn-primary" onclick="Admin.uploadOneImages(4);">Upload ảnh </a>
                            <input name="image_primary" type="hidden" id="image_primary" value="@if(isset($data['info_img'])){{$data['info_img']}}@endif">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!--hien thi anh-->
                        <div id="block_img_upload">
                            @if(isset($data['info_img']) && $data['info_img']!= '')
                                <img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_INFORSEO, $id, $data['info_img'], CGlobal::sizeImage_300, '', true, CGlobal::type_thumb_image_banner, false)}}">
                                <div class="clearfix"></div>
                            @endif
                        </div>
                    </div>
                </div>



                <div class="clearfix"></div>
                <div class="form-group col-sm-2 text-left"></div>
                <div class="form-group col-sm-10 text-left">
                    <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                </div>
                <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                {{ Form::close() }}
            </div>
        </div>
    </div>
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
<!--Popup anh khac de chen vao noi dung bai viet-->
<div class="modal fade" id="sys_PopupImgOtherInsertContent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Click ảnh để chèn vào nội dung</h4>
            </div>
            <div class="modal-body">
                <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                    <div class="form_group">
                        <div class="clearfix"></div>
                        <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                            <div id="div_image_insert_content" class="float_left"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- chen anh vào noi dung-->
<script>
    CKEDITOR.replace(
     'info_content',
     {
     toolbar: [
     { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
     { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
     { name: 'colors',      items : [ 'TextColor','BGColor' ] },
     ],
     },
     {height:600}
     );
</script>

<script type="text/javascript">
    function insertImgContent(src, name_news){
        CKEDITOR.instances.news_content.insertHtml('<img src="'+src+'" alt="'+name_news+'"/>');
    }
</script>