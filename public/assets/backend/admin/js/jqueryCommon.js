$(document).ready(function () {
    $(".sys_show_popup_common").on('click', function () {
        var objectId = $(this).attr('data-objectId');
        var title = $(this).attr('title');
        var _token = $('input[name="_token"]').val();

        var viewHtml = $(this).attr('data-show');//0: popup nhỏ, 1: popup to, 2: hiển thị trong html
        var divShow = $(this).attr('data-div-show');
        var url = $(this).attr('data-url');
        var method = $(this).attr('data-method');
        var formName = $(this).attr('data-form-name');
        var dataInput = $(this).attr('data-input');

        //$('#loader').show();
        $.ajax({
            dataType: 'json',
            type: method,
            url: url,
            data: {
                '_token': _token,
                'objectId': objectId,
                'titlePopup': title,
                'dataInput': dataInput,
                'formName': formName
            },
            success: function (res) {
                $('#loader').hide();
                if (res.success == 1) {
                    if (viewHtml == 2) {
                        $('#' + divShow).html(res.html);
                        jqueryCommon.showContentRightPage();
                    } else {
                        $('#sys_showPopupCommon').modal('show');
                        if (parseInt(viewHtml) == 1) {
                            $(".modal-dialog").addClass("modal-lg");
                        }
                        $('#sys_show_infor').html(res.html);
                    }
                } else {
                    jqueryCommon.showMsgError(res.success, res.message);
                }
            }
        });
    });
    $('.detailCommon').dblclick(function () {
        jqueryCommon.getDetailCommonByAjax(this);
    });
    $(".sys_delete_item_common").on('click', function () {
        var _token = $('input[name="_token"]').val();
        var url = $(this).attr('data-url');
        var method = $(this).attr('data-method');
        var dataInput = $(this).attr('data-input');
        var title = $(this).attr('title');
        jqueryCommon.isConfirm(title).then((confirmed) => {
            $.ajax({
                dataType: 'json',
                type: method,
                url: url,
                data: {
                    '_token': _token,
                    'dataInput': dataInput,
                },
                success: function (res) {
                    $('#loadingAjax').hide();
                    if (res.success == 1) {
                        jqueryCommon.showMsg('success', res.message);
                        location.reload();
                    } else {
                        jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.message);
                    }
                }
            });
        });
    });

    jQuery('.formatMoney').autoNumeric('init');

    //QuynhTM add edit block right
    $(".btn-search-right").click((function () {
        $(".div-parent-background").toggleClass("div-parent-open");
        $(".area-btn-right").addClass("btn-click");
    }));
    $(".btn-edit-right").click((function () {
        $(".btn-close-search-list").addClass("btn-click");
    }));
    //đóng block right
    $(".btn-close-search-list").click((function () {
        $(".div-parent-background").removeClass("div-parent-open");
        $(".div-block-right").removeClass("div-block-width-big");
        $(".area-btn-right").removeClass("btn-click");
    }));
    //End QuynhTM

    //tim kiem
    var config = {
        '.chosen-select'           : {width: "100%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
});

var jqueryCommon = {
    getDetailCommonByAjax: function (obj) {
        var objectId = $(obj).attr('data-objectId');
        var title = $(obj).attr('title');
        var _token = $('input[name="_token"]').val();

        var viewHtml = $(obj).attr('data-show');//0: popup nhỏ, 1: popup to, 2: hiển thị trong html
        var divShow = $(obj).attr('data-div-show');
        var url = $(obj).attr('data-url');
        var method = $(obj).attr('data-method');
        var formName = $(obj).attr('data-form-name');
        var dataInput = $(obj).attr('data-input');

        //get data other
        var functionAction = $(obj).attr('data-function-action');
        var loading = $(obj).attr('data-loading');//1: right detail: 2: other detail
        if (loading == 2) {
            $('#loaderRight').show();
        } else {
            $('#loader').show();
        }

        $.ajax({
            dataType: 'json',
            type: method,
            url: url,
            data: {
                '_token': _token,
                'objectId': objectId,
                'titlePopup': title,
                'dataInput': dataInput,
                'formName': formName,
                'functionAction': functionAction
            },
            success: function (res) {
                if (loading == 2) {
                    $('#loaderRight').hide();
                } else {
                    $('#loader').hide();
                }
                if (res.success == 1) {
                    if (loading == 2) {
                        $('#' + divShow).html(res.html);
                        jqueryCommon.showContentOtherRightPage();
                    } else {
                        $('#' + divShow).html(res.html);
                        jqueryCommon.showContentRightPage();
                    }
                    if (viewHtml != 2) {
                        $('#sys_showPopupCommon').modal('show');
                        if (parseInt(viewHtml) == 1) {
                            $(".modal-dialog").addClass("modal-lg");
                        }
                        $('#sys_show_infor').html(res.html);
                    }
                } else {
                    jqueryCommon.showMsgError(res.success, res.message);
                }
            }
        });
    },
    /**Function common**/
    getDataByAjax: function (obj) {
        var objectId = $(obj).attr('data-objectId');
        var title = $(obj).attr('title');
        var _token = $('input[name="_token"]').val();

        var viewHtml = $(obj).attr('data-show');//0: popup nhỏ, 1: popup to, 2: hiển thị trong html
        var divShow = $(obj).attr('data-div-show');
        var url = $(obj).attr('data-url');
        var method = $(obj).attr('data-method');
        var formName = $(obj).attr('data-form-name');
        var dataInput = $(obj).attr('data-input');
        var loadPage = $(obj).attr('data-load-page');//0 không load lại page, 1: có load lại
        var functionAction = $(obj).attr('data-function-action');
        var loading = $(obj).attr('data-loading');//1: right detail: 2: other detail
        if (loading == 2) {
            //$('#loaderRight').show();
        } else {
            //$('#loader').show();
        }
        $.ajax({
            dataType: 'json',
            type: method,
            url: url,
            data: {
                '_token': _token,
                'objectId': objectId,
                'titlePopup': title,
                'loadPage': loadPage,
                'dataInput': dataInput,
                'formName': formName,
                'functionAction': functionAction
            },
            success: function (res) {
                if (loading == 2) {
                    $('#loaderRight').hide();
                } else {
                    $('#loader').hide();
                }
                if (res.success == 1) {
                    if (res.loadPage == 1) {
                        location.reload();
                    } else {
                        if (viewHtml == 2) {
                            $('#' + divShow).html(res.html);
                            jqueryCommon.showContentRightPage();
                        } else {
                            $('#sys_showPopupCommon').modal('show');
                            if (parseInt(viewHtml) == 0) {
                                $(".modal-dialog").removeClass("modal-lg");
                            }
                            $('#sys_show_infor').html(res.html);
                        }
                    }
                } else {
                    jqueryCommon.showMsgError(res.success, res.message);
                }
            }
        });
    },
    doSubmitForm: function () {
        var url_action = $('#url_action').val();
        var form_id = $('#formName').val();
        var load_page = $('#load_page').val();
        var isFormFile = $('#isFormFile').val();

        if (!jqueryCommon.getFormValidation(form_id, 2)) return;
        var dataForm = jqueryCommon.getDataFormObj(form_id);
        var _token = $('input[name="_token"]').val();

        //check ngày tháng
        var startDate = $('#' + form_id + '_EFFECTIVE_DATE').val();
        var endDate = $('#' + form_id + '_EXPIRATION_DATE').val();
        if (startDate != '' && endDate != '') {
            var checkDate = jqueryCommon.compareDate(startDate, endDate);
            if (checkDate) {
                jqueryCommon.showMsg('error', '', 'Thông báo lỗi', 'Ngày hết hạn phải lớn hơn ngày áp dụng');
                return;
            }
        }
        //$('#loaderRight').show();
        $('.submitFormItem').prop("disabled", true);
        if(parseInt(isFormFile) == 1){
            var form = $('#'+form_id)[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: url_action,
                data: data,
                dataForm: dataForm,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (res) {
                    $('#loaderRight').hide();
                    $('.submitFormItem').prop("disabled", false);
                    jqueryCommon.showMsg('success', res.message);
                    if (load_page == 1 || res.loadPage == 1) {
                        //location.reload();
                    } else {
                        $('#' + res.divShowInfor).html(res.html);
                    }
                },
                error: function (e) {
                    $('.submitFormItem').prop("disabled", false);
                    console.log("ERROR : ", e);
                }
            });
        }else {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: url_action,
                data: {
                    '_token': _token,
                    'dataForm': dataForm,
                },
                success: function (res) {
                    $('#loaderRight').hide();
                    $('.submitFormItem').prop("disabled", false);
                    if (res.success == 1) {
                        jqueryCommon.showMsg('success', res.message);
                        if (load_page == 1 || res.loadPage == 1) {
                            location.reload();
                        } else {
                            $('#' + res.divShowInfor).html(res.html);
                            //jqueryCommon.cancelUpdateFormItem();
                        }
                    } else {
                        $('.submitFormItem').prop("disabled", false);
                        jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.message);
                    }
                }
            });
        }
    },
    compareDate: function (startDate, endDate) {
        // date = 'd/m/Y'
        if (startDate != undefined) {
            job_startDate = startDate.split('/');
            job_endDate = endDate.split('/');

            var new_start_date = new Date(job_startDate[2], job_startDate[1], job_startDate[0]);
            var new_end_date = new Date(job_endDate[2], job_endDate[1], job_endDate[0]);
            if (new_end_date < new_start_date) {
                return true;
            }
        }
    },

    doActionPopup: function (form_name, url_action) {
        var form_id = 'form_' + form_name;
        if (!jqueryCommon.getFormValidation(form_name, 1)) return;
        var dataForm = jqueryCommon.getDataFormObj(form_id);
        var msg = 'Bạn có chắc chắc cập nhật thông tin này?';
        $('#loaderPopup').show();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: url_action,
            data: {
                '_token': _token,
                'dataForm': dataForm,
            },
            success: function (res) {
                $('#loaderPopup').hide();
                if (res.success == 1) {
                    $('#sys_showPopupCommon').modal('hide');
                    jqueryCommon.showMsg('success', res.message);
                    if (res.loadPage == 1) {
                        location.reload();
                    } else {
                        $('#' + res.divShowInfor).html(res.html);
                    }
                } else {
                    jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.message);
                }
            }
        });
    },
    clickEditBlock: function (obj) {
        var blockShow = $(obj).attr('data-block');
        var dataShow = $('#show_block_' + blockShow).val();
        var div_infor = $(obj).attr('data-infor');
        var div_edit = $(obj).attr('data-edit');
        if (dataShow == 0) {
            $("." + div_edit).addClass('display-none-block');
            $("." + div_infor).removeClass('display-none-block');
            $('#show_block_' + blockShow).val(1);
        } else {
            $("." + div_infor).addClass('display-none-block');
            $("." + div_edit).removeClass('display-none-block');
            $('#show_block_' + blockShow).val(0);
        }
    },
    clickShowEditFormItem: function () {
        $(".submitFormItem").removeClass('display-none-block');
        $(".formInforItem").addClass('display-none-block');
        $(".formEditItem").removeClass('display-none-block');
        $(".cancelUpdate").removeClass('display-none-block');
    },
    clickShowFormChildElement: function (id, divShow, button_id) {
        $(".tr_data").addClass('display-none-block');
        $("#" + divShow + id).removeClass('display-none-block');
        $('#' + button_id).attr('disabled', 'disabled');
    },
    submitFormChildElement: function (form_name, url_action) {
        var form_id = 'form_' + form_name;
        if (!jqueryCommon.getFormValidation(form_name, 2)) return;
        var dataForm = jqueryCommon.getDataFormObj(form_name);
        var msg = 'Bạn có chắc chắc cập nhật thông tin này?';
        //$('#loaderRight').show();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: url_action,
            data: {
                '_token': _token,
                'dataForm': dataForm,
            },
            success: function (res) {
                $('#loaderRight').hide();
                if (res.success == 1) {
                    jqueryCommon.showMsg('success', res.message);
                    if(res.loadPage ==  1){
                        location.reload();
                    }else {
                        $('#' + res.divShowAjax).html(res.html);
                    }
                } else {
                    jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.message);
                }
            }
        });
    },

    clickHideFormChildElement: function (id, divShow, button_id) {
        $(".tr_data").addClass('display-none-block');
        $("#" + divShow + id).addClass('display-none-block');
        $('#' + button_id).removeAttr("disabled");
    },
    cancelUpdateFormItem: function () {
        $(".submitFormItem").addClass('display-none-block');
        $(".formInforItem").removeClass('display-none-block');
        $(".formEditItem").addClass('display-none-block');
        $(".cancelUpdate").addClass('display-none-block');
    },
    hideContentRightPage: function () {
        $(".div-parent-background").removeClass("div-parent-open");
        $(".div-block-right").removeClass("div-block-width-big");
        $(".content-search-page").removeClass("display-none-block");
        $("#content-page-right").html('');
        $(".area-btn-right").removeClass("btn-click");
        $(".btn-close-search-list").removeClass("btn-click");
        //location.reload();
    },
    showContentRightPage: function () {
        $(".div-parent-background").toggleClass("div-parent-open");
        $(".div-block-right").addClass("div-block-width-big");
        $(".content-search-page").addClass("display-none-block");
        $(".area-btn-right").addClass("btn-click");
        $(".btn-close-search-list").addClass("btn-click");
    },
    //show layout other
    showContentOtherRightPageLayout: function () {
        $("#content-other-right").removeClass("display-none-block");
        $(".div-other-background").toggleClass("div-parent-other-open");
        $(".div-other-right").addClass("div-block-width-item-big");
    },
    hideContentOtherRightPageLayout: function () {
        $(".div-other-background").removeClass("div-parent-other-open");
        $(".div-other-right").removeClass("div-block-width-item-big");
        $("#content-other-right").addClass("display-none-block");
    },
    //tat lay out been ngoaif
    hideContentRightPageLayout: function () {
        $(".div-parent-background").removeClass("div-parent-open");
        $(".div-block-right").removeClass("div-block-width-big");
        $(".content-search-page").removeClass("display-none-block");
        $(".btn-close-search-list").removeClass("btn-click");
        $('#content-page-right-layout').hide();
        //location.reload();
    },
    //Other detail
    showContentOtherRightPage: function () {
        $(".div-other-background").toggleClass("div-parent-other-open");
        $(".div-other-right").addClass("div-block-width-item-big");
    },
    hideContentOtherRightPage: function () {
        $(".div-other-background").removeClass("div-parent-other-open");
        $(".div-other-right").removeClass("div-block-width-item-big");
        $("#content-other-right").html('');
    },
    submitFormOtherItem: function (form_name, url_action) {
        var form_id = 'form_' + form_name;
        if (!jqueryCommon.getFormValidation(form_id, 2)) return;
        var dataForm = jqueryCommon.getDataFormObj(form_id);

        //check ngày tháng
        var startDate = $('#' + form_name + '_EFFECTIVE_DATE').val();
        var endDate = $('#' + form_name + '_EXPIRATION_DATE').val();
        if (startDate != '' && endDate != '') {
            var checkDate = jqueryCommon.compareDate(startDate, endDate);
            if (checkDate) {
                jqueryCommon.showMsg('error', '', 'Thông báo lỗi', 'Ngày hiệu lực phải lớn hơn ngày hết hiệu lực');
                return;
            }
        }

        $('#loaderRight').show();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: url_action,
            data: {
                '_token': _token,
                'dataForm': dataForm,
            },
            success: function (res) {
                $('#loaderRight').hide();
                if (res.success == 1) {
                    jqueryCommon.showMsg('success', res.message);
                    $('#' + res.divShowAjax).html(res.html);
                    jqueryCommon.hideContentOtherRightPage();
                } else {
                    jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.message);
                }
            }
        });
    },
    toStringDate: function (date) {
        return date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + (date.getDate())).slice(-2)
    },
    downloadFile: function (file) {
        $.fileDownload(file)
            .done(function () {
                console.log('File download a success!');
            })
            .fail(function () {
                console.log('File download failed!');
            });
    },
    isConfirm: function (msg) {
        return swal({
            title: "Confirmation!",
            width: 400,
            text: msg,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'CANCEL',
            allowOutsideClick: false
        });
    },
    showMsg: function (type, msg, title, html) {
        var obj = {
            width: 400,
            type: type,
            allowOutsideClick: true
        };
        if (html) {
            obj.html = html;
        } else {
            obj.text = msg;
        }
        if (title) {
            obj.title = title;
        }
        return swal(obj);
    },
    showMsgError: function (success, message) {
        if (success == 0) {
            jqueryCommon.showMsg('error', message);
        } else {
            jqueryCommon.showMsg('error', '', 'Hết phiên làm việc', message);
        }
    },
    autoGenCode: function (code_view) {
        var departName = $('#DEPARTMENT_NAME_').val();
        var name = jqueryCommon.filterViStr(departName);
        var code = code_view.toUpperCase() + '_' + name.trim().replace(/[^\w\s]/ig, '').replace(/\s+/g, '_').toUpperCase();
        $('#DEPARTMENT_CODE_').val(code);
    },
    filterViStr: function (str) {
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/ig, 'a');
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/ig, 'e');
        str = str.replace(/ì|í|ị|ỉ|ĩ/ig, 'i');
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/ig, 'o');
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/ig, 'u');
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/ig, 'y');
        str = str.replace(/đ/ig, 'd');
        return str;
    },
    getFormValidation: function (form_id, type) {
        if (type == 1) {//popup
            var form = $('#' + form_id + ' form');//popup
        } else {
            var form = $('#' + form_id); //page
        }
        var input = form.find('input, select, textarea');
        var rules = {};
        var messages = {};
        var label;
        for (var i = 0; i < input.length; i++) {
            if ($(input[i]).prop('disabled') || $(input[i]).is(':hidden')) continue;

            if ($(input[i]).parent().find('label').length) {
                label = $(input[i]).parent().find('label').text().replace('*', '').trim();
            } else {
                label = $(input[i]).parent().prev().text().replace('*', '').trim();
            }
            var type = input[i].tagName == 'SELECT' ? 'chọn' : 'nhập';
            var msgObj = {};
            var ruleObj = {};
            if ($(input[i]).prop('required')) {
                msgObj.required = "Bắt buộc phải {type} {label}".replace('{type}', type).replace('{label}', label);
            }

            var max = $(input[i]).attr('maxlength');
            var min = $(input[i]).attr('minlength');
            var exp = $(input[i]).attr('pattern');
            var maxNum = $(input[i]).attr('max');
            var minNum = $(input[i]).attr('min');
            // check maximum of number
            if (maxNum) {
                ruleObj.max = parseInt(maxNum);
                msgObj.max = "{label} phải nhỏ hơn {max}".replace('{label}', label).replace('{max}', maxNum);
            }
            // check minimum of number
            if (minNum) {
                ruleObj.min = parseInt(minNum);
                msgObj.min = "{label} phải lớn hơn là {min}".replace('{label}', label).replace('{min}', minNum);
            }

            if (max) {
                ruleObj.maxlength = parseInt(max);
                msgObj.maxlength = "Độ dài của {label} là {max}".replace('{label}', label).replace('{max}', max);
            }

            if (min) {
                ruleObj.minlength = parseInt(min);
                if (!max || min == max) {
                    msgObj.minlength = "Độ dài của {label} là {min}".replace('{label}', label).replace('{min}', min);
                } else {
                    msgObj.minlength = "Độ dài của {label} là {max}".replace('{label}', label).replace('{min}', min).replace('{max}', max);
                }
            }
            if (exp) {
                msgObj.pattern = "{label} không hợp lệ".replace('{label}', label);
                ruleObj.pattern = true;
            }
            if (['ActiveDate', 'DeactiveDate', 'DateOfBirth', 'date'].indexOf(input[i].name) != -1) {
                msgObj.dpDate = "Ngày tháng không hợp lệ";
                ruleObj.dpDate = true;
            }
            messages[input[i].name] = msgObj;
            if ((Object.keys(ruleObj).length)) {
                rules[input[i].name] = ruleObj;
            }
        }
        form.validate({
            rules: rules,
            messages: messages
        });
        return form.valid();
    },
    copyText: function (id) {
        var copyText = document.getElementById(id);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
    },
    getDataFormObj: function (formId) {
        var formObj = {};
        var inputs = $('#' + formId).serializeArray();
        $.each(inputs, function (i, input) {
            formObj[input.name] = input.value;
        });
        return formObj;
    },
    buildOptionCommon: function (objId, type, showId) {
        var _token = $('input[name="_token"]').val();
        var object_value = $('#' + objId).val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/ajaxCommon/buildOption',
            data: {
                '_token': _token,
                'object': object_value,
                'type': type
            },
            success: function (res) {
                if (res.success == 1) {
                    $('#' + showId).html(res.optionOut);
                } else {
                    jqueryCommon.showMsg('error', '', 'Thông báo lỗi', 'Lỗi dữ liệu.');
                }
            }
        });
    },

    /*Ajax load tab*/
    ajaxGetData: function (obj) {
        $(".tr_data").addClass('display-none-block');
        var _token = $('input[name="_token"]').val();
        var objectId = $(obj).attr('data-object-id');
        var url = $(obj).attr('data-url');
        var functionAction = $(obj).attr('data-function-action');
        var divShowId = $(obj).attr('data-show-id');
        var dataInput = $(obj).attr('data-input');
        var typeLoading = $(obj).attr('data-loading');
        $("#" + divShowId).removeClass('display-none-block');
        var isContentHtml = $('#' + divShowId).html();

        if (!$.trim(isContentHtml)) {
            if(typeLoading == 1){
                $('#loader').show();
            }else {
                $('#loaderRight').show();
            }
            var dataPost = {
                '_token': _token,
                'url': url,
                'divShowId': divShowId,
                'objectId': objectId,
                'dataInput': dataInput,
                'functionAction': functionAction
            };
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: url,
                data: dataPost,
                success: function (res) {
                    if(typeLoading == 1){
                        $('#loader').hide();
                    }else {
                        $('#loaderRight').hide();
                    }
                    if (res.success == 1) {
                        $('#' + divShowId).html(res.html);
                    } else {
                        jqueryCommon.showMsgError(res.success, res.message);
                    }
                }
            });
        }
    },

    /*Ajax search*/
    searchAjaxWithForm: function (form_id, url_action) {
        var page_no = 1;
        var dataForm = jqueryCommon.getDataFormObj(form_id);
        dataForm['page_no'] = page_no;
        jqueryCommon._callAjaxGetData(dataForm, url_action);
        return false;
    },
    /*Ajax paging*/
    pagingAjaxWithForm: function (form_id, url_action) {
        $('.pagination a').click(function (e) {
            var page_no = $(this).attr('href').split('page_no=')[1];
            var dataForm = jqueryCommon.getDataFormObj(form_id);
            dataForm['page_no'] = page_no;
            jqueryCommon._callAjaxGetData(dataForm, url_action);
            e.preventDefault();
            return false;
        });
    },
    /*Call data by ajax*/
    _callAjaxGetData: function (dataForm, url_action) {
        $('#loader').show();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: url_action,
            data: {
                '_token': _token,
                'dataForm': dataForm,
            },
            success: function (res) {
                $('#loader').hide();
                if (res.success == 1) {
                    $('#' + res.divShowId).html(res.html);
                } else {
                    jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.message);
                }
            }
        });
    },

    //upload ảnh
    uploadMultipleImagesCommon: function (type) {
        jQuery('#sys_PopupUploadImg').modal('show');
        jQuery('.ajax-upload-dragdrop').remove();
        $('.modal-backdrop').attr('style', 'z-index: 0 !important');
        var id_hiden = '1111';
        var settings = {
            url: WEB_ROOT + '/ajax/uploadImage',
            method: "POST",
            allowedTypes: "jpg,png,jpeg,gif",
            fileName: "multipleFile",
            formData: {id: id_hiden, type: type},
            multiple: false,
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
                    //setTimeout("jQuery('.ajax-file-upload-statusbar').hide();", 1000);
                    //setTimeout("jQuery('#status').hide();", 1000);
                    //setTimeout("jQuery('#sys_PopupUploadImg').modal('hide');", 1000);
                }
            },
            onError: function (files, status, errMsg) {
                jQuery("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        jQuery("#sys_mulitplefileuploader").uploadFile(settings);
    },
    numberFormat: function (nStr, decSeperate, groupSeperate) {
        nStr += '';
        var x = nStr.split(decSeperate);
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
        }
        return x1 + x2;
    },
    replaceString: function (string, search_replace, str_replace) {
        string = string.replace(search_replace, str_replace);
        return string;
    },
    changeRadio: function (id){
        var value_defaul = $("#"+id).val();
        if(value_defaul == 1){
            $("#"+id).val(0);
        }else {
            $("#"+id).val(1);
        }
    },
    changeTwoButton: function (id,id_btn0,id_btn1){
        var value_defaul = $("#"+id).val();
        if(value_defaul == 1){
            $("#"+id).val(0);
            $("#"+id_btn0).removeClass("btn-light");
            $("#"+id_btn0).addClass("btn-danger");

            $("#"+id_btn1).removeClass("btn-success");
            $("#"+id_btn1).addClass("btn-light");
        }else {
            $("#"+id).val(1);
            $("#"+id_btn1).removeClass("btn-light");
            $("#"+id_btn1).addClass("btn-success");

            $("#"+id_btn0).removeClass("btn-danger");
            $("#"+id_btn0).addClass("btn-light");
        }
    },
    submitAjaxFormMultipart: function(form_id,btnSubmit,urlAjax){
        var form = $('#'+form_id)[0];
        // Create an FormData object
        var data = new FormData(form);

        // disabled the submit button
        $("#"+btnSubmit).prop("disabled", true);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: urlAjax,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                // code thành công
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
        });
    },
}
