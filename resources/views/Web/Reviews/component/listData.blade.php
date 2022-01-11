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
            <div class="form-group col-lg-2">
                <div class="marginT20 display-none-block" id="show_button_approval_order">
                    <button class="btn btn-light" type="button" name="approval_order_success" id="approval_order_success" value="3" onclick="clickUpdateStatus('{{$urlPostData}}',{{STATUS_INT_BA}})"><i class="fa fa-check"></i> {{viewLanguage('Phê duyệt')}}</button>
                    <button class="btn btn-light" type="button" name="approval_order_cancel" id="approval_order_cancel" value="0" onclick="clickUpdateStatus('{{$urlPostData}}',{{STATUS_INT_KHONG}})"><i class="fa fa-times"></i> {{viewLanguage('Hủy')}}</button>
                </div>
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
                        <th width="2%" class="text-center">{{viewLanguage('STT')}} <input type="checkbox" class="check" id="checkAllOrder"></th>
                        <th width="30%" class="text-left">{{viewLanguage('Đối tượng được đánh giá')}}</th>
                        <th width="15%" class="text-left">{{viewLanguage('Người gửi')}}</th>

                        <th width="30%" class="text-left">{{viewLanguage('Nội dung')}}</th>
                        <th width="5%" class="text-center">{{viewLanguage('Điểm')}}</th>
                        <th width="8%" class="text-center">{{viewLanguage('Ngày tạo')}}</th>
                        <th width="10%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td class="text-center middle">
                                <input class="check" type="checkbox" name="checkItems[]" value="{{$item->id}}" data-amount="" onchange="changeColorButton();">
                                {{$stt+$key+1}}
                            </td>
                            <td class="text-left middle">
                                @if($item->type_review == \App\Models\Web\Reviews::typeReviewProduct)
                                    <a href="{{buildLinkDetailProduct($item->object_id,$item->object_name)}}" title="{{$item->object_name}}" target="_blank">
                                        [{{$item->object_id}}]-{{$item->object_name}}
                                    </a>
                                @else
                                    <a href="{{buildLinkDetailNew($item->object_id,$item->object_name)}}" title="{{$item->object_name}}" target="_blank">
                                        [{{$item->object_id}}]-{{$item->object_name}}
                                    </a>
                                @endif
                                @if($partner_id == 0) @if(isset($arrPartner[$item->partner_id]))<br><span class="font_10">{{$arrPartner[$item->partner_id]}}</span> @endif @endif
                            </td>
                            <td class="text-left middle">
                                @if(!empty($item->assessor)){{$item->assessor}} <br/>@endif
                                @if(!empty($item->email)){{$item->email}}@endif
                            </td>
                            <td class="text-left middle">{!! $item->content !!}</td>
                            <td class="text-left middle">{{$item->star_points}}</td>
                            <td class="text-center middle">{{date('H:i d-m-Y',strtotime($item->created_at))}}</td>
                            <td class="text-center middle">
                                @if(isset($arrIsActive[$item->is_active])){{$arrIsActive[$item->is_active]}}@endif
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
            changeColorButton();
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
    function changeColorButton(){
        var changeColor = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                changeColor = 1;
            }
        });
        if(changeColor == 1){
            $('#show_button_approval_order').removeClass("display-none-block");
            $("#approval_order_success").addClass("btn-success");
            $("#approval_order_success").removeClass("btn-light");

            $("#approval_order_cancel").addClass("btn-danger");
            $("#approval_order_cancel").removeClass("btn-light");
        }else {
            $('#show_button_approval_order').addClass("display-none-block");
            $("#approval_order_success").removeClass("btn-success");
            $("#approval_order_success").addClass("btn-light");

            $("#approval_order_cancel").addClass("btn-danger");
            $("#approval_order_cancel").removeClass("btn-light");
        }
    }
    function clickUpdateStatus(url_ajax,status){
        var dataId = [];
        var i = 0;
        var _token = $('input[name="_token"]').val();
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                i++;
            }
        });
        if (dataId.length == 0) {
            alert('Bạn chưa chọn đơn để thao tác.');
            return false;
        }

        var msg = 'Bạn có muốn thay đổi trạng thái các item này?';
        jqueryCommon.isConfirm(msg).then((confirmed) => {
            $('#loader').show();
            $('#show_button_approval_order').addClass("display-none-block");
            $.ajax({
                type: "post",
                url: url_ajax,
                data: {_token: _token,dataId: dataId, status: status, actionUpdate: 'updateStatus'},
                dataType: 'json',
                success: function (res) {
                    $('#loader').hide();
                    if (res.success == 1) {
                        jqueryCommon.showMsg('success',res.message);
                        window.location.reload();
                    } else {
                        jqueryCommon.showMsgError(res.success,res.message);
                    }
                }
            });
        });
    }
</script>
