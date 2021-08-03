
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
        <div class="ibox-tools marginDownT6">
            <button class="btn btn-primary" type="button" name="submit" value="1" onclick="changeStatus(); jqueryCommon.searchAjaxWithForm('{{$formSeachIndex}}','{{$urlSearchAjax}}')"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
            <button class="btn-transition btn btn-outline-success btn-search-right" type="button" name="search_ava" value="1"><i class="fa fa-search"></i> {{viewLanguage('Nâng cao')}}</button>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-3">
                <label for="user_group">Sản phẩm</label>
                <select  class="form-control input-sm" name="p_product_code" id="p_product_code">
                    {!! $optionProduct !!}
                </select>
            </div>
           <div class=" col-lg-3">
                <label for="user_group">Đối tác</label>
                <select  class="form-control input-sm chosen-select w-100" name="p_org_code" id="p_org_code">
                    {!! $optionOrg !!}
                </select>
            </div>
            <div class=" col-lg-3">
                <label for="user_group">Kênh tiếp nhận</label>
                <select  class="form-control input-sm" name="p_channel" id="p_channel">
                    {!! $optionChannel !!}
                </select>
            </div>
            <div class=" col-lg-3">
                <label for="user_group">Trạng thái</label><br>
                <select  class="form-control input-sm" name="p_status" id="p_status" multiple="">
                    {!! $optionStatus !!}
                </select>
                <input type="hidden" id="p_str_status" name="p_str_status" value="">
            </div>
            <input type="hidden" id="div_show" name="div_show" value="table_show_ajax">
            <input type="hidden" id="template_out" name="template_out" value="ClaimHDI">
            <input type="hidden" id="router_index" name="router_index" value="claimHdi.index">
        </div>
    </div>
</div>

<div class="main-card mb-3 card" id="table_show_ajax">
    @include('Sellings.ClaimIndemnify.ClaimHdi.component._tableClaim')
</div>
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/selectmulti/multi-styles.css')}}"/>
<script src="{{URL::asset('assets/backend/admin/lib/selectmulti/jquery.multi-select.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#p_status').multiSelect();
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        $("#checkAllOrder").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
            changeColorButton();
        });
    });
    function changeStatus(){
        var strStatus = $('#p_status option:selected').toArray().map(item => item.value).join();
        if(strStatus.trim() != ''){
            $('#p_str_status').val(strStatus.trim());
        }else {
            $('#p_str_status').val('');
        }
    }
    function changeColorButton(){
        var changeColor = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                changeColor = 1;
            }
        });
        if(changeColor == 1){
            $('#show_button_approval_order').removeClass("display-none-block");
            $("#approval_order").addClass("btn-success");
            $("#approval_order").removeClass("btn-light");
        }else {
            $('#show_button_approval_order').addClass("display-none-block");
            $("#approval_order").removeClass("btn-success");
            $("#approval_order").addClass("btn-light");
        }
    }
    function clickApprovalOrderList(url_ajax){
        var dataId = [];
        var dataAmount = [];
        var i = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                dataAmount[i] = $(this).attr('data-amount');
                i++;
            }
        });
        if (dataId.length == 0 || dataAmount.length == 0) {
            alert('Bạn chưa chọn đơn để thao tác.');
            return false;
        }

        var msg = 'Bạn có muốn phê duyệt các đơn này?';
        jqueryCommon.isConfirm(msg).then((confirmed) => {
            $('#loader').show();
            $.ajax({
                type: "post",
                url: url_ajax,
                data: {dataId: dataId, dataAmount: dataAmount},
                dataType: 'json',
                success: function (res) {
                    $('#loader').hide();
                    if (res.success == 1) {
                        jqueryCommon.showMsg('success',res.message);
                        window.location.reload();
                    } else {
                        jqueryCommon.showMsgError(res.success,res.message);
                    }
                }
            });
        });
    }
    function changerRadio(){
        var status_defaul = $("#status_defaul").val();
        if(status_defaul == 1){
            $("#status_defaul").val(0);
        }else {
            $("#status_defaul").val(1);
        }
    }

</script>



