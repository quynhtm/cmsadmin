<div style="position: relative">
    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>

    <div id="divDetailItem">
        <div class="card-header">
            @if($objectId > 0)Cập nhật thông tin tổ chức @else Thêm thông tin tổ chức @endif
            <div class="btn-actions-pane-right">
                @include('admin.AdminLayouts.listButtonActionFormEdit')
            </div>
        </div>

        <div class="div-infor-right">
            <div class="main-card mb-3">
                <div class="card-body paddingTop-unset">
                    <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column" style="padding-top: 0px!important;">

                        {{---Block 1---}}
                        <form id="form_{{$formName}}">
                            <div class="vertical-timeline-item vertical-timeline-element marginBottom-unset">
                                <span class="vertical-timeline-element-icon bounce-in icon-timeline timeline-active">1</span>
                                <div class="vertical-timeline-element-content bounce-in" id="formShowEditSuccess">
                                    @include('Systems.OpenId.organization.component.organization._detailFormOrg')
                                </div>
                            </div>
                        </form>

                        {{---Block 2---}}
                        <div class="vertical-timeline-item vertical-timeline-element">
                            <div>
                                <span class="vertical-timeline-element-icon bounce-in icon-timeline @if($objectId > 0) timeline-active @endif">2</span>
                                <div class="vertical-timeline-element-content bounce-in">
                                    {{---tạo mới tổ chứ---}}
                                    @if($objectId <= 0)
                                        <div class="card-header"> Thông tin khác </div>
                                        <div class="marginT15">
                                            Bạn cần tạo tổ chức trước khi thêm thông tin khác của tổ chức
                                        </div>
                                    @else
                                        <div class="listTabWithAjax">
                                            <div class="card-header card-header-tab-animation">
                                                <ul class="nav nav-justified">
                                                    <li class="nav-item">
                                                        <a role="tab" class="nav-link active" data-toggle="tab" href="#tab-content-1" onclick="jqueryCommon.ajaxGetData(this);" data-show-id="tab-content-1" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetOrgItem" data-input="{{json_encode(['type'=>'orgBank','item_id'=>0])}}" data-object-id="{{$data->ORG_CODE}}">
                                                            <span>{{viewLanguage('Tài khoản ngân hàng')}}</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a role="tab" class="nav-link" data-toggle="tab" href="#tab-content-2" onclick="jqueryCommon.ajaxGetData(this);" data-show-id="tab-content-2" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetOrgItem" data-input="{{json_encode(['type'=>'orgContract','item_id'=>0])}}" data-object-id="{{$data->ORG_CODE}}">
                                                            <span>{{viewLanguage('Hợp đồng với HDI')}}</span>
                                                        </a>
                                                    </li>
                                                    {{--<li class="nav-item">
                                                        <a role="tab" class="nav-link" data-toggle="tab" href="#tab-content-3" onclick="jqueryCommon.ajaxGetData(this);" data-show-id="tab-content-3" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetOrgItem" data-input="{{json_encode(['type'=>'orgStructs','item_id'=>0])}}" data-object-id="{{$data->ORG_CODE}}">
                                                            <span>{{viewLanguage('Mô hình tổ chức')}}</span>
                                                        </a>
                                                    </li>--}}
                                                    <li class="nav-item">
                                                        <a role="tab" class="nav-link" data-toggle="tab" href="#tab-content-4" onclick="jqueryCommon.ajaxGetData(this);" data-show-id="tab-content-4" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetOrgItem" data-input="{{json_encode(['type'=>'orgRelationship','item_id'=>0])}}" data-object-id="{{$data->ORG_CODE}}">
                                                            <span>{{viewLanguage('Quan hệ với tổ chức khác')}}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-content marginT10" >
                                                {{--Tài khoản ngân hàng---}}
                                                <div class="tab-pane tabs-animation fade show active" id="tab-content-1" role="tabpanel">
                                                    @if($typeTab == 'orgBank')
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button type="button" class="btn btn-info" id="{{$buttonAdd}}" onclick="jqueryCommon.clickShowFormChildElement('{{$item_id}}','{{$row_id}}','{{$buttonAdd}}');" ><i class="pe-7s-plus"></i> {{viewLanguage('Add')}}</button>
                                                            </div>
                                                            <div class="col-md-12 marginT5 table-responsive">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead class="thin-border-bottom">
                                                                    <tr>
                                                                        <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                                                                        <th width="8%" class="text-center">{{viewLanguage('Action')}}</th>
                                                                        <th width="25%" class="text-center">{{viewLanguage('Ngân hàng')}}</th>

                                                                        <th width="25%" class="text-center">{{viewLanguage('Chi nhánh')}}</th>
                                                                        <th width="20%" class="text-center">{{viewLanguage('Chủ tài khoản')}}</th>
                                                                        <th width="20%" class="text-center">{{viewLanguage('Số tài khoản')}}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    {{---Block them moi---}}
                                                                    <thead class="tr_data display-none-block" id="{{$row_id}}{{$item_id}}">
                                                                    @include('Systems.OpenId.organization.component.organization._detailFormOtherItem')
                                                                    </thead>

                                                                    <tbody>
                                                                    @foreach ($listTabBank as $kb => $bank)
                                                                        <tr class="detailOtherCommon" data-show-id="{{$row_id}}{{$bank->BRANCH_CODE}}" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetOrgItem" data-input="{{json_encode(['type'=>$typeTab,'formEdit'=>1,'item_id'=>$bank->BRANCH_CODE])}}" data-object-id="{{$bank->ORG_CODE}}">
                                                                            <td class="text-center">{{$kb+1}}</td>
                                                                            <td class="text-center">
                                                                                @if($is_root || $permission_edit || $permission_add)
                                                                                    <a href="javascript:void(0);" style="color: @if($bank->IS_ACTIVE == STATUS_INT_MOT)green @else red @endif" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Cập nhật trạng thái: ')}}{{$bank->BRANCH_CODE}}" data-method="post" data-url="{{$urlDeleteOtherItem}}" data-input="{{json_encode(['item'=>$bank,'typeTab'=>$typeTab,'divShowId'=>$divShowId])}}">
                                                                                        @if($bank->IS_ACTIVE == STATUS_INT_MOT)
                                                                                            <i class="pe-7s-check fa-2x"></i>
                                                                                        @else
                                                                                            <i class="pe-7s-less fa-2x"></i>
                                                                                        @endif
                                                                                    </a>
                                                                                @endif
                                                                            </td>
                                                                            <td class="text-center">{{$bank->BANK_NAME}}</td>
                                                                            <td class="text-center">{{$bank->BRANCH_NAME}}</td>
                                                                            <td class="text-center">{{$bank->BANK_HOLDER}}</td>
                                                                            <td class="text-center">{{$bank->BANK_ACCOUNT}}</td>
                                                                        </tr>
                                                                    <thead class="tr_data" id="{{$row_id}}{{$bank->BRANCH_CODE}}" style="background-color: #F5F5F6!important;"></thead>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="paging_simple_numbers">
                                                                {!! $pagingItem !!}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                {{--Hợp đồng với HDI---}}
                                                <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                                                </div>
                                                {{--Mô hình tổ chức---}}
                                                <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
                                                </div>
                                                {{--Quan hệ với tổ chức khác---}}
                                                <div class="tab-pane tabs-animation fade" id="tab-content-4" role="tabpanel">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        //chi tiết banks
        $('.detailOtherCommon').dblclick(function () {
            jqueryCommon.ajaxGetData(this);
        });
    });
</script>