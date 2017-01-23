$(document).ready(function() {
    $("#checkAll").click(function () {
        $(".check").prop('checked', $(this).prop('checked'));
    });
});
var Admin = {
    deleteItem: function(id,type) {
    	jConfirm('Bạn muốn xóa Item này không [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
			if(r){
	            $('#img_loading_'+id).show();
	            var url_ajax = '';
	            if(type == 1){ //xoa tin tức
	                url_ajax = 'deleteNews';
	            }else if(type == 2){
	                url_ajax = 'deleteCustomer';
	            }else if(type == 3){
	                url_ajax = 'deleteBanner';
	            }else if(type == 4){
	                url_ajax = 'deleteLibraryImage';
	            }else if(type == 9){
	                url_ajax = 'deletePermission';
	            }else if(type == 10){
	            	url_ajax = 'deleteCategory';
	            }else if(type == 11){
	            	url_ajax = 'deleteInfor';
	            }else if(type == 12){
	            	url_ajax = 'deleteContract';
	            }else if(type == 13){
	            	url_ajax = 'deleteLang';
	            }
	            if(url_ajax != ''){
	                $.ajax({
	                    type: "post",
	                    url: url_ajax,
	                    data: {id : id},
	                    dataType: 'json',
	                    success: function(res) {
	                        $('#img_loading_'+id).hide();
	                        if(res.isIntOk == 1){
	                            jAlert('Bạn đã thực hiện thành công!', 'Thông báo');
	                            window.location.reload();
	                        }else{
	                            jAlert('Không thể thực hiện được thao tác.', 'Thông báo');
	                        }
	                    }
	                });
	            }
	        }
    	});
    },
    removeAllItems: function(type){
        var dataId = [];
        var i = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                i++;
            }
        });
        if(dataId.length == 0) {
            jAlert('Bạn chưa chọn items để thao tác!', 'Thông báo');
            return false;
        }
        var url_ajax = '';
        if(type == 1){ //xoa sản phẩm
            url_ajax = 'deleteMultiProduct';
        }else if(type == 5){
        	 url_ajax = 'deleteMultiCustomerEmail';
        }else if(type == 6){
        	 url_ajax = 'deleteMultiProviderEmail';
        }
        if(url_ajax != ''){
            if(confirm('Bạn có muốn thực hiện thao tác này?')) {
                $('#img_loading_delete_all').show();
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {dataId: dataId},
                    dataType: 'json',
                    success: function (res) {
                        $('#img_loading_delete_all').hide();
                        if (res.isIntOk == 1) {
                            alert('Bạn đã thực hiện thành công');
                            window.location.reload();
                        } else {
                            alert('Không thể thực hiện được thao tác.');
                        }
                    }
                });
            }
        }
    },
    getCategoryWithTypeLanguage:function(){
        var type_language = $('#type_language').val();
        if(parseInt(type_language) > 0){
            var url_ajax = 'getCategoryNewsLanguage';
            jQuery.ajax({
                type: "post",
                url: WEB_ROOT + '/admin/news/getCategoryNewsLanguage',
                data: {type_language : type_language},
                dataType: 'json',
                success: function(res) {
                    if(res.isIntOk === 1){
                        $('#news_category').html(res.html_option);
                    }
                }
            });
        }
    },

    changeTypeInfor:function(){
        var info_type = $('#info_type').val();
        if(parseInt(info_type) > 0){
            if(info_type == 1 || info_type == 2 || info_type == 5 || info_type == 6 || info_type == 7 || info_type == 8){
                $('.block_show').hide();
                $('#block_show_1').show();
            }else{
                $('.block_show').hide();
                $('#block_show_'+info_type).show();
            }
        }
    },
    setStastusBlockItems: function(){
        var dataId = [];
        var i = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                i++;
            }
        });
        if(dataId.length == 0) {
            alert('Bạn chưa chọn items để thao tác.');
            return false;
        }
        var valueInput = $('#product_status_update').val();
        if(parseInt(valueInput) == -1){
            alert('Bạn chưa chọn trạng thái để cập nhật.');
            return false;
        }
        var url_ajax = 'setStastusBlockItems';

        if(url_ajax != '' && parseInt(valueInput) > -1){
            if(confirm('Bạn có muốn thực hiện thao tác này?')) {
                $('#img_loading_delete_all').show();
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {dataId: dataId, valueInput:valueInput},
                    dataType: 'json',
                    success: function (res) {
                        $('#img_loading_delete_all').hide();
                        if (res.isIntOk == 1) {
                            alert('Bạn đã thực hiện thành công');
                            window.location.reload();
                        } else {
                            alert('Không thể thực hiện được thao tác.');
                        }
                    }
                });
            }
        }
    },
    updateStatusItem: function(id,status,type) {
        if(confirm('Bạn có muốn thay đổi trạng thái Item này không?')) {
            $('#img_loading_'+id).show();
            if(type == 1){ //cap nhat danh muc
               var url_ajax = WEB_ROOT + '/admin/category/updateStatusCategory';
            }/*else if(type == 2){//user shop
                var url_ajax = WEB_ROOT + '/admin/userShop/updateStatusUserShop';
            }*/

            $.ajax({
                type: "post",
                url: url_ajax,
                data: {id : id,status : status},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading_'+id).hide();
                    if(res.isIntOk == 1){
                        window.location.reload();
                    }else{
                        alert('Không thể thực hiện được thao tác.');
                    }
                }
            });
        }
    },
    changeOptionPersonnel: function(){
        var personnel_check_creater = $('#personnel_check_creater').val();
        if(parseInt(personnel_check_creater) == 1){
            $('#show_personnel_user_name').show();
        }else{
            $('#show_personnel_user_name').hide();
        }
    },
    updateCategoryCustomer: function(customer_id,category_id){
        $('#img_loading_'+category_id).show();
        var category_price_discount = $('#category_price_discount_id_'+category_id).val();
        var category_price_hide_discount = $('#category_price_hide_discount_id_'+category_id).val();
        $.ajax({
            type: "post",
            url: WEB_ROOT + '/admin/discountCustomers/updateCategory',
            data: {customer_id : customer_id, category_id:category_id, category_price_discount : category_price_discount, category_price_hide_discount : category_price_hide_discount},
            dataType: 'json',
            success: function(res) {
                $('#img_loading_'+category_id).hide();
                if(res.isIntOk == 1){
                    /*alert('Bạn đã thực hiện thành công');
                    window.location.reload();*/
                }else{
                    alert('Không thể thực hiện được thao tác.');
                }
            }
        });
    },
    updateProductCustomer: function(customer_id,product_id){
        $('#img_loading_'+product_id).show();
        var product_price_discount = $('#product_price_discount_id_'+product_id).val();
        $.ajax({
            type: "post",
            url: WEB_ROOT + '/admin/discountCustomers/updateProduct',
            data: {customer_id : customer_id, product_id:product_id, product_price_discount : product_price_discount},
            dataType: 'json',
            success: function(res) {
                $('#img_loading_'+product_id).hide();
                if(res.isIntOk == 1){
                    /*alert('Bạn đã thực hiện thành công');
                    window.location.reload();*/
                }else{
                    alert('Không thể thực hiện được thao tác.');
                }
            }
        });
    },
    getDistrictInforCustomer:function(){
        var customer_province_id = $('#customer_province_id').val();
        if(parseInt(customer_province_id) > 0){
            jQuery.ajax({
                type: "POST",
                url: WEB_ROOT + '/thong-tin-quan-huyen-cua-khach.html',
                data: {customer_province_id : customer_province_id},
                dataType: 'json',
                success: function(res) {
                    if(res.isIntOk === 1){
                        $('#customer_district_id').html(res.html_option);
                    }else{
                        alert(res.msg, 'Thông báo');
                    }
                }
            });
        }
    },

    uploadImagesCategory: function() {
        $('#sys_PopupUploadImg').modal('show');
        $('.ajax-upload-dragdrop').remove();
        var id_hiden = $('#id_hiden').val();
        var settings = {
            url: WEB_ROOT + '/admin/categories/uploadImage',
            method: "POST",
            allowedTypes:"jpg,png,jpeg,gif",
            fileName: "multipleFile",
            formData: {id: id_hiden},
            multiple: false,
            onSuccess:function(files,xhr,data){
                if(xhr.intIsOK === 1){
                    $('#sys_PopupUploadImg').modal('hide');
                    //thanh cong
                    $("#status").html("<font color='green'>Upload is success</font>");
                    setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",5000 );
                    setTimeout( "jQuery('#status').hide();",5000 );
                }
            },
            onError: function(files,status,errMsg){
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#sys_mulitplefileuploader").uploadFile(settings);
    },
    changeIsShop: function(is_customer, customer_id){
        if(is_customer > 0){
            $('#img_loading').show();
            $.ajax({
                type: "post",
                url: WEB_ROOT + '/admin/customer/setIsCustomer',
                data: {customer_id : customer_id, is_customer:is_customer},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading').hide();
                    if(res.isIntOk == 1){
                        alert('Bạn đã thực hiện thành công');
                    }else{
                        alert('Không thể thực hiện được thao tác.');
                    }
                }
            });
        }
    },
    changeStatusShop: function(customer_status, customer_id){
        if(customer_id > 0){
            $('#img_loading').show();
            $.ajax({
                type: "post",
                url: WEB_ROOT + '/admin/customer/updateStatusCustomer',
                data: {customer_id : customer_id, customer_status:customer_status},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading').hide();
                    if(res.isIntOk == 1){
                        alert('Bạn đã thực hiện thành công');
                    }else{
                        alert('Không thể thực hiện được thao tác.');
                    }
                }
            });
        }
    },
    //UPLOAD
    uploadOneImages: function(type) {
		jQuery('#sys_PopupUploadImg').modal('show');
		jQuery('.ajax-upload-dragdrop').remove();
		var id_hiden = document.getElementById('id_hiden').value;

		var settings = {
			url: WEB_ROOT + '/ajax/uploadImage',
			method: "POST",
			allowedTypes:"jpg,png,jpeg,gif",
			fileName: "multipleFile",
			formData: {id: id_hiden,type: type},
			multiple: false,//up 1 anh
			onSubmit:function(){
				jQuery( "#sys_show_button_upload").hide();
				jQuery("#status").html("<font color='green'>Đang upload...</font>");
			},
			onSuccess:function(files,xhr,data){
				dataResult = JSON.parse(xhr);
				if(dataResult.intIsOK === 1){
					//gan lai id item cho id hiden: dung cho them moi, sua item
					jQuery('#id_hiden').val(dataResult.id_item);
					jQuery('#image_primary').val(dataResult.info.name_img);
					jQuery( "#sys_show_button_upload").show();

					var html= "";
					html += "<img src='" + dataResult.info.src + "'/>";
					//html +='<br/><a href="javascript: void(0);" onclick="Common.removeImageItem('+dataResult.id_item.trim()+',\''+dataResult.info.name_img.trim()+'\','+type+');">Xóa ảnh</a>';
					jQuery('#block_img_upload').html(html);

					//thanh cong
					jQuery("#status").html("<font color='green'>Upload is success</font>");
					setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",1000 );
					setTimeout( "jQuery('#status').hide();",1000 );
					setTimeout( "jQuery('#sys_PopupUploadImg').modal('hide');",1000 );
				}
			},
			onError: function(files,status,errMsg){
				jQuery("#status").html("<font color='red'>Upload is Failed</font>");
			}
		}
		jQuery("#sys_mulitplefileuploader").uploadFile(settings);
	},
	insertImageContent: function(type) {
		var id = document.getElementById('id_hiden').value;
		$('#div_image_insert_content').html('');
		$.ajax({
			type: "post",
			url: WEB_ROOT+'/ajax/getImageContentCommon',
			data: {id : id, type : type},
			dataType: 'json',
			success: function(res) {
				$('#img_loading_' + id).hide();
				if(res.isIntOk == 1){
					jQuery('#sys_PopupImgOtherInsertContent').modal('show');
					var rs = res.dataImage;
					var html = '';
					for( k in rs ) {
						var clickInsert = "<a href='javascript:void(0);' class='img_item' onclick='insertImgContent(\"" + rs[k].src_thumb_content + "\",\"" + rs[k].post_title + "\")'>";
						html +='<span class="float_left image_insert_content" style="margin:5px;">';
						html += clickInsert;
						html += "<img src='" + rs[k].src_img_other + "' width='100' height='100'/>";
						html +="</a>";
						html +="</span>";
					}
					$('#div_image_insert_content').append(html);
				}else{
					alert('Không thể thực hiện thao tác.');
				}
			}
		});
	},
	//UPLOAD MULTIPLE IMG
	uploadMultipleImages: function(type) {
		jQuery('#sys_PopupUploadImg').modal('show');
		jQuery('.ajax-upload-dragdrop').remove();
		var id_hiden = document.getElementById('id_hiden').value;

		var settings = {
			url: WEB_ROOT + '/ajax/uploadImage',
			method: "POST",
			allowedTypes:"jpg,png,jpeg,gif",
			fileName: "multipleFile",
			formData: {id: id_hiden,type: type},
			multiple: (id_hiden==0)? false: true,
			onSubmit:function(){
				jQuery( "#sys_show_button_upload").hide();
				jQuery("#status").html("<font color='green'>Đang upload...</font>");
			},
			onSuccess:function(files,xhr,data){
				dataResult = JSON.parse(xhr);
				if(dataResult.intIsOK === 1){
					//gan lai id item cho id hiden: dung cho them moi, sua item
					jQuery('#id_hiden').val(dataResult.id_item);
					jQuery( "#sys_show_button_upload").show();

					//add vao list sản sản phẩm khác
					var checked_img_pro = "<br/><input type='radio' id='checked_image_"+dataResult.info.id_key+"' name='checked_image_' value='"+dataResult.info.id_key+"' onclick='Admin.checkedImage(\""+dataResult.info.name_img+"\",\"" + dataResult.info.id_key + "\")'><label for='checked_image_"+dataResult.info.id_key+"' style='font-weight:normal'>Ảnh đại diện</label><br/>";
					if( type == 2){
						var checked_img_pro = checked_img_pro + "<br/><input type='radio' id='checked_image_hover"+dataResult.info.id_key+"' name='checked_image_hover' value='"+dataResult.info.id_key+"' onclick='Admin.checkedImageHover(\""+dataResult.info.name_img+"\",\"" + dataResult.info.id_key + "\")'><label for='checked_image_hover"+dataResult.info.id_key+"' style='font-weight:normal'>Ảnh hover</label><br/>";
					}
					var delete_img = "<a href='javascript:void(0);' id='sys_delete_img_other_" + dataResult.info.id_key + "' onclick='Admin.removeImage(\""+dataResult.info.id_key+"\",\""+dataResult.id_item+"\",\""+dataResult.info.name_img+"\", "+type+")' >Xóa ảnh</a>";
					var html= "<li id='sys_div_img_other_" + dataResult.info.id_key + "'>";
					html += "<div class='block_img_upload' >";
					html += "<img height='100' width='100' src='" + dataResult.info.src + "'/>";
					html += "<input type='hidden' id='img_other_" + dataResult.info.id_key + "' class='sys_img_other' name='img_other[]' value='" + dataResult.info.name_img + "'/>";
					html += checked_img_pro;
					html += delete_img;
					html +="</div></li>";
					jQuery('#sys_drag_sort').append(html);

					//thanh cong
					jQuery("#status").html("<font color='green'>Upload is success</font>");
					setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",1000 );
					setTimeout( "jQuery('#status').hide();",1000 );
					setTimeout( "jQuery('#sys_PopupUploadImg').modal('hide');",1000 );
				}
			},
			onError: function(files,status,errMsg){
				jQuery("#status").html("<font color='red'>Upload is Failed</font>");
			}
		}
		jQuery("#sys_mulitplefileuploader").uploadFile(settings);
	},
	checkedImage: function(nameImage,key){
		if (confirm('Bạn có muốn chọn ảnh này làm ảnh đại diện?')) {
			jQuery('#image_primary').val(nameImage);
		}
	},
	checkedImageHover: function(nameImage,key){
		jQuery('#image_primary_hover').val(nameImage);
	},
	removeImage: function(key,id,nameImage, type){
		//product
		if(jQuery("#image_primary_hover").length ){
			var img_hover = jQuery("#image_primary_hover").val();
			if(img_hover == nameImage){
				jQuery("#image_primary_hover").val('');
			}
		}
		if(jQuery("#image_primary").length ){
			var image_primary = jQuery("#image_primary").val();
			if(image_primary == nameImage){
				jQuery("#image_primary").val('');
			}
		}
		if (confirm('Bạn có chắc chắn xóa ảnh này?')) {
			jQuery.ajax({
				type: "POST",
				url: WEB_ROOT+'/ajax/removeImageCommon',
				data: {key : key, id : id, nameImage : nameImage, type:type},
				responseType: 'json',
				success: function(data) {
					if(data.intIsOK === 1){
						jQuery('#sys_div_img_other_'+key).remove();
					}else{
						jQuery('#sys_msg_return').html(data.msg);
					}
				}
			});
		}
		jQuery('#sys_PopupImgOtherInsertContent #div_image').html('');
	},
    /**
     * thong tin quan huyen
     * @param district_province_id
     * @param district_id
     */
    getInforDistrictOfProvince: function(district_province_id,district_id) {
        $('#sys_showPopupDistrict').modal('show');
        $('#img_loading_district').show();
        $('#sys_show_infor').html('');
        $.ajax({
            type: "GET",
            url: WEB_ROOT + '/admin/province/getInforDistrictOfProvince',
            data: {district_province_id : district_province_id,district_id : district_id},
            dataType: 'json',
            success: function(res) {
                $('#img_loading_district').hide();
                $('#sys_show_infor').html(res.html);
            }
        });
    },
    submitInforDistrictOfProvince: function() {
    var district_name = document.getElementById('district_name').value;
    var district_status = document.getElementById('district_status').value;
    var district_position = document.getElementById('district_position').value;
    var district_province_id = document.getElementById('district_province_id').value;
    var district_id = document.getElementById('district_id').value;
    $.ajax({
        type: "POST",
        url: WEB_ROOT + '/admin/province/submitInforDistrictOfProvince',
        data: {district_name : district_name,
            district_status : district_status,
            district_position : district_position,
            district_province_id : district_province_id,
            district_id : district_id,
        },
        dataType: 'json',
        success: function(res) {
            if(res.intReturn === 1){
                window.location.reload();
            }else{
                alert(res.msg);
            }
        }
    });
},
}