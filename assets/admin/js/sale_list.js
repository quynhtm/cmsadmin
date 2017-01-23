/**
 * Created by MT969 on 10/19/2015.
 */
$(document).ready(function(){
    $('[data-rel=popover]').popover({container: 'body'});
    $('#customers_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});

    $( "#export_create_start" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: 'dd-mm-yy',
        onClose: function(selectedDate) {
            $("#export_create_end").datepicker("option", "minDate", selectedDate);
            $('#export_create_end').focus();
        }
    });

    $( "#export_create_end" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: 'dd-mm-yy'
    });

    $( "#sale_list_time" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        //setDate: new Date(),
        dateFormat: 'dd-mm-yy'
    }).datepicker( "setDate", new Date());

    $("#customers_id,#sale_list_type").on('change',function(){
        $("#sys_data_export").hide(1111,function(){
            $("#sys_data_export").html('');
        });
    })

    $("#sys_get_export").on('click dbclick',function(){
        var customers_id = parseInt($("#customers_id").val());
        var export_pay_type = parseInt($("#sale_list_type").val());
        var export_create_start = $("#export_create_start").val();
        var export_create_end = $("#export_create_end").val();
        if(customers_id > 0){
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: WEB_ROOT + '/admin/export/export_sale',
                data: {
                    customers_id: customers_id,
                    export_pay_type: export_pay_type,
                    export_create_start: export_create_start,
                    export_create_end: export_create_end
                },
                beforeSend: function () {
                },
                complete: function () {
                },
                error: function () {
                    $("#sys_data_export").html('');
                    bootbox.alert('Lỗi hệ thống');
                },
                success: function (data) {
                    $("#sys_data_export").html(data.html);
                    $("#sys_data_export").show();
                    var active_class = 'active';
                    $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
                        var th_checked = this.checked;//checkbox inside "TH" table header
                        $(this).closest('table').find('tbody > tr').each(function(){
                            var row = this;
                            if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                            else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
                        });
                    });

                    //select/deselect a row when the checkbox is checked/unchecked
                    $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
                        var $row = $(this).closest('tr');
                        if(this.checked) $row.addClass(active_class);
                        else $row.removeClass(active_class);
                    });
                }
            });
        }else{
            bootbox.alert('Chưa chọn thông tin khách hàng');
        }
    });

    $(".sys_update_payment").on('click dbclick',function(){
        var $this = $(this);
        var sale_list_code = $(this).data('code');
        var sale_list_id = $(this).data('id');
        bootbox.confirm("Bạn muốn cập nhật trạng thái thanh toán cho bảng kê " + sale_list_code + " ", function (result) {
            if(result == true){
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: WEB_ROOT + '/admin/sale_list/update_payment',
                    data: {
                        sale_list_id: sale_list_id
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
                            if(parseInt($("#sale_list_type").val()) == 1){
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
})
