{{ Form::open(array('method' => 'GET', 'role'=>'form','id'=>'formSeachIndex')) }}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Search')}}</h5>
        <div class="ibox-tools marginDownT6">
            <button class="btn btn-primary" type="button" name="submit" value="1" onclick="jqueryCommon.searchAjaxWithForm('{{$formSeachIndex}}','{{$urlSearchAjax}}')"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class=" col-lg-4">
                <label for="user_group">Sản phẩm bảo hiểm</label>
                <select  class="form-control input-sm" name="p_product_code" id="p_product_code">
                    {!! $optionProduct !!}
                </select>
            </div>
            <div class=" col-lg-4">
                <label for="user_group">Đối tác</label>
                <select  class="form-control input-sm" name="p_org_code" id="p_org_code">
                    {!! $optionSeller !!}
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
            <div class="col-lg-2 marginT30">
                <input type="hidden" id="is_accumulated_defaul" name="is_accumulated_defaul" value="{{$search['is_accumulated_defaul']}}">
                <input type="checkbox" class="custom-checkbox float-left" id="is_accumulated" name="is_accumulated" onchange="changerRadio();" @if($search['is_accumulated_defaul'] == STATUS_INT_MOT) checked @endif>
                <label for="is_accumulated" class="float-left marginL10">Lũy kế</label>
            </div>
            <input type="hidden" id="div_show" name="div_show" value="table_show_ajax">
        </div>
    </div>
</div>
<div class="main-card mb-3 card" id="table_show_ajax">
    @include('Report.product._tableProduct')
</div>
{{ Form::close() }}
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
    function changerRadio(){
        var status_defaul = $("#is_accumulated_defaul").val();
        if(status_defaul == 1){
            $("#is_accumulated_defaul").val(0);
        }else {
            $("#is_accumulated_defaul").val(1);
        }
    }
</script>
