var arr_ResultCode = ["NONE_PERMISSION", "NONE_VALID"];
var reg_email = /^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/;
var reg_phone_vn = /((09|03|07|08|05)+([0-9]{8})\b)/g;

//Init project
function Init() {
    $('.date-picker .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    $('.input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });

    $('.select2').select2();
    $('.chosen-select').chosen({ width: "100%" });

    $("input[data-fomat='currency']").on({
        keyup: function () {
            formatCurrencyChange($(this));
        },
        blur: function () {
            formatCurrencyChange($(this), "1");
        }
    });
    $("input[data-fomat='percent']").on({
        keyup: function () {
            formatPercentChange($(this));
        },
        blur: function () {
            formatPercentChange($(this), "1");
        }
    });
}

//function dang dùng
function showDataIntoForm(p_formName){
    var data_item = $('#' + p_formName).find('#data_item').val();
    json = JSON.parse(data_item)
    //hien thi text thong tin
    $('#' + p_formName).find('.showInforItem').each(function (index) {
        var label = $(this);
        label.text(json[label.attr("data-field")]);
    });
    $('#' + p_formName).find(':input').each(function (index) {
        var input = $(this);

        if (input.attr('type') != 'button' && input.attr('name') != 'temp_data' &&
            $.trim(input.attr('name')) != '' && input.attr('name') != typeof undefiend && this.id.indexOf(p_formName) != -1
        ) {
            if (input.attr('type') == 'checkbox') {
                input.attr('checked', json[input.attr('name')]);
            }
            else if (input.prop("nodeName") == 'SELECT') {
                if (json[input.attr('name')] != undefined && json[input.attr('name')] != "") {
                    if (input.hasClass('select2'))
                        input.val(json[input.attr('name')].toString()).trigger("change");
                    else if (input.hasClass('chosen-select'))
                        input.val(json[input.attr('name')].toString()).trigger('chosen:updated');
                    else
                        input.val(json[input.attr('name')].toString());
                }
            }
            else {
                if (input.attr("data-fomat") == "currency") {
                    input.val(formatCurrency(json[input.attr('name')]));
                }
                else {
                    input.val(json[input.attr('name')]);
                }
            }
        }
    });
}
function BindingData(p_formName, json) {
    $('#' + p_formName).find(':input').each(function (index) {
        var input = $(this);

        if (input.attr('type') != 'button' && input.attr('name') != 'temp_data' &&
            $.trim(input.attr('name')) != '' && input.attr('name') != typeof undefiend && this.id.indexOf(p_formName + '_') != -1
        ) {
            if (input.attr('type') == 'checkbox') {
                input.attr('checked', json[input.attr('name')]);
            }
            else if (input.prop("nodeName") == 'SELECT') {
                if (json[input.attr('name')] != undefined && json[input.attr('name')] != "") {
                    if (input.hasClass('select2'))
                        input.val(json[input.attr('name')].toString()).trigger("change");
                    else if (input.hasClass('chosen-select'))
                        input.val(json[input.attr('name')].toString()).trigger('chosen:updated');
                    else
                        input.val(json[input.attr('name')].toString());
                }
            }
            else {
                if (input.attr("data-fomat") == "currency") {
                    input.val(formatCurrency(json[input.attr('name')]));
                }
                else {
                    input.val(json[input.attr('name')]);
                }
            }
        }
    });
}
function GetToken(p_formName) {
    var form = $('#' + p_formName);
    var token = $('input[name="_token"]', form).val();
    return token;
}
function BaseValid(p_formName) {
    var inputData;
    var inputId;
    var result = true;

    $('#' + p_formName).find(':input').each(function () {
        inputData = $.trim($(this).attr('data-valid'));
        inputId = $(this).attr('id');

        if (typeof inputId != typeof undefiend && inputId.indexOf(p_formName + '_') != -1 && inputData != '' && typeof inputData != typeof undefiend) {
            if (inputData.indexOf('text') != -1) {
                if ($.trim($(this).val()) == '') {
                    showNotification('error', 'Bạn chưa nhập ' + this.title + '!');
                    $(this).focus();
                    result = false;
                    return false;
                }
            }
            else if (inputData.indexOf('email') != -1) {
                var val = $.trim($(this).val());
                if (val == '') {
                    showNotification('error', 'Bạn chưa nhập ' + this.title + '!');
                    $(this).focus();
                    result = false;
                    return false;
                }
                if (val != '' && !reg_email.test(String(val).toLowerCase())) {
                    showNotification('error', 'Địa chỉ email không đúng!');
                    $(this).focus();
                    result = false;
                    return false;
                }
            }
            else if (inputData.indexOf('phone') != -1) {
                var val = $.trim($(this).val());
                if (val == '') {
                    showNotification('error', 'Bạn chưa nhập ' + this.title + '!');
                    $(this).focus();
                    result = false;
                    return false;
                }

                if (val != '' && !reg_phone_vn.test(val)) {
                    showNotification('error', 'Số điện thoại không đúng!');
                    $(this).focus();
                    result = false;
                    return false;
                }
            }
        }
    });

    return result;
}

