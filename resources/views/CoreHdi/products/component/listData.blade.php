{{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Search')}}</h5>
        <div class="ibox-tools marginDownT6">
            @if($is_root || $permission_view)
                <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
            @endif
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="form-group col-lg-6">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
            </div>
            <div class="form-group col-lg-6">
                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                <select  class="form-control input-sm" name="p_status" id="p_status">
                    {!! $optionStatus !!}}
                </select>
            </div>
            <hr>
        </div>
    </div>
</div>
{{ Form::close() }}
<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        <th width="4%" class="text-center">{{viewLanguage('STT')}}</th>
                        <th width="15%" class="text-left">{{viewLanguage('Product code')}}</th>
                        <th width="25%" class="text-left">{{viewLanguage('Product name')}}</th>

                        <th width="10%" class="text-left">{{viewLanguage('Danh mục')}}</th>
                        <th width="10%" class="text-left">{{viewLanguage('Nhóm BH')}}</th>

                        <th width="10%" class="text-left">{{viewLanguage('Trạng thái')}}</th>
                        <th width="10%" class="text-left">{{viewLanguage('Người thao tác')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr @if($is_root || $permission_view)class="detailCommon"@endif data-form-name="detailOrg" data-input="{{json_encode(['item'=>$item])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}{{$item->PRODUCT_NAME}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="{{$item->BP_ID}}">
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-left middle">{{$item->PRODUCT_CODE}}</td>
                            <td class="text-left middle">{{$item->PRODUCT_NAME}}</td>

                            <td class="text-left middle">{{$item->CATEGORY}}</td>
                            <td class="text-left middle">{{$item->GROUP_INSUR}}</td>

                            <td class="text-left middle">{{$item->STATUS}}</td>
                            <td class="text-left middle">
                                {{$item->CREATE_BY}}<br>
                                {{$item->MODIFIED_BY}}<br>
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
