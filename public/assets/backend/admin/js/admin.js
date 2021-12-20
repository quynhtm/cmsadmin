$(document).ready(function () {
    var lng;
    Admin.setLang();
    Admin.openDetailView();
    Admin.loadTabRepaymentList('.listTabsRepaymentsAtview .tab-toggle','/manager/repayment/ajaxIndexLoadTab');
    Admin.btnTiepNhanRepayment();
    Admin.btnCreateBill();
    // Show tooltip
    $("#show-search-advanced").click(function(){
        $("#search-advanced").slideToggle(300);
    });

    //select tools tips
    var config = {
        '.chosen-select'           : {width: "100%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    $("#disableInput :input").prop("disabled", true);

    $(".fixDuplicateData").removeAttr("disabled");

    var form = document.querySelector('form');
    if(form != undefined){
        form.onsubmit = function () {
            document.getElementsByClassName("fixDuplicateData").disabled = true;
            $('.save').hide();
        };
    }


    function tick() {
        $('.edit ').on('click', function (event) {
            event.preventDefault();
            $(this).html("Lưu");
            $(this).removeClass("edit");
            $(this).addClass("save");
            $(this).unbind('click');
            $('#disableInput :input').removeAttr('disabled', true);
        });
    }
    $('.edit ').on('click', function (event) {
        event.preventDefault();
        $(this).html("Lưu");
        $(this).removeClass("edit");
        $(this).addClass("save");
        $(this).unbind('click');
        $('#disableInput :input').removeAttr('disabled', true);
    });

    $('.cancel').on('click', function () {
        $('.edit').bind('click');
        $("#disableInput :input").prop("disabled", true);
        $('.fixDuplicateData').addClass('edit');
        $('.save').html('Sửa');
        $('.save').addClass('edit', function () {
            $('.fixDuplicateData').removeClass('save');
            $('.edit').removeAttr('disabled').unbind('click');
            tick();
        });
    });

    /*$('[data-toggle="popover"]').popover(
        {
            html : true,
            title: function() {
                var content = $(this).attr('data-html-content');
                return $(content).find('.title').html();
            },
            content: function() {
                var content = $(this).attr('data-html-content');
                return $(content).find('.content').html();
            },
            placement: function(context, source){
                var position = $(source).position();
                if (position.top < 250){
                    return "bottom";
                } else  {
                    return "top";
                }
            }
        }
    );*/

    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    $("#checkAll").click(function () {
        $(".check").prop('checked', $(this).prop('checked'));
    });

    $(".sys_delete_common").on('click', function () {
        var $this = $(this);
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        var content = $(this).attr('data-content');
        var _token = $('input[name="_token"]').val();
        bootbox.confirm("Bạn chắc chắn muốn xóa "+content+" này", function (result) {
            if (result == true) {
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: WEB_ROOT + '/manager/' + url + id,
                    data: {
                        '_token': _token,
                    },
                    beforeSend: function () {
                        $('.modal').modal('hide')
                    },
                    error: function () {
                        bootbox.alert('Lỗi hệ thống');
                    },
                    success: function (data) {
                        if (data.success == 1) {
                            alert('Xóa item thành công');
                            window.onLoad();
                        } else {
                            bootbox.alert('Lỗi cập nhật');
                        }
                    }
                });
            }
        });
    });


    if ($('.input-date').length && typeof $.datepicker != 'undefined'){
        $('.input-date').each(function(){
            var dateFormat = typeof $(this).data('format') != 'undefined' ? $(this).data('format') : 'dd/mm/yy';
            $(this).datepicker({dateFormat: dateFormat});
        })
    }
});
var Admin = {
    /**
     *********************************************************************************************************************
     * @param id
     * Function cho SMS
     * *******************************************************************************************************************
     */
    checkSubmitForm:1,
    /************************************************************************************************
     *  HD Insurance
     ************************************************************************************************/
    getPopupMoveDepartOfStaff: function (obj){
        var dataId = [];
        var i = 0;
        $("input[name*='checkStaffCode']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                i++;
            }
        });
        if (dataId.length == 0) {
            jqueryCommon.showMsg('error','','Thông báo lỗi','Bạn chưa chọn nhân viên để thao tác.');
            return false;
        }
        var title = $(obj).attr('title');
        var _token = $('input[name="_token"]').val();

        var divShow = $(obj).attr('data-div-show');
        var url = $(obj).attr('data-url');
        var method = $(obj).attr('data-method');
        var dataInput = $(obj).attr('data-input');
        var functionAction = $(obj).attr('data-function-action');

        //$('#loaderRight').show();
        $.ajax({
            dataType: 'json',
            type: method,
            url: url,
            data: {
                '_token': _token,
                'titlePopup': title,
                'dataInput': dataInput,
                'dataUserCode': dataId,
                'divShow': divShow,
                'functionAction': functionAction
            },
            success: function (res) {
                $('#loaderRight').hide();
                if (res.success == 1) {
                    $('#sys_showPopupCommonSmall').modal('show');
                    $('#'+divShow).html(res.html);
                } else {
                    jqueryCommon.showMsgError(res.success,res.message);
                }
            }
        });
    },
    actionMoveDepartOfStaff: function (formId,urlAction){
        if (!jqueryCommon.getFormValidation(formId,2)) return;
        var dataForm = jqueryCommon.getDataFormObj(formId);
        var _token = $('input[name="_token"]').val();
        $('#loaderRight').show();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: urlAction,
            data: {
                '_token': _token,
                'dataForm': dataForm,
            },
            success: function (res) {
                $('#loaderRight').hide();
                if (res.success == 1) {
                    jqueryCommon.showMsg('success',res.message);
                    location.reload();
                    //$('#'+res.divShow).html(res.html);
                } else {
                    jqueryCommon.showMsg('error','','Thông báo lỗi',res.message);
                }
            }
        });
    },
    getListMenuPermission: function (objectId,urlAction,typeSearch){
        var _token = $('input[name="_token"]').val();
        var projectCodeMenu = $('#s_project_code_menu').val();
        //$('#loaderRight').show();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: urlAction,
            data: {
                '_token': _token,
                'projectCodeMenu': projectCodeMenu,
                'objectId': objectId,
                'typeSearch': typeSearch,
                'funcAction': 'getListMenuPermission',
                'functionAction': '_functionGetData',
            },
            success: function (res) {
                $('#loaderRight').hide();
                if (res.success == 1) {
                    $('#div_list_menu_permission').html(res.html);
                } else {
                    jqueryCommon.showMsg('error','','Thông báo lỗi',res.message);
                }
            }
        });
    },











    /************************************************************************************************
     *  phần khác
     ************************************************************************************************/
    setLang: function () {
        $.ajaxSetup({async: false});
        var lang = $("body").attr("lang");
        var file_lang = WEB_ROOT + "/storage/language/" + lang + ".json";
        $.getJSON(file_lang, function (data) {
            lng = data;
        });
        $.ajaxSetup({async: true});
    },
    checkActionForm: function(){
        if(confirm('Bạn có chắc chắn xử lý nghiệp vụ này?')){
            return Admin.disabledActionForm();
        }
        return false;
    },
    disabledActionForm: function(){
        if(Admin.checkSubmitForm != 0){
            Admin.checkSubmitForm = 0;
            return true;
        }
        return false;
    },
    addItem: function (elementForm, elementInput, btnSubmit, url) {
        $("#loading").fadeIn().fadeOut(10);
        var isError = false;
        var msg = {};
        $(elementInput).each(function () {
            var input = $(this);
            if ($(this).hasClass("input-required") && input.val() == '') {
                msg[$(this).attr("name")] = "※" + $(this).attr("title") +' - '+ lng['alert_is_required'];
                isError = true;
            }
        });
        if (isError == true) {
            var error_msg = '';
            $.each(msg, function (key, value) {
                error_msg = error_msg + value + "\n";
            });
            alert(error_msg);
            return false;
        } else {
            $(btnSubmit).attr("disabled", 'true');
            var data = Admin.getFormData(elementForm);
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                headers: {'X-CSRF-TOKEN': _token},
                success: function (res) {
                    $(btnSubmit).removeAttr("disabled");
                    if(res.isOk == 1){
                        window.location.reload();
                    }else {
                        alert(res.msg);
                    }
                },
            });
            //window.location.reload();
        }
    },
    scrolleTop:function(){
        $('.editItem').click(function(){
            $("html, body").animate({scrollTop: 0}, 500);
        });
    },
    resetItem: function (elementKey, elementValue) {
        $("#loading").fadeIn().fadeOut(10);
        $('input[type="text"]').val('');
        $('textarea').val('');
        $(elementKey).val(elementValue);
        $('.frmHead').text('Thêm mới');
        $('.icChage').removeClass('fa-edit').addClass('fa-plus-square');
    },
    getFormData: function (frmElements) {
        var out = {};
        var s_data = $(frmElements).serializeArray();
        for (var i = 0; i < s_data.length; i++) {
            var record = s_data[i];
            out[record.name] = record.value;
        }
        return out;
    },
    editItem: function (id, url) {
        var _token = $('meta[name="csrf-token"]').attr('content');
        $("#loading").fadeIn().fadeOut(10);
        $.ajax({
            type: "POST",
            url: url,
            data: {id: id},
            headers: {'X-CSRF-TOKEN': _token},
            success: function (data) {
                $('.loadForm').html(data);
                return false;
            }
        });
    },
    deleteItemByUrl: function (id, url) {
        var a = confirm('Bạn có chắc muốn xóa Item này?');
        var _token = $('meta[name="csrf-token"]').attr('content');
        $("#loading").fadeIn().fadeOut(10);
        if (a) {
            $.ajax({
                type: 'get',
                url: url,
                data: {'id': id},
                headers: {'X-CSRF-TOKEN': _token},
                success: function (data) {
                    if ((data.errors)) {
                        alert(data.errors)
                    } else {
                        window.location.reload();
                    }
                },
            });
        }
    },

    btnTiepNhanRepayment:function(){
        $('.btnTiepNhanRepayment').click(function(){
            var total = jQuery(".userReceiveListRepayment table tbody input.check:checked" ).length;
            if(total==0){
                jAlert('Vui lòng chọn ít nhất 1 lịch thu hồi để nhận!', 'Thông báo');
                return false;
            }else{
                jConfirm('Bạn muốn nhận YCV [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
                    if(r){
                        $('form.userReceiveListRepayment').submit();
                        return true;
                    }
                });
            }
        });
    },
    btnCreateBill:function(){
        $('#actionCreateBill').click(function(){
            if($('#amount_bill').val() == '' || $('#date_bill').val() == 0 || $('#vimo_code_bill').val() == ''){
                alert('Vui lòng nhập đầy đủ thông tin')
                return false;
            }
            else if($('#amount_bill').val() <= 0){
                alert('Vui lòng nhập số tiền lớn hơn 0');
                return false;
            }else{
                $('#createBill').submit();
                return true;
            }
        });
    },
    loadTabRepaymentList:function(element_click,url_define){
        $(element_click).click(function(){
            $('#loadingAjax').show();
            var function_action = $(this).attr('data-function-action');
            window.location.href = function_action;
        });
    },
    showChooseFile: function() {
        if($('#input_type').val() == 'select'){
            $('.custom-file-upload').removeClass('hidden')
        }
        else{
            $('.custom-file-upload').addClass('hidden')
        }
    },
    showTypeSendAndIsloot: function() {
        if($('#type_send').val() == 1){
            $('#showTimeAndTypeLoot').removeClass('hidden')
        }
        else{
            $('#showTimeAndTypeLoot').addClass('hidden')
        }
    },
    doiSoatChungTu:function(){
        if (confirm('Bạn có muốn đối soát chứng từ này không?')) {
            $('#form_doi_soat_chung_tu').submit();
        }
    },
    huyDoiSoatChungTu:function(){
        if (confirm('Bạn có muốn hủy đối soát chứng từ này không?')) {
            $('#form_doi_soat_chung_tu').submit();
        }
    },
    sendMultiNotificationForLoaner: function(channnel, content_send, id) {
        if (confirm('Bạn có muốn gửi thông báo này không?')) {
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + '/manager/content_notify/ajaxSend',
                    data: {channel: channnel,content: content_send,id: id},
                    dataType: 'json',
                    success: function (res) {
                        alert(res)
                        location.reload();
                    },
                    error: function () {
                        alert('Không thể gửi thông báo. Vui lòng thử lại')
                    }
                });
        }
    },
    sendNotificationLoanerAndLender: function(user, content_send, status) {
        if (confirm('Bạn có muốn gửi thông báo này không?')) {
            if(status !== 1){
                alert('Tin nhắn này chưa được kích hoạt')
            }
            else{
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + '/manager/marketing_campaign/ajaxSend',
                    data: {user: user,content: content_send},
                    dataType: 'json',
                    success: function (res) {
                        alert(res)
                    },
                    error: function () {
                        alert('Không thể gửi thông báo. Vui lòng thử lại')
                    }
                });
            }
        }
    },
     isEmailAddress: function(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    },
    getInfoSettingUser: function (user_id) {
        $('#sys_showPopupInfoSetting').modal('show');
        $('#img_loading').show();
        $('#sys_show_infor').html('');
        $.ajax({
            type: "GET",
            url: WEB_ROOT + '/manager/user/getInfoSettingUser',
            data: {user_id: user_id},
            dataType: 'json',
            success: function (res) {
                $('#img_loading').hide();
                $('#sys_show_infor').html(res.html);
            }
        });
    },
    checkDuplicateOptionPoint: function () {
        if($('#name').val() !== '' && $('#code').val() !== '' && $('#value').val() !== ''){
            $('#button_save').addClass('hidden');
        }
    }
    ,
    submitInfoSettingUser: function () {
        $('#img_loading').show();
        var formData = $('#form_user_setting').serialize();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: WEB_ROOT + '/manager/user/submitInfoSettingUser',//
            data: {formData: formData, '_token': _token},
            dataType: 'json',
            success: function (res) {
                $('#sys_showPopupInfoSetting').modal('hide');
            }
        });
    },
    resetForm: function (id_form) {
        $("#"+ id_form).trigger("reset");
    },
    submitForm: function (id_form,hidden_button) {
        $("#"+ hidden_button).addClass("hidden");
        $("#"+ id_form).submit();
    },

    /**
     *********************************************************************************************************************
     * @param id
     * AND Function cho SMS
     * *******************************************************************************************************************
     */
    deleteItem: function (id, type) {
        if (confirm('Bạn có muốn xóa Item này không?')) {
            $('#img_loading_' + id).show();
            var _token = $('input[name="_token"]').val();
            var url_ajax = '';
            if (type == 1) { //xoa tin tức
                url_ajax = 'deleteNews';
            } else if (type == 2) {
                url_ajax = 'deleteCustomer';
            } else if (type == 3) {
                url_ajax = 'deleteGroupRole';
            } else if (type == 4) {
                url_ajax = 'deleteMenu';
            } else if (type == 9) {
                url_ajax = 'deletePermission';
            } else if (type == 5) {
                url_ajax = 'banner/deleteBanner';
            } else if (type == 6) {
                url_ajax = 'managerOrder/deleteOrder';
            } else if (type == 7) {
                url_ajax = 'product/deleteProduct';
            } else if (type == 8) {
                url_ajax = 'company/deleteCompany';
            } else if (type == 10) {
                url_ajax = 'lender_popup/deleteLenderPopup';
            } else if (type == 11) {
                url_ajax = 'content_notify/deleteContentNotify';
            } else if (type == 12) {
                url_ajax = 'marketing_coin_policy/delete';
            } else if (type == 13) {
                url_ajax = 'questions-file/delete';
            }
            if (url_ajax != '') {
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {id: id, _token: _token},
                    dataType: 'json',
                    success: function (res) {
                        $('#img_loading_' + id).hide();
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
    activeItem: function (id, active, urlAjax, target) {
        console.log(id);
        console.log(active);
        console.log(urlAjax);
        console.log(target);
        var action = '';
        if (target === '') {
            var dataTarget = "Sản phẩm";
        }
        else {
            var dataTarget = target;
        }

        if(active == 1){
            action = 'kích hoạt'
        }

        else{
            action = 'khoá'
        }
        if (confirm('Bạn có muốn ' + action + dataTarget + ' này không?')) {
            $('#img_loading_' + id).show();
            var _token = $('input[name="_token"]').val();
            if(urlAjax === '') {
                var url_ajax = 'product/activeProduct';
            }
            else {
                var url_ajax = urlAjax;
            }

            if (url_ajax != '') {
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {id: id, _token: _token,status: active},
                    dataType: 'json',
                    success: function (res) {
                        $('#img_loading_' + id).hide();
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
    blockItem: function (id, action, urlAjax, target) {
        var dataAction = '';
        if(action == -2){
            dataAction = 'khoá '
        }

        if (confirm('Bạn có muốn ' + dataAction + target + ' này không?')) {
            $('#img_loading_' + id).show();
            var _token = $('input[name="_token"]').val();
            var url_ajax = urlAjax;

            if (url_ajax != '') {
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {id: id, _token: _token,status: action},
                    dataType: 'json',
                    success: function (res) {
                        $('#img_loading_' + id).hide();
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
    ajaxReceiveRepayment: function(repayment_id) {
        if (confirm('Bạn có muốn tiếp nhận lịch trả nợ của người vay này?')) {
            $.ajax({
                type: "POST",
                url: WEB_ROOT + '/manager/repayment/receive-repayment',
                data: {repayment_id: repayment_id},
                dataType: 'json',
                success: function (res) {
                    alert(res)
                    window.location.reload();
                },
                error: function () {
                    alert('Tiếp nhận không thành công')
                }
            });
        }
    },
    actionItemAJAX: function (id, action, urlAjax, target) {
        var dataAction = '';
        if(action === '-3'){
            dataAction = 'xoá '
        }

        if(action == -2){
            dataAction = 'khoá '
        }

        if(action === 1){
            dataAction = 'Kích hoạt '
        }

        if (confirm('Bạn có muốn ' + dataAction + target + ' này không?')) {
            $('#img_loading_' + id).show();
            var _token = $('input[name="_token"]').val();
            var url_ajax = urlAjax;

            if (url_ajax != '') {
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {id: id, _token: _token,status: action},
                    dataType: 'json',
                    success: function (res) {
                        $('#img_loading_' + id).hide();
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
    updateListInforProduct: function (type) {
        var dataId = [];
        var i = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                i++;
            }
        });
        if (dataId.length == 0) {
            alert('Bạn chưa chọn items để thao tác.');
            return false;
        }
        var url_ajax = '';
        var title_action = '';
        if (type == 1) { //xoa sản phẩm
            url_ajax = 'deleteMultiProduct';
            title_action = ' XÓA SẢN PHẨM '
        } else if (type == 2) { // add logo lên ảnh sản phẩm
            url_ajax = 'addLogoImgInProduct';
            title_action = ' ADD LOGO VÀO ẢNH '
        }

        if (url_ajax != '') {
            if (confirm('Bạn có muốn thực hiện thao tác:'+title_action+' này?')) {
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
    setStastusBlockItems: function () {
        var dataId = [];
        var i = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                i++;
            }
        });
        if (dataId.length == 0) {
            alert('Bạn chưa chọn items để thao tác.');
            return false;
        }
        var valueInput = $('#product_status_update').val();
        if (parseInt(valueInput) == -1) {
            alert('Bạn chưa chọn trạng thái để cập nhật.');
            return false;
        }
        var url_ajax = 'setStastusBlockItems';

        if (url_ajax != '' && parseInt(valueInput) > -1) {
            if (confirm('Bạn có muốn thực hiện thao tác này?')) {
                $('#img_loading_delete_all').show();
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {dataId: dataId, valueInput: valueInput},
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
    updateStatusItem: function (id, status, type) {
        if (confirm('Bạn có muốn thay đổi trạng thái Item này không?')) {
            $('#img_loading_' + id).show();
            if (type == 1) { //cap nhat danh muc
                var url_ajax = WEB_ROOT + '/admin/category/updateStatusCategory';
            }
            /*else if(type == 2){//user shop
                            var url_ajax = WEB_ROOT + '/admin/userShop/updateStatusUserShop';
                        }*/

            $.ajax({
                type: "post",
                url: url_ajax,
                data: {id: id, status: status},
                dataType: 'json',
                success: function (res) {
                    $('#img_loading_' + id).hide();
                    if (res.isIntOk == 1) {
                        window.location.reload();
                    } else {
                        alert('Không thể thực hiện được thao tác.');
                    }
                }
            });
        }
    },
    changeOptionPersonnel: function () {
        var personnel_check_creater = $('#personnel_check_creater').val();
        if (parseInt(personnel_check_creater) == 1) {
            $('#show_personnel_user_name').show();
        } else {
            $('#show_personnel_user_name').hide();
        }
    },
    updateCategoryCustomer: function (customer_id, category_id) {
        $('#img_loading_' + category_id).show();
        var category_price_discount = $('#category_price_discount_id_' + category_id).val();
        var category_price_hide_discount = $('#category_price_hide_discount_id_' + category_id).val();
        $.ajax({
            type: "post",
            url: WEB_ROOT + '/admin/discountCustomers/updateCategory',
            data: {
                customer_id: customer_id,
                category_id: category_id,
                category_price_discount: category_price_discount,
                category_price_hide_discount: category_price_hide_discount
            },
            dataType: 'json',
            success: function (res) {
                $('#img_loading_' + category_id).hide();
                if (res.isIntOk == 1) {
                    /*alert('Bạn đã thực hiện thành công');
                    window.location.reload();*/
                } else {
                    alert('Không thể thực hiện được thao tác.');
                }
            }
        });
    },
    updateProductCustomer: function (customer_id, product_id) {
        $('#img_loading_' + product_id).show();
        var product_price_discount = $('#product_price_discount_id_' + product_id).val();
        $.ajax({
            type: "post",
            url: WEB_ROOT + '/admin/discountCustomers/updateProduct',
            data: {customer_id: customer_id, product_id: product_id, product_price_discount: product_price_discount},
            dataType: 'json',
            success: function (res) {
                $('#img_loading_' + product_id).hide();
                if (res.isIntOk == 1) {
                    /*alert('Bạn đã thực hiện thành công');
                    window.location.reload();*/
                } else {
                    alert('Không thể thực hiện được thao tác.');
                }
            }
        });
    },
    getDistrictInforCustomer: function () {
        var customer_province_id = $('#customer_province_id').val();
        if (parseInt(customer_province_id) > 0) {
            jQuery.ajax({
                type: "POST",
                url: WEB_ROOT + '/thong-tin-quan-huyen-cua-khach.html',
                data: {customer_province_id: customer_province_id},
                dataType: 'json',
                success: function (res) {
                    if (res.isIntOk === 1) {
                        $('#customer_district_id').html(res.html_option);
                    } else {
                        alert(res.msg, 'Thông báo');
                    }
                }
            });
        }
    },

    uploadImagesCategory: function () {
        $('#sys_PopupUploadImg').modal('show');
        $('.ajax-upload-dragdrop').remove();
        var id_hiden = $('#id_hiden').val();
        var settings = {
            url: WEB_ROOT + '/admin/categories/uploadImage',
            method: "POST",
            allowedTypes: "jpg,png,jpeg,gif",
            fileName: "multipleFile",
            formData: {id: id_hiden},
            multiple: false,
            onSuccess: function (files, xhr, data) {
                if (xhr.intIsOK === 1) {
                    $('#sys_PopupUploadImg').modal('hide');
                    //thanh cong
                    $("#status").html("<font color='green'>Upload is success</font>");
                    setTimeout("jQuery('.ajax-file-upload-statusbar').hide();", 5000);
                    setTimeout("jQuery('#status').hide();", 5000);
                }
            },
            onError: function (files, status, errMsg) {
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#sys_mulitplefileuploader").uploadFile(settings);
    },
    changeIsShop: function (is_customer, customer_id) {
        if (is_customer > 0) {
            $('#img_loading').show();
            $.ajax({
                type: "post",
                url: WEB_ROOT + '/admin/customer/setIsCustomer',
                data: {customer_id: customer_id, is_customer: is_customer},
                dataType: 'json',
                success: function (res) {
                    $('#img_loading').hide();
                    if (res.isIntOk == 1) {
                        alert('Bạn đã thực hiện thành công');
                    } else {
                        alert('Không thể thực hiện được thao tác.');
                    }
                }
            });
        }
    },
    changeStatusShop: function (customer_status, customer_id) {
        if (customer_id > 0) {
            $('#img_loading').show();
            $.ajax({
                type: "post",
                url: WEB_ROOT + '/admin/customer/updateStatusCustomer',
                data: {customer_id: customer_id, customer_status: customer_status},
                dataType: 'json',
                success: function (res) {
                    $('#img_loading').hide();
                    if (res.isIntOk == 1) {
                        alert('Bạn đã thực hiện thành công');
                    } else {
                        alert('Không thể thực hiện được thao tác.');
                    }
                }
            });
        }
    },
    //UPLOAD
    uploadOneImages: function (type) {
        jQuery('#sys_PopupUploadImg').modal('show');
        jQuery('.ajax-upload-dragdrop').remove();
        var id_hiden = document.getElementById('id_hiden').value;

        var settings = {
            url: WEB_ROOT + '/ajax/uploadImage',
            method: "POST",
            allowedTypes: "jpg,png,jpeg,gif",
            fileName: "multipleFile",
            formData: {id: id_hiden, type: type},
            multiple: false,//up 1 anh
            onSubmit: function () {
                jQuery("#sys_show_button_upload").hide();
                jQuery("#status").html("<font color='green'>Đang upload...</font>");
            },
            onSuccess: function (files, xhr, data) {
                dataResult = JSON.parse(xhr);
                if (dataResult.intIsOK === 1) {
                    //gan lai id item cho id hiden: dung cho them moi, sua item
                    jQuery('#id_hiden').val(dataResult.id_item);
                    jQuery('#image_primary').val(dataResult.info.name_img);
                    jQuery("#sys_show_button_upload").show();

                    var html = "";
                    html += "<img src='" + dataResult.info.src + "'/>";
                    //html +='<br/><a href="javascript: void(0);" onclick="Common.removeImageItem('+dataResult.id_item.trim()+',\''+dataResult.info.name_img.trim()+'\','+type+');">Xóa ảnh</a>';
                    jQuery('#block_img_upload').html(html);

                    //thanh cong
                    jQuery("#status").html("<font color='green'>Upload is success</font>");
                    setTimeout("jQuery('.ajax-file-upload-statusbar').hide();", 1000);
                    setTimeout("jQuery('#status').hide();", 1000);
                    setTimeout("jQuery('#sys_PopupUploadImg').modal('hide');", 1000);
                }
            },
            onError: function (files, status, errMsg) {
                jQuery("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        jQuery("#sys_mulitplefileuploader").uploadFile(settings);
    },
    insertImageContent: function (type) {
        var id = document.getElementById('id_hiden').value;
        $('#div_image_insert_content').html('');
        $.ajax({
            type: "post",
            url: WEB_ROOT + '/ajax/getImageContentCommon',
            data: {id: id, type: type},
            dataType: 'json',
            success: function (res) {
                $('#img_loading_' + id).hide();
                if (res.isIntOk == 1) {
                    jQuery('#sys_PopupImgOtherInsertContent').modal('show');
                    var rs = res.dataImage;
                    var html = '';
                    for (k in rs) {
                        var clickInsert = "<a href='javascript:void(0);' class='img_item' onclick='insertImgContent(\"" + rs[k].src_thumb_content + "\",\"" + rs[k].post_title + "\")'>";
                        html += '<span class="float_left image_insert_content" style="margin:5px;">';
                        html += clickInsert;
                        html += "<img src='" + rs[k].src_img_other + "' width='100' height='100'/>";
                        html += "</a>";
                        html += "</span>";
                    }
                    $('#div_image_insert_content').append(html);
                } else {
                    alert('Không thể thực hiện thao tác.');
                }
            }
        });
    },
    //UPLOAD MULTIPLE IMG
    uploadMultipleImages: function (type) {
        jQuery('#sys_PopupUploadImg').modal('show');
        jQuery('.ajax-upload-dragdrop').remove();
        var id_hiden = document.getElementById('id_hiden').value;

        var settings = {
            url: WEB_ROOT + '/ajax/uploadImage',
            method: "POST",
            allowedTypes: "jpg,png,jpeg,gif",
            fileName: "multipleFile",
            formData: {id: id_hiden, type: type},
            multiple: (id_hiden == 0) ? false : true,
            onSubmit: function () {
                jQuery("#sys_show_button_upload").hide();
                jQuery("#status").html("<font color='green'>Đang upload...</font>");
            },
            onSuccess: function (files, xhr, data) {
                dataResult = JSON.parse(xhr);
                if (dataResult.intIsOK === 1) {
                    //gan lai id item cho id hiden: dung cho them moi, sua item
                    jQuery('#id_hiden').val(dataResult.id_item);
                    jQuery("#sys_show_button_upload").show();

                    //add vao list sản sản phẩm khác
                    var checked_img_pro = "<br/><input type='radio' id='checked_image_" + dataResult.info.id_key + "' name='checked_image_' value='" + dataResult.info.id_key + "' onclick='Admin.checkedImage(\"" + dataResult.info.name_img + "\",\"" + dataResult.info.id_key + "\")'><label for='checked_image_" + dataResult.info.id_key + "' style='font-weight:normal'>Ảnh đại diện</label><br/>";
                    if (type == 2) {
                        var checked_img_pro = checked_img_pro + "<br/><input type='radio' id='checked_image_hover" + dataResult.info.id_key + "' name='checked_image_hover' value='" + dataResult.info.id_key + "' onclick='Admin.checkedImageHover(\"" + dataResult.info.name_img + "\",\"" + dataResult.info.id_key + "\")'><label for='checked_image_hover" + dataResult.info.id_key + "' style='font-weight:normal'>Ảnh hover</label><br/>";
                    }
                    var delete_img = "<a href='javascript:void(0);' id='sys_delete_img_other_" + dataResult.info.id_key + "' onclick='Admin.removeImage(\"" + dataResult.info.id_key + "\",\"" + dataResult.id_item + "\",\"" + dataResult.info.name_img + "\", " + type + ")' >Xóa ảnh</a>";
                    var html = "<li id='sys_div_img_other_" + dataResult.info.id_key + "'>";
                    html += "<div class='block_img_upload' >";
                    html += "<img height='100' width='100' src='" + dataResult.info.src + "'/>";
                    html += "<input type='hidden' id='img_other_" + dataResult.info.id_key + "' class='sys_img_other' name='img_other[]' value='" + dataResult.info.name_img + "'/>";
                    html += checked_img_pro;
                    html += delete_img;
                    html += "</div></li>";
                    jQuery('#sys_drag_sort').append(html);

                    //thanh cong
                    jQuery("#status").html("<font color='green'>Upload is success</font>");
                    setTimeout("jQuery('.ajax-file-upload-statusbar').hide();", 1000);
                    setTimeout("jQuery('#status').hide();", 1000);
                    setTimeout("jQuery('#sys_PopupUploadImg').modal('hide');", 1000);
                }
            },
            onError: function (files, status, errMsg) {
                jQuery("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        jQuery("#sys_mulitplefileuploader").uploadFile(settings);
    },
    checkedImage: function (nameImage, key) {
        if (confirm('Bạn có muốn chọn ảnh này làm ảnh đại diện?')) {
            jQuery('#image_primary').val(nameImage);
        }
    },
    checkedImageHover: function (nameImage, key) {
        jQuery('#image_primary_hover').val(nameImage);
    },
    removeImage: function (key, id, nameImage, type) {
        //product
        if (jQuery("#image_primary_hover").length) {
            var img_hover = jQuery("#image_primary_hover").val();
            if (img_hover == nameImage) {
                jQuery("#image_primary_hover").val('');
            }
        }
        if (jQuery("#image_primary").length) {
            var image_primary = jQuery("#image_primary").val();
            if (image_primary == nameImage) {
                jQuery("#image_primary").val('');
            }
        }

        if (confirm('Bạn có chắc chắn xóa ảnh này?')) {
            var _token = $('input[name="_token"]').val();
            jQuery.ajax({
                type: "POST",
                url: WEB_ROOT + '/ajax/removeImageCommon',
                data: {_token: _token,key: key, id: id, nameImage: nameImage, type: type},
                responseType: 'json',
                success: function (data) {
                    if (data.intIsOK === 1) {
                        jQuery('#sys_div_img_other_' + key).remove();
                    } else {
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
    getInforDistrictOfProvince: function (district_province_id, district_id) {
        $('#sys_showPopupDistrict').modal('show');
        $('#img_loading_district').show();
        $('#sys_show_infor').html('');
        $.ajax({
            type: "GET",
            url: WEB_ROOT + '/admin/province/getInforDistrictOfProvince',
            data: {district_province_id: district_province_id, district_id: district_id},
            dataType: 'json',
            success: function (res) {
                $('#img_loading_district').hide();
                $('#sys_show_infor').html(res.html);
            }
        });
    },
    submitInforDistrictOfProvince: function () {
        var district_name = document.getElementById('district_name').value;
        var district_status = document.getElementById('district_status').value;
        var district_position = document.getElementById('district_position').value;
        var district_province_id = document.getElementById('district_province_id').value;
        var district_id = document.getElementById('district_id').value;
        $.ajax({
            type: "POST",
            url: WEB_ROOT + '/admin/province/submitInforDistrictOfProvince',
            data: {
                district_name: district_name,
                district_status: district_status,
                district_position: district_position,
                district_province_id: district_province_id,
                district_id: district_id,
            },
            dataType: 'json',
            success: function (res) {
                if (res.intReturn === 1) {
                    window.location.reload();
                } else {
                    alert(res.msg);
                }
            }
        });
    },

    getAjaxOptionRelation: function (object,selectId,url) {
        $('#'+selectId).html('');
        var _token = $('input[name="_token"]').val();
        //var url_ajax = WEB_ROOT + '/manager/districtsProvince/ajaxGetOption';
        var url_ajax = WEB_ROOT + '/manager/'+url;
        var object_id = $('#'+object.id).val();
        $.ajax({
            type: "post",
            url: url_ajax,
            data: {object_id: object_id, selectId: selectId, _token: _token},
            dataType: 'json',
            success: function (res) {
                if (res.isIntOk === 1) {
                    $('#'+selectId).html(res.optionSelect);
                } else {
                    $('#'+selectId).html('');
                }
            }
        });

    },
    getAjaxOptionConfigSalary: function (object,type,selectId) {
        $('#'+selectId).html('');
        var _token = $('input[name="_token"]').val();
        var url_ajax = WEB_ROOT + '/manager/wageStepConfig/ajaxGetOption';
        var object_id = $('#'+object.id).val();
        $.ajax({
            type: "post",
            url: url_ajax,
            data: {object_id: object_id, type: type, selectId: selectId, _token: _token},
            dataType: 'json',
            success: function (res) {
                if (res.isIntOk === 1) {
                    if(type == 5){
                        $('#'+selectId).val(res.optionSelect);
                    }else {
                        $('#'+selectId).html(res.optionSelect);
                    }

                } else {
                    $('#'+selectId).html('');
                }
            }
        });

    },
    openDetailView: function () {
        $('.detailView').dblclick(function () {
            /*Quynhtm đóng lại vì mở 2 tab
            var url = $(this).attr( "data-action" );
            window.open(url);*/
        });
    },
    getAjaxCompany: function (element_click, company_id) {
        $(element_click).on('click', function (e) {
            e.preventDefault();
            const tab = $(this).data('tab');
            const checkTabContent = $('#' + tab).html();
            const functionAction = $(this).data('function-action');

            if (checkTabContent === '') {
                $('#loadingAjax').show();
                $.ajax({
                    url: WEB_ROOT + '/manager/company/edit/' + company_id + '/' + functionAction,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#loadingAjax').hide();
                        $('#' + tab).html(data.result);
                        $('#modal-bank-user .modal-content').html(data.modal);
                    },
                    error: function (error) {
                        $('#loadingAjax').hide();
                        console.log(error);
                    }
                });
            }
        });

    },
    getPhiPhatVaTongThuHomNay: function (repayment_id) {
        $('#loadingAjax').show();
        $.ajax({
            type: "POST",
            url: WEB_ROOT + '/manager/repayment/ajaxLoadPhiPhat',
            data: {repayment_id: repayment_id},
            responseType: 'json',
            success: function (data) {
                console.log(data.tong_phai_thu);
                $('#loadingAjax').hide();
                $('.line-tong_phai_thu_' + repayment_id).html(data.tong_phai_thu);
                $('.line-phi_phat-' + repayment_id).html(data.phi_phat);
                $('#modal-bank-user .modal-content').html(data.modal);
            },
            error: function (error) {
                $('#loadingAjax').hide();
                console.log(error);
            }
        });
    },
    getContractByPhone: function () {
        var phone = $("#phone").val();
        if(phone.length >= 9){
            $('#loadingAjax').show();
            $.ajax({
                type: "POST",
                url: WEB_ROOT + '/manager/transaction_loaner/ajaxLoadContract',
                data: {phone: phone},
                responseType: 'json',
                success: function (data) {
                    $('#loadingAjax').hide();
                    $('#contract_code_option')
                        .find('option')
                        .remove()
                        .end()
                        .append(JSON.parse(data).option)
                    ;
                    $('#loaner_name').val(JSON.parse(data).name.name)
                    $('#loaner_id').val(JSON.parse(data).name.loaner_id)
                },
                error: function (error) {
                    $('#loadingAjax').hide();
                    console.log("a");
                }
            });
        }
    },
    getLoanerByContractCode: function () {
        var contract = $("#contract_code_option").val();
            $('#loadingAjax').show();
            $.ajax({
                type: "POST",
                url: WEB_ROOT + '/manager/transaction_loaner/ajaxLoadLoaner',
                data: {contract: contract},
                responseType: 'json',
                success: function (data) {
                    $('#loadingAjax').hide();
                    $('#loaner_name').val(JSON.parse(data).name)
                    $('#loaner_id').val(JSON.parse(data).loaner_id)
                },
                error: function (error) {
                    $('#loadingAjax').hide();
                    console.log(error);
                }
            });
    },
    postAjaxCompany: function (dataPost) {
        var currentA = $('.listWalletAndBank li.active a');
        var tab = currentA.data('tab');
        $.ajax({
            url: WEB_ROOT + '/manager/company/ajax_post_data',
            type: 'POST',
            dataType: 'json',
            data: dataPost,
            beforeSend: function () {
                $('#loadingAjax').show();
            },
            success: function (data) {
                $('#loadingAjax').hide();
                if (data.error != undefined) {
                    $('#' + tab + ' .errors').html(data.error);
                    return;
                }
                $('#' + tab).html(data.result);
                window.location.href = WEB_ROOT + '/manager/company/edit/' + $('#id_hiden').val() + '?tab=' + $('.listWalletAndBank .active a.tab-toggle').data('tab-id');
            },
            error: function (err) {
                $('#loadingAjax').hide();
                console.log(err);
            }
        });
        $('#loadingAjax').hide();
        return true;
    },
    deleteAjaxCompany: function (action, id, target) {
        var dataPost = {
            action: action,
            id: id
        };
        console.log(dataPost);
        if (confirm('Bạn có muốn xoá ' + target + ' này không?')) {
            $.ajax({
                url: WEB_ROOT + '/manager/company/ajax_delete_data',
                type: 'POST',
                dataType: 'json',
                data: dataPost,
                success: function (data) {
                    if (data.isOk) {
                        alert('Bạn đã thực hiện thành công');
                        window.location.href = WEB_ROOT + '/manager/company/edit/' + $('#id_hiden').val() + '?tab=' + $('.listWalletAndBank .active a.tab-toggle').data('tab-id');
                    } else {
                        alert('Không thể thực hiện được thao tác.');
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
    },
    getAjaxBankInfo: function (element_select, url, data) {
        $(element_select).on('change', function (e) {
            e.preventDefault();
            var data = {
                field_get: ['define_name', 'define_note'],
                define_id: $(this).val()
            };

            if ($(this).val() === 0)  {
                $('#bank_name').val('');
                $('#bank_full_name').val('');
                return;
            }

            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                async: true,
                dataType: 'json',
                success: function (data) {
                    if (data != '') {
                        $('#bank_name').val(data.define_name);
                        $('#bank_full_name').val(data.define_note);
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            })
        });
    },
    getAjaxBankUserModal: function (element_click, _type) {
        $(element_click).on('click', function (e) {
            $('#loadingAjax').show();
            $.ajax({
                url: WEB_ROOT + '/manager/company/ajax_get_bank_user',
                type: 'POST',
                data: {id: $(this).data('id'), type: _type},
                success: function (data) {
                    $('#loadingAjax').hide();
                    $('#modal-bank-user .modal-content').html(data.result);
                },
                error: function (jqXHR, textStatus) {
                    $('#loadingAjax').hide();
                    console.log(textStatus);
                }
            })
        });
    },
    activeGuarantor: function (id, active, guarantor_name) {
        var action = active == 1 ? 'hoạt động' : 'khóa';
        if (confirm('Bằng việc Click OK, nhà đảm bảo ' + guarantor_name +' sẽ chuyển sang trạng thái ' + action + ' . Bạn đồng ý?')) {
            var _token = $('input[name="_token"]').val();
            var url_ajax = WEB_ROOT + '/manager/guarantor/ajax_lock_or_active_guarantor';
            if (url_ajax != '') {
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {id: id, _token: _token, status: active},
                    dataType: 'json',
                    success: function (res) {
                        if (res.isOK == 1) {
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
    activeMarketingProgram: function (id, active, guarantor_name) {
        var action = active == 1 ? 'hoạt động' : 'khóa';
        if (confirm('Bằng việc Click OK, chương trình khuyến mại ' + guarantor_name +' sẽ chuyển sang trạng thái ' + action + ' . Bạn đồng ý?')) {
            var _token = $('input[name="_token"]').val();
            var url_ajax = WEB_ROOT + '/manager/marketing_program/ajaxLockOrActive';
            if (url_ajax != '') {
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {id: id, _token: _token, status: active},
                    dataType: 'json',
                    success: function (res) {
                        $('#img_loading_' + id).hide();
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
    activeContentNotify: function (id, active, object_receive, career) {
        var action = active == 1 ? 'gửi' : 'hủy';
        if (confirm('Click kích hoạt thông báo là bạn đồng ý thực hiện ' + action + ' thông báo tới cho ' + object_receive + ' với sản phẩm vay là ' + career + '. Xác nhận?')) {
            var _token = $('input[name="_token"]').val();
            var url_ajax = WEB_ROOT + '/manager/content_notify/ajax_lock_or_active_content_notify';
            if (url_ajax != '') {
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {id: id, _token: _token, status: active},
                    dataType: 'json',
                    success: function (res) {
                        if (res.isOK == 1) {
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
    activeMarketingCoinPolicy: function (id, active) {
        var action = active == 1 ? 'kích hoạt' : 'khóa';
        if (confirm('Bạn có chắc ' + action + ' chính sách marketing tiêu và tích xu này không? Click OK để hoàn tất')) {
            var _token = $('input[name="_token"]').val();
            var url_ajax = WEB_ROOT + '/manager/marketing_coin_policy/ajaxLockOrActive';
            if (url_ajax != '') {
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {id: id, _token: _token, status: active},
                    dataType: 'json',
                    success: function (res) {
                        if (res.isOK == 1) {
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
    deleteItemInDetail: function (id, type) {
        if (confirm('Bạn có muốn xóa Item này không?')) {
            $('#img_loading_' + id).show();
            var _token = $('input[name="_token"]').val();
            var url_ajax = url_list = '';
            if (type == 1) {
                url_ajax = WEB_ROOT + '/manager/' + 'marketing_coin_policy/delete';
                url_list = WEB_ROOT + '/manager/' + 'marketing_coin_policy';
            }
            if (url_ajax != '') {
                $.ajax({
                    type: "post",
                    url: url_ajax,
                    data: {id: id, _token: _token},
                    dataType: 'json',
                    success: function (res) {
                        $('#img_loading_' + id).hide();
                        if (res.isIntOk == 1) {
                            alert('Bạn đã thực hiện thành công');
                            window.location.href = url_list;
                        } else {
                            alert('Không thể thực hiện được thao tác.');
                        }
                    }
                });
            }
        }
    },
    /**
     * QuynhTM
     * @param id
     * @param active
     */
    ajaxSearchBillAction: function (reason) {
        var _token = $('input[name="_token"]').val();
        var type_object = 0;
        var account_bank = '';
        var purpose_payment = $('#purpose_payment').val();
        if(reason == 1){//gửi
            type_object = $('#type_object_send').val();
            account_bank = $('#account_bank_send').val();
        }else if(reason == 2){//nhận
            type_object = $('#type_object_receive').val();
            account_bank = $('#account_bank_receive').val();
        }
        var url_ajax = WEB_ROOT + '/manager/guarantorBillExpenditure/ajaxSearchBillAction';
        if (url_ajax != '') {
            if(reason == 1){// bên gửi
                $('#object_name_send').val('');
                $('#object_id_send_hiden').val(0);
            }else if(reason == 2){// bên nhận
                $('#object_name_receive').val('');
                $('#object_id_receive_hiden').val(0);

                $('#contracts_id_hiden').val(0);
                $('#contracts_code').val('');
            }
            $('#load_bill_'+reason).show();
            $.ajax({
                type: "get",
                url: url_ajax,
                data: {_token: _token,
                    type_object: type_object,
                    account_bank: account_bank,
                    purpose_payment: purpose_payment,
                },
                dataType: 'json',
                success: function (res) {
                    $('#load_bill_'+reason).hide();
                    if (res.isOK == 1) {
                        if(reason == 1){// bên gửi
                            $('#object_name_send').val(res.data.object_name_send);
                            $('#object_id_send_hiden').val(res.data.object_id_send);
                        }else if(reason == 2){// bên nhận
                            $('#object_name_receive').val(res.data.object_name_receive);
                            $('#object_id_receive_hiden').val(res.data.object_id_receive);

                            $('#contracts_id_hiden').val(res.data.contracts_id);
                            $('#contracts_code').val(res.data.contracts_code);
                            $('#amount_money').val(res.data.amount_money);
                        }
                    } else {
                        alert('Không tồn tại thông tin tìm kiếm.');
                    }
                }
            });
        }
    },
    changeStatusBillExpenditure: function (id, status_change,object) {
        if (confirm('Bạn có muốn thay đổi trạng thái này không?')) {
            $('#img_loading_' + id).show();
            var _token = $('input[name="_token"]').val();
            var url_ajax = '';
            if (object == 3) {//NĐB
                url_ajax = WEB_ROOT + '/manager/guarantorBillExpenditure/ajaxChangeStatus';
            } else if (object == 4) {//VM
                url_ajax = WEB_ROOT + '/manager/companyBillExpenditure/ajaxChangeStatus';
            }
            if (Admin.checkSubmitForm != 0) {
                Admin.checkSubmitForm = 0;
                if (url_ajax != '') {
                    $.ajax({
                        type: "post",
                        url: url_ajax,
                        data: {id: id, _token: _token, status_change: status_change},
                        dataType: 'json',
                        success: function (res) {
                            $('#img_loading_' + id).hide();
                            if (res.isOK == 1) {
                                alert('Bạn đã thực hiện thành công');
                                window.location.reload();
                            } else {
                                alert(res.msg);
                            }
                        }
                    });
                }
            }
        }
    },
    /**
     * QuynhTM
     * @returns {boolean}
     */
    chuyenHdvGiaiNganTuDong: function () {
        if (confirm('Bạn có muốn thay đổi HDV này thành giải ngân tự đông?')) {
            var dataId = [];
            var i = 0;
            $("input[name*='checkLoanContract']").each(function () {
                if ($(this).is(":checked")) {
                    dataId[i] = $(this).val();
                    i++;
                }
            });
            if (dataId.length == 0) {
                alert('Bạn chưa chọn items để thao tác.');
                return false;
            }else if(dataId.length > 6) {
                alert('Bạn không được chọn quá 5 HĐV.');
                return false;
            }
            if(dataId.length <= 5){
                $('#loadingAjax').show();
                $.ajax({
                    type: "post",
                    url: WEB_ROOT + '/manager/loanContracts/moveContractToAutoDisburse',
                    data: {loanContractId: dataId},
                    dataType: 'json',
                    success: function (res) {
                        $('#loadingAjax').hide();
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
}
