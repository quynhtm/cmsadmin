/**
 * Created by Tuan on 03/06/2015.
 */
var restore = 0;
$(document).ready(function(){

    $('[data-rel=popover]').popover({container: 'body'});

    $('#providers_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});

    $("#providers_id").on('change', function () {
        var providers_id = $(this).val();
        if (parseInt(providers_id) > 0)
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: WEB_ROOT + '/admin/getProviderInfo',
                data: {
                    providers_id: providers_id
                },
                beforeSend: function () {
                    //$("#sys_provider_info").addClass('hidden');
                    $("#sys_provider_info").hide();
                    $("#sys_load").show();
                },
                error: function () {
                    $("#sys_provider_info").html('');
                },
                success: function (data) {
                    $("#sys_load").fadeOut(555, function () {
                        $("#sys_provider_info").html(data.html);
                        $("#sys_provider_info").fadeIn(1111);
                    });
                }
            });
        else
            $("#sys_provider_info").hide(1111);
    });

    $('#import_product_num').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

    $("#import_product_price").on('keyup', function (event) {
        Import.fomatNumber('import_product_price');
    });

    $("#import_pay_discount_vnd").on('keyup', function (event) {
        Import.fomatNumber('import_pay_discount_vnd');
        var import_price = parseInt($('#import_price').val());
        var import_discount = parseInt($("#input_import_pay_discount_vnd").val());
        var import_total = import_price - import_discount;
        import_total = formatNumber(import_total);
        $('#sys_import_total').html(import_total);
    });

    $('#import_pay_discount_percent').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

    $("#import_pay_discount_percent").on('keyup', function (event) {
        var import_price = parseInt($('#import_price').val());
        var import_discount = parseInt($("#import_pay_discount_percent").val() * import_price / 100);
        var import_total = import_price - import_discount;
        import_total = formatNumber(import_total);
        $('#sys_import_total').html(import_total);
    });

    $('input[name="import_pay_discount_type"]').on('change',function(){
        $('.sys_discount').hide();
        $('#sys_discount_' + $(this).val()).show();
        var import_price = parseInt($('#import_price').val());
        if ($(this).val() == 1) {
            var import_discount = parseInt($("#import_pay_discount_percent").val() * import_price / 100);
        }else if($(this).val() == 2){
            var import_discount = parseInt($("#input_import_pay_discount_vnd").val());
        }else{
            var import_discount = 0;
        }
        var import_total = import_price - import_discount;
        import_total = formatNumber(import_total);
        $('#sys_import_total').html(import_total);
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
                                value: item.product_Name
                            }
                        }));
                    }
                }
            });
        }
        //minLength: 3
    });

    $("#sys_add_product").on('click',function(){
        var name = $("#product_name").val();
        var price = $("#input_import_product_price").val();
        var num = $("#import_product_num").val();
        var type = $("#import_pay_type:checked").val();
        var discount_type = $('input[name="import_pay_discount_type"]:checked').val();
        var discount_percent = $("#import_pay_discount_percent").val();
        var discount_vnd = $("#input_import_pay_discount_vnd").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/import_fake/addProduct',
            data: {
                name: name,
                price: price,
                num: num,
                type: type,
                discount_type: discount_type,
                discount_vnd: discount_vnd,
                discount_percent: discount_percent
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
                    $("#input_import_product_price").val(0);
                    $("#import_product_price").val('');
                    $("#import_product_num").val('');
                    $("#import_pay_discount_vnd").on('keyup', function (event) {
                        Import.fomatNumber('import_pay_discount_vnd');
                        var import_price = parseInt($('#import_price').val());
                        var import_discount = parseInt($("#input_import_pay_discount_vnd").val());
                        var import_total = import_price - import_discount;
                        import_total = formatNumber(import_total);
                        $('#sys_import_total').html(import_total);
                    });
                    $('#import_pay_discount_percent').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
                    $("#import_pay_discount_percent").on('keyup', function (event) {
                        var import_price = parseInt($('#import_price').val());
                        var import_discount = parseInt($("#import_pay_discount_percent").val() * import_price / 100);
                        var import_total = import_price - import_discount;
                        import_total = formatNumber(import_total);
                        $('#sys_import_total').html(import_total);
                    });
                    $('input[name="import_pay_discount_type"]').on('change',function(){
                        $('.sys_discount').hide();
                        $('#sys_discount_' + $(this).val()).show();
                        var import_price = parseInt($('#import_price').val());
                        if ($(this).val() == 1) {
                            var import_discount = parseInt($("#import_pay_discount_percent").val() * import_price / 100);
                        }else if($(this).val() == 2){
                            var import_discount = parseInt($("#input_import_pay_discount_vnd").val());
                        }else{
                            var import_discount = 0;
                        }
                        var import_total = import_price - import_discount;
                        import_total = formatNumber(import_total);
                        $('#sys_import_total').html(import_total);

                    });
                    $('')
                }
            }
        });
    })


    $(".sys_open_delete").on('click', function () {
        restore = 0;
        var import_code = $(this).attr('data-code');
        $("#import_" + import_code).modal('show');
    });
    $(".sys_open_restore").on('click', function () {
        restore = 1;
        var import_code = $(this).attr('data-code');
        $("#import_" + import_code).modal('show');
    });
    $(".sys_delete_import").on('click',function(){
        var $this = $(this);
        var import_id = $(this).attr('data-id');
        var import_code = $(this).attr('data-code');
        var import_note = $("#import_note_" + import_code).val();
        var import_status = $("#import_status").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/import_fake/remove',
            data: {
                import_id: import_id,
                import_note: import_note,
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
                    if(import_status == 1){
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

    $(".sys_update_payment").on('click dbclick',function(){
        var $this = $(this);
        var import_code = $(this).data('code');
        var import_id = $(this).data('id');
        bootbox.confirm("Bạn muốn cập nhật trạng thái thanh toán cho phiếu nhập " + import_code + " ", function (result) {
            if(result == true){
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: WEB_ROOT + '/admin/import_fake/update_payment',
                    data: {
                        import_id: import_id
                    },
                    beforeSend: function () {
                        $this.addClass('disabled');
                    },
                    error: function () {
                        $this.removeClass('disabled');
                        bootbox.alert('Lỗi hệ thống');
                    },
                    success: function (data) {
                        $this.removeClass('disabled');
                        if(data.success == 1){
                            $this.hide();
                            if(parseInt($("#import_pay_type").val()) == 1){
                                $this.parents('tr').hide();
                            }
                        }
                        bootbox.alert(data.html);
                    }
                });
            }
        });
        return false;
    });

});

