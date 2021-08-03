<div class="float-left w-50 paddingLR15">
    <div class="row form-group">
        <div class="col-lg-8">
            <label for="user_group">Khách hàng</label> <span class="red"> (*)</span>
            <select class="input-sm chosen-select w-100" name="p_org_buyer" id="p_org_buyer">
                {!! $optionOrg !!}
            </select>
        </div>
        <div class="col-lg-4">
            <label for="user_group">&nbsp;</label><br>
            <button class="w-100 btn btn-secondary disabled" type="button">{{viewLanguage('Thêm đối tác')}}</button>
        </div>

        <div class="col-lg-12 marginT10">
            <label for="user_group">Phòng ban - CN</label> <span class="red"> (*)</span>
            <select class="input-sm chosen-select w-100" name="p_struct_code" id="p_struct_code">
                {!! $optionDeparts !!}
            </select>
        </div>

        <div class="col-lg-8 marginT10">
            <label for="user_group">Sản phẩm</label> <span class="red"> (*)</span>
            <select class="input-sm chosen-select w-100" name="p_product" id="p_product" onchange="ajaxChangeParamPack('{{$urlActionFunction}}');">
                {!! $optionProducts !!}
            </select>
        </div>
        <div class="col-lg-4 marginT10">
            <label for="user_group">&nbsp;</label><br>
            <button class="w-100 btn btn-secondary disabled" type="button" name="add_product">{{viewLanguage('Thêm sản phẩm')}}</button>
        </div>

        <div class="col-lg-8 marginT10">
            <label for="user_group">Số hợp đồng</label> <span class="red"> (*)</span>
            <input type="text" class="form-control input-sm" id="p_contract_no" name="p_contract_no" placeholder="Số hợp đồng" @if(isset($dataFormProgram->CONTRACT_NO))value="{{$dataFormProgram->CONTRACT_NO}}"@endif>
        </div>
        <div class="col-lg-4 marginT10">
            <label for="user_group">&nbsp;</label><br>
            <button class="w-100 btn btn-secondary disabled" type="button">{{viewLanguage('Chọn hợp đồng')}}</button>
        </div>

        <div class="col-lg-6 marginT10">
            <label for="user_email">Hiệu lực hợp đồng</label> <span class="red"> (*)</span>
            <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_effective_date" id="p_effective_date" @if(isset($dataFormProgram->EFFECTIVE_DATE))value="{{$dataFormProgram->EFFECTIVE_DATE}}"@endif>
            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
        </div>
        <div class="col-lg-6 marginT10 ">
            <label for="user_email">đến</label> <span class="red"> (*)</span>
            <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_expiration_date" id="p_expiration_date" @if(isset($dataFormProgram->EXPIRATION_DATE))value="{{$dataFormProgram->EXPIRATION_DATE}}"@endif>
            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
        </div>

        <div class="col-lg-12 marginT10">
            <label for="user_group">Tiêu đề Email</label> <span class="red"> (*)</span>
            <input type="text" class="form-control input-sm" id="p_email_subject" name="p_email_subject" placeholder="Tiêu đề Email" @if(isset($dataFormProgram->EMAIL_SUBJECT))value="{{$dataFormProgram->EMAIL_SUBJECT}}"@endif>
        </div>

        <div class="col-lg-6 marginT10">
            <label for="user_group">Template email</label><span class="red"> (*)</span>
            <input type="hidden" name="p_temp_email" id="p_temp_email" value="@if(isset($dataFormProgram->EMAIL_TEMP)){{$dataFormProgram->EMAIL_TEMP}}@endif">
            @if(isset($dataFormProgram->EMAIL_TEMP))
                <br>
                <a class="color_hdi" target="_blank" href="{{$urlServiceFile.$dataFormProgram->EMAIL_TEMP}}" >{{$dataFormProgram->EMAIL_TEMP}}</a>
            @endif
            <label title="Template Email" for="inputImageTemplate" class="w-100 btn-transition btn btn-outline-success marginT10" style="padding-left: 0px!important; padding-right: 0px!important;">
                <input type="file" name="inputImageTemplate" id="inputImageTemplate" style="display:none">
                <i class="fa fa-share-square"></i>
                Upload template email(.html)
            </label>
        </div>

        <div class="col-lg-6 marginT10">
            <label for="user_group">Giấy chứng nhận</label><span class="red"> (*)</span>
            <input type="hidden" name="p_certificate_temp" id="p_certificate_temp" value="@if(isset($dataFormProgram->CERTIFICATE_TEMP)){{$dataFormProgram->CERTIFICATE_TEMP}}@endif">
            @if(isset($dataFormProgram->CERTIFICATE_TEMP))
                <br>
                <a class="color_hdi" target="_blank" href="{{$urlServiceFile.$dataFormProgram->CERTIFICATE_TEMP}}" >{{$dataFormProgram->CERTIFICATE_TEMP}}</a>
            @endif

            <label title="Template Email" for="inputImageTemplateCertificate" class="w-100 btn-transition btn btn-outline-success marginT10" style="padding-left: 0px!important; padding-right: 0px!important;">
                <input type="file" name="inputImageTemplateCertificate" id="inputImageTemplateCertificate" style="display:none">
                <i class="fa fa-share-square"></i>
                Upload giấy chứng nhận(.html)
            </label>
        </div>

        <div class="clearfix"></div>
        <div class="col-lg-3 marginT10">
            <button class="w-100 mb-2 mr-2 btn btn-success" id="submitProgramme" type="button" >{{viewLanguage('Lưu')}}</button>
        </div>
        <div class="col-lg-3 marginT10">
            <input class="w-100 btn-transition btn btn-outline-warning" id="resetProgramme" type="reset" value="{{viewLanguage('Reset')}}">
        </div>
        <div class="col-lg-3 marginT10">
            <input class="w-100 btn-transition btn btn-outline-info" onclick="ajaxGenTemplateEmail('{{$urlActionFunction}}')" type="button" value="{{viewLanguage('Gen mẫu Email')}}">
        </div>

    </div>
