<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        {{--<th width="3%" class="text-center"><input type="checkbox" class="check" id="checkAll"></th>--}}
                        <th width="4%" class="text-center">{{viewLanguage('STT')}}</th>
                        <th width="8%" class="text-center">{{viewLanguage('Action')}}</th>
                        <th width="12%" class="text-left">{{viewLanguage('Mã tổ chức')}}</th>
                        <th width="25%" class="text-left">{{viewLanguage('Tên tổ chức')}}</th>
                        <th width="45%" class="text-left">{{viewLanguage('Địa chỉ')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr @if($is_root || $permission_view)class="detailCommon"@endif data-form-name="detailOrg" data-input="{{json_encode(['item'=>$item])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}{{$item->ORG_CODE}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="{{$item->ORG_ID}}">
                            {{--<td class="text-center middle">
                                <input class="check" type="checkbox" name="checkItems[]" id="sys_checkItems" value="{{$item->ORG_CODE}}">
                            </td>--}}
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-center middle">
                                @if($is_root || $permission_edit || $permission_add)
                                    <a href="javascript:void(0);" style="color: red" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Xóa thông tin: ')}}{{$item->ORG_CODE}}" data-method="post" data-url="{{$urlDeleteItem}}" data-input="{{json_encode(['item'=>$item])}}">
                                        <i class="pe-7s-trash fa-2x"></i>
                                    </a>&nbsp;
                                @endif
                                @if($item->IS_ACTIVE == STATUS_INT_MOT)
                                    <a href="javascript:void(0);" class="green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                @else
                                    <a href="javascript:void(0);" class="red" title="Ẩn"><i class="fa fa-minus fa-2x"></i></a>
                                @endif
                            </td>
                            <td class="text-left middle">{{$item->ORG_CODE}}</td>
                            <td class="text-left middle">{{$item->ORG_NAME}}</td>
                            <td class="text-left middle">{{$item->ADDRESS_SHORT}}</td>
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
