<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        <th width="5%" class="text-center">{{viewLanguage('STT')}}</th>
                        <th width="55%" class="text-left">{{viewLanguage('DOMAIN')}}</th>
                        <th width="25%" class="text-left">{{viewLanguage('ENV_CODE')}}</th>
                        <th width="15%" class="text-left">{{viewLanguage('Trạng thái')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr @if($is_root || $permission_view)class="detailCommon"@endif data-form-name="detailDatabases" data-input="{{json_encode(['item'=>$item])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}{{$item->DOMAIN}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="{{$item->DOMAIN_ID}}">
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-left middle">{{$item->DOMAIN}}</td>
                            <td class="text-left middle">{{$item->ENV_CODE}}</td>
                            <td class="text-left middle">
                                @if($arrStatus[$item->IS_ACTIVE]){{$arrStatus[$item->IS_ACTIVE]}}@endif
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
