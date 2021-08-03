<div id="listOtherItemSearch" >

    <div class="form-group row">
    <!-- <div class="col-md-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">{{viewLanguage('Từ khóa')}} </span>
                </div>
                <input type="text" class="form-control" name="p_key_search" id="p_key_search" value="">
            </div>
        </div>-->
        <div class="col-md-5">
            @if($is_root || $permission_edit || $permission_add)
                <!--<a class="mb-2 mr-2 btn-icon btn btn-primary" href="javascript:void(0);" class="mb-2 mr-2 btn-icon btn btn-success" onclick="clickSearchVoucherValue(this);" data-method="post" title="{{viewLanguage('Tìm kiếm')}}" data-url="{{$urlSearchOtherItem}}" data-input="{{json_encode(['divShowId'=>'listOtherItemSearch','arrKey'=>['CAMPAIGN_CODE'=>$data->CAMPAIGN_CODE,'GIFT_CODE'=>$data->GIFT_CODE,'GIFT_TYPE'=>$data->GIFT_TYPE]])}}" ><i class="fa fa-search"></i> {{viewLanguage('Search')}}</a>-->
                @if($amountAllocateValue > 0)
                    <a href="javascript:void(0);" class="mb-2 mr-2 btn-icon btn btn-success" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="addFormOther" data-show="2" data-loading="2" data-div-show="content-other-right" data-function-action="_ajaxGetItemOther" data-method="post" title="{{viewLanguage('Thêm mới cấp phát')}}" data-input="{{json_encode(['itemOther'=>[],'isDetail'=>STATUS_INT_MOT,'action'=>'getDetailItemOther','type'=>$tabOtherItem1,'arrKey'=>['CAMPAIGN_CODE'=>$data->CAMPAIGN_CODE,'GIFT_CODE'=>$data->GIFT_CODE,'GIFT_TYPE'=>$data->GIFT_TYPE]])}}" data-url="{{$urlAjaxGetData}}" data-objectId="0">
                        <i class="pe-7s-repeat"></i> {{viewLanguage('Thêm mới')}}
                    </a>
                @endif
            @endif
            @if($is_root || $permission_approve)
                <a href="javascript:void(0);" class="mb-2 mr-2 btn-icon btn btn-primary" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="addFormOther" data-show="2" data-loading="2" data-div-show="content-other-right" data-function-action="_ajaxGetItemOther" data-method="post" title="{{viewLanguage('Thêm mới cấp phát')}}" data-input="{{json_encode(['itemOther'=>[],'isDetail'=>STATUS_INT_MOT,'action'=>'getAllocateToPartners','type'=>$tabOtherItem1,'arrKey'=>['CAMPAIGN_CODE'=>$data->CAMPAIGN_CODE,'GIFT_CODE'=>$data->GIFT_CODE,'GIFT_TYPE'=>$data->GIFT_TYPE]])}}" data-url="{{$urlAjaxGetData}}" data-objectId="0">
                    <i class="pe-7s-repeat"></i> {{viewLanguage('Cấp phát Voucher cho đối tác')}}
                </a>
            @endif
        </div>
    </div>

