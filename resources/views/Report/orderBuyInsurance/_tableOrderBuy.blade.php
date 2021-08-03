<div class="card-body">
    @if($data && sizeof($data) > 0)
        <div class="row">
            <div class="col-lg-6 text-left">
                <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{numberFormat($total)}}</b> bản ghi @endif</h5>
            </div>
            <div class="col-lg-6 text-right display-none-block">
                @if($total >0)
                    <button class="border-0 btn-transition btn btn-outline-success marginDownT15" type="submit" name="submit" value="2" title="Xuất excel"><i class="fa fa-file-excel fa-2x"></i></button>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="table-background-header">
                    <th width="3%" class="text-center middle">{{viewLanguage('STT')}}</th>
                    <th width="5%" class="text-center middle">{{viewLanguage('Files')}}</th>
                    <th width="15%" class="text-left middle">{{viewLanguage('Tên khách hàng')}}</th>

                    <th width="10%" class="text-center middle">{{viewLanguage('Số điện thoại')}}</th>
                    <th width="15%" class="text-center middle">{{viewLanguage('Email')}}</th>
                    <th width="27%" class="text-center middle">{{viewLanguage('Địa chỉ')}}</th>
                    <th width="8%" class="text-center middle">{{viewLanguage('Ngày YC')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center middle">{{$stt+$key+1}}</td>
                        <td class="text-center middle">
                            @if(isset($listFile) && isset($listFile[$item->REGISTER_ID]))
                            <a href="javascript:void(0);"class="color_hdi" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="detailItem" data-input="{{json_encode(['item'=>$listFile[$item->REGISTER_ID]])}}" data-show="1" data-override="1" data-div-show="content-page-right" title="{{viewLanguage('Danh sách files quyền lợi')}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="1">
                                <i class="lnr-download fa-2x"></i>
                            </a>
                            @endif
                        </td>
                        <td class="text-left middle">@if(isset($item->NAME)){{$item->NAME}}@endif</td>
                        <td class="text-center middle">@if(isset($item->PHONE)){{$item->PHONE}}@endif</td>
                        <td class="text-center middle">@if(isset($item->EMAIL)){{$item->EMAIL}}@endif</td>
                        <td class="text-left middle">@if(isset($item->ADDRESS)){{$item->ADDRESS}}@endif</td>
                        <td class="text-center middle">@if(isset($item->CREATE_DATE)){{$item->CREATE_DATE}}@endif</td>
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
<script type="text/javascript">
    $(document).ready(function(){
        jqueryCommon.pagingAjaxWithForm('{{$formSeachIndex}}','{{$urlSearchAjax}}');
    });
</script>