<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        <th width="3%" class="text-center"><input type="checkbox" class="check" id="checkAll"></th>
                        <th width="4%" class="text-center">{{viewLanguage('STT')}}</th>
                        <th width="6%" class="text-center">{{viewLanguage('Action')}}</th>
                        <th width="15%" class="text-left">{{viewLanguage('Bank code')}}</th>

                        <th width="22%" class="text-left">{{viewLanguage('Bank name')}}</th>
                        <th width="10%" class="text-left">{{viewLanguage('Parent code')}}</th>
                        {{--<th width="20%" class="text-left">{{viewLanguage('Infor')}}</th>--}}
                        <th width="40%" class="text-left">{{viewLanguage('Address')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr @if($is_root || $permission_view)class="detailCommon"@endif data-form-name="detailOrg" data-input="{{json_encode(['item'=>$item])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}{{$item->BANK_NAME}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="{{$item->BANK_ID}}">
                            <td class="text-center middle">
                                <input class="check" type="checkbox" name="checkItems[]" id="sys_checkItems" value="{{$item->BANK_ID}}">
                            </td>
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-center middle">
                                @if($is_root || $permission_edit || $permission_add)
                                    <a href="javascript:void(0);" style="color: red" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Xóa thông tin: ')}}{{$item->BANK_CODE}}" data-method="post" data-url="{{$urlDeleteItem}}" data-input="{{json_encode(['item'=>$item])}}">
                                        <i class="pe-7s-trash fa-2x"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="text-left middle">{{$item->BANK_CODE}}</td>
                            <td class="text-left middle">{{$item->BANK_NAME}}</td>
                            <td class="text-left middle">{{$item->PARENT_CODE}}</td>
                            {{--<td class="text-left middle">
                                @if(trim($item->EMAIL) != '')E: {{$item->EMAIL}} <br> @endif
                                @if(trim($item->PHONE_SERVICE) != '')P: {{$item->PHONE_SERVICE}} <br> @endif
                                @if(trim($item->WEBSITE) != '')W: {{$item->WEBSITE}} <br> @endif
                            </td>--}}
                            <td class="text-left middle">{{$item->BANK_ADDRESS}}</td>
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
