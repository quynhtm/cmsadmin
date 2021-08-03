@foreach ($listBoiThuong as $keybt => $itembt)
    <tr id="tr_claim_chose_{{$itembt->BEN_CODE}}">
        <td class="text-left middle">
            <a href="javascript:void(0);" style="color: red" title="{{viewLanguage('Bỏ quyền lợi bồi thường này')}}" onclick="removeOptionClaim('{{$itembt->BEN_CODE}}');"><i class="fa fa-trash fa-2x"></i></a>&nbsp;&nbsp;
            @if($itembt->BEN_NAME != '')
                {{$itembt->BEN_NAME}}
            @else
                <input type="text" id="name_ben_code_{{$itembt->BEN_CODE}}" name="name_ben_code_{{$itembt->BEN_CODE}}" class="w-75" value="{{$itembt->BEN_CODE}}">
            @endif
        </td>
        <td class="text-center middle">
            <input type="text" id="{{$itembt->BEN_CODE}}" name="{{$itembt->BEN_CODE}}" value="0" class="form-control input-sm text-right input_money_boi_thuong" onchange="changeMoneyBoiThuong(this);">
            <input type="hidden" class="input_money_bt" id="money_{{$itembt->BEN_CODE}}" name="money_{{$itembt->BEN_CODE}}" value="0">
            <input type="hidden" id="claim_chose_{{$itembt->BEN_CODE}}" name="claim_chose[]" value="{{$itembt->BEN_CODE}}">
        </td>
    </tr>
@endforeach