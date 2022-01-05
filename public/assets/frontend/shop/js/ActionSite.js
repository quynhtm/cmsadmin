var ActionSite = {
    detailAddtoCart: function (str_pro_id) {
        var input_quantity = $('#input_quantity').val();
        if(parseInt(input_quantity) > 0 && str_pro_id.trim() != ''){
            ActionSite.addOneProductToCart(str_pro_id,input_quantity);
        }else {
            alert('Bạn chưa chọn được sản phẩm vào giỏ hàng');
        }
    },
    addOneProductToCart: function (str_pro_id, number) {
        var _token = $('input[name="_token"]').val();
        var number_add = (parseInt(number) > 1) ? number : 1;
        jQuery.ajax({
            type: "POST",
            url: WEB_ROOT + '/ajaxAddCart',
            data: {pro_id: str_pro_id, number: number_add, _token: _token},
            success: function (data) {
                if (data.intIsOK === 1) {
                    $('#totalItemCart').html('');
                    $('#totalItemCart').html(parseInt(data.totalCart)+' sản phẩm');
                    $('#totalItemCartHidden').html('');
                    $('#totalItemCartHidden').html(parseInt(data.totalCart));
                    alert(data.msg);
                } else {
                    alert(data.msg);
                }
            }
        });
    },
    removeOneItemCart: function (str_pro_id) {
        var _token = $('input[name="_token"]').val();
        jQuery.ajax({
            type: "POST",
            url: WEB_ROOT + '/deleteOneProductInCart',
            data: {pro_id: str_pro_id, _token: _token},
            success: function (data) {
                if (data.intIsOK === 1) {
                    alert(data.msg);
                    window.location.reload();
                } else {
                    alert(data.msg);
                }
            }
        });
    },
    submitOrderCart: function () {
        var _token = $('input[name="_token_cart_order"]').val();
        var payment_methods = $("#formOrderCart input[type='radio']:checked").val();
        jQuery.ajax({
            type: "POST",
            url: WEB_ROOT + '/sendOrderToCart',
            data: {payment_methods: payment_methods, _token: _token},
            success: function (data) {
                if (data.intIsOK === 1) {
                    //$('#modal-order-success').modal('show');
                    alert('Đặt hàng thành công');
                    location.reload();
                } else {
                    alert(data.msg);
                }
            }
        });
    },
    submitSearchHome: function () {
        var title_search = $('#title_search').val();
        var depart_search = $('#depart_search').val();
        if(title_search.trim() != '' || parseInt(depart_search) > 0){
            $('#search_title_product').submit();
        }else {
            alert('Bạn chưa chọn tiêu chí tìm kiếm');
        }
    },
    onchangeViewImageDetail: function (pro_id,url_image) {
        if(parseInt(pro_id) > 0){
            $("#img_product_big").attr("src",url_image);
        }
    }
}

