<div>
    <form id="form_{{$formName}}">
    <div class="formInforItem  @if($objectId <= 0)display-none-block @endif" >
        <div class="">
            <div class="form-group form-infor-detail paddingT10">
                <h4>Thông tin chung</h4>
                <div class="row form-group">
                    <div class="col-lg-4">
                        Số hợp đồng: <b class="showInforItem" data-field="CONTRACT_NO"></b>
                    </div>
                    <div class="col-lg-4">
                        Sản phẩm: <b class="showInforItem" data-field="PRODUCT_NAME"></b>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        Khách hàng: <b class="showInforItem" data-field="NAME"></b>
                    </div>
                    <div class="col-lg-4">
                        Ngày sinh: <b class="showInforItem" data-field="DOB"></b>
                    </div>

                    <div class="col-lg-4">
                        Số điện thoại: <b class="showInforItem" data-field="PHONE"></b>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        CMND/CCCD/Hộ chiếu: <b class="showInforItem" data-field="IDCARD"></b>
                    </div>
                    <div class="col-lg-4">
                        Email: <b class="showInforItem" data-field="EMAIL"></b>
                    </div>
                    <div class="col-lg-4">
                        Địa chỉ: <b class="showInforItem" data-field="ADDRESS"></b>
                    </div>
                </div>
            </div>

            @if(isset($dataItem) && !empty($dataItem && $dataItem['RELATIONSHIP'] != RELATIONSHIP_BAN_THAN))
                <div class="form-group form-infor-detail marginT20">
                    <h4>Người khai báo</h4>
                    <div class="row form-group">
                        <div class="col-lg-4">
                            Họ tên: <b class="showInforItem" data-field="">{{$dataItem['NAME']}}</b>
                        </div>
                        <div class="col-lg-4">
                            Quan hệ với NĐBH: <b class="showInforItem" data-field="">{{$dataItem['RELATIONSHIP']}}</b>
                        </div>
                        <div class="col-lg-4">
                            CMND/CCCD/Hộ chiếu: <b class="showInforItem" data-field="">{{$dataItem['IDCARD']}}</b>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-4">
                            Ngày sinh: <b class="showInforItem" data-field="">{{$dataItem['DOB']}}</b>
                        </div>
                        <div class="col-lg-4">
                            Số điện thoại: <b class="showInforItem" data-field="">{{$dataItem['PHONE']}}</b>
                        </div>
                        <div class="col-lg-4">
                            Email: <b class="showInforItem" data-field="">{{$dataItem['EMAIL']}}</b>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{----Form Edit----}}
    <div class="formEditItem @if($objectId > 0)display-none-block @endif" >
        <div class="">
            <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
            <input type="hidden" id="url_action" name="url_action" value="{{$urlPostItem}}">
            <input type="hidden" id="formName" name="formName" value="{{$formName}}">
            <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
            <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
            <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
            {{ csrf_field() }}
        </div>
    </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".a_edit_block").on('click', function () {
            jqueryCommon.clickEditBlock(this);
        });

        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
        showDataIntoForm('form_{{$formName}}');
    });
</script>