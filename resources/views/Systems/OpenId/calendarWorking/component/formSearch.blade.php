<div class="ui-theme-search-list">
    <a href="javascript:void(0);" class="area-btn btn-open-options btn btn-success" title="{{viewLanguage('Search')}}">
        <i class="pe-7s-search fa-w-16 fa-2x"></i>
    </a>
    @if($is_root || $permission_edit || $permission_add)
        <a href="javascript:void(0);"class="area-btn btn-action1 btn btn-warning sys_show_popup_common" data-form-name="addForm" data-input="{{json_encode([])}}" data-size="1" title="{{viewLanguage('Thêm ')}}{{$pageTitle}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="0">
            <i class="pe-7s-plus fa-w-16 fa-2x"></i>
        </a>
    @endif
    <div class="theme-settings__inner">
        <div class="scrollbar-container">
            <div class="theme-settings__options-wrapper">
                <h3 class="themeoptions-heading">Tìm kiếm</h3>
                {{---Form search---}}
                <div class="ibox-content">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="are_time_" class="control-label">{{viewLanguage('Thời gian')}}</label>
                            <select name="are_time_" id="are_time_" class="form-control input-sm">
                                {!! $optionTime !!}}
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="type_calendar_" class="control-label">{{viewLanguage('Bắt đầu')}}</label>
                            <input type="text" class="form-control input-date" id="start_date_" name="start_date_" autocomplete="off" @if(isset($search['start_date']))value="{{$search['start_date']}}"@endif>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="type_calendar_" class="control-label">{{viewLanguage('kết thúc')}}</label>
                            <input type="text" class="form-control input-date" id="end_date_" name="end_date_" autocomplete="off" @if(isset($search['end_date']))value="{{$search['end_date']}}"@endif>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="type_calendar_" class="control-label">{{viewLanguage('Loại lịch')}}</label>
                            <select name="type_calendar_" id="type_calendar_" class="form-control input-sm">
                                {!! $optionType !!}}
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="type_whose_" class="control-label">{{viewLanguage('Lịch của')}}</label>
                            <select name="type_whose_" id="type_whose_" class="form-control input-sm">
                                {!! $optionWhose !!}}
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="preside_id_" class="control-label">{{viewLanguage('Thành phần tham dự')}}</label>
                            <select name="preside_id_" id="preside_id_" class="form-control input-sm">
                                {!! $optionParticipants !!}}
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="status_" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                            <select name="status_" id="status_" class="form-control input-sm">
                                {!! $optionStatus !!}}
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="address_">Địa điểm</label>
                            <input type="text" class="form-control input-sm" id="address_" name="address_" autocomplete="off" @if(isset($search['address']))value="{{$search['address']}}"@endif>
                        </div>
                        <hr>
                        <div class="form-group col-lg-12">
                            @if($is_root || $permission_edit || $permission_add)
                                <a href="javascript:void(0);"class="mb-2 mr-2 btn-icon btn btn-success sys_show_popup_common" data-form-name="addForm" data-input="{{json_encode([])}}" data-size="1" title="{{viewLanguage('Thêm ')}}{{$pageTitle}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="0">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                    {{viewLanguage('Add')}}
                                </a>
                            @endif
                            @if($is_root || $permission_view)
                            <button class="mb-2 mr-2 btn-icon btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                            @endif
                        </div>
                        <br><br>
                    </div>
                    {!! Form::close() !!}
                </div>
                {{---Form search---}}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
    //tim kiem
    var config = {
        '.chosen-select'           : {width: "58%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
