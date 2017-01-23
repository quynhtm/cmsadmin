/**
 * Created by MT969 on 10/7/2015.
 */

$(document).ready(function(){

    $('[data-rel=popover]').popover({container: 'body'});

    $('#customers_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});

    $('#customers_id').on('change',function(){
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/customers/removeSessionPriceList',
            data: {
            },
            beforeSend: function () {
            },
            error: function () {
                $('#customers_id').val(0);
            },
            success: function (data) {
                $("#sys_product_info").html('');
            }
        });
    });

    $("#product_name").autocomplete({
        source: function (request, response) {
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: WEB_ROOT + '/admin/getProductByName',
                data: {
                    product_name: $("#product_name").val()
                },
                beforeSend: function () {
                },
                complete: function () {
                },
                error: function () {
                },
                success: function (data) {
                    if (data.success) {
                        //response(data.product);
                        response($.map(data.product, function(item) {
                            return {
                                value: item.product_Name,
                                quantity: item.product_Quantity
                            }
                        }));
                    }
                }
            });
        },
        select: function( event, ui ) {
            $("#product_name").val(ui.item.value);
            $("#product_num").focus();
            //$("#product_Quantity").val(ui.item.quantity);
            return false;
        }
        //minLength: 3
    });

    $('#product_num').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

    $(".txt_input").on('keypress', function (event) {
        if (event.which == 13 || event.keyCode == 13) {
            $("#sys_add_product").trigger("click")
            return false;
        }
    });

    $("#sys_add_product").on('click',function(){
        var name = $("#product_name").val();
        var num = $("#product_num").val();
        var customers_id = $("#customers_id").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/customers/addProduct',
            data: {
                name: name,
                customers_id: customers_id,
                num: num
            },
            beforeSend: function () {
            },
            error: function () {
            },
            success: function (data) {
                $("#sys_product_info").html(data.html);
                $('[data-rel=popover]').popover({container: 'body'});
                if (data.success == 1) {
                    $("#product_name").val('');
                    $("#product_num").val('');
                    $("#product_name").focus();

                }
            }
        });
    });

    $("#btn_export_pdf").on('click dbclick',function(){
        var customers_id = $("#customers_id").val();
        var newWindow = window.open(WEB_ROOT, '_blank');
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/customers/price_list',
            data: {
                customers_id: customers_id
            },
            beforeSend: function () {
            },
            error: function () {
                bootbox.alert('Lỗi hệ thống');
            },
            success: function (data) {
                if (data.success == 1) {
                    //window.open(data.link, '_blank');
                    newWindow.location = data.link;
                }else{
                    bootbox.alert(data.mess);
                }
            }
        });
        return false;
    });
});
var PriceList = {

    removeItem:function(product_id){
        var customers_id = $("#customers_id").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/customers/removeProduct',
            data: {
                product_id: product_id,
                customers_id: customers_id
            },
            beforeSend: function () {
            },
            error: function () {
            },
            success: function (data) {
                $("#sys_product_info").html(data.html);
                $(".popover").removeClass('in');
                $('[data-rel=popover]').popover({container: 'body'});
            }
        });
    }
}
