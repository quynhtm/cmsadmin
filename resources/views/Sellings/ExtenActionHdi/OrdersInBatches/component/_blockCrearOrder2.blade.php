<form id="form_create_order" enctype="multipart/form-data">
<div class="form-group form-infor-common">
    <div class="row form-group">
        <div class="col-lg-12">
            <label for="user_group"><b id="title_create_order">Chương trình bảo hiểm - Master Happy Care - Thời gian từ 01/07/2021 đến 31/07/2022</b></label>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-lg-3">
            <label for="user_group">Loại cấp đơn</label><br/>
            <label for="user_group"><b id="lancapdon"></b></label>
            <input name="p_lancapdon" id="p_lancapdon" type="hidden" value="1">
        </div>
        <div class="col-lg-3">
            <label for="user_group">Số phụ lục hợp đồng</label>
            <input type="text" class="form-control input-sm" id="p_contract_addendum" name="p_contract_addendum" placeholder="Số phụ lục hợp đồng">
        </div>
        <div class="col-lg-3">
            <label for="user_group">Phụ lục hợp đồng</label>
            <label title="{{viewLanguage('Chọn file PLHĐ')}}" for="inputFilePLHD" class="w-100 btn-transition btn btn-outline-success">
                <input type="file" name="inputFilePLHD" id="inputFilePLHD" style="display:none">
                <i class="fa fa-share-square"></i> {{viewLanguage('Chọn file PLHĐ(pdf)')}}
            </label>
        </div>
        <div class="col-lg-3">
            <label for="user_email">File danh sách</label>
            &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="color_hdi" style="text-decoration: underline">Tải file mẫu</a>

            <label title="{{viewLanguage('Upload danh sách')}}" for="inputFileExcelOrder" class="w-100 btn-transition btn btn-outline-success">
                <input type="file" name="inputFileExcelOrder" id="inputFileExcelOrder" style="display:none">
                <i class="fa fa-share-square"></i> {{viewLanguage('Upload danh sách(xlsx,xls)')}}
            </label>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-lg-3 marginT5">
            <input type="hidden" name="check_create_test" id="check_create_test" value="0">
            <div role="group" class="btn-group-sm btn-group btn-group-toggle" data-toggle="buttons" >
                <label class="btn btn-danger active" id="btn_test" onclick="jqueryCommon.changeTwoButton('check_create_test','btn_test','btn_live'); showHideRemove();" style="border-radius: 20px 0 0 20px">
                    &nbsp;&nbsp;&nbsp;&nbsp;Cấp đơn test&nbsp;&nbsp;&nbsp;&nbsp;
                </label>
                <label class="btn btn-light active" id="btn_live" onclick="jqueryCommon.changeTwoButton('check_create_test','btn_test','btn_live'); showHideRemove();" style="border-radius: 0 20px 20px 0">
                    Cấp đơn chính thức
                </label>
            </div>
        </div>
        <div class="col-lg-3 marginT5">
            <input type="hidden" id="check_creat_certification" name="check_creat_certification" value="0">
            <input type="checkbox" class="custom-checkbox float-left" onchange="jqueryCommon.changeRadio('check_creat_certification');">
            <label for="is_success" class="float-left marginL10">Cấp đơn với số GCN sinh trước</label>
        </div>
        <div class="col-lg-3 marginT5">
            <input type="hidden" id="check_send_email" name="check_send_email" value="1" >
            <input type="checkbox" class="custom-checkbox float-left" onchange="jqueryCommon.changeRadio('check_send_email');" checked>
            <label for="is_success" class="float-left marginL10">Gửi email cho KH khi cấp đơn</label>
        </div>
        <div class="col-lg-3 marginT5">
            <input type="hidden" id="check_send_sms" name="check_send_sms" value="0">
            <input type="checkbox" class="custom-checkbox float-left" onchange="jqueryCommon.changeRadio('check_send_sms');">
            <label for="is_success" class="float-left marginL10">Gửi SMS cho KH khi cấp đơn</label>
        </div>
    </div>
    <div class="row form-group marginT15">
        <div class="col-lg-3">
            <button class="w-100 mb-2 mr-2 btn btn-success" id="submitCreateOrder" type="button" > <i class="fa fa-check"></i> {{viewLanguage('Cấp đơn')}}</button>
        </div>
        <div class="col-lg-2 display-none-block" id="btn_remove">
            <button class="w-100 mb-2 mr-2 btn btn-danger" type="button" name="Xóa đơn test"><i class="fa fa-trash"></i> {{viewLanguage('Xóa đơn test')}}</button>
        </div>
        <div class="col-lg-7 text-right display-none-block">
            <button class="mb-2 mr-2 btn-transition btn btn-outline-success" type="button" > <i class="fa fa-file-excel"></i> {{viewLanguage('Xuất file excel')}}</button>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $("#submitCreateOrder").click(function (event) {
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            submitAjaxFormMultipart('form_create_order','submitCreateOrder','{{$urlCreateOrder}}')
        });
    });
    function showHideRemove(){
        var value_defaul = $("#check_create_test").val();
        if(value_defaul == 1){
            $("#btn_remove").hide();
        }else {
            $("#btn_remove").show();
        }
    }
    function submitAjaxFormMultipart(form_id,btnSubmit,urlAjax){
        var chose_program_id = $('#p_chose_program_id').val();
        if(chose_program_id > 0){
            var form = $('#'+form_id)[0];
            // Create an FormData object

            var data = new FormData(form);
            //data chương trình
            var data_infor_program = $('#data_infor_program').val();
            data.append("data_infor_program", data_infor_program);
            data.append("p_chose_program_id", chose_program_id);

            // disabled the submit button
            //$("#"+btnSubmit).prop("disabled", true);
            $('#loader').show();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: urlAjax,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (res) {
                    $('#loader').hide();
                    if(res.success == 1){
                        jqueryCommon.showMsg('success', 'Đã cấp đơn thành công');
                        window.location.href = res.urlIndex;
                    }else {
                        jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.message);
                    }
                },
                error: function (e) {
                    console.log("ERROR : ", e);
                }
            });
        }else {
            jqueryCommon.showMsg('error', '', 'Thông báo lỗi', 'Chưa chọn Chương trình để cấp đơn');
        }

    }
</script>