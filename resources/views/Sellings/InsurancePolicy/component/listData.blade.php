<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Danh sách cấp đơn')}}</h5>
        <div class="ibox-tools marginDownT6">
            <button class="btn-transition btn btn-outline-success btn-search-right" type="button" name="search_ava" value="2"><i class="fa fa-search"></i> {{viewLanguage('Tìm kiếm nâng cao')}}</button>
            <button class="btn btn-primary" type="button" name="submit" value="1" onclick="jqueryCommon.searchAjaxWithForm('{{$formSeachIndex}}','{{$urlSearchAjax}}')"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
        </div>
    </div>
    <div class="ibox-content text-center">
        {{viewLanguage('Chọn để lọc danh sách cấp đơn theo sản phẩm đó.')}}
        {{viewLanguage('Di chuột hoặc ấn vào sản phẩm để tạo đơn')}}.
        <div class="marginT20 text-center">
            @foreach($arrProductShow as $key_pro => $valu_pro)
                @if($valu_pro['isShow'] == 1)
                <button class="h_50 mb-2 mr-2 btn application-choose @if($search['p_product_code']==$valu_pro['pro_code'])btn-success-chose @else btn-success-2 @endif" onclick="checkProExten(0);choseCategory(this);" id="{{$valu_pro['pro_id']}}" data-category-code="{{$valu_pro['category']}}" data-product-code="{{$valu_pro['pro_code']}}" data-channel="{{$valu_pro['channel']}}" type="button" name="submit" value="1">
                    <span class="line-height-35">{!! $valu_pro['pro_name'] !!}</span>
                    <span class="badge badge-secondary badge-dot badge-dot-lg"> </span>
                    <div class="application_hover @if($valu_pro['is_open'] == 0)display-none-block @endif">
                        <span style="font-weight: bold;color: #000000!important;">{!! $valu_pro['pro_name'] !!}</span>
                        <a href="javascript:void(0);" onclick="clickApplicationInsurance('{{$valu_pro['category']}}','Cấp đơn: {{$valu_pro['pro_name']}}','ADD','','','{{$valu_pro['pro_code']}}','{{$valu_pro['channel']}}')" class="btn btn-success-chose w-100 marginT10"><span style="color: #ffffff!important;"><i class="pe-7s-plus"></i> {{viewLanguage('Cấp đơn')}}</span></a>
                    </div>
                </button>
                @endif
            @endforeach
            @if(isset($arrProductHide) && !empty($arrProductHide))
                <div class="mb-2 mr-2 dropright btn-group">
                    <button id="next_product" type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle-split dropdown-toggle btn btn-success-2" style="height: 50px"></button>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" style="width: 280px; padding-left: 8px">
                        <h4>Sản phẩm cấp đơn</h4>
                        @foreach($arrProductHide as $key_pro2 => $valu_pro2)
                            @if($valu_pro2['isShow'] == 1)
                                <button class="h_50 mb-2 mr-2 btn application-choose @if($search['p_product_code']==$valu_pro2['pro_code'])btn-success-chose @else btn-success-2 @endif" onclick="checkProExten(1);choseCategory(this);" id="{{$valu_pro2['pro_id']}}" data-category-code="{{$valu_pro2['category']}}" data-product-code="{{$valu_pro2['pro_code']}}" data-channel="{{$valu_pro2['channel']}}" type="button" name="submit" value="1">
                                    <span class="line-height-35">{!! $valu_pro2['pro_name'] !!}</span>
                                    <span class="badge badge-secondary badge-dot badge-dot-lg"> </span>
                                    <div class="application_hover @if($valu_pro2['is_open'] == 0)display-none-block @endif">
                                        <span style="font-weight: bold;color: #000000!important;">{!! $valu_pro2['pro_name'] !!}</span>
                                        <a href="javascript:void(0);" onclick="clickApplicationInsurance('{{$valu_pro2['category']}}','Cấp đơn: {{$valu_pro2['pro_name']}}','ADD','','','{{$valu_pro2['pro_code']}}','{{$valu_pro2['channel']}}')" class="btn btn-success-chose w-100 marginT10"><span style="color: #ffffff!important;"><i class="pe-7s-plus"></i> {{viewLanguage('Cấp đơn')}}</span></a>
                                    </div>
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-2 marginT20">
                <input type="checkbox" class="custom-checkbox float-left" id="is_success" name="is_success" onchange="changerRadio();" @if($search['is_success_defaul'] == 1) checked @endif>
                <label for="is_success" class="float-left marginL10">Đơn chưa hoàn thành</label>
            </div>
            <div class=" col-lg-3">
                <label for="user_email">Số giấy tờ khách hàng</label>
                <input type="text" class="form-control input-sm" id="p_idcard" name="p_idcard" placeholder="Số CMND/CCCD/Hộ chiếu" @if(isset($search['p_idcard']))value="{{$search['p_idcard']}}"@endif>
            </div>
            <div class=" col-lg-3">
                <label for="user_group">Đối tác</label>
                <select  class="form-control input-sm chosen-select w-100" name="p_org_seller" id="p_org_seller">
                    {!! $optionOrg !!}
                </select>
            </div><div class=" col-lg-2">
                <label for="user_group">Tình trạng</label>
                <select  class="form-control input-sm" name="p_status" id="p_status">
                    {!! $optionStatus !!}
                </select>
            </div>
            <div class=" col-lg-1 paddingRight-unset">
                <label for="user_group">Tháng</label>
                <select  class="form-control input-sm" name="p_month" id="p_month">
                    {!! $optionMonth !!}
                </select>
            </div>
            <div class=" col-lg-1 paddingLeft-unset">
                <label for="user_group">Năm</label>
                <select  class="form-control input-sm" name="p_year" id="p_year">
                    {!! $optionYear !!}
                </select>
            </div>
            <input type="hidden" id="div_show" name="div_show" value="table_show_ajax">
            <input type="hidden" id="category_code" name="p_category" value="{{$search['p_category']}}">
            <input type="hidden" id="product_code" name="p_product_code" value="{{$search['p_product_code']}}">
            <input type="hidden" id="is_success_defaul" name="is_success_defaul" value="{{$search['is_success_defaul']}}">
        </div>
    </div>