function BaseSave(p_url, p_formName, p_controlName, p_function_run, p_display, token) {
    var dataSent = '1=1&__RequestVerificationToken=' + token;
    var loi = true;

    $('#' + p_formName).find(':input').each(function (index) {
        var input = $(this);

        if (input.attr('type') != 'button' && input.attr('name') != 'temp_data' &&
            $.trim(input.attr('name')) != '' && input.attr('name') != typeof undefiend && this.id.indexOf(p_formName + '_') != -1
        ) {
            if (input.attr('type') == 'checkbox') {
                dataSent += '&' + input.attr('name') + '=' + input.is(":checked");
            }
            else {
                dataSent += '&' + input.attr('name') + '=' + input.val();//repaceSpecialString(input.val());
            }
        }
    });

    repaceAllSpecialString(dataSent);
    loadingForm(true);
    $.ajax({
        url: p_url + '?idrd=' + getRandomNumber(),
        type: "POST",
        data: dataSent,
        success: function (data) {
            loadingForm(false);
            if (data.ResultCode.indexOf('LOGIN_SUCCESS') != -1) {
                redirectLogin();
            }
            else if (data.ResultCode.indexOf('SUCCESS') != -1) {
                if (p_function_run != undefined && p_function_run != '')
                    processRefresh(p_function_run);
                if (p_display == null || p_display == true)
                    showNotification('success', 'Lưu thông tin thành công!');
                loi = false;
            }
            else if (data.ResultCode.indexOf('ERROR') != -1) {
                showNotification('error', data.ResultValue);
            }
            else if (data.ResultCode.indexOf('FAIL') != -1) {
                showNotification('error', 'Thực hiện không thành công!');
                //loi = true;
            }
            else if (data.ResultCode.indexOf('SESSION_IS_NULL') != -1)
                logout(false);
            //else if (data.ResultCode.indexOf('NONE_PERMISSION') != -1)
            else if (arr_ResultCode.indexOf(data.ResultCode) != -1) {
                showNotification('error', data.ResultValue);
            }
            else
                showNotification('error', data.ResultValue);
        },
        failure: function (errMsg) {
            loadingForm(false);
            showNotification('error', "Lỗi trong quá trình truyền nhận thông tin! " + errMsg);
        }
    });
    return loi;
}

// Common


function BaseDelete(url, p_function_run, token) {
    $('#modal_delete').modal('show');
    $('#btn_confirm_del').on('click', function (e) {
        loadingForm(true);
        //e.preventDefault();
        var dataSent = '__RequestVerificationToken=' + token;
        $.ajax({
            url: url,
            type: "POST",
            async: true,
            data: dataSent,
            success: function (data) {
                loadingForm(false);
                if (data.ResultCode.indexOf('SUCCESS') != -1) {
                    processRefresh(p_function_run);

                    showNotification('success', 'Xóa thông tin thành công!');
                    //return true;
                }
                else if (data.ResultCode.indexOf('SESSION_IS_NULL') != -1) {
                    logout(false);
                    return false;
                }
                else if (data.ResultCode.indexOf('ERROR') != -1) {
                    showNotification('error', data.ResultValue);
                }
                else if (arr_ResultCode.indexOf(data.ResultCode) != -1) {
                    showNotification('error', data.ResultValue);
                }
                else
                    showNotification('error', replacePreErrorString(data.ResultCode));
            },
            failure: function (errMsg) {
                loadingForm(false);
                showNotification('error', "Lỗi trong quá trình truyền nhận thông tin! " + errMsg);
                return false;
            }
        });
        $('#modal_delete').modal('hide');
    });
}

