{{----Edit và thêm mới----}}
<div class="formDetailItem" >
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$urlPostData}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($dataDetail)}}">

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_MOT}}">
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
                <div class="row form-group">
                    <div class="col-lg-4">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Danh mục')}}</label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="category_id" id="category_id" required>
                            {!! $optionIsActive !!}}
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Loại sản phẩm')}}</label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="product_is_hot" id="product_is_hot" required>
                            {!! $optionIsActive !!}}
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
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Kiểu giá')}}</label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="product_type_price" id="product_type_price" required>
                            {!! $optionIsActive !!}}
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
                    <div class="col-lg-6">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Thông tin khuyến mại')}}</label>
                        <textarea rows="5" cols="8" name="product_selloff" id="{{$formName}}product_selloff" class="form-control input-sm"></textarea>
                    </div>
                    <div class="col-lg-6">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Ghi chú nhập hàng')}}</label>
                        <textarea rows="5" cols="8" name="product_note" id="{{$formName}}product_note" class="form-control input-sm"></textarea>
                    </div>
                </div>
            </div>
            {{-----Ảnh sản phẩm-----}}
            <div class="col-lg-5">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input name="image_primary" type="hidden" id="image_primary" value="@if(isset($dataDetail['product_image'])){{$dataDetail['product_image']}}@endif">
                            <input name="product_image_hover" type="hidden" id="image_primary_hover" value="@if(isset($dataDetail['product_image_hover'])){{$dataDetail['product_image_hover']}}@endif">
                            <a href="javascript:;"class="btn btn-primary" onclick="Admin.uploadMultipleImages(2);">Upload ảnh</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <!--hien thi anh-->
                        <ul id="sys_drag_sort" class="ul_drag_sort">
                            @if(isset($arrViewImgOther))
                                @foreach ($arrViewImgOther as $key => $imgNew)
                                    <li id="sys_div_img_other_{{$key}}" style="margin: 1px!important;">
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
                                            <a href="javascript:void(0);" onclick="Admin.removeImage({{$key}},{{$objectId}},'{{$imgNew['img_other']}}',2);">Xóa ảnh</a>
                                            <span style="display: none"><b>{{$key}}</b></span>
                                        </div>
                                    </li>
                                    @if(isset($imagePrimary) && $imagePrimary == $imgNew['img_other'] )
                                        <input type="hidden" id="products_images_key_upload" name="products_images_key_upload" value="{{$key}}">
                                    @endif
                                @endforeach
                            @else
                                <input type="hidden" id="products_images_key_upload" name="products_images_key_upload" value="-1">
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-----Nội dung sản phẩm-----}}
        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả ngắn')}}</label>
                <textarea rows="4" class="form-control input-sm" name="product_sort_desc" id="{{$formName}}product_sort_desc"></textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-12">
                <label for="NAME" class="text-right control-label">{{viewLanguage('Mô tả chi tiết')}}</label>
                <textarea class="form-control input-sm" rows="10" name="product_content" id="{{$formName}}product_content"></textarea>
            </div>
        </div>

    </div>
</div>
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