</div>

{{------View danh sách hiển thị-----}}
<div class="main-card mb-3 card" id="table_show_ajax">
    @include('Sellings.InsurancePolicy.component.tableList._tableListATTD')
</div>

<script id="script_layout" src="{{\Illuminate\Support\Facades\Config::get('config.URL_SDK_' . \Illuminate\Support\Facades\Config::get('config.ENVIRONMENT'))}}source/4874b3fae14c29fd43d9d7533651cb60/integrate.js"></script>
<script type="text/javascript">
    var config = {
        '.chosen-select'           : {width: "100%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    var hdisdk=null;
    $(document).ready(function(){
        const config = {
            classId: "body-insurance-policy",
            partnerId: "",
            publickey: ""
        }
        hdisdk = new HDISdk(config)
        hdisdk.init((initresult)=>{
            if(initresult.sucess){
                //do something
            }
        })
        //khi submit xong
        hdisdk.onFormsubmit((data, result)=>{
            // when form is submit
        })

        //var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        $("#checkAllOrder").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
            changeColorButton();
        });
    });
    function checkProExten(type){
        if(type == 1){
            $("#next_product").addClass("btn-success-chose");
            $("#next_product").removeClass("btn-success-2");
        }else {
            $("#next_product").addClass("btn-success-2");
            $("#next_product").removeClass("btn-success-chose");
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
            $("#approval_order").addClass("btn-success");
            $("#approval_order").removeClass("btn-light");
        }else {
            $("#approval_order").removeClass("btn-success");
            $("#approval_order").addClass("btn-light");
        }
    }
    function changerRadio(){
        var status_defaul = $("#is_success_defaul").val();
        if(status_defaul == 1){
            $("#is_success_defaul").val(0);
        }else {
            $("#is_success_defaul").val(1);
        }
    }
    function choseCategory(obj){
        $(".application-choose").addClass("btn-success-2");
        $(".application-choose").removeClass("btn-success-chose");

        var id_div = $(obj).attr('id');
        $("#"+id_div).addClass("btn-success-chose");
        $("#"+id_div).removeClass("btn-success-2");

        var category = $(obj).attr('data-category-code');
        $("#category_code").val(category);

        var product_code = $(obj).attr('data-product-code');
        $("#product_code").val(product_code);
        //tim kiem theo san pham
        jqueryCommon.searchAjaxWithForm('{{$formSeachIndex}}','{{$urlSearchAjax}}')
    }
    //('ADD','','',
    function viewDetailOrder(obj){
        var contract_code = $(obj).attr('data-contract-code');
        var category = $(obj).attr('data-category');
        var product_code = $(obj).attr('data-product-code');
        var detail_code = $(obj).attr('data-detail-code');
        var channel = $(obj).attr('data-channel');
        var action = 'EDIT';
        if(detail_code == ''){
            //get detail_code
            var _token = $('input[name="_token"]').val();
            $('#loader').show();
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
                    $('#loader').hide();
                    if (res.success == 1) {
                        clickApplicationInsurance(category,'Cập nhật đơn bảo hiểm',action,contract_code,res.detail_code,product_code,channel);
                    } else {
                        jqueryCommon.showMsg('error','','Thông báo lỗi',res.message);
                    }
                }
            });
        }else {
            //clickApplicationInsuranceOther(category,'Cập nhật đơn bảo hiểm',action,contract_code,detail_code);
            clickApplicationInsurance(category,'Cập nhật đơn bảo hiểm',action,contract_code,detail_code,product_code,channel);
        }
    }
    function test() {
        console.log('Test ham click')
    }
    function clickApplicationInsurance(category,tilte,action,contract_code,detail_code,product_code,channel){
        $("#content-page-right").html('');
        $('#content-page-right-layout').show();
        $('#title_cap_don').html(tilte)
        jqueryCommon.showContentRightPage();
        const sdk_params = {
            partner: '{{PARTNER_ID_INSURANCE_POLICY}}', //Đối tác sử dụng
            action: action, //  Với trường hợp cấp đơn mới là: 'ADD', còn sửa là 'EDIT'
            category: category, // loại sản phẩm
            contract_code: contract_code, //Mã hợp đồng truyền lên
            detail_code: detail_code, //Mã detail_code truyền lên
            org_code: '{{$org_code_user}}', //mã đơn vị người sử dụng
            user_name: '{{$user_name_login}}', //user name
            user_permission: '{!! $arrPermissionInspection !!}', //nhóm quyền giám định
            product_code: product_code, //product_code
            channel: channel, //channel
            onClose: function(){
                jqueryCommon.hideContentRightPageLayout()
            }
        }
        hdisdk.open(sdk_params);
        $(".div-parent-background").addClass("div-parent-open");
    }
    function clickApplicationInsuranceOther(category,tilte,action,contract_code,detail_code,product_code,channel){
        $('#title_cap_don').html(tilte)
        jqueryCommon.showContentOtherRightPageLayout();
        //hdisdk.open(category);
        const sdk_params = {
            partner: '{{PARTNER_ID_INSURANCE_POLICY}}', //Đối tác sử dụng
            action: action, //  Với trường hợp cấp đơn mới là: 'ADD', còn sửa là 'EDIT'
            category: category, // loại sản phẩm
            contract_code: contract_code, //Mã hợp đồng truyền lên
            detail_code: detail_code, //Mã detail_code truyền lên
            org_code: '{{$org_code_user}}', //mã đơn vị người sử dụng
            user_name: '{{$user_name_login}}', //user name
            product_code: product_code, //product_code
            channel: channel, //channel
            onClose: function(){
                jqueryCommon.hideContentRightPageLayout()
            }
        }
        hdisdk.open(sdk_params);
    }
</script>