function BaseExport(p_url, p_formName, token) {

    var dataSent = '1=1&__RequestVerificationToken=' + token;
    var loi = true;
    $('#' + p_formName).find(':input').each(function (index) {
        var input = $(this);

        if (input.attr('type') != 'button' && input.attr('name') != 'temp_data' &&
            $.trim(input.attr('name')) != '' && input.attr('name') != typeof undefiend && this.id.indexOf(p_formName + '_') != -1
        ) {
            if (input.attr('type') == 'checkbox') {
                dataSent += '&' + input.attr('name') + '=' + input.is(":checked");
            }
            else {
                dataSent += '&' + input.attr('name') + '=' + input.val();//repaceSpecialString(input.val());
            }
        }
    });

    repaceAllSpecialString(dataSent);
    loadingForm(true);
    $.ajax({
        url: p_url + '?idrd=' + getRandomNumber(),
        type: "POST",
        data: dataSent,
        async: false,
        success: function (data) {
            loadingForm(false);
            if (data.ResultCode.indexOf('LOGIN_SUCCESS') != -1) {
                redirectLogin();
            }
            else if (data.ResultCode.indexOf('SUCCESS') != -1) {
                showNotification('success', 'Xuất thông tin thành công!');
                window.open(data.ResultValue);

            }
            else if (data.ResultCode.indexOf('ERROR') != -1) {
                showNotification('error', data.ResultValue);
            }
            else if (data.ResultCode.indexOf('FAIL') != -1) {
                showNotification('error', 'Thực hiện không thành công!');
                //loi = true;
            }
            else if (data.ResultCode.indexOf('SESSION_IS_NULL') != -1)
                logout(false);
            //else if (data.ResultCode.indexOf('NONE_PERMISSION') != -1)
            else if (arr_ResultCode.indexOf(data.ResultCode) != -1) {
                showNotification('error', data.ResultValue);
            }
            else
                showNotification('error', data.ResultValue);
        },
        failure: function (errMsg) {
            loadingForm(false);
            showNotification('error', "Lỗi trong quá trình truyền nhận thông tin! " + errMsg);
        }
    });
    return loi;
}

function doLogin(p_url, p_formName) {//, captcha) {
    var dataSent = '1=1';
    //if (captcha != '' && captcha != null && captcha != typeof undefiend) {
    //    dataSent += '&g-recaptcha-response=' + captcha;
    //}

    $('#' + p_formName).find(':input').each(function (index) {
        var input = $(this);
        if (input.attr('type') != 'button' && input.attr('name') != 'temp_data' &&
            $.trim(input.attr('name')) != '' && input.attr('name') != typeof undefiend)
            if (input.attr('type') == 'checkbox') {
                dataSent += '&' + input.attr('name') + '=' + input.is(":checked");
            }
            else {
                dataSent += '&' + input.attr('name') + '=' + input.val();
            }
    });

    repaceAllSpecialString(dataSent);
    loadingForm(true);

    $.ajax({
        url: p_url + '?idrd=' + getRandomNumber(),
        type: "POST",
        data: dataSent,
        success: function (data) {
            loadingForm(false);
            if (data.ResultCode.indexOf('SUCCESS') != -1) {
                setTimeout(function () {
                    redirect(data.ResultValue);
                }, 1000);
                redirect('/Home/Index');
                return true;
            }
            else if (data.ResultCode.indexOf('ERROR') != -1) {
                showNotification('error', data.ResultValue);
            }

            else {
                showNotification('error', 'Thực hiện không thành công!');
            }
        },
        failure: function (errMsg) {
            loadingForm(false);
            showNotification('error', "Lỗi trong quá trình truyền nhận thông tin! " + errMsg);
        }
    });
    return false;
}

