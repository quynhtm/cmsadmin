{!!Form::open(array('method' => 'POST', 'role'=>'form')) !!}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
        <div class="ibox-tools marginDownT6">
            <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-2">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
            </div>
            <div class="col-lg-3">
                <label for="depart_alias">{{viewLanguage('Tổ chức')}}</label>
                <select class="form-control input-sm chosen-select w-100" name="ORG_CODE" id="ORG_CODE" onchange="jqueryCommon.buildOptionCommon('ORG_CODE','DEPART','STRUCT_CODE_SEARCH')">
                    {!! $optionOrg !!}
                </select>
            </div>
            <div class="col-lg-3">
                <label for="depart_alias">{{viewLanguage('Phòng ban')}}</label>
                <select class="form-control input-sm" name="STRUCT_CODE" id="STRUCT_CODE_SEARCH" >
                    {!! $optionDepart !!}
                </select>
            </div>
            <div class="col-lg-2">
                <label for="depart_alias">{{viewLanguage('Kiểu người dùng')}}</label>
                <select  class="form-control input-sm" name="USER_TYPE" id="USER_TYPE">
                    {!! $optionUserType !!}}
                </select>
            </div>
            <div class="col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                <select  class="form-control input-sm" name="IS_ACTIVE" id="IS_ACTIVE">
                    {!! $optionStatus !!}}
                </select>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr class="table-background-header">
                        {{--<th width="3%" class="text-center"><input type="checkbox" class="check" id="checkAll"></th>--}}
                        <th width="3%" class="text-center">{{viewLanguage('STT')}}</th>
                        <th width="5%" class="text-center">{{viewLanguage('Avatar')}}</th>
                        <th width="20%" class="text-left">{{viewLanguage('User name')}}</th>

                        <th width="20%" class="text-left">{{viewLanguage('Thông tin cá nhân')}}</th>
                        <th width="32%" class="text-left">{{viewLanguage('Tổ chức')}}</th>

                        <th width="10%" class="text-center">{{viewLanguage('Last login')}}</th>
                        <th width="12%" class="text-center">{{viewLanguage('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <?php
                            $today = date('d_m_Y',strtotime($item->LAST_LOGIN)) == date('d_m_Y',time())? 1: 0;
                        ?>
                        <tr>
                            <td class="text-center middle">{{$stt+$key+1}}</td>

                            <td class="text-center middle" @if($today == STATUS_INT_MOT) style="background-color: #CEF6D8" @endif>
                                @if(isset($item->IMAGE) && trim($item->IMAGE) != '')
                                    <img class="editable img-responsive" src="{{getLinkFileToStore($item->IMAGE,false)}}" width="50" height="50" title="{{$item->IMAGE}}"/>
                                @else
                                    @if(isset($item->GENDER) && $item->GENDER == 0)
                                        <img class="editable img-responsive" alt="" id="" src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/icon/avatar-girl.png" width="50" height="50"/>
                                    @else
                                        <img class="editable img-responsive" alt="" id="" src="{{Config::get('config.WEB_ROOT')}}assets/backend/img/icon/avatar-boys.png" width="50" height="50"/>
                                    @endif
                                @endif
                            </td>
                            <td class="text-left middle">
                                <b>{{$item->USER_NAME}}</b>
                                @if(isset($item->EMP_CODE) && trim($item->EMP_CODE) != '')<br><span class="font_10">{{$item->EMP_CODE}}</span>@endif
                                @if(isset($item->EMAIL) && trim($item->EMAIL) != '')<br><span class="font_10">{{$item->EMAIL}}</span>@endif
                            </td>
                            <td class="text-left middle">
                                @if(isset($item->FULL_NAME) && trim($item->FULL_NAME) != '')<b>{{$item->FULL_NAME}}</b>@endif
                                @if(isset($item->PHONE) && trim($item->PHONE) != '')<br><span class="font_10">{{$item->PHONE}}</span>@endif
                                @if(isset($arrUserType[$item->USER_TYPE]))<br/><span class="font_10">{{$arrUserType[$item->USER_TYPE]}}</span>@endif
                            </td>
                            <td class="text-left middle">
                                @if(isset($arrOrg[$item->ORG_CODE])){{$arrOrg[$item->ORG_CODE]}}@endif
                                @if(isset($item->STRUCT_NAME) && trim($item->STRUCT_NAME) != '')<br/>{{$item->STRUCT_NAME}}@endif
                                @if(trim($item->EFFECTIVE_DATE) != '')<br><span class="font_10 green">{{convertDateDMY($item->EFFECTIVE_DATE)}}</span>@endif
                            </td>
                            <td class="text-center middle">@if(trim($item->LAST_LOGIN) != ''){{date('d-m-Y H:i',strtotime($item->LAST_LOGIN))}} @endif</td>
                            <td class="text-center middle">
                                @if($is_root || $permission_view || $permission_add)
                                    <a href="javascript:void(0);" onclick="jqueryCommon.getDataByAjax(this);" class="color_hdi" data-form-name="detailOrg" data-input="{{json_encode(['item'=>$item])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Cập nhật: ')}}{{$item->FULL_NAME}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="{{$item->USER_CODE}}"><i class="fa fa-edit fa-2x"></i></a>&nbsp;
                                @endif
                                @if($item->IS_ACTIVE == STATUS_INT_MOT)
                                    <a href="javascript:void(0);" class="color_hdi" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                @else
                                    <a href="javascript:void(0);" class="red" title="Ẩn"><i class="fa fa-minus fa-2x"></i></a>
                                @endif
                                    <br/>

                                @if($is_root)
                                    <a href="javascript:void(0);"class="color_hdi sys_show_popup_common" data-size="1" data-form-name="detailItem" title="{{viewLanguage('Cấu hình sản phẩm cho người dùng')}}" data-method="get" data-url="{{$urlAjaxGetProductWithUser}}" data-input="{{json_encode(['item'=>$item])}}" data-objectId="{{$item->USER_CODE}}"><i class="fa fa-cubes fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                @endif
                                @if($is_root)
                                    <a href="{{URL::route('admin.loginas',array('username' => $item->USER_NAME))}}" target="_blank" class="color_hdi"  title="{{viewLanguage('Đăng nhập trên System.')}}"><i class="fa fa-user-secret fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                    <a href="{{\App\Library\AdminFunction\CGlobal::$arrDomainProject[env('ENVIRONMENT','DEV')][1]}}\manager\loginas\{{$item->USER_NAME}}" target="_blank" style="color: #eca909"  title="{{viewLanguage('Đăng nhập trên OpenSelling.')}}"><i class="fa fa-user-secret fa-2x"></i></a>
                                @endif
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
<script type="text/javascript">
    $(document).ready(function(){
        var config = {
            '.chosen-select'           : {width: "100%"},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });
</script>
