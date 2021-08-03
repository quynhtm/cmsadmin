<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        {{--<th width="3%" class="text-center"><input type="checkbox" class="check" id="checkAll"></th>--}}
                        <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                        <th width="6%" class="text-center middle">{{viewLanguage('Thao tác')}}</th>
                        <th width="8%" class="text-left middle">{{viewLanguage('Mã tiền tố')}}</th>

                        <th width="20%" class="text-left middle">{{viewLanguage('Đối tác')}}</th>
                        <th width="22%" class="text-left middle">{{viewLanguage('Chiến dịch')}}</th>
                        <th width="8%" class="text-left middle">{{viewLanguage('Voucher cho')}}</th>
                        <th width="8%" class="text-center middle">{{viewLanguage('SL cấp phát')}}</th>
                        <th width="18%" class="text-center middle">{{viewLanguage('Thời gian hiệu lực')}}</th>

                        <th width="14%" class="text-center middle">{{viewLanguage('Status')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr @if($is_root || $permission_view || $permission_add)class="detailCommon"@endif data-form-name="detailItem" data-input="{{json_encode(['item'=>$item,'arrKey'=>['CAMPAIGN_CODE'=>$item->CAMPAIGN_CODE,'GIFT_CODE'=>$item->GIFT_CODE,'GIFT_TYPE'=>$item->GIFT_TYPE]])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}{{$item->CAMPAIGN_CODE}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="1">
                            {{--<td class="text-center middle">
                                <input class="check" type="checkbox" name="checkItems[]" id="sys_checkItems" value="{{$item->ORG_CODE}}">
                            </td>--}}
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-center middle">
                                @if($is_root || $permission_edit || $permission_add)
                                    <a style="color: red" data-form-name="detailItem" class="sys_delete_item_common" data-input="{{json_encode(['item'=>$item,'arrKey'=>['CAMPAIGN_CODE'=>$item->CAMPAIGN_CODE,'GIFT_CODE'=>$item->GIFT_CODE,'GIFT_TYPE'=>$item->GIFT_TYPE]])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}{{$item->CAMPAIGN_CODE}}" data-method="post" data-url="{{$urlUpdateStatusItem}}" data-objectId="1">
                                        <i class="pe-7s-trash fa-2x"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="text-left middle">{{$item->GIFT_CODE}}</td>

                            <td class="text-left middle">{{$item->ORG_NAME}}</td>
                            <td class="text-left middle">{{$item->CAMPAIGN_NAME}}</td>
                            <td class="text-left middle">
                                @if(isset($arrGiftType[$item->GIFT_TYPE])){{$arrGiftType[$item->GIFT_TYPE]}}@endif
                            </td>
                            <td class="text-center middle">{{$item->AMOUNT_ALLOCATE}}</td>
                            <td class="text-center middle">
                                @if(trim($item->EFFECTIVE_DATE) != '')
                                    <span class="green">{{convertDateDMY($item->EFFECTIVE_DATE)}}</span>
                                @endif
                                @if(trim($item->EXPIRATION_DATE) != '')
                                    - <span class="red">{{convertDateDMY($item->EXPIRATION_DATE)}}</span>
                                @endif
                            </td>
                            <td class="text-center middle">
                                @if(isset($arrStatus[$item->STATUS]))<b>{{$arrStatus[$item->STATUS]}}</b>@endif
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
