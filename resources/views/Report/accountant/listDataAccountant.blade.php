{{ Form::open(array('method' => 'GET', 'role'=>'form','id'=>'formSeachIndex')) }}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Search')}}</h5>
        <div class="ibox-tools marginDownT6">
            <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-4">
                <label for="user_group">Sản phẩm bảo hiểm</label>
                <select  class="form-control input-sm" name="p_product_code" id="p_product_code" @if(in_array($product_code,$arrProPage)) disabled @endif>
                    {!! $optionProduct !!}
                </select>
            </div>
            <div class=" col-lg-4">
                <label for="user_group">Đối tác</label>
                <select  class="form-control input-sm" name="p_org_code" id="p_org_code">
                    {!! $optionSeller !!}
                </select>
            </div>
            <div class="col-lg-2">
                <label for="user_email">Từ ngày hiệu lực</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_from_date" id="p_from_date" @if(isset($search['p_from_date']))value="{{$search['p_from_date']}}"@endif>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-2">
                <label for="user_email">đến ngày hiệu lực</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_to_date" id="p_to_date" @if(isset($search['p_to_date']))value="{{$search['p_to_date']}}"@endif >
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <input type="hidden" id="is_accumulated_defaul" name="is_accumulated_defaul" value="0">
            <!--<div class="col-lg-2 marginT30">
                <input type="checkbox" class="custom-checkbox float-left" id="is_accumulated" name="is_accumulated" onchange="changerRadio();" @if($search['is_accumulated_defaul'] == STATUS_INT_MOT) checked @endif>
                <label for="is_accumulated" class="float-left marginL10">Lũy kế</label>
            </div>-->
        </div>
    </div>
</div>

<div class="main-card mb-3 card">
    @if(trim($table_view) != '')
        @include('Report.accountant.'.$table_view)
    @else
        <div class="alert">
            chưa có view
        </div>
    @endif
</div>
{{ Form::close() }}
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        $("#checkAllOrder").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
        });
    });
    function checkExportExcel(){
        var exportExcel = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                exportExcel = 1;
            }
        });
        if(exportExcel == 1){
            return true;
        }else {
            jqueryCommon.showMsg('error', '', 'Thông báo lỗi', 'Bạn chưa chọn đơn để xuất excel');
            return false;
        }
    }
    function changerRadio(){
        var status_defaul = $("#is_accumulated_defaul").val();
        if(status_defaul == 1){
            $("#is_accumulated_defaul").val(0);
        }else {
            $("#is_accumulated_defaul").val(1);
        }
    }
</script>
