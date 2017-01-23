/**
 * Created by Tuan on 07/06/2015.
 */
var restore = 0;
$(document).ready(function(){
    $('[data-rel=popover]').popover({container: 'body'});
    $('#customers_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});

    $('#customers_id').on('change',function(){
        var customers_id = $(this).val();
        $("#sys_product_info").html('');
        if (parseInt(customers_id) > 0)
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: WEB_ROOT + '/admin/getCustomerInfo',
                data: {
                    customers_id: customers_id
                },
                beforeSend: function () {
                    //$("#sys_provider_info").addClass('hidden');
                    $("#sys_customer_info").hide();
                    $("#sys_load").show();
                },
                error: function () {
                    $("#sys_customer_info").html('');
                },
                success: function (data) {
                    $("#sys_load").fadeOut(555, function () {
                        $("#sys_customer_info").fadeIn(1111);
                        $("#sys_customer_info").html(data.html);
                    });
                }
            });
        else
            $("#sys_customer_info").hide(2222);
    });

    $('#export_product_num').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

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
                    //$('#sys_product_group_create').removeAttr('onclick');
                },
                complete: function () {
                    //$('#sys_product_group_create').attr('onclick', 'sales.showListProductSale();');
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
            $("#product_name").val(ui.item.value)
            $("#product_Quantity").val(ui.item.quantity);
            return false;
        }
        //minLength: 3
    });

    $("#sys_add_product").on('click',function(){
        var name = $("#product_name").val();
        var num = $("#export_product_num").val();
        var customers_id = $("#customers_id").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/export/addProduct',
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
                    $("#product_Quantity").val('');
                    $("#export_product_num").val('');

                }
            }
        });
    });
    $(".sys_open_delete").on('click', function () {
        restore = 0;
        var export_code = $(this).attr('data-code');
        $("#export_" + export_code).modal('show');
    });
    $(".sys_open_restore").on('click', function () {
        restore = 1;
        var export_code = $(this).attr('data-code');
        $("#export_" + export_code).modal('show');
    });
    $(".sys_delete_export").on('click',function(){
        var $this = $(this);
        var export_id = $(this).attr('data-id');
        var export_code = $(this).attr('data-code');
        var export_note = $("#export_note_" + export_code).val();
        var export_status = $("#export_status").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/export/remove',
            data: {
                export_id: export_id,
                export_note: export_note,
                restore: restore
            },
            beforeSend: function () {
                $('.modal').modal('hide')
            },
            error: function () {
                bootbox.alert('Lỗi hệ thống');
            },
            success: function (data) {
                if(data.success == 1){
                    if(export_status == 1){
                        $this.parents('tr').html('');
                    }else{
                        console.log($this);
                        $this.parents('tr').addClass('orange bg-warning');
                        $this.parents('td').html('');

                    }
                    if(restore == 1){
                        window.location.href = data.link;
                        return false;
                    }
                }
                bootbox.alert(data.html);
            }
        });
    });
    $(".txt_input").on('keypress', function (event) {
        if (event.which == 13 || event.keyCode == 13) {
            $("#sys_add_product").trigger("click")
            return false;
        }
    });

});
var Export = {

    removeItem:function(product_id){
        var customers_id = $("#customers_id").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/export/removeProduct',
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
