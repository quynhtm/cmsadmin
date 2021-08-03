
{{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Search')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="form-group col-lg-3">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
            </div>
            <div class="form-group col-lg-3">
                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                <select  class="form-control input-sm" name="IS_ACTIVE" id="IS_ACTIVE">
                    {!! $optionStatus !!}}
                </select>
            </div>
            <div class="form-group col-lg-3">
                @if($is_root || $permission_view)
                    <button class="mb-2 mr-2 btn-icon btn btn-primary marginT25" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                @endif
            </div>
            <div class="form-group col-lg-3 marginT20 text-right">
                <a href="{{\Illuminate\Support\Facades\Config::get('config.URL_API_DEV')}}OpenApi/RemoveAll" target="_blank" class="btn-warning btn marginR15 marginL15"> Xóa cache</a>
                <a href="{{\Illuminate\Support\Facades\Config::get('config.URL_API_DEV')}}OpenApi/RemoveParams" target="_blank" class="btn-danger btn"> Reset param</a>
            </div>
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
                        {{--<th width="3%" class="text-center"><input type="checkbox" class="check" id="checkAll"></th>--}}
                        <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                        <th width="8%" class="text-center">{{viewLanguage('TT')}}</th>
                        <th width="10%" class="text-center">{{viewLanguage('Api code')}}</th>
                        <th width="15%" class="text-center">{{viewLanguage('Api name')}}</th>

                        <th width="35%" class="text-center">{{viewLanguage('Procedure')}}</th>
                        <th width="5%" class="text-center">{{viewLanguage('Type')}}</th>
                        <th width="5%" class="text-center">{{viewLanguage('Crud')}}</th>

                        <th width="8%" class="text-center">{{viewLanguage('Date')}}</th>
                        <th width="10%" class="text-center">{{viewLanguage('User')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td class="text-center middle">{{$stt+$key+1}}</td>
                            <td class="text-center middle">
                                @if($is_root || $permission_view || $permission_add)
                                    <a href="javascript:void(0);" style="color: green" onclick="jqueryCommon.getDetailCommonByAjax(this);" data-form-name="detailApi" data-input="{{json_encode(['item'=>$item])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}{{$item->API_CODE}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="{{$item->GID}}">
                                        <i class="pe-7s-look fa-2x"></i>
                                    </a>&nbsp;&nbsp;
                                @endif

                                @if($item->ISACTIVE == STATUS_INT_MOT)
                                    <a href="javascript:void(0);" class="green" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                @else
                                    <a href="javascript:void(0);" class="red" title="Ẩn"><i class="fa fa-minus fa-2x"></i></a>
                                @endif
                            </td>
                            <td class="text-center middle">{{$item->API_CODE}}</td>
                            <td class="text-left middle">{{$item->API_NAME}}</td>

                            <td class="text-left middle">{{$item->PRO_CODE}}</td>
                            <td class="text-center middle">{{$item->ACTION_TYPE}}</td>
                            <td class="text-center middle">{{$item->CRUD}}</td>

                            <td class="text-left middle">
                                @if(trim($item->CREATEDATE) != ''){{convertDateDMY($item->CREATEDATE)}} <br/>@endif
                                @if(trim($item->MODIFIEDDATE) != '')<span class="red">{{convertDateDMY($item->MODIFIEDDATE)}}</span>@endif
                            </td>
                            <td class="text-left middle">
                                @if(trim($item->CREATEBY) != ''){{$item->CREATEBY}}<br/>@endif
                                @if(trim($item->MODIFIEDBY) != '')<span class="red">{{$item->MODIFIEDBY}}</span>@endif
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
