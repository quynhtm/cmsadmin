{{---ID > 0 và có thông tin data---}}
<div>
    <div class="card-header paddingLeft-unset">
        <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
             Thông tin chung đơn bảo hiểm
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
                        Số hợp đồng: <b class="showInforItem" data-field="CONTRACT_NO"></b>
                    </div>
                    <div class="col-lg-4">
                        Sản phẩm: <b class="showInforItem" data-field="CATEGORY_NAME"></b>
                    </div>
                    <div class="col-lg-4">
                        Loại hợp đồng: <b class="showInforItem" data-field="LO_NAME"></b>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12">
                        Hiệu lực hợp đồng: <b class="showInforItem" data-field="">
                            @if(isset($data->EFFECTIVE_DATE) && trim($data->EFFECTIVE_DATE) != ''){{cutStrDate($data->EFFECTIVE_DATE)}}@endif
                            @if(isset($data->EXPIRATION_DATE) && trim($data->EXPIRATION_DATE) != '') - {{cutStrDate($data->EXPIRATION_DATE)}}@endif
                        </b>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        Khách hàng:@if(isset($data->GENDER) && isset($arrDanhXung[$data->GENDER])){{$arrDanhXung[$data->GENDER]}}@endif <b class="showInforItem" data-field="">
                            @if(isset($data->NAME)) {{$data->NAME}}@endif
                        </b>
                    </div>
                    <div class="col-lg-8">
                        Địa chỉ: <b class="showInforItem" data-field="ADDRESS_FULL"></b>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        Số CMND/CCCD: <b class="showInforItem" data-field="IDCARD"></b>
                    </div>
                    <div class="col-lg-4">
                        Ngày cấp: <b class="showInforItem" data-field="IDCARD_D"></b>
                    </div>
                    <div class="col-lg-4">
                        Nơi cấp: <b class="showInforItem" data-field="IDCARD_P"></b>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        Số điện thoại: <b class="showInforItem" data-field="PHONE"></b>
                    </div>
                    <div class="col-lg-4">
                        Mail: <b class="showInforItem" data-field="EMAIL"></b>
                    </div>
                    <div class="col-lg-4">
                        ĐV thụ hưởng: <b class="showInforItem" data-field="BEN_ORG_NAME"></b>
                    </div>
                </div>
            </div>
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
            <div class="card-header-2 paddingLeft-unset">
                <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
                    Người được bảo hiểm
                </div>
            </div>
            <div class="form-group marginT10">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Danh xưng')}} </label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="GENDER" id="form_{{$formName}}_GENDER">
                            {!! $optionDanhXung !!}}
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Tên')}} </label> <span class="red"> (*)</span>
                        <input type="text" class="form-control input-sm" minlength="1" maxlength="150" required name="NAME" id="form_{{$formName}}_NAME">
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Số điện thoại')}} </label> <span class="red"> (*)</span>
                        <input type="number" class="form-control input-sm" minlength="1" maxlength="50" required name="PHONE" id="form_{{$formName}}_PHONE">
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Mail')}} </label> <span class="red"> (*)</span>
                        <input type="text" class="form-control input-sm" minlength="1" maxlength="150" required name="EMAIL" id="form_{{$formName}}_EMAIL">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Số CMND/CCCD')}} </label> <span class="red"> (*)</span>
                        <input type="text" class="form-control input-sm" minlength="1" maxlength="20" required name="IDCARD" id="form_{{$formName}}_IDCARD">
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày cấp')}} </label> <span class="red"> (*)</span>
                        <input type="text" class="form-control input-sm input-date" data-valid = "text" required name="IDCARD_D" id="{{$formName}}_IDCARD_D" value="@if(isset($data->EFFECTIVE_DATE)){{$data->IDCARD_D}}@endif">
                        <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Nơi cấp')}} </label> <span class="red"> (*)</span>
                        <input type="text" class="form-control input-sm" minlength="1" maxlength="250" required name="IDCARD_P" id="form_{{$formName}}_IDCARD_P">
                    </div>
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày sinh')}} </label>
                        <input type="text" class="form-control input-sm input-date" data-valid = "text" name="DOB" id="{{$formName}}_DOB" value="@if(isset($data->DOB)){{convertDateDMY($data->DOB)}}@endif">
                        <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Số nhà, ngõ, nghách, đường')}} </label> <span class="red"> (*)</span>
                        <input type="text" class="form-control input-sm" minlength="1" maxlength="50" required name="ADDRESS" id="form_{{$formName}}_ADDRESS">
                    </div>
                    <div class="col-lg-2 paddingRight-unset">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Tỉnh/TP')}}</label>
                        <select class="form-control input-sm paddingNone" name="PROVINCE" id="PROVINCE" onchange="jqueryCommon.buildOptionCommon('form_{{$formName}}_PROVINCE','OPTION_DISTRICT_CODE','form_{{$formName}}_DISTRICT')">
                            {!! $optionProvince !!}
                        </select>
                    </div>
                    <div class="col-lg-2 paddingNone">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Quận huyện')}}</label>
                        <select class="form-control input-sm paddingNone" name="DISTRICT" id="DISTRICT" onchange="jqueryCommon.buildOptionCommon('form_{{$formName}}_DISTRICT','OPTION_WARD_CODE','form_{{$formName}}_WARDS')">
                            {!! $optionDistrict !!}
                        </select>
                    </div>
                    <div class="col-lg-2 paddingLeft-unset">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Phường xã')}}</label>
                        <select class="form-control input-sm paddingNone" name="WARDS" id="WARDS" >
                            {!! $optionWard !!}
                        </select>
                    </div>
                </div>
            </div>

            {{--Thụ hưởng, cán bộ ngân hàng---}}
            <div class="card-header-2 paddingLeft-unset">
                <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
                    Thụ hưởng, cán bộ ngân hàng
                </div>
            </div>
            <div class="form-group marginT10">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Đơn vị thụ hưởng')}} </label><span class="red"> (*)</span>
                        <select  class="form-control input-sm" name="BEN_ORG_CODE" id="form_{{$formName}}_BEN_ORG_CODE">
                            {!! $optionDonViThuHuong !!}}
                        </select>
                    </div>
                </div>
            </div>

            {{--Upload file---}}
            <div class="card-header-2 paddingLeft-unset">
                <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
                    Upload file
                </div>
            </div>
            <div class="form-group marginT10">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="NAME" class="text-right control-label">{{viewLanguage('Tải giấy yêu cầu sửa đổi bổ xung')}} </label>
                    </div>
                    <button type="button" class="col-lg-3 btn-transition btn btn-outline-success">Tải về</button>
                </div>
                <div class="row marginT15">
                    <div class="col-lg-4">
                        <label for="NAME" class="text-right control-label"><b>{{viewLanguage('Gửi yêu cầu bổ xung')}}</b></label>
                        <button class="div-upload-img" type="button" >{{----onclick="jqueryCommon.uploadMultipleImagesCommon(2);"---}}
                            <i class="pe-7s-cloud-upload fa-2x color_hdi"></i>
                            <br/>Ấn vào đây để chọn file
                        </button>
                    </div>
                    <div class="col-lg-4">
                        <label for="NAME" class="text-right control-label"><b>{{viewLanguage('Các file khác')}}</b></label>
                        <button class="div-upload-img" type="button">
                            <i class="pe-7s-cloud-upload fa-2x color_hdi"></i>
                            <br/>Ấn vào đây để chọn file
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group marginT15">
                <div class="row">
                    <div class="col-lg-3">
                        <button type="button" class="col-lg-12 btn-transition  btn btn-success" onclick="jqueryCommon.doSubmitForm();">Lưu sửa đổi</button>
                    </div>
                    <div class="col-lg-3">
                        <button type="button" class="col-lg-12 btn-transition btn btn-outline-success a_edit_block" data-block="detail_1" data-infor="formInforItem" data-edit="formEditItem">Hủy bỏ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<!--Popup upload ảnh-->
<div class="modal fade" id="sys_PopupUploadImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Upload ảnh</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                    <div class="form_group">
                        <div id="sys_mulitplefileuploader" class="btn btn-primary">Upload ảnh</div>
                        <div id="status"></div>

                        <div class="clearfix"></div>
                        <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                            <div id="div_image"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Popup upload ảnh-->

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