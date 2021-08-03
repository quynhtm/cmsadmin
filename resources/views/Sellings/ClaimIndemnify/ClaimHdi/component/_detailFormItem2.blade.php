<div>
    <form id="form_formNameOther">
        <div class="formInforItem @if($objectId <= 0)display-none-block @endif" >
            <div class="marginT15">

                {{---------Thông tin bồi thường mở rộng----------}}
                @if(isset($inforDetailExten) && !empty($inforDetailExten))
                <div class="form-group form-infor-detail ">
                    <h4>Thông tin bồi thường mở rộng</h4>
                    <div class="row form-group">
                        @foreach($inforDetailExten as $key1 => $item1)
                            <div class="col-lg-4">
                                {{$item1->INS_DESC}}: <b class="showInforItem" data-field="">{{$item1->INS_VALUE}}</b>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{---------Yêu cầu bồi thường----------}}
                @if(isset($desRequestClaim) && !empty($desRequestClaim))
                    @foreach($desRequestClaim as $key2 => $item2)
                        <div class="form-group form-infor-detail  marginT20">
                            <h4>{{$item2['BEN_NAME']}}</h4>
                            <div class="row form-group">
                                @foreach($item2['ARR_LIST'] as $key_item => $item_chi)
                                <div class="col-lg-4">
                                    {{$item_chi['DEC_DESC']}}: <b class="showInforItem" data-field="">{{$item_chi['DEC_VALUE']}}</b>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif

                {{---------Chi tiết bồi thường----------}}
                @if(isset($dataItem) && !empty($dataItem))
                    <div class="form-group form-infor-detail  marginT20">
                        <h4>Khách hàng yêu cầu bồi thường</h4>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                Số tiền YC bồi thường: <b class="showInforItem" data-field="">{{numberFormat($dataItem['REQUIRED_AMOUNT'])}} {{MONEY_VND}}</b>
                            </div>
                            <div class="col-lg-4">
                                Hình thức chuyển tiền: <b class="showInforItem" data-field="">Chuyển khoản</b>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                Số tài khoản: <b class="showInforItem" data-field="">{{$dataItem['ACCOUNT_NO']}}</b>
                            </div>
                            <div class="col-lg-4">
                                Chủ tài khoản: <b class="showInforItem" data-field="">{{$dataItem['ACCOUNT_NAME']}}</b>
                            </div>
                            <div class="col-lg-4">
                                Ngân hàng: <b class="showInforItem" data-field="">{{$dataItem['ACCOUNT_BANK']}}</b>
                            </div>
                        </div>
                    </div>
                    @if(isset($dataItem['AMOUNT']) && $dataItem['AMOUNT'] > 0)
                        <div class="form-group form-infor-detail marginT20">
                            <h4>Kết quả xử lý bồi thường</h4>
                            <div class="row form-group">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        Kết quả: <b class="showInforItem" data-field="">Đồng ý bồi thường</b>
                                    </div>
                                    <div class="form-group">
                                        Số tiền bồi thường: <b class="showInforItem" data-field="">{{numberFormat($dataItem['AMOUNT'])}} {{MONEY_VND}}</b>
                                    </div>
                                </div>
                                @if(isset($listDuocBoiThuong) && !empty($listDuocBoiThuong))
                                    <div class="col-lg-7">
                                        <table class="table table-bordered table-hover marginBottom-unset">
                                            <thead class="thin-border-bottom">
                                            <tr class="table-background-header">
                                                <th width="3%" class="text-center middle">STT</th>
                                                <th width="70%" class="text-left middle">{{viewLanguage('Quyền lợi bồi thường')}}
                                                </th>
                                                <th width="27%" class="text-right middle">{{viewLanguage('Số tiền bồi thường')}}
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($listDuocBoiThuong as $keybt => $itembt)
                                                <tr>
                                                    <td class="text-center middle">{{$keybt+1}}</td>
                                                    <td class="text-left middle">{{$itembt->BEN_NAME}}</td>
                                                    <td class="text-right middle">
                                                        <b class="red">{{numberFormat($itembt->AMOUNT)}} {{MONEY_VND}}</b>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endif
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