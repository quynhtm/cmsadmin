<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.libraryImageView')}}"> Danh sách thư viện ảnh</a></li>
            <li class="active">@if($id > 0)Cập nhật thư viện ảnh @else Tạo mới thư viện ảnh @endif</li>
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
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Name ảnh</i>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input type="text" placeholder="Tên bài viết" id="image_title" name="image_title" class="form-control input-sm" value="@if(isset($data['image_title'])){{$data['image_title']}}@endif">
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
                        <select class="form-control input-sm" id="type_language" name="type_language" onchange="Admin.getCategoryWithTypeLanguage()">
                            <?php echo $optionLanguage;?>
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Status</i>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <select name="image_status" id="image_status" class="form-control input-sm">
                            {{$optionStatus}}
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Upload Image news</i>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <a href="javascript:;"class="btn btn-primary" onclick="Admin.uploadMultipleImages(5);">Upload Image</a>
                        <input name="image_primary" type="hidden" id="image_primary" value="@if(isset($data['image_image'])){{$data['image_image']}}@endif">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <!--hien thi anh-->
                    <ul id="sys_drag_sort" class="ul_drag_sort">
                        @if(isset($arrViewImgOther))
                            @foreach ($arrViewImgOther as $key => $imgNew)
                                <li id="sys_div_img_other_{{$key}}" style="margin: 1px!important;">
                                    <div class='block_img_upload'>
                                        <img src="{{$imgNew['src_img_other']}}" height='100' width='100'>
                                        <input type="hidden" id="img_other_{{$key}}" name="img_other[]" value="{{$imgNew['img_other']}}" class="sys_img_other">
                                        <div class='clear'></div>
                                        <input type="radio" id="checked_image_{{$key}}" name="checked_image" value="{{$key}}" @if(isset($imagePrimary) && $imagePrimary == $imgNew['img_other'] ) checked="checked" @endif onclick="Admin.checkedImage('{{$imgNew['img_other']}}','{{$key}}');">
                                        <label for="checked_image_{{$key}}" style='font-weight:normal'>Ảnh đại diện</label>
                                        <div class="clearfix"></div>
                                        <a href="javascript:void(0);" onclick="Admin.removeImage({{$key}},{{$id}},'{{$imgNew['img_other']}}', 5);">Xóa ảnh</a>
                                        <span style="display: none"><b>{{$key}}</b></span>
                                    </div>
                                </li>
                                @if(isset($imageOrigin) && $imageOrigin == $imgNew['img_other'] )
                                    <input type="hidden" id="news_images_key_upload" name="news_images_key_upload" value="{{$key}}">
                                @endif
                            @endforeach
                        @else
                            <input type="hidden" id="news_images_key_upload" name="news_images_key_upload" value="-1">
                        @endif
                    </ul>

                    <input name="list1SortOrder" id ='list1SortOrder' type="hidden" />
                    <script type="text/javascript">
                        $("#sys_drag_sort").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder });
                        function saveOrder() {
                            var data = $("#sys_drag_sort li div span").map(function() { return $(this).children().html(); }).get();
                            $("input[name=list1SortOrder]").val(data.join(","));
                        };
                    </script>
                    <!--ket thuc hien thi anh-->
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Details</i>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="controls"><button type="button" onclick="Admin.insertImageContent(5)" class="btn btn-primary">Chèn ảnh vào nội dung</button></div>
                        <textarea class="form-control input-sm"  name="image_content">@if(isset($data['image_content'])){{$data['image_content']}}@endif</textarea>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group col-sm-2 text-left"></div>
                <div class="form-group col-sm-10 text-left">
                    <a class="btn btn-warning" href="{{URL::route('admin.libraryImageView')}}"><i class="fa fa-reply"></i> Back</a>
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
    CKEDITOR.replace('image_content', {height:800});
    /*CKEDITOR.replace(
     'news_content',
     {
     toolbar: [
     { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
     { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
     { name: 'colors',      items : [ 'TextColor','BGColor' ] },
     ],
     },
     {height:600}
     );*/
</script>

<script type="text/javascript">
    //kéo thả ảnh
    jQuery("#sys_drag_sort").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder });
    function saveOrder() {
        var data = jQuery("#sys_drag_sort li div span").map(function() { return jQuery(this).children().html(); }).get();
        jQuery("input[name=list1SortOrder]").val(data.join(","));
    };
    function insertImgContent(src, name_news){
        CKEDITOR.instances.image_content.insertHtml('<img src="'+src+'" alt="'+name_news+'"/>');
    }
</script>