function getDataJsonAjax(url) {
    var json_kq;
    $.ajax({
        type: "POST",
        url: url,
        //   data: formData,
        async: false,
        success: function (data) {
            if (data.resultmessage.indexOf('SUCCESS') != -1) {
                json_kq = JSON.parse(data.resultlist);
            }
            else
                showNotification('error', replacePreErrorString(data.resultmessage));
            //alert(replacePreErrorString(data.resultmessage));
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return json_kq;

}

function GetData(o) {
    var newO, origKey, newKey, value
    if (o instanceof Array) {
        return o.map(function (value) {
            if (typeof value === "object") {
                value = toCamel(value)
            }
            return value
        })
    } else {
        newO = {}
        for (origKey in o) {
            if (o.hasOwnProperty(origKey)) {
                newKey = origKey.toLowerCase();
                value = o[origKey]
                if (value instanceof Array || (value !== null && value.constructor === Object)) {
                    value = toCamel(value)
                }
                newO[newKey] = value
            }
        }
    }
    return newO


}

function showNotification(type, mess) {
    if (type == 'error')
        toastr.error(mess);
    else if (type == 'success')
        toastr.success(mess);
    else
        toastr.error('Type Notify Error');
}

function loadingForm(status) {
    try {
        if (status) {
            $('#div_loadingContent').show();
            var width = $('#div_loadingContent').width();
            var height = $('#div_loadingContent').height();
            var width1 = $('#loadingContent').width();
            var height1 = $('#loadingContent').height();
            $('#loadingContent').css('margin-left', (width - width1) / 2 + 'px');
            $('#loadingContent').css('margin-top', (height - height1) / 2 + 'px');
        }
        else
            $('#div_loadingContent').hide();
    } catch (Exception) {
        alert('Lỗi loading');
    }
}

function redirectLogin(url) {
    window.location.replace(window.location.origin + 'Account/Index');
}

function redirect(url) {
    window.location.replace(window.location.origin + url);
}

function logout(question) {
    if (question) if (!window.confirm('Bạn thật sự muốn thoát khỏi chương trình?')) return;
    window.location = appPath + 'Account/LogoutCMS';
}

function processRefresh(function_run) {
    if (typeof function_run != 'undefined' && function_run != '') {
        temp = function_run;
        eval(temp);
    }
}

function getRandomNumber() {
    return Math.floor(Math.random() * 100000);
}

function repaceSpecialString(data) {
    var temp = data;

    if (data != null && data != undefined && data != '') {
        temp = temp.replace(/'/g, "");
        temp = temp.replace(/\?/g, "QUESTM");
        temp = temp.replace(/\+/g, "PLUSM");
        temp = temp.replace(/&/g, "JOINM");

        temp = temp.replace(/[&\\\#+$~'?{}]/g, ' ');
        temp = temp.replace(/(<([^>]+)>)/ig, "");
        temp = temp.replace(/NaN/g, "");
    }

    return temp;
}

function repaceAllSpecialString(data) {
    var temp = '';
    if (data != null) {
        temp = data.split("'").join('');
        //temp = temp.replace('?', 'QUESTM');
        temp = temp.replace('+', 'PLUSM');
        //temp = temp.replace('&', 'JOINM');
        temp = temp.replace(/[_\W]+/g, " ");
        temp = temp.replace(/NaN/g, "");
    }
    return temp;
}

function LoadData(block, pageIndex, params, url) {
    //ReloadDataNoneIcon(block);
    loadingForm(true);
    params.PageIndex = pageIndex;
    $.ajax({
        type: "POST",
        url: url,
        dataType: "html",
        data: params,
        success: function (data) {
            $(block).html(data);
            //$(block).unblock();
            loadingForm(false);
            $(block + ' .datatable-footer .dataTables_paginate .previous').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('disabled');
                if (!hClass) {
                    var currentPage = $(block + ' .datatable-footer .dataTables_paginate span .paginate_button.current').html();
                    var page = parseInt(currentPage);
                    LoadData(block, page - 1, params, url);
                }
            });
            $(block + ' .datatable-footer .dataTables_paginate .next').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('disabled');
                if (!hClass) {
                    var currentPage = $(block + ' .datatable-footer .dataTables_paginate span .paginate_button.current').html();
                    var page = parseInt(currentPage);
                    LoadData(block, page + 1, params, url);
                }
            });
            $(block + ' .datatable-footer .dataTables_paginate span .paginate_button').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('current');
                if (!hClass) {
                    LoadData(block, $this.html(), params, url);
                }
            });
        }
    });
}

