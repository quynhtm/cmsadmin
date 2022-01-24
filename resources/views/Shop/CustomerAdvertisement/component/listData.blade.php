<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
        <div class="ibox-tools marginDownT6">
            @if($permission_full || $permission_view)
                <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
            @endif
            @if($permission_full || $permission_edit || $permission_add)
                {{--<a href="javascript:void(0);"  class="btn btn-success" onclick="jqueryCommon.getDataByAjax(this);" data-loading="1" data-show="2" data-div-show="content-page-right" data-form-name="addFormItem" data-url="{{$urlGetData}}" data-function-action="_functionGetData" data-method="post" data-input="{{json_encode(['funcAction'=>'getDetailItem','dataItem'=>[]])}}" data-objectId="0" title="{{viewLanguage('Thêm mới')}}">
                    <i class="fa fa-plus"></i>
                </a>--}}
            @endif
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="form-group col-lg-4">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
            </div>
            <div class="form-group col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                <select  class="form-control input-sm" name="is_active" id="is_active">
                    {!! $optionIsActive !!}}
                </select>
            </div>
            <div class="form-group col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Tỉnh thành')}}</label>
                <select  class="form-control input-sm" name="customer_city_id" id="customer_city_id">
                    {!! $optionCity !!}}
                </select>
            </div>
            <div class="form-group col-lg-4">
                <div class="marginT30 display-none-block" id="show_button_action_status">
                    <button class="btn btn-success" type="button"  onclick="jqueryCommon.clickUpdateStatus('{{$urlPostData}}',{{STATUS_INT_HAI}})"><i class="fa fa-check"></i> {{viewLanguage('Gửi mail MKT')}}</button>
                    <button class="btn btn-warning" type="button"  onclick="jqueryCommon.clickUpdateStatus('{{$urlPostData}}',{{STATUS_INT_MOT}})"><i class="fa fa-refresh"></i> {{viewLanguage('Hiển thị')}}</button>
                    <button class="btn btn-danger" type="button" onclick="jqueryCommon.clickUpdateStatus('{{$urlPostData}}',{{STATUS_INT_KHONG}})"><i class="fa fa-times"></i> {{viewLanguage('Ẩn')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> item @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        <th width="5%" class="text-center">STT</th>
                        <th width="3%" class="text-center"><input type="checkbox" class="check" id="checkAllOrder"></th>

                        <th width="15%" class="text-left">{{viewLanguage('Họ tên')}}</th>
                        <th width="18%" class="text-left">{{viewLanguage('Email')}}</th>
                        <th width="10%" class="text-left">{{viewLanguage('Số điện thoại')}}</th>

                        <th width="30%" class="text-left">{{viewLanguage('Địa chỉ')}}</th>
                        <th width="10%" class="text-center">{{viewLanguage('Thành phố')}}</th>
                        <th width="6%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-center middle">
                                <input class="check" type="checkbox" name="checkItems[]" value="{{$item->id}}" data-amount="" onchange="jqueryCommon.changeColorButton();">
                            </td>
                            <td class="text-left middle">
                                {{$item->customer_full_name}}
                            </td>
                            <td class="text-left middle">{{$item->customer_alias}}</td>
                            <td class="text-left middle">{{$item->customer_phone}}</td>

                            <td class="text-left middle">{{$item->customer_address}}</td>
                            <td class="text-center middle">@if(isset($arrCity[$item->customer_city_id])){{$arrCity[$item->customer_city_id]}}@endif</td>

                            <td class="text-center middle">
                                @if($item->is_active == STATUS_INT_MOT)
                                    <a href="javascript:void(0);" style="color: green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                @else
                                    <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-times fa-2x"></i></a>
                                @endif
                            </td>
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
<script type="text/javascript">
    $(document).ready(function(){
        $("#checkAllOrder").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
            jqueryCommon.changeColorButton();
        });

        var config = {
            '.chosen-select'           : {width: "100%"},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });
</script>
