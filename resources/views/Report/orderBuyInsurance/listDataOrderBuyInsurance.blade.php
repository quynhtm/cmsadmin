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
                <select  class="form-control input-sm chosen-select w-100" name="p_product_code" id="p_product_code">
                    {!! $optionProduct !!}
                </select>
            </div>
            <div class=" col-lg-4">
                <label for="user_group">Đối tác</label>
                <select  class="form-control input-sm chosen-select w-100" name="p_org_seller" id="p_org_seller">
                    {!! $optionSeller !!}
                </select>
            </div>

            <div class=" col-lg-2 paddingRight-unset">
                <label for="user_email">Thời gian yêu cầu từ</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="f_date" id="f_date" @if(isset($search['f_date']))value="{{$search['f_date']}}"@endif>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class=" col-lg-2 paddingLeft-unset">
                <label for="user_email">đến</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="t_date" id="t_date" @if(isset($search['t_date']))value="{{$search['t_date']}}"@endif >
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>

            <div class=" col-lg-12">
                <label for="user_email">Từ khóa</label>
                <input type="text" class="form-control input-sm" id="text_search" name="text_search" placeholder="Tên khách hàng, số điện thoại, email" @if(isset($search['text_search']))value="{{$search['text_search']}}"@endif>
            </div>
            <input type="hidden" id="div_show" name="div_show" value="table_show_ajax">
        </div>
    </div>
</div>
<div class="main-card mb-3 card" id="table_show_ajax">
    @include('Report.orderBuyInsurance._tableOrderBuy')
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