function LoadHtml(block, p_formName, pageIndex, url) {
    var dataSent = 'pageIndex=' + pageIndex;
    if (typeof (p_formName) != typeof (undefined) && p_formName != '') {
        $('#' + p_formName).find(':input').each(function (index) {
            var input = $(this);

            if (input.attr('type') != 'button' && input.attr('name') != 'temp_data' &&
                $.trim(input.attr('name')) != '' && input.attr('name') != typeof undefiend && this.id.indexOf(p_formName + '_') != -1
            ) {
                if (input.attr('type') == 'checkbox') {
                    dataSent += '&' + input.attr('name') + '=' + input.is(":checked");
                }
                else {
                    dataSent += '&' + input.attr('name') + '=' + input.val();//repaceSpecialString(input.val());
                }
            }
        });
    }
    repaceAllSpecialString(dataSent);
    loadingForm(true);
    $.ajax({
        type: "POST",
        url: url,// + '?idrd=' + getRandomNumber(),
        dataType: "html",
        data: dataSent,
        //async: false,
        success: function (data) {
            $('#' + block).html(data);
            Init();
            loadingForm(false);
            $('#' + block + ' .datatable-footer .dataTables_paginate .previous').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('disabled');
                if (!hClass) {
                    var currentPage = $('#' + block + ' .datatable-footer .dataTables_paginate span .paginate_button.current').html();
                    var page = parseInt(currentPage);
                    LoadHtml(block, p_formName, page - 1, url);
                }
            });
            $('#' + block + ' .datatable-footer .dataTables_paginate .next').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('disabled');
                if (!hClass) {
                    var currentPage = $('#' + block + ' .datatable-footer .dataTables_paginate span .paginate_button.current').html();
                    var page = parseInt(currentPage);
                    LoadHtml(block, p_formName, page + 1, url);
                }
            });
            $('#' + block + ' .datatable-footer .dataTables_paginate span .paginate_button').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('current');
                if (!hClass) {
                    LoadHtml(block, p_formName, $this.html(), url);
                }
            });
        }
    });
}

function LoadHtmlNotAsync(block, p_formName, pageIndex, url) {
    var dataSent = 'pageIndex=' + pageIndex;
    if (typeof (p_formName) != typeof (undefined) && p_formName != '') {
        $('#' + p_formName).find(':input').each(function (index) {
            var input = $(this);

            if (input.attr('type') != 'button' && input.attr('name') != 'temp_data' &&
                $.trim(input.attr('name')) != '' && input.attr('name') != typeof undefiend && this.id.indexOf(p_formName + '_') != -1
            ) {
                if (input.attr('type') == 'checkbox') {
                    dataSent += '&' + input.attr('name') + '=' + input.is(":checked");
                }
                else {
                    dataSent += '&' + input.attr('name') + '=' + input.val();//repaceSpecialString(input.val());
                }
            }
        });
    }
    repaceAllSpecialString(dataSent);
    loadingForm(true);
    $.ajax({
        type: "POST",
        url: url,// + '?idrd=' + getRandomNumber(),
        dataType: "html",
        data: dataSent,
        async: false,
        success: function (data) {
            $('#' + block).html(data);
            loadingForm(false);
            $('#' + block + ' .datatable-footer .dataTables_paginate .previous').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('disabled');
                if (!hClass) {
                    var currentPage = $('#' + block + ' .datatable-footer .dataTables_paginate span .paginate_button.current').html();
                    var page = parseInt(currentPage);
                    LoadHtml(block, p_formName, page - 1, url);
                }
            });
            $('#' + block + ' .datatable-footer .dataTables_paginate .next').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('disabled');
                if (!hClass) {
                    var currentPage = $('#' + block + ' .datatable-footer .dataTables_paginate span .paginate_button.current').html();
                    var page = parseInt(currentPage);
                    LoadHtml(block, p_formName, page + 1, url);
                }
            });
            $('#' + block + ' .datatable-footer .dataTables_paginate span .paginate_button').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('current');
                if (!hClass) {
                    LoadHtml(block, p_formName, $this.html(), url);
                }
            });
        }
    });
}