<div class="marginT5 table-responsive" >
@if(isset($dataOther))
    <table class="table table-bordered table-hover">
        <thead class="thin-border-bottom">
        <tr>
            <th width="7%" class="text-center middle">{{viewLanguage('Thao tác')}}</th>
            <th width="8%" class="text-center middle">{{viewLanguage('Lần cấp')}}</th>
            <th width="10%" class="text-center middle">{{viewLanguage('Mã block')}}</th>

            <th width="8%" class="text-center middle">{{viewLanguage('SL cấp phát')}}</th>
            <th width="8%" class="text-center middle">{{viewLanguage('SL đã kích hoạt')}}</th>
            <th width="15%" class="text-center middle">{{viewLanguage('Ngày hiệu lực')}}</th>
            <th width="15%" class="text-center middle">{{viewLanguage('Ngày hết hiệu lực')}}</th>

            <th width="15%" class="text-center middle">{{viewLanguage('File DS voucher')}}</th>
            <th width="10%" class="text-center middle">{{viewLanguage('Trạng thái')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($dataOther) && $dataOther)
            @foreach ($dataOther as $kb => $itemOther)
                <tr ondblclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="addFormOther" data-show="2" data-loading="2" data-div-show="content-other-right" data-function-action="_ajaxGetItemOther" data-method="post" title="{{viewLanguage('Cập nhật: ')}}" data-input="{{json_encode(['itemOther'=>$itemOther,'isDetail'=>STATUS_INT_MOT,'action'=>'getDetailItemOther','type'=>$tabOtherItem1,'arrKey'=>['CAMPAIGN_CODE'=>$itemOther->CAMPAIGN_CODE,'GIFT_CODE'=>$itemOther->GIFT_CODE,'GIFT_TYPE'=>$itemOther->GIFT_TYPE]])}}" data-url="{{$urlAjaxGetData}}" data-objectId="{{$itemOther->GCV_ID}}">
                    <td class="text-center middle">
                        @if($is_root || $permission_edit || $permission_add)
                            <a style="color: red" onclick="clickUpdateVoucherValue(this);" data-form-name="addFormOther" data-type-active="{{STATUS_VOUCHER_CANCEL}}" data-method="POST" data-url="{{$urlUpdateStatusOtherItem}}" data-objectId="{{$itemOther->GCV_ID}}" data-div-show="listOtherItemSearch">
                                <i class="pe-7s-trash fa-2x"></i>
                            </a>
                        @endif
                    </td>
                    <td class="text-center middle">{{$itemOther->TIMES}}</td>
                    <td class="text-center middle">{{$itemOther->BLOCK_CODE}}</td>
                    <td class="text-center middle">{{$itemOther->AMOUNT_ALLOCATE}}</td>

                    <td class="text-center middle">{{$itemOther->USE_NO}}</td>
                    <td class="text-center middle">
                        @if(isset($itemOther->EFFECTIVE_DATE) && trim($itemOther->EFFECTIVE_DATE) != '')
                            {{date('d/m/Y H:i',strtotime(trim($itemOther->EFFECTIVE_DATE)))}}
                        @endif
                    </td>
                    <td class="text-center middle">
                        @if(isset($itemOther->EXPIRATION_DATE) && trim($itemOther->EXPIRATION_DATE) != '')
                            {{date('d/m/Y H:i',strtotime(trim($itemOther->EXPIRATION_DATE)))}}
                        @endif
                    </td>
                    <td class="text-center ">
                        @if($is_root || $permission_approve)
                            @if($itemOther->STATUS == STATUS_VOUCHER_APPROVE)
                                <a href="{{URL::route('vouchersGift.getExportExcel',array('id' => setStrVar($itemOther->GCV_ID)))}}" target="_blank" class="btn btn-info" title="{{viewLanguage('Export excel')}}">
                                    <i class="fa fa-download"></i>
                                    File DS voucher
                                </a>
                            @endif
                        @endif
                    </td>
                    <td class="text-center middle">
                        @if(isset($arrStatusValue[$itemOther->STATUS]))
                            @if($itemOther->STATUS == STATUS_VOUCHER_APPROVE)
                                <b class="btn btn-success">{{$arrStatusValue[$itemOther->STATUS]}}</b>
                            @endif
                            @if($itemOther->STATUS == STATUS_VOUCHER_WAIT)
                                <b class="btn btn-secondary">{{$arrStatusValue[$itemOther->STATUS]}}</b>
                            @endif
                            @if($itemOther->STATUS == STATUS_VOUCHER_REFUSE)
                                <b class="btn btn-warning">{{$arrStatusValue[$itemOther->STATUS]}}</b>
                            @endif
                            @if($itemOther->STATUS == STATUS_VOUCHER_CANCEL)
                                <b class="btn btn-danger">{{$arrStatusValue[$itemOther->STATUS]}}</b>
                            @endif
                        @endif
                    </td>

                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@endif
</div>
<div class="paging_simple_numbers"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
    function clickCancelVoucher(){
        $('#sys_showPopupCancelVoucher').modal('show');
        $( ".modal-dialog" ).addClass( "modal-lg" );
        $(".modal-backdrop").attr('style', 'z-index: 1!important');
    }
    function clickSearchVoucherValue(obj){
        var _token = $('input[name="_token"]').val();
        var url = $(obj).attr('data-url');
        var method = $(obj).attr('data-method');
        var dataInput = $(obj).attr('data-input');
        var p_key_search = $('#p_key_search').val();
        if(p_key_search.length >0){
            $('#loaderRight').show();
            $.ajax({
                dataType: 'json',
                type: method,
                url: url,
                data: {
                    '_token': _token,
                    'key_search': p_key_search,
                    'dataInput': dataInput,
                },
                success: function (res) {
                    $('#loaderRight').hide();
                    if (res.success == 1) {
                        $('#'+res.divShowId).html(res.html);
                    } else {
                        jqueryCommon.showMsg('error','','Thông báo lỗi',res.message);
                    }
                }
            });
        }
    }
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
    function clickUpdateVoucherValue(obj){
        var _token = $('input[name="_token"]').val();
        var url = $(obj).attr('data-url');
        var method = $(obj).attr('data-method');
        var divShow = $(obj).attr('data-div-show');
        var objectId = $(obj).attr('data-objectId');
        var typeActive = $(obj).attr('data-type-active');
        var formName = $(obj).attr('data-form-name');
        var msg = 'Bạn có chắc chắc cập nhật trạng thái này?';
        var noteCancel = '';
        if(typeActive == '{{STATUS_VOUCHER_REFUSE}}'){
            noteCancel = $('#note_cancel').val();
            if(noteCancel == ''){
                jqueryCommon.showMsg('error','','Thông báo lỗi','Bạn chưa nhâp lý do từ chối.');
                return false;
            }
        }
        jqueryCommon.isConfirm(msg).then((confirmed) => {
            if((parseInt(objectId)) > 0){
                $('#loaderRight').show();
                $.ajax({
                    dataType: 'json',
                    type: method,
                    url: url,
                    data: {
                        '_token': _token,
                        'divShow': divShow,
                        'objectId': objectId,
                        'typeActive': typeActive,
                        'formName': formName,
                        'noteCancel': noteCancel,
                    },
                    success: function (res) {
                        $('#loaderRight').hide();
                        if (res.success == 1) {
                            jqueryCommon.showMsg('success','Cập nhật thành công');
                            $('#'+res.divShowAjax).html(res.html);
                            jqueryCommon.hideContentOtherRightPage();
                        } else {
                            jqueryCommon.showMsg('error','','Thông báo lỗi',res.message);
                        }
                    }
                });
            }
        });
    }
</script>