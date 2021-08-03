<div class="ibox-content">
    @if($data && sizeof($data) > 0)
        <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                    <th width="68%" class="text-left">{{viewLanguage('Version code')}}</th>
                    <th width="15%" class="text-center">{{viewLanguage('Tình trạng')}}</th>
                    <th width="15%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr @if($is_root || $permission_view || $permission_add || $permission_edit)class="detailCommon"@endif data-form-name="detailItem" data-input="{{json_encode(['item'=>$item])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ').$item->VERSION_CODE}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="{{$item->VER_ID}}">
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-left middle">{{$item->VERSION_CODE}}</td>
                        <td class="text-center middle">{{$item->STATUS}}</td>
                        <td class="text-center middle">@if($arrActive[$item->IS_ACTIVE]){{$arrActive[$item->IS_ACTIVE]}}@endif</td>
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