function LoadHtmlAppen(block, p_formName, pageIndex, url) {
    var dataSent = 'pageIndex=' + pageIndex;
    if (typeof (p_formName) != typeof (undefined) && p_formName != '') {
        $('#' + p_formName).find(':input').each(function (index) {
            var input = $(this);

            if (input.attr('type') != 'button' && input.attr('name') != 'temp_data' &&
                $.trim(input.attr('name')) != '' && input.attr('name') != typeof undefiend && this.id.indexOf(p_formName + '_') != -1
            ) {
                if (input.attr('type') == 'checkbox') {
                    dataSent += '&' + input.attr('name') + '=' + input.is(":checked");
                }
                else {
                    dataSent += '&' + input.attr('name') + '=' + repaceSpecialString(input.val());
                }
            }
        });
    }
    repaceAllSpecialString(dataSent);
    loadingForm(true);
    $.ajax({
        type: "POST",
        url: url,// + '?idrd=' + getRandomNumber(),
        dataType: "html",
        data: dataSent,
        //async: false,
        success: function (data) {
            $('#' + block).append(data);
            Init();

            loadingForm(false);
            $('#' + block + ' .datatable-footer .dataTables_paginate .previous').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('disabled');
                if (!hClass) {
                    var currentPage = $('#' + block + ' .datatable-footer .dataTables_paginate span .paginate_button.current').html();
                    var page = parseInt(currentPage);
                    LoadHtml(block, p_formName, page - 1, url);
                }
            });
            $('#' + block + ' .datatable-footer .dataTables_paginate .next').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('disabled');
                if (!hClass) {
                    var currentPage = $('#' + block + ' .datatable-footer .dataTables_paginate span .paginate_button.current').html();
                    var page = parseInt(currentPage);
                    LoadHtml(block, p_formName, page + 1, url);
                }
            });
            $('#' + block + ' .datatable-footer .dataTables_paginate span .paginate_button').click(function () {
                var $this = $(this);
                var hClass = $this.hasClass('current');
                if (!hClass) {
                    LoadHtml(block, p_formName, $this.html(), url);
                }
            });
        }
    });
}

function ClearData(p_name, p_arrFieldNotReset, arrNotChange) {

    // Du lieu truoc khi reset
    if (p_arrFieldNotReset != '' && typeof (p_arrFieldNotReset) != undefined && p_arrFieldNotReset != undefined) {
        var temp2 = '';
        var strValuePreReset = '';
        var arrFieldNotReset = p_arrFieldNotReset.split(',');
        for (var i = 0; i < arrFieldNotReset.length; i++) {
            if (i < arrFieldNotReset.length - 1)
                strValuePreReset = strValuePreReset + $('#' + p_name + '_' + $.trim(arrFieldNotReset[i])).val() + ',';
            else
                strValuePreReset = strValuePreReset + $('#' + p_name + '_' + $.trim(arrFieldNotReset[i])).val();
        }
    }
    // Clear element
    $('#' + p_name).find(':input').each(function () {
        switch (this.type) {
            case 'select':
            case 'select-multiple':
            case 'select-one':
                $(this).val($("#" + this.id + " option:first").val());
                break;
            case 'text':
            case 'number':
            case 'textarea':
            case 'password':
            case 'hidden':
                $(this).val('');
                break;
            //case 'hidden':
            //    if ((typeof restHidden == typeof undefined) || restHidden)
            //        $(this).val('');
            //    break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }

        if ($(this).hasClass('select2') && ((typeof arrNotChange != typeof undefined && arrNotChange.indexOf($(this).attr('name'))) == -1 || typeof arrNotChange == typeof undefined)) {
            $(this).trigger('change');
        }

        if ($(this).hasClass('chosen-select') && ((typeof arrNotChange != typeof undefined && arrNotChange.indexOf($(this).attr('name'))) == -1 || typeof arrNotChange == typeof undefined)) {
            $(this).trigger('chosen:updated');
        }
    });

    // Gan lai du lieu cho cac truong khong reset
    if (p_arrFieldNotReset != '' && typeof (p_arrFieldNotReset) != undefined && p_arrFieldNotReset != undefined) {
        var arrValuePreReset = strValuePreReset.split(',');
        for (var i = 0; i < arrFieldNotReset.length; i++) {
            $('#' + p_name + '_' + $.trim(arrFieldNotReset[i])).val($.trim(arrValuePreReset[i]));
        }
    }
}

function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function formatCurrencyChange(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.
    var minus = '';
    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "" || input_val === "-") { return; }

    if (parseFloat(input_val) < 0) minus = '-';

    // original length
    var original_len = input_val.length;

    // initial caret position
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "1") {
            right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = left_side + "." + right_side;

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = input_val;

        // final formatting
        if (blur === "1") {
            input_val += ".00";
        }
    }
    input_val = minus + input_val;
    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

