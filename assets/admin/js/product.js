/**
 * Created by tuanna on 02/05/2016.
 */
$(document).ready(function(){
    function readURL(input) {
        if (input.files && input.files[0]) {
            console.log(input.files);
            var reader = new FileReader();
            reader.onload = function (e) {
                console.log(e);
                $('.product_avatar_preview').show();
                $('.product_avatar_preview img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readsURL(input) {
        if (input.files && input.files[0]) {
            console.log(input.files);
            var length = input.files.length
            var i = 0
            while (i < length) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var html = '<div style="width: 156px;height: 156px;padding: 2px;margin: 2px;border: 1px solid gainsboro;float: left"><img src="' + e.target.result + '" alt="" width="150" height="150"></div>';
                    /*                $('.product_avatar_preview').show();
                     $('.product_avatar_preview img').attr('src', e.target.result);*/
                    $('.product_image_preview').append(html);
                }
                reader.readAsDataURL(input.files[i]);
                i++;
            }
            if(length > 0){
                $('.product_image_preview').show();
                $('.product_image_remove').show();

            }
        }
    }

    $("#product_avatar").change(function () {
        var fileSize = this.files[0].size;
        var fileType = this.files[0].type;
        if(fileSize>1048576){ //do something if file size more than 1 mb (1048576)
            bootbox.alert('Kích thước file ảnh quá lớn');
            $(".product_avatar_remove").trigger('click');
            return false;
        }else{
            switch(fileType){
                case 'image/png':
                //case 'image/gif':
                case 'image/jpeg':
                case 'image/pjpeg':
                    break;
                default:
                    bootbox.alert('File ảnh không đúng định dạng');
                    $(".product_avatar_remove").trigger('click');
                    return false;
            }
        }
        readURL(this);
    });

    $(".product_avatar_remove").on('click', function () {
        var $el = $('#product_avatar');
        $el.wrap('<form>').closest('form').get(0).reset();
        $el.unwrap();
        $('.product_avatar_preview').hide();
    });

    $("#product_image").change(function () {
        var length = parseInt(this.files.length);
        var i = 0;
        while(i < length){
            var fileSize = this.files[i].size;
            var fileType = this.files[i].type;
            var name = this.files[i].name;
            console.log(fileSize);
            if(fileSize>1048576){ //do something if file size more than 1 mb (1048576)
                bootbox.alert('Kích thước file ảnh "' + name + '" quá lớn');
                $(".product_image_remove").trigger('click');
                return false;
            }else{
                switch(fileType){
                    case 'image/png':
                    //case 'image/gif':
                    case 'image/jpeg':
                    case 'image/pjpeg':
                        break;
                    default:
                        bootbox.alert('File ảnh "' + name + '" không đúng định dạng');
                        $(".product_image_remove").trigger('click');
                        return false;
                }
            }
            i++;
        }
        $('.product_image_preview').html('');
        readsURL(this);
    });

    $(".product_image_remove").on('click', function () {
        var $el = $('#product_image');
        $el.wrap('<form>').closest('form').get(0).reset();
        $el.unwrap();
        $('.product_image_preview').hide();
        $('.product_image_remove').hide();
    });
});