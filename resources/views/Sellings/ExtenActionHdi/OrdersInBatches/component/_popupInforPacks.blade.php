<div class="modal-content" id="{{$form_id}}" style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_formUpdatePacks" enctype="multipart/form-data">
        <input type="hidden" id="formName" name="formName" value="{{$form_id}}">
        <input type="hidden" id="popup_progid" name="popup_progid" value="">
        <input type="hidden" id="popup_org_seller" name="popup_org_seller" value="{{$org_buyer}}">
        <input type="hidden" id="popup_product_code" name="popup_product_code" value="{{$product_code}}">
        <input type="hidden" id="str_json_pack" name="str_json_pack" @if(isset($listPacks) && !empty($listPacks))value="{{json_encode($listPacks)}}" @endif>
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body">
            @if(isset($listPacks) && !empty($listPacks))
            <div class="form_group">
                <?php
                $totalPack = count($listPacks);
                ?>
                <div class="form-group" @if($totalPack >=10)style="height: 600px; overflow: hidden; overflow-y: scroll" @endif>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="table-background-header">
                            <th width="5%" class="text-center middle">{{viewLanguage('STT')}}</th>
                            <th width="15%" class="text-center middle">{{viewLanguage('Mã gói')}}</th>
                            <th width="35%" class="text-center middle">{{viewLanguage('Tên gói')}}</th>

                            <th width="10%" class="text-center middle">{{viewLanguage('Phí')}}</th>
                            <th width="30%" class="text-center middle">{{viewLanguage('Quyền lợi')}}</th>
                            <!-- <th width="5%" class="text-center middle">{{viewLanguage('Upload')}}</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($listPacks as $key => $infor_pack)
                            <?php $pack_code = isset($infor_pack['PACK_CODE'])? $infor_pack['PACK_CODE']: 'PACK_CODE_'.$key?>
                            <tr>
                                <td class="text-center middle">
                                    {{$key+1}}<br/>
                                    <input class="check" type="checkbox" name="checkPack[]" @if(isset($infor_pack['IS_USED']) && $infor_pack['IS_USED']==1) checked @endif value="@if(isset($infor_pack['PACK_CODE'])){{$infor_pack['PACK_CODE']}}@endif">
                                </td>
                                <td class="text-left middle">@if(isset($infor_pack['PACK_CODE'])){{$infor_pack['PACK_CODE']}}@endif</td>
                                <td class="text-left middle">@if(isset($infor_pack['PACK_NAME'])){{$infor_pack['PACK_NAME']}}@endif</td>

                                <td class="text-right middle">@if(isset($infor_pack['FEES'])){{numberFormat($infor_pack['FEES'])}}@endif</td>
                                <td class="text-left middle">
                                    @if(isset($infor_pack['BENEFIT_URL']) && trim($infor_pack['BENEFIT_URL']) != '')
                                        <a class="color_hdi" target="_blank" href="{{$urlServiceFile.$infor_pack['BENEFIT_URL']}}" title="File quyền lợi: {{$infor_pack['BENEFIT_URL']}}">File quyền lợi</a>
                                    @endif
                                </td>
                                <!-- <td class="text-left text-middle middle">
                                    <div class="w-100">
                                        <input type="hidden" name="p_pack_benefit_url_{{$pack_code}}" id="p_pack_benefit_url_{{$pack_code}}" @if(isset($infor_pack['BENEFIT_URL'])) value="{{$infor_pack['BENEFIT_URL']}}" @endif >
                                        <label for="inputInterest_{{$pack_code}}" class="w-100 btn-transition btn btn-outline-success " style="padding-left: 0px!important; padding-right: 0px!important;" title="upload file quyền lợi PDF">
                                            <input type="file" name="inputInterest_{{$pack_code}}" id="inputInterest_{{$pack_code}}" style="display:none">
                                            <i class="fa fa-share-square"></i>
                                        </label>
                                    </div>
                                </td>-->
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
           <button type="button" class="btn btn-primary" id="submitInforPack"><i class="pe-7s-diskette"></i> {{viewLanguage('Save')}}</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        //list gói đc chọn
        var dataPack = [];
        var i = 0;
        $("input[name*='checkPack']").each(function () {
            if ($(this).is(":checked")) {
                dataPack[i] = $(this).val();
                i++;
            }
        });
        if (dataPack.length == 0) {
            jqueryCommon.showMsg('error', '', 'Thông báo lỗi','Bạn chưa chọn gói để cập nhật.');
            return false;
        }

        $("#submitInforPack").click(function (event) {
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#form_formUpdatePacks')[0];
            // Create an FormData object
            var data = new FormData(form);

            $('#loader').show();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: '{{$urlPostAddInforPacks}}',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (res) {
                    $('#loader').hide();
                    //$("#submitProgramme").prop("disabled", false);
                    if(res.success == 1){
                        jqueryCommon.showMsg('success', 'Đã cập nhật gói thành công');
                        $('#'+res.divShowInfor).html(res.html);
                        $('#sys_showPopupCommon').modal('hide');
                    }else {
                        jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.message);
                    }
                },
                error: function (e) {
                    console.log("ERROR : ", e);
                }
            });
        });
    });
</script>