function formatCurrency(amount) {
    try {
        var sacle = 2;
        var decimalCount = sacle;
        var decimal = ".";
        var thousands = ",";
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        amount = Math.floor(Math.abs(Number(amount) || 0) * Math.pow(10, sacle)) / Math.pow(10, sacle);
        let i = parseInt(amount).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
        console.log(e)
    }
};

function GetValueCurrency(input) {
    const regex = /,/gi;
    input = input.toString().replace(regex, '');
    input = formatCurrency(input);
    return parseFloat(input.toString().replace(regex, ''));
}

function formatPercentChange(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.

    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") { return; }

    // original length
    var original_len = input_val.length;

    // initial caret position
    var caret_pos = input.prop("selectionStart");


    // check for decimal
    if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = right_side.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "");
        //right_side = formatNumber(right_side);

        // On blur make sure 6 numbers after decimal
        if (blur === "1") {
            //right_side += "000000";
        }

        // Limit decimal to only 6 digits
        right_side = right_side.substring(0, 6);

        // join number by .
        input_val = left_side + "." + right_side;

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = input_val;

        // final formatting
        if (blur === "1") {
            //input_val += ".000000";
        }
    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

function formatPercent(amount) {
    try {
        var sacle = 6;
        var decimalCount = sacle;
        var decimal = ".";
        var thousands = ",";
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? sacle : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        amount = Math.floor(Math.abs(Number(amount) || 0) * Math.pow(10, sacle)) / Math.pow(10, sacle);//toFixed(decimalCount)
        let i = parseInt(amount).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
        console.log(e)
    }
};

function GetValuePercent(input) {
    const regex = /,/gi;
    input = input.toString().replace(regex, '');
    input = formatPercent(input);
    return parseFloat(input.toString().replace(regex, ''));
}

function RoundData(value, percision) {
    if (percision == undefined || percision == '' || percision == 0) {
        percision = 1;
        return value;
    }
    else {
        var data = Math.pow(10, percision);
        //return Math.round(value / data) * data;
        return parseFloat(value).toFixed(percision);
    }
}

//menu
function ActiveNavigation() {
    var pathName = window.location.pathname + window.location.search;
    if (pathName === '#' || pathName === '')
        return;

    var findPathname = $('.nav-sidebar').find("li a[href='" + pathName + "']");
    //findPathname.addClass('active');

    findPathname.parents('li').addClass('menu-open').children('a').addClass('active');
    if (findPathname.parents('li').length >= 3) {
        var _this = findPathname;
        for (var i = findPathname.parents('li').length - 1; i > 1; i--) {
            _this = _this.parent('li').parent('ul').parent('li');
            console.log(1, _this);

            _this.children('a').css("background-color", "gray");
            //findPathname.parents('li')[i].children('a').css("background-color", "gray");
        }
    }
    findPathname.parents('ul').css('display', 'block');
}



// get data table

function GetDataTable(p_table) {
    // get data table
    var $rows = $('#' + p_table).find('tr:not(:hidden)');
    var $tds = $('#' + p_table).find('td:not(:hidden)');
    var headers = [];
    var data = [];

    $rows.find('th:not(:empty)').each(function () {
        var text = $(this).attr('data-name');
        headers.push(text);//.text().toLowerCase());
    });

    $rows.each(function () {
        var $td = $(this).find('td');
        var $td2 = $td.find('input');
        var $td3 = $td.find('select');
        var h2 = {};
        // Use the headers from earlier to name our hash keys
        headers.forEach(function (header, i) {
            //if (header > 0)
            h2[header] = $td.eq(i).find('input,select').val();// || $td.eq(i + 1).attr('data-menu');//.text();
        });
        data.push(h2);
    });
    return data;
}

function QuyDoiTienTe(tien, tyLe) {
    tien = (tien == undefined) || (tien == '') ? 0 : GetValueCurrency(tien);
    tyLe = (tyLe == undefined) || (tyLe == '') ? 0 : GetValuePercent(tyLe);
    return formatCurrency(tien * tyLe);
}
