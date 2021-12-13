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
            @if($partner_id == STATUS_INT_KHONG)
            <div class="form-group col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Đối tác')}}</label>
                <select  class="form-control input-sm" name="partner_id" id="partner_id">
                    {!! $optionPartner !!}}
                </select>
            </div>
            @endif
            <div class="form-group col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                <select  class="form-control input-sm" name="is_active" id="is_active">
                    {!! $optionIsActive !!}}
                </select>
            </div>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                        <th width="15%" class="text-left">{{viewLanguage('Người đăng ký')}}</th>
                        <th width="10%" class="text-left">{{viewLanguage('Người đại diện')}}</th>
                        <th width="15%" class="text-left">{{viewLanguage('Email')}}</th>

                        <th width="10%" class="text-left">{{viewLanguage('Phone')}}</th>
                        <th width="10%" class="text-left">{{viewLanguage('CMND/CCCD')}}</th>
                        <th width="30%" class="text-left">{{viewLanguage('Địa chỉ')}}</th>

                        <th width="8%" class="text-center">{{viewLanguage('Tình trạng')}}</th>
                        <th width="5%" class="text-center">{{viewLanguage('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-left middle">{{$item->shop_name}}</td>
                            <td class="text-left middle">{{$item->shop_representative}}</td>
                            <td class="text-left middle">{{$item->shop_email}}</td>

                            <td class="text-left middle">{{$item->shop_phone}}</td>
                            <td class="text-left middle">{{$item->shop_idcard}}</td>
                            <td class="text-left middle">{!! $item->shop_address !!}</td>
                            <td class="text-center middle">
                                @if(isset($arrIsActive[$item->is_active])){{$arrIsActive[$item->is_active]}}@endif
                            </td>

                            <td class="text-center middle">
                                @if($permission_full || $permission_view || $permission_edit || $permission_add)
                                    {{--<a href="javascript:void(0);"  class="color_hdi" onclick="jqueryCommon.getDataByAjax(this);" data-loading="1" data-show="2" data-div-show="content-page-right" data-form-name="addFormItem" data-url="{{$urlGetData}}" data-function-action="_functionGetData" data-method="post" data-input="{{json_encode(['funcAction'=>'getDetailItem','dataItem'=>$item])}}" data-objectId="{{$item->id}}" title="{{viewLanguage('Thông tin chi tiết')}}">
                                        <i class="fa fa-eye "></i>
                                    </a>--}}
                                @endif
                                @if($permission_full || $permission_remove)
                                    {{--<a href="javascript:void(0);" style="color: red" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Xóa thông tin: ')}}{{$item->GROUP_NAME}}" data-method="post" data-url="{{$urlPostData}}" data-input="{{json_encode(['item'=>$item])}}">
                                        <i class="pe-7s-trash fa-2x"></i>
                                    </a>&nbsp;--}}
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
