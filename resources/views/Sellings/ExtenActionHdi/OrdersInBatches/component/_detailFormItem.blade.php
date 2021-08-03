{{---ID > 0 và có thông tin data---}}
<div>
    <div class="card-header paddingLeft-unset">
        <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
             Thông tin đơn
        </div>
        @if($objectId > 0)
            <div class="col-lg-2 text-right card-title-2 display-none-block">
                <input type="hidden" id="show_block_detail_1" name="show_block_detail_1" value="1">
                <a href="javascript:;" data-block="detail_1" data-infor="formInforItem" data-edit="formEditItem" class="a_edit_block color_hdi"> Sửa</a>
            </div>
        @endif
    </div>
    {{----Block thông tin----}}
    <form id="form_{{$formName}}">
    <div class="formInforItem @if($objectId <= 0)display-none-block @endif" >
        <div class="marginT15">
            <div class="form-group form-infor-detail">
                <div class="row form-group">
                    <div class="col-lg-4">
                        Khách hàng: <b class="showInforItem" data-field="NAME"></b>
                    </div>
                    <div class="col-lg-4">
                        Đơn vị cấp: <b class="showInforItem" data-field="ORG_INIT_CODE"></b>
                    </div>
                    <div class="col-lg-4">
                        Số tiền cần thanh toán: <b class="showInforItem" data-field="">@if(isset($data->AMOUNT)){{numberFormat($data->AMOUNT)}}@endif @if(isset($data->CURRENCY)){{$data->CURRENCY}}@endif</b>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        Số điện thoại: <b class="showInforItem" data-field="PHONE"></b>
                    </div>
                    <div class="col-lg-4">
                        Ngày tạo đơn: <b class="showInforItem" data-field="ORDER_DATE"></b>
                    </div>
                    <div class="col-lg-4">
                        Nội dung thanh toán: <b class="showInforItem" data-field="CONTENT_PAY"></b>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{----Form Edit----}}
    <div class="formEditItem" >
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
    function compareDate(){
        var startDate = $('#EFFECTIVE_DATE').val();
        alert(startDate);
        var job_start_date = "10-1-2014"; // Oct 1, 2014
        var job_end_date = "11-1-2014"; // Nov 1, 2014
        job_start_date = job_start_date.split('-');
        job_end_date = job_end_date.split('-');

        var new_start_date = new Date(job_start_date[2],job_start_date[0],job_start_date[1]);
        var new_end_date = new Date(job_end_date[2],job_end_date[0],job_end_date[1]);

        if(new_end_date <= new_start_date) {
            // your code
        }
    }
</script>