jQuery(document).ready(function($) {
    //hover view anh
    jQuery(".imge_hover").mouseover(function() {
        var id = jQuery(this).attr('id');
        jQuery("#div_hover_" + id).show();
    });
    jQuery(".imge_hover").mouseout(function() {
        var id = jQuery(this).attr('id');
        jQuery("#div_hover_" + id).hide();
    });
});

var Common = {
    removeImageItem: function(id, nameImage, type){
        //type = 3: xóa ảnh banner
        if (confirm('Bạn có chắc xóa ảnh này?')) {
            jQuery.ajax({
                type: "POST",
                url: WEB_ROOT + '/ajax/removeImageCommon',
                data: {item_id : id, nameImage : nameImage, type: type},
                dataType: 'json',
                success: function(data) {
                    if(data.intIsOK == 1){
                        jQuery("#block_img_upload").html('');//hien thi ảnh ẩn đi
                        jQuery("#image_primary").val('');
                        alert('Bạn đã thực hiện thành công');
                    }else{
                        alert('Không thể thực hiện được thao tác.');
                    }
                }
            });
        }
    },
};//class

