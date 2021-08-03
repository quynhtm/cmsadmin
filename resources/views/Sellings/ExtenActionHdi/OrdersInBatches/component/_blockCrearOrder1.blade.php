<input name="_token" type="hidden" value="{{ csrf_token() }}">
<input name="dataOption" id="dataOption" type="hidden" @if(isset($dataOption))value="{{ json_encode($dataOption)}}"@endif>
<input name="dataInforCreatOrder" id="dataInforCreatOrder" type="hidden" @if(isset($dataInfor))value="{{ json_encode($dataInfor)}}"@endif>



<form id="form_programme" enctype="multipart/form-data">
<div class="form-group form-infor-common">
    <div class="row">
        <div class="col-lg-9">
            <label for="user_group">Chương trình bảo hiểm</label> <span class="red"> (*)</span>
            <div id="select_programme" class="">
                <select class="input-sm chosen-select w-100" name="p_programme_code" id="p_programme_code" onchange="ajaxGetInforProgramme(1,'{{$urlActionFunction}}');">
                    {!! $optionProgrammes !!}
                </select>
            </div>
            <div id="input_programme" class="display-none-block">
                <input type="text" class="form-control input-sm" id="p_programme_name" name="p_programme_name" placeholder="Tên chương trình bảo hiểm">
            </div>
        </div>
        <div class="col-lg-3 marginT40">
            <input type="hidden" id="check_create_programme" name="check_create_programme" value="0">
            <input type="checkbox" class="custom-checkbox float-left" onchange="jqueryCommon.changeRadio('check_create_programme'); showHideAddProgramme();">
            <label for="check_create_programme" class="float-left marginL10">{{viewLanguage('Thêm mới chương trình')}}</label>
        </div>
    </div>

    <div class="row marginT10" id="data_infor_programme">
        {{--@include('Sellings.ExtenActionHdi.OrdersInBatches.component._inforProgramme')--}}
    </div>

</div>
</form>
<script type="text/javascript">
    $(document).ready(function () {

    });

    function showHideAddProgramme(){
        var value_defaul = $("#check_create_programme").val();
        if(value_defaul == 1){//thêm mới
            $("#input_programme").removeClass("display-none-block");
            $("#select_programme").addClass("display-none-block");
        }else {
            $("#select_programme").removeClass("display-none-block");
            $("#input_programme").addClass("display-none-block");
        }
        ajaxGetInforProgramme(0,'{{$urlActionFunction}}');
    }

    function ajaxGetInforProgramme(type_edit,url){
        var p_programme_code = 0
        if(type_edit == 1){
            p_programme_code = $('#p_programme_code').val();
        }else {
            p_programme_code = 0;
        }
        var dataOption = $('#dataOption').val();
        var _token = $('input[name="_token"]').val();
        $('#loader').show();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: url,
            data: {
                '_token': _token,
                'programme_id': p_programme_code,
                'dataOption': dataOption,
                'divShowId': 'data_infor_programme',
                'templateView': '_inforProgramme',
                'functionAction': 'ajaxGetInforProgramme'
            },
            success: function (res) {
                $('#loader').hide();
                if (res.success == 1) {
                    $('#data_infor_programme').html(res.html);

                    //block cấp đơn
                    if(res.dataCreate.inforProgram.NUM_OF_GEN == 1){
                        $('#p_contract_addendum').val(res.dataCreate.inforProgram.CONTRACT_NO);
                        $('#p_contract_addendum').prop('readonly', true);
                    }

                    $('#lancapdon').html('Lần cấp '+res.dataCreate.inforProgram.NUM_OF_GEN);
                    $('#p_lancapdon').val(res.dataCreate.inforProgram.NUM_OF_GEN);
                    $('#title_create_order').html(res.dataCreate.title_create_order);
                } else {
                    jqueryCommon.showMsgError(res.success, res.message);
                }
            }
        });
    }

    function ajaxChangeParamPack(url){
        var p_product = $('#p_product').val();
        var p_org_buyer = $('#p_org_buyer').val();

        if(p_product.trim() != ''){
            var dataInforCreatOrder = $('#dataInforCreatOrder').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: url,
                data: {
                    '_token': _token,
                    'p_product': p_product,
                    'p_org_buyer': p_org_buyer,
                    'dataInforCreatOrder': dataInforCreatOrder,
                    'divShowId': 'table_list_packs',
                    'templateView': '_table_list_packs',
                    'functionAction': 'ajaxChangeParamPack'
                },
                success: function (res) {
                    $('#loader').hide();
                    if (res.success == 1) {
                        $('#table_list_packs').html(res.html);
                    } else {
                        jqueryCommon.showMsgError(res.success, res.message);
                    }
                }
            });
        }else {
            $('#table_list_packs').html('');
            $('#p_package_obj').val('');
        }
    }

    function ajaxAddInforPacks(url){
        var p_product = $('#p_product').val();
        var p_org_buyer = $('#p_org_buyer').val();
        var p_package_obj = $('#p_package_obj').val();

        if(p_product.trim() == ''){
            jqueryCommon.showMsgError(0, 'Bạn chưa chọn Sản phẩm cho gói');
            return false;
        }
        /*if(p_org_buyer.trim() == ''){
            jqueryCommon.showMsgError(0, 'Bạn chưa chọn Khách hàng cho gói');
            return false;
        }*/
        var dataInforCreatOrder = $('#dataInforCreatOrder').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: url,
            data: {
                '_token': _token,
                'p_product': p_product,
                'p_org_buyer': p_org_buyer,
                'p_package_obj': p_package_obj,
                'dataInforCreatOrder': dataInforCreatOrder,
                'titlePopup': 'Cập nhật gói cho chương trình',
                'divShowId': 'sys_show_infor',
                'templateView': '_popupInforPacks',
                'functionAction': 'ajaxAddInforPacks'
            },
            success: function (res) {
                $('#loader').hide();
                if (res.success == 1) {
                    $('#sys_showPopupCommon').modal('show');
                    $(".modal-dialog").addClass("modal-lg");
                    $('#sys_show_infor').html(res.html);
                } else {
                    jqueryCommon.showMsgError(res.success, res.message);
                }
            }
        });
    }
</script>