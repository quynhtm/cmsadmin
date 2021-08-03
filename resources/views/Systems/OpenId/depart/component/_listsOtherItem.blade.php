{{---tạo mới---}}
@if($objectId <= 0)
    <div class="card-header"> Thông tin khác </div>
    <div class="marginT15">
        Chưa có nhân viên thuộc phòng ban
    </div>
    {{---cập nhật---}}
@else
    <div class="card-header"> Thông tin nhân viên</div>
    @if($listStaff && sizeof($listStaff) > 0)
    <div class="listTabWithAjax">
        <div class="tab-content">
            <div class="row marginT10">
                <div class="form-group row col-md-12">
                    <div class="col-md-4">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Tên nhân viên')}}</label>
                        <input type="text" class="form-control input-sm"  required name="ORG_CODE" id="ORG_CODE">
                    </div>

                    <div class="col-md-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Trạng thái')}} </label><span class="red"> (*)</span>
                        <select class="form-control input-sm" name="ORG_TYPE" id="ORG_TYPE" >
                            {!! $optionStatus !!}
                        </select>
                    </div>
                    <div class="col-md-5 marginT15">
                        @if($is_root || $permission_edit || $permission_add)
                        <button class="mb-2 mr-2 btn-icon btn btn-primary" type="button" name="searchStaff" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                        <a href="javascript:void(0);" class="mb-2 mr-2 btn-icon btn btn-success" data-input="{{json_encode(['item'=>$data])}}" title="Chuyển depart cho nhân viên" data-method="post" data-div-show="sys_show_infor_small" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetPopupMove" onclick="Admin.getPopupMoveDepartOfStaff(this)">
                            <i class="pe-7s-repeat"></i> {{viewLanguage('Chuyển phòng ban')}}
                        </a>
                        @endif
                    </div>
                </div>
                <h5 class="clearfix marginL10"> @if($totalStaff >0) Có tổng số <b>{{$totalStaff}}</b> nhân viên thuộc phòng ban @endif </h5>
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr>
                            <th width="2%" class="text-center"><input type="checkbox" class="check" id="checkAllAjax"></th>
                            <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                            <th width="10%" class="text-center">{{viewLanguage('Mã NV')}}</th>
                            <th width="20%" class="text-center">{{viewLanguage('Họ tên')}}</th>

                            <th width="15%" class="text-center">{{viewLanguage('Chức vụ')}}</th>
                            <th width="15%" class="text-center">{{viewLanguage('Ngày sinh')}}</th>
                            <th width="15%" class="text-center">{{viewLanguage('Email')}}</th>
                            <th width="10%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($listStaff as $keys => $staff)
                            <tr>
                                <td class="text-center">
                                    <input class="checkAjax" type="checkbox" name="checkStaffCode[]" id="sys_checkItems" value="{{$staff->USER_CODE}}">
                                </td>
                                <td class="text-center">{{$sttStaff+$keys+1}}</td>
                                <td class="text-center">{{$staff->USER_CODE}}</td>
                                <td class="text-center">{{$staff->FULL_NAME}}</td>

                                <td class="text-center">{{$staff->POSITION_CODE}}</td>
                                <td class="text-center">{{convertDateDMY($staff->BIRTHDAY)}}</td>
                                <td class="text-center">{{$staff->EMAIL}}</td>
                                <td class="text-center">{{$staff->IS_ACTIVE}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
        Chưa có nhân viên thuộc phòng ban này
    @endif
@endif

<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        $("#checkAllAjax").click(function () {
            $(".checkAjax").prop('checked', $(this).prop('checked'));
        });
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
