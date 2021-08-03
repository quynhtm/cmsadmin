
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-2 paddingRight-unset paddingLeft-unset">
                <label for="user_email">Ngày hẹn</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_appointment_date" id="p_appointment_date" @if(isset($search['p_appointment_date']))value="{{$search['p_appointment_date']}}"@endif>
                <div class="icon_calendar" style="right: 10px"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class=" col-lg-4">
                <label for="user_email">Chủ xe/ Biển số (Số khung - số máy)</label>
                <input type="text" class="form-control input-sm" id="p_number_plate" name="p_number_plate" placeholder="Chủ xe/biển số/số khung số máy" @if(isset($search['p_number_plate']))value="{{$search['p_number_plate']}}"@endif>
            </div>
            <div class=" col-lg-2">
                <label for="user_group">Tỉnh thành giám định</label>
                <select  class="form-control input-sm chosen-select w-100" name="p_provice_code" id="p_provice_code">
                    {!! $optionProvince !!}
                </select>
            </div>
<!--           <div class=" col-lg-2">
                <label for="user_group">Mã đại lý</label>
                <select  class="form-control input-sm chosen-select w-100" name="p_agency_code" id="p_agency_code">

                </select>
            </div>-->
            <div class=" col-lg-2">
                <label for="user_group">Tình trạng</label>
                <select  class="form-control input-sm" name="p_status" id="p_status">
                    {!! $optionStatus !!}
                </select>
            </div>
            <div class="col-lg-2 marginT30 text-right">
                <input type="hidden" id="routerIndex" name="routerIndex" value="{{$routerName}}">
                <input type="hidden" id="_tableView" name="_tableView" value="_tableData">
                <input type="hidden" id="div_show" name="div_show" value="table_show_ajax">
                <button class="btn btn-primary w_100" type="button" name="submit" value="1" onclick="jqueryCommon.searchAjaxWithForm('{{$formSeachIndex}}','{{$urlSearchAjax}}')"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                <button class="btn-transition btn btn-outline-success btn-search-right display-none-block" type="button" name="search_ava" value="1"><i class="fa fa-search"></i> {{viewLanguage('Nâng cao')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="main-card mb-3 card" id="table_show_ajax">
    @include('Sellings.Inspection.MotorVehicleInspection.component._tableData')
</div>

<script id="script_layout" src="{{\Illuminate\Support\Facades\Config::get('config.URL_SDK_' . \Illuminate\Support\Facades\Config::get('config.ENVIRONMENT'))}}source/4874b3fae14c29fd43d9d7533651cb60/integrate.js"></script>
<script type="text/javascript">
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

        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });

    function viewDetailOrder(obj){
        var contract_code = $(obj).attr('data-contract-code');
        var category = $(obj).attr('data-category');
        var product_code = $(obj).attr('data-product-code');
        var detail_code = $(obj).attr('data-detail-code');
        var action = 'EDIT';
        clickApplicationInsurance(category,'Chi tiết đơn bảo hiểm',action,contract_code,detail_code,product_code);
    }
    function clickApplicationInsurance(category,tilte,action,contract_code,detail_code,product_code){
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
            onClose: function(){
                jqueryCommon.hideContentRightPageLayout()
            }
        }
        hdisdk.open(sdk_params);
        $(".div-parent-background").addClass("div-parent-open");
    }</script>