var Import = {
    fomatNumber:function (id) {
        var re = parseInt(parseInt($("#" + id).val().replace(/\./g, ''))) || 0;
        if (re > 1000000000) {
            re = 1000000000;
        }
        jQuery('#input_' + id).val(re);
        number.numberFormatNew(re, id);
    },
    removeItem:function(product_id){
        var type = $("#import_pay_type:checked").val();
        var discount_type = $('input[name="import_pay_discount_type"]:checked').val();
        var discount_vnd = $("#input_import_pay_discount_vnd").val();
        var discount_percent = $("#import_pay_discount_percent").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/import_fake/removeProduct',
            data: {
                product_id: product_id,
                type: type,
                discount_type:discount_type,
                discount_vnd: discount_vnd,
                discount_percent: discount_percent
            },
            beforeSend: function () {
            },
            error: function () {
            },
            success: function (data) {
                $("#sys_product_info").html(data.html);
                $(".popover").removeClass('in');
                $('[data-rel=popover]').popover({container: 'body'});
                $("#import_pay_discount_vnd").on('keyup', function (event) {
                    Import.fomatNumber('import_pay_discount_vnd');
                    var import_price = parseInt($('#import_price').val());
                    var import_discount = parseInt($("#input_import_pay_discount_vnd").val());
                    var import_total = import_price - import_discount;
                    import_total = formatNumber(import_total);
                    $('#sys_import_total').html(import_total);
                });
                $('#import_pay_discount_percent').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
                $("#import_pay_discount_percent").on('keyup', function (event) {
                    var import_price = parseInt($('#import_price').val());
                    var import_discount = parseInt($("#import_pay_discount_percent").val() * import_price / 100);
                    var import_total = import_price - import_discount;
                    import_total = formatNumber(import_total);
                    $('#sys_import_total').html(import_total);
                });
                $('input[name="import_pay_discount_type"]').on('change',function(){
                    $('.sys_discount').hide();
                    $('#sys_discount_' + $(this).val()).show();
                    var import_price = parseInt($('#import_price').val());
                    if ($(this).val() == 1) {
                        var import_discount = parseInt($("#import_pay_discount_percent").val() * import_price / 100);
                    }else if($(this).val() == 2){
                        var import_discount = parseInt($("#input_import_pay_discount_vnd").val());
                    }else{
                        var import_discount = 0;
                    }
                    var import_total = import_price - import_discount;
                    import_total = formatNumber(import_total);
                    $('#sys_import_total').html(import_total);
                });
            }
        });
    }
}