</div>

<div class="float-left row col-lg-6 paddingRight-unset">
    <div class="col-lg-12 paddingRight-unset">
        <a class="color_hdi" href="javascript:void(0);" onclick="ajaxAddInforPacks('{{$urlActionFunction}}')">{{viewLanguage('Cập nhật thông tin gói')}}</a>
            <div id="table_list_packs">
                @include('Sellings.ExtenActionHdi.OrdersInBatches.component._table_list_packs')
            </div>
    </div>
</div>
<input name="p_chose_program_id" id="p_chose_program_id" type="hidden" @if(isset($programme_id))value="{{ $programme_id}}"@endif>
<input name="data_infor_program" id="data_infor_program" type="hidden" @if(isset($inforProgram))value="{{ json_encode($inforProgram)}}"@endif>

<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        var chose_program_id = $('#p_chose_program_id').val();

        var config = {
            '.chosen-select'           : {width: "100%"},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

        $("#submitProgramme").click(function (event) {
            var check_create_programme = $('#check_create_programme').val();
            var chose_program_id = $('#p_chose_program_id').val();

            //list gói đc chọn
            var dataPack = [];
            var i = 0;
            $("input[name*='checkPack']").each(function () {
                if ($(this).is(":checked")) {
                    dataPack[i] = $(this).val();
                    i++;
                }
            });
            if (dataPack.length == 0) {
                jqueryCommon.showMsg('error', '', 'Thông báo lỗi','Bạn chưa chọn gói để cập nhật.');
                return false;
            }

            if(parseInt(check_create_programme) == 1 || parseInt(chose_program_id) > 0){
                //stop submit the form, we will post it manually.
                event.preventDefault();

                // Get form
                var form = $('#form_programme')[0];

                // Create an FormData object
                var data = new FormData(form);

                // If you want to add an extra field for the FormData
                //data.append("arr_pack_checked", dataPack);

                // disabled the submit button
                $("#submitProgramme").prop("disabled", true);
                $('#loader').show();
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: '{{$urlUpdateProgramme}}',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function (res) {
                        $('#loader').hide();
                        $("#submitProgramme").prop("disabled", false);
                        if(res.success == 1){
                            jqueryCommon.showMsg('success', 'Đã cập nhật chương trình thành công');

                            //block cấp đơn
                            if(res.inforProgram.NUM_OF_GEN == 1){
                                $('#p_contract_addendum').val(res.inforProgram.CONTRACT_NO);
                                $('#p_contract_addendum').prop('readonly', true);
                            }
                            $('#lancapdon').html('Lần cấp '+res.inforProgram.NUM_OF_GEN);
                            $('#p_lancapdon').val(res.inforProgram.NUM_OF_GEN);

                            $('#p_chose_program_id').val(res.chose_program_id);
                            $('#data_infor_program').val(res.data_infor_program);
                            $('#title_create_order').html(res.title_create_order);
                        }else {
                            jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.message);
                        }
                    },
                    error: function (e) {
                        console.log("ERROR : ", e);
                    }
                });
            }
        });
    });
    function ajaxGenTemplateEmail(url){
        var chose_program_id = $('#p_chose_program_id').val();
        var _token = $('input[name="_token"]').val();
        if(parseInt(chose_program_id) > 0){
            $('#loader').show();
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: url,
                data: {
                    '_token': _token,
                    'programme_id': chose_program_id,
                    'functionAction': 'ajaxGenTemplateEmail'
                },
                success: function (res) {
                    $('#loader').hide();
                    if (res.success == 1) {
                        $("#submitCreateOrder").prop("disabled", false);
                        jqueryCommon.showMsg('success', 'Đã gen Email template thành công');
                    } else {
                        jqueryCommon.showMsgError(res.success, res.message);
                    }
                }
            });
        }
    }

</script>