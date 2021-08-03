
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Search')}}</h5>
        <div class="ibox-tools marginDownT6">
            <button class="btn btn-primary" type="button" name="submit" value="1" onclick="changeStatus(); jqueryCommon.searchAjaxWithForm('{{$formSeachIndex}}','{{$urlSearchAjax}}')"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
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
            <div class=" col-lg-2">
                <label for="user_group">Kênh tiếp nhận</label>
                <select  class="form-control input-sm" name="p_channel" id="p_channel" style="max-width: 15rem;">
                    {!! $optionChannel !!}
                </select>
            </div>

            <div class="col-lg-2">
                <label for="user_email">Từ ngày yêu cầu</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_from_date" id="p_from_date" @if(isset($search['p_from_date']))value="{{$search['p_from_date']}}"@endif>
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-2">
                <label for="user_email">đến ngày yêu cầu</label>
                <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_to_date" id="p_to_date" @if(isset($search['p_to_date']))value="{{$search['p_to_date']}}"@endif >
                <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
            </div>
            <div class="col-lg-3 paddingRight-unset paddingLeft-unset">
                <label for="user_group">Trạng thái</label><br>
                <select  class="form-control input-sm" name="p_status" id="p_status" multiple="">
                    {!! $optionStatus !!}
                </select>
                <input type="hidden" id="p_str_status" name="p_str_status" value="">
            </div>
            <input type="hidden" id="div_show" name="div_show" value="table_show_ajax">
            <input type="hidden" id="template_out" name="template_out" value="ReportClaimVietJet">
            <input type="hidden" id="router_index" name="router_index" value="claimReport.indexClaimVietJet">
        </div>
    </div>
</div>
{{----Table view data----}}
<div class="main-card mb-3 card" id="table_show_ajax">
    @if(trim($table_view) != '')
        @include('Report.claim.'.$table_view)
    @else
        <div class="alert">
            chưa có view
        </div>
    @endif
</div>


<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/backend/admin/lib/selectmulti/multi-styles.css')}}"/>
<script src="{{URL::asset('assets/backend/admin/lib/selectmulti/jquery.multi-select.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#p_status').multiSelect();
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
    function changeStatus(){
        var strStatus = $('#p_status option:selected').toArray().map(item => item.value).join();
        if(strStatus.trim() != ''){
            $('#p_str_status').val(strStatus.trim());
        }else {
            $('#p_str_status').val('');
        }
    }
</script>
