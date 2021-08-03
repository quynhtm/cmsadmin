<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Danh sách hợp đồng')}}</h5>
        <div class="ibox-tools marginDownT6">
            <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
            <button class="btn-transition btn btn-outline-success btn-search-right" type="button" name="search_ava" value="2"><i class="fa fa-search"></i> {{viewLanguage('Tìm kiếm nâng cao')}}</button>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-5">
                <label for="user_email">Mã đơn</label>
                <input type="text" class="form-control input-sm" id="p_order_code" name="p_order_code" placeholder="" @if(isset($search['p_order_code']))value="{{$search['p_order_code']}}"@endif>
            </div>
            <div class=" col-lg-3">
                <label for="user_group">Trạng thái</label>
                <select  class="form-control input-sm" name="p_status" id="p_status">
                    {!! $optionStatus !!}
                </select>
            </div>
            <div class=" col-lg-2">
                <label for="user_email">Từ ngày tạo</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_from_date" id="p_from_date" @if(isset($search['p_from_date']))value="{{$search['p_from_date']}}"@endif>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class=" col-lg-2">
                <label for="user_email">Đến ngày tạo</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_to_date" id="p_to_date" @if(isset($search['p_to_date']))value="{{$search['p_to_date']}}"@endif >
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="col-lg-4 marginT20 display-none-block" id="show_button_approval_order">
        <button class="btn btn-light" type="button" name="approval_order" id="approval_order" value="0" onclick="clickApprovalOrderList('{{$urlApprovalOrder}}')"><i class="fa fa-check"></i> {{viewLanguage('Phê duyệt')}}</button>
    </div>
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <div class="row">
                <div class="col-lg-4 text-left">
                    <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif</h5>
                </div>
                <div class="col-lg-8 text-right">
                    @if($total >0)
                        <button class="btn-transition btn btn-outline-warning btn-search-right marginDownT15 display-none-block" type="submit" name="submit" value="2" title="Xuất excel"><i class="fa fa-file-excel"></i></button>
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                        <tr class="table-background-header">
                            <th width="3%" class="text-center middle"><input type="checkbox" class="check" id="checkAllOrder"></th>
                            <th width="3%" class="text-center middle">{{viewLanguage('')}}</th>
                            <th width="10%" class="text-center middle">{{viewLanguage('Mã đơn/ Kỳ')}}</th>

                            <th width="10%" class="text-center middle">{{viewLanguage('Khách hàng')}}</th>
                            <th width="10%" class="text-center middle">{{viewLanguage('Đơn vị cấp')}}</th>
                            <th width="8%" class="text-center middle">{{viewLanguage('Ngày tạo')}}</th>
                            <th width="10%" class="text-center middle">{{viewLanguage('Nội dung đề nghị')}}</th>
                            <th width="10%" class="text-center middle">{{viewLanguage('Sản phẩm')}}</th>

                            <th width="8%" class="text-center middle">{{viewLanguage('Số tiền cần thanh toán')}}</th>
                            <th width="8%" class="text-center middle">{{viewLanguage('Số tiền đã thanh toán')}}</th>
                            <th width="8%" class="text-center middle">{{viewLanguage('Tình trạng')}}</th>
                            <th width="10%" class="text-center middle">{{viewLanguage('Trạng thái')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td class="text-center middle">
                                <input class="check" type="checkbox" @if(isset($item->PAYMENT_CODE) && $item->PAYMENT_CODE == STATUS_INT_MOT) name="checkItems[]"@else disabled @endif value="@if(isset($item->ORDER_TRANS_CODE)){{$item->ORDER_TRANS_CODE}}@endif" data-amount="{{$item->TOTAL_PAY}}" onchange="changeColorButton();">
                            </td>
                            <td class="text-center middle">
                                @if($is_root || $permission_view || $permission_add)
                                    <a href="javascript:void(0);" style="color: green" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="detailItem" data-input="{{json_encode(['item'=>$item,'arrKey'=>['ORDER_CODE'=>$item->ORDER_CODE,'ORG_CODE'=>$item->ORG_CODE,'ORDER_TRANS_CODE'=>$item->ORDER_TRANS_CODE,'PAYMENT_CODE'=>$item->PAYMENT_CODE]])}}" data-show="2" data-override="1" data-div-show="content-page-right" title="{{viewLanguage('Thông tin hợp đồng: ')}}{{$item->ORDER_CODE}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="1">
                                        <i class="pe-7s-look fa-2x"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="text-left middle">
                                @if(isset($item->ORDER_CODE)){{$item->ORDER_CODE}}@endif
                            </td>

                            <td class="text-left middle">
                                @if(isset($item->CUS_NAME))<b>{{$item->CUS_NAME}}</b>@endif
                                @if(isset($item->PAYER_PHONE))<br/>{{$item->PAYER_PHONE}}@endif
                            </td>
                            <td class="text-left middle">@if(isset($item->ORG_NAME)){{$item->ORG_NAME}}@endif</td>
                            <td class="text-center middle">@if(isset($item->ORDER_DATE) && !empty($item->ORDER_DATE)){{convertDateDMY($item->ORDER_DATE)}}@endif</td>
                            <td class="text-left middle">@if(isset($item->CONTENT_PAY)){{$item->CONTENT_PAY}}@endif</td>
                            <td class="text-left middle">@if(isset($item->PRODUCT_NAME)){{$item->PRODUCT_NAME}}@endif</td>

                            <td class="text-right middle"><b class="red">@if(isset($item->AMOUNT)){{numberFormat($item->AMOUNT)}}@endif</b></td>
                            <td class="text-right middle"><b class="green">@if(isset($item->TOTAL_PAY)){{numberFormat($item->TOTAL_PAY)}}@endif</b></td>
                            <td class="text-center middle">@if(isset($item->STATUS_PAYMENT)){{$item->STATUS_PAYMENT}}@endif</td>
                            <td class="text-center middle">@if(isset($item->STATUS_ORDER)){{$item->STATUS_ORDER}}@endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="paging_simple_numbers">
                {!! $paging !!}
            </div>
        @else
            <div class="alert">
                Không có dữ liệu
            </div>
        @endif
    </div>
</div>
<script id="script_layout" src="{{\Illuminate\Support\Facades\Config::get('config.URL_SDK_' . \Illuminate\Support\Facades\Config::get('config.ENVIRONMENT'))}}source/4874b3fae14c29fd43d9d7533651cb60/integrate.js"></script>
<script type="text/javascript">
    var hdisdk=null;
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        $("#checkAllOrder").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
            changeColorButton();
        });

        //detail đơn
        /*$('.sys_show_order_insurance').dblclick(function () {
            var contract_code = $(this).attr('data-contract-code');
            var category = $(this).attr('data-category');
            clickApplicationInsurance(category,contract_code,'Cập nhật đơn bảo hiểm')
        });*/

    });
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
    //tim kiem
    function choseCategory(obj){
        $(".application-choose").addClass("btn-success-2");
        $(".application-choose").removeClass("btn-success");

        var id_div = $(obj).attr('id');
        $("#"+id_div).addClass("btn-success");
        $("#"+id_div).removeClass("btn-success-2");

        var category = $(obj).attr('data-order');
        $("#category_order").val(category);
    }
    //('ADD','','',
    function viewDetailOrder(obj){
        var contract_code = $(obj).attr('data-contract-code');
        var category = $(obj).attr('data-category');
        var product_code = $(obj).attr('data-product-code');
        var detail_code = $(obj).attr('data-detail-code');
        var action = 'EDIT';
        if(detail_code == ''){
            //get detail_code
            var _token = $('input[name="_token"]').val();
            //$('#loaderRight').show();
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '{{URL::route('insurancePolicy.ajaxGetDetailContract')}}',
                data: {
                    '_token': _token,
                    'contract_code': contract_code,
                    'category': category,
                    'product_code': product_code
                },
                success: function (res) {
                    $('#loaderRight').hide();
                    if (res.success == 1) {
                        clickApplicationInsurance(category,'Cập nhật đơn bảo hiểm',action,contract_code,res.detail_code);
                    } else {
                        jqueryCommon.showMsg('error','','Thông báo lỗi',res.message);
                    }
                }
            });
        }else {
            clickApplicationInsurance(category,'Cập nhật đơn bảo hiểm',action,contract_code,detail_code);
        }
    }
    function clickApplicationInsurance(category,tilte,action,contract_code,detail_code){
        $("#content-page-right").html('');
        $('#content-page-right-layout').show();
        $('#title_cap_don').html(tilte)
        jqueryCommon.showContentRightPage();
        //hdisdk.open(category);
        const config = {
            classId: "body-insurance-policy",
            partnerId: "",
            publickey: "",
            sdk_params: {
                partner: '{{PARTNER_ID_INSURANCE_POLICY}}', //Đối tác sử dụng
                action: action, //  Với trường hợp cấp đơn mới là: 'ADD', còn sửa là 'EDIT'
                category: category, // loại sản phẩm
                contract_code: contract_code, //Mã hợp đồng truyền lên
                detail_code: detail_code, //Mã detail_code truyền lên
                org_code: '{{$org_code_user}}', //mã đơn vị người sử dụng
            }
        }
        hdisdk = new HDISdk(config)
        $(".div-parent-background").addClass("div-parent-open");
        hdisdk.init((initresult)=>{
            if(initresult.sucess){
                //do something
            }
        })
        //khi submit xong
        hdisdk.onFormsubmit((data, result)=>{
            // when form is submit
        })
    }
</script>



