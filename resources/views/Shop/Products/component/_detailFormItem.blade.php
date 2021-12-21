{{----Edit và thêm mới----}}
<div class="formDetailItem" >
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$urlPostData}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataDetail)}}">

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
        <input type="hidden" id="isFormFile" name="isFormFile" value="{{STATUS_INT_MOT}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        <input type="hidden" id="actionUpdate" name="actionUpdate" value="updateData">
        {{ csrf_field() }}
        <div class="row form-group">
            <div class="col-lg-7">
                <div class="row form-group">
                    <div class="col-lg-12">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Tên sản phẩm')}}</label><span class="red"> (*)</span>
                        <input type="text" class="form-control input-sm" required name="product_name" id="{{$formName}}product_name">
                    </div>
                </div>

                @if($partner_id == 0)
                <div class="row form-group">
                    <div class="col-lg-12">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Đối tác')}}</label>
                        <select  class="form-control input-sm" name="partner_id" id="partner_id">
                            {!! $optionPartner !!}}
                        </select>
                    </div>
                </div>
                @else
                    <input type="hidden" name="partner_id"  @if($objectId > 0) id="{{$formName}}partner_id" @else value="{{$partner_id}}" @endif>
                @endif

                <div class="row form-group">
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Kiểu giá')}}</label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="product_type_price" id="product_type_price" required>
                            {!! $optionProductPrice !!}}
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Giá bán')}}</label><span class="red"> (*)</span>
                        <input type="text" placeholder="Giá bán" id="product_price_market" name="product_price_sell" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" " data-p-sign="s" value="@if(isset($dataDetail['product_price_sell'])){{$dataDetail['product_price_sell']}}@endif">
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Giá nhập')}}</label>
                        <input type="text" placeholder="Giá nhập" id="product_price_input" name="product_price_input" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" " data-p-sign="s" value="@if(isset($dataDetail['product_price_input'])){{$dataDetail['product_price_input']}}@endif">
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Giá thị trường')}}</label>
                        <input type="text" placeholder="Giá thị trường" id="product_price_market" name="product_price_market" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" " data-p-sign="s" value="@if(isset($dataDetail['product_price_market'])){{$dataDetail['product_price_market']}}@endif">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-8">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Danh mục')}}</label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="category_id" id="category_id" required>
                            {!! $optionCategory !!}}
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}}</label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="product_status" id="product_status" required>
                            {!! $optionIsActive !!}}
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Loại sản phẩm')}}</label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="product_is_hot" id="product_is_hot" required>
                            {!! $optionProductType !!}}
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Tình trạng')}}</label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="product_sale" id="product_sale">
                            {!! $optionProductSale !!}}
                        </select>
                    </div>
                    <div class="col-lg-2 paddingRight-unset">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Nhập')}}</label>
                        <input type="number" class="form-control input-sm" name="quality_input" id="{{$formName}}quality_input">
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Xuất')}}</label>
                        <input type="number" class="form-control input-sm" name="quality_out" id="{{$formName}}quality_out">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả ngắn')}}</label>
                        <textarea rows="4" class="form-control input-sm" name="product_sort_desc" id="{{$formName}}product_sort_desc"></textarea>
                    </div>
                </div>
            </div>

            {{-----Ảnh sản phẩm-----}}
            <div class="col-lg-5">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input name="product_image" type="hidden" id="image_primary" value="@if(isset($dataDetail['product_image'])){{$dataDetail['product_image']}}@endif">
                            <input name="product_image_hover" type="hidden" id="image_primary_hover" value="@if(isset($dataDetail['product_image_hover'])){{$dataDetail['product_image_hover']}}@endif">
                            <input name="product_image_other" type="hidden" id="product_image_other" value="@if(isset($dataDetail['product_image_other'])){{$dataDetail['product_image_other']}}@endif">

                            <input type="file" name="file_image_upload[]" id="file_image_upload" multiple="multiple">
                            <input type="hidden" id="id_hiden" name="id_hiden" value="{{$objectId}}"/>
                            @if(isset($arrViewImgOther) && count($arrViewImgOther) > 0)
                                Sản phẩm đang có {{count($arrViewImgOther)}} ảnh
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <!--hien thi anh-->
                        <div @if(isset($arrViewImgOther) && count($arrViewImgOther) > 3) style="overflow: hidden; overflow-y: scroll; width: 100%; height: 230px" @endif>
                            <ul id="sys_drag_sort" class="ul_drag_sort">
                                @if(isset($arrViewImgOther))
                                    @foreach ($arrViewImgOther as $key => $imgNew)
                                        @if(trim($imgNew['img_other']) != '')
                                            <li id="sys_div_img_other_{{$key}}" style="margin-right: 3px!important;">
                                                <div class='block_img_upload'>
                                                    <img src="{{$imgNew['src_img_other']}}" height='100' width='100'>
                                                    <input type="hidden" id="img_other_{{$key}}" name="img_other[]" value="{{$imgNew['img_other']}}" class="sys_img_other">
                                                    <div class='clear'></div>
                                                    <input type="radio" id="chẹcked_image_{{$key}}" name="chẹcked_image" value="{{$key}}" @if(isset($imagePrimary) && $imagePrimary == $imgNew['img_other'] ) checked="checked" @endif onclick="Admin.checkedImage('{{$imgNew['img_other']}}','{{$key}}');">
                                                    <label for="chẹcked_image_{{$key}}" style='font-weight:normal'>Ảnh đại diện</label>

                                                    <div class="clearfix"></div>
                                                    <input type="radio" id="chẹcked_image_hover_{{$key}}" name="chẹcked_image_hover" value="{{$key}}" @if(isset($imageHover) && $imageHover == $imgNew['img_other'] ) checked="checked" @endif onclick="Admin.checkedImageHover('{{$imgNew['img_other']}}','{{$key}}');">
                                                    <label for="chẹcked_image_hover_{{$key}}" style='font-weight:normal'>Ảnh hover</label>

                                                    <div class="clearfix"></div>
                                                    <a href="javascript:void(0);" class="red" onclick="Admin.removeImage({{$key}},{{$objectId}},'{{$imgNew['img_other']}}',2);">Xóa ảnh ({{$key+1}})</a>
                                                    <span style="display: none"><b>{{$key}}</b></span>
                                                </div>
                                            </li>
                                            @if(isset($imagePrimary) && $imagePrimary == $imgNew['img_other'] )
                                                <input type="hidden" id="products_images_key_upload" name="products_images_key_upload" value="{{$key}}">
                                            @endif
                                        @endif
                                    @endforeach
                                @else
                                    <input type="hidden" id="products_images_key_upload" name="products_images_key_upload" value="-1">
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-12 marginT5">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Ghi chú nhập hàng')}}</label>
                        <textarea rows="5" cols="8" name="product_note" id="{{$formName}}product_note" class="form-control input-sm"></textarea>
                    </div>
                    <div class="col-lg-12 marginT5">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Thông tin khuyến mại')}}</label>
                        <textarea rows="5" cols="8" name="product_selloff" id="{{$formName}}product_selloff" class="form-control input-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>
        {{-----Nội dung sản phẩm-----}}
        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả chi tiết')}}</label>
                <textarea class="form-control input-sm" rows="10" name="product_content" id="{{$formName}}product_content"></textarea>
            </div>
        </div>
    </div>
</div>

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

<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        showDataIntoForm('{{$formName}}');
    });
</script>
<script type="text/javascript">
    CKEDITOR.replace(
        'product_sort_desc',
        {
            toolbar: [
                { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                { name: 'colors',      items : [ 'TextColor','BGColor' ] },
            ],
        },
        {height:600}
    );
    CKEDITOR.replace('product_content', {height:600});
</script>
<script type="text/javascript">
    jQuery('.formatMoney').autoNumeric('init');
    function insertImgContent(src, title){
        CKEDITOR.instances.product_content.insertHtml('<img src="'+src+'" alt="'+title+'"/>');
    }
</script>
