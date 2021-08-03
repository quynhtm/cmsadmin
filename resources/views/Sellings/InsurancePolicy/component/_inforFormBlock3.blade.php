<div>
    <div class="card-header paddingLeft-unset">
        <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
             Upload file
        </div>
        <div class="col-lg-2 text-right card-title-2">
            <input type="hidden" id="show_block_infor_3" name="show_block_infor_3" value="1">
            <a href="javascript:;" data-block="infor_3" data-infor="formInforBlock3" data-edit="formEditBlock3" class="a_edit_block color_hdi"> Sửa</a>
        </div>
    </div>
    {{----Block thông tin----}}
    <div class="formInforBlock3 @if($objectId <= 0)display-none-block @endif" >
        <div class="marginT15">
            <div class="row">
                <div class="col-lg-3 text-right">
                    <label for="NAME" class="control-label paddingT5">{{viewLanguage('Tải giấy yêu cầu bảo hiểm')}} </label>
                </div>
                <button type="button" class="col-lg-3 btn-transition btn btn-outline-success">Tải về</button>
            </div>
        </div>
        <div class="col-lg-12 card-header paddingLeft-unset" style="height: 1rem"></div>
        <div class="row marginT15">
            <div class="col-lg-4">
                <label for="NAME" class="control-label col-lg-12"><b>{{viewLanguage('Gửi yêu cầu bảo hiểm')}}<span class="red">*</span></b></label>
                @if(isset($inforFormBlock3['GYC']) && !empty($inforFormBlock3['GYC']))
                    @foreach($inforFormBlock3['GYC'] as $kf1=>$file_gyc)
                        <div class="col-lg-12 marginT10 color_hdi">
                            {{$file_gyc->FILE_NAME}}
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="control-label col-lg-12"><b>{{viewLanguage('CMND/CCCD/Hộ chiếu')}}</b></label>
                @if(isset($inforFormBlock3['CMND']) && !empty($inforFormBlock3['CMND']))
                    @foreach($inforFormBlock3['CMND'] as $kf2=>$file_cmnd)
                        <div class="col-lg-12 marginT10 color_hdi">
                            {{$file_cmnd->FILE_NAME}}
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-lg-4">
                <label for="NAME" class="text-right control-label"><b>{{viewLanguage('Các file khác')}}</b></label>
                @if(isset($inforFormBlock3['KHAC']) && !empty($inforFormBlock3['KHAC']))
                    @foreach($inforFormBlock3['KHAC'] as $kf3=>$file_khac)
                        <div class="col-lg-12 marginT10 color_hdi">
                            {{$file_khac->FILE_NAME}}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{----Form Edit----}}
    <form id="form_InforBlock3">
        <div class="formEditBlock3 display-none-block" >
            <div class="">
                <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
                <input type="hidden" id="url_action" name="url_action" value="{{$urlPostItem}}">
                <input type="hidden" id="formName" name="formName" value="{{$formName}}">
                <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
                <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
                <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
                <input type="hidden" id="_STATUS" name="STATUS" @if(isset($data->STATUS))value="{{$data->STATUS}}" @else value="INACTIVE" @endif>
                {{ csrf_field() }}
                {{--Upload file---}}
                <div class="card-header-2 paddingLeft-unset">
                    <div class="col-lg-10 text-left card-title-2 paddingLeft-unset">
                        Upload file
                    </div>
                </div>
                <div class="form-group marginT10">
                    <div class="row">
                        <div class="col-lg-3 text-right">
                            <label for="NAME" class="control-label paddingT5">{{viewLanguage('Tải giấy yêu cầu bảo hiểm')}} </label>
                        </div>
                        <button type="button" class="col-lg-3 btn-transition btn btn-outline-success">Tải về</button>
                    </div>
                    <div class="col-lg-12 card-header paddingLeft-unset" style="height: 1rem"></div>
                    <div class="row marginT15">
                        <div class="col-lg-4">
                            <label for="NAME" class="text-right control-label"><b>{{viewLanguage('Gửi yêu cầu bảo hiểm')}}<span class="red">*</span></b></label>
                            <button class="div-upload-img">
                                <i class="pe-7s-cloud-upload fa-2x color_hdi"></i>
                                <br/>Ấn vào đây để chọn file
                            </button>
                            <div class="clearfix"></div>

                            @if(isset($inforFormBlock3['GYC']) && !empty($inforFormBlock3['GYC']))
                                @foreach($inforFormBlock3['GYC'] as $kf11=>$file_gyc)
                                    <div class="row marginT10 color_hdi">
                                        <div class="col-lg-8">
                                            {{$file_gyc->FILE_NAME}}
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button" class="btn-danger"><i class="pe-7s-trash"></i> Xóa</button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="col-lg-4">
                            <label for="NAME" class="text-right control-label"><b>{{viewLanguage('CMND/CCCD/Hộ chiếu')}}</b></label>
                            <button class="div-upload-img">
                                <i class="pe-7s-cloud-upload fa-2x color_hdi"></i>
                                <br/>Ấn vào đây để chọn file
                            </button>
                            <div class="clearfix"></div>

                            @if(isset($inforFormBlock3['CMND']) && !empty($inforFormBlock3['CMND']))
                                @foreach($inforFormBlock3['CMND'] as $kf22=>$file_cmnd)
                                    <div class="row marginT10 color_hdi">
                                        <div class="col-lg-8">
                                            {{$file_cmnd->FILE_NAME}}
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button" class="btn-danger"><i class="pe-7s-trash"></i> Xóa</button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="col-lg-4">
                            <label for="NAME" class="text-right control-label"><b>{{viewLanguage('Các file khác')}}</b></label>
                            <button class="div-upload-img">
                                <i class="pe-7s-cloud-upload fa-2x color_hdi"></i>
                                <br/>Ấn vào đây để chọn file
                            </button>
                            <div class="clearfix"></div>

                            @if(isset($inforFormBlock3['KHAC']) && !empty($inforFormBlock3['KHAC']))
                                @foreach($inforFormBlock3['KHAC'] as $kf33=>$file_khac)
                                    <div class="row marginT10 color_hdi">
                                        <div class="col-lg-8">
                                            {{$file_khac->FILE_NAME}}
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button" class="btn-danger"><i class="pe-7s-trash"></i> Xóa</button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 card-header paddingLeft-unset" style="height: 1rem"></div>
                <div class="form-group marginT10">
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="checkbox" class="custom-checkbox float-left" id="order_status" name="order_status" onchange="changerRadio();">
                            <label for="order_status" class="float-left marginL10">Thanh toán luôn</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Chọn phương thức thanh toán')}} </label> <span class="red"> (*)</span>
                        </div>
                        <div class="col-lg-4">
                            <select  class="form-control input-sm" name="CURRENCY" id="form_{{$formName}}_CURRENCY">
                                {!! $optionHinhThucThanhToan !!}}
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" class="custom-checkbox float-left" id="order_status" name="order_status" onchange="changerRadio();">
                            <label for="order_status" class="float-left marginL10">Gửi nội dung chuyển khoản qua SMS</label>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" class="custom-checkbox float-left" id="order_status" name="order_status" onchange="changerRadio();">
                            <label for="order_status" class="float-left marginL10">Gửi nội dung chuyển khoản qua Email</label>
                        </div>
                    </div>
                </div>
                <div class="marginT15">
                    <div class="form-group form-infor-detail">
                        <div class="row form-group">
                            <div class="col-lg-12 red">
                                Quý khách vui lòng Chuyển khoản với nội dung "..." cho STK: "..."
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group marginT15">
                    <div class="row">
                        <div class="col-lg-3">
                            <button type="button" class="col-lg-12 btn-transition  btn btn-success">Lưu và thanh toán</button>
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="col-lg-12 btn-transition btn btn-outline-success a_edit_block" data-block="infor_3" data-infor="formInforBlock3" data-edit="formEditBlock3">Hủy bỏ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){

    });
</script>