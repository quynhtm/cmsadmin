@if($typeTab == 'orgBank')
<div class="row">
    @if($is_root || $permission_edit || $permission_add)
    <div class="col-md-12">
        <button type="button" class="btn btn-info" id="{{$buttonAdd}}" onclick="jqueryCommon.clickShowFormChildElement('{{$item_id}}','{{$row_id}}','{{$buttonAdd}}');" ><i class="pe-7s-plus"></i> {{viewLanguage('Add')}}</button>
    </div>
    @endif
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
            @foreach ($data as $kb => $bank)
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

@if($typeTab == 'orgContract')
    <div class="row">
        @if($is_root || $permission_edit || $permission_add)
        <div class="col-md-12">
            <button type="button" class="btn btn-info" id="{{$buttonAdd}}" onclick="jqueryCommon.clickShowFormChildElement('{{$item_id}}','{{$row_id}}','{{$buttonAdd}}');" ><i class="pe-7s-plus"></i> {{viewLanguage('Add')}}</button>
        </div>
        @endif
        <div class="col-md-12 marginT5 table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr>
                    <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                    <th width="8%" class="text-center">{{viewLanguage('Action')}}</th>
                    <th width="15%" class="text-center">{{viewLanguage('Số Hợp đồng')}}</th>
                    <th width="25%" class="text-left">{{viewLanguage('Đối tác')}}</th>

                    <th width="15%" class="text-center">{{viewLanguage('Ngày hiệu lực')}}</th>
                    <th width="20%" class="text-center">{{viewLanguage('Ngày hết hiệu lực')}}</th>
                    <th width="15%" class="text-center">{{viewLanguage('Tệp đính kèm')}}</th>
                </tr>
                </thead>
                {{---Block them moi---}}
                <thead class="tr_data display-none-block" id="{{$row_id}}{{$item_id}}">
                @include('Systems.OpenId.organization.component.organization._detailFormOtherItem')
                </thead>

                <tbody>
                @foreach ($data as $kb => $contract)
                    <tr class="detailOtherCommon" data-show-id="{{$row_id}}{{$contract->ORG_PARTNER_CODE}}{{$contract->STRUCT_NO}}" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetOrgItem" data-input="{{json_encode(['type'=>$typeTab,'formEdit'=>1,'item_id'=>$contract->ORG_PARTNER_CODE,'arrKey'=>['ORG_PARTNER_CODE'=>$contract->ORG_PARTNER_CODE,'STRUCT_NO'=>$contract->STRUCT_NO]])}}" data-object-id="{{$contract->ORG_CODE}}">
                        <td class="text-center">{{$stt+$kb+1}}</td>
                        <td class="text-center">
                            @if($is_root || $permission_edit || $permission_add)
                                <a href="javascript:void(0);" style="color: @if($contract->IS_ACTIVE == STATUS_INT_MOT)green @else red @endif" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Cập nhật trạng thái: ')}}{{$contract->ORG_PARTNER_CODE}}" data-method="post" data-url="{{$urlDeleteOtherItem}}" data-input="{{json_encode(['item'=>$contract,'typeTab'=>$typeTab,'divShowId'=>$divShowId])}}">
                                    @if($contract->IS_ACTIVE == STATUS_INT_MOT)
                                        <i class="pe-7s-check fa-2x"></i>
                                    @else
                                        <i class="pe-7s-less fa-2x"></i>
                                    @endif
                                </a>
                            @endif
                        </td>
                        <td class="text-center">{{$contract->STRUCT_NO}}</td>
                        <td class="text-left">@if(isset($arrOrgParent[$contract->ORG_PARTNER_CODE])){{$arrOrgParent[$contract->ORG_PARTNER_CODE]}}@endif</td>
                        <td class="text-center">{{convertDateDMY($contract->EFFECTIVE_DATE)}}</td>
                        <td class="text-center">{{convertDateDMY($contract->EXPIRATION_DATE)}}</td>
                        <td class="text-center">{{$contract->DIR_PATH}}</td>
                    </tr>
                <thead class="tr_data" id="{{$row_id}}{{$contract->ORG_PARTNER_CODE}}{{$contract->STRUCT_NO}}" style="background-color: #F5F5F6!important;"></thead>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="paging_simple_numbers">
            {!! $pagingItem !!}
        </div>
    </div>
@endif

@if($typeTab == 'orgStructs')
    <div class="row">
        @if($is_root || $permission_edit || $permission_add)
        <div class="col-md-12">
            <button type="button" class="btn btn-info" id="{{$buttonAdd}}" onclick="jqueryCommon.clickShowFormChildElement('{{$item_id}}','{{$row_id}}','{{$buttonAdd}}');" ><i class="pe-7s-plus"></i> {{viewLanguage('Add')}}</button>
        </div>
        @endif
        <div class="col-md-12 marginT5 table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr>
                    <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                    <th width="8%" class="text-center">{{viewLanguage('Action')}}</th>
                    <th width="40%" class="text-center">{{viewLanguage('Cấp độ')}}</th>
                    <th width="40%" class="text-center">{{viewLanguage('Thành phần tổ chức')}}</th>
                </tr>
                </thead>
                {{---Block them moi---}}
                <thead class="tr_data display-none-block" id="{{$row_id}}{{$item_id}}">
                @include('Systems.OpenId.organization.component.organization._detailFormOtherItem')
                </thead>

                <tbody>
                @foreach ($data as $kb => $structs)
                    <tr class="detailOtherCommon" data-show-id="{{$row_id}}{{$structs->ORG_STRUCT}}{{$structs->ORG_TYPE}}" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetOrgItem" data-input="{{json_encode(['type'=>$typeTab,'formEdit'=>1,'item_id'=>$structs->ORG_STRUCT,'arrKey'=>['ORG_STRUCT'=>$structs->ORG_STRUCT,'ORG_TYPE'=>$structs->ORG_TYPE]])}}" data-object-id="{{$structs->ORG_CODE}}">
                        <td class="text-center">{{$kb+1}}</td>
                        <td class="text-center">
                            @if($is_root || $permission_edit || $permission_add)
                                <a href="javascript:void(0);" style="color: @if($structs->IS_ACTIVE == STATUS_INT_MOT)green @else red @endif" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Cập nhật trạng thái: ')}}{{$structs->ORG_STRUCT}}" data-method="post" data-url="{{$urlDeleteOtherItem}}" data-input="{{json_encode(['item'=>$structs,'typeTab'=>$typeTab,'divShowId'=>$divShowId])}}">
                                    @if($structs->IS_ACTIVE == STATUS_INT_MOT)
                                        <i class="pe-7s-check fa-2x"></i>
                                    @else
                                        <i class="pe-7s-less fa-2x"></i>
                                    @endif
                                </a>
                            @endif
                        </td>
                        <td class="text-center">{{$structs->ORG_LEVEL}}</td>
                        <td class="text-center">{{$structs->ORG_STRUCT_NAME}}</td>
                    </tr>
                <thead class="tr_data" id="{{$row_id}}{{$structs->ORG_STRUCT}}{{$structs->ORG_TYPE}}" style="background-color: #F5F5F6!important;"></thead>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="paging_simple_numbers">
            {!! $pagingItem !!}
        </div>
    </div>
@endif

@if($typeTab == 'orgRelationship')
    <div class="row">
        @if($is_root || $permission_edit || $permission_add)
        <div class="col-md-12">
            <button type="button" class="btn btn-info" id="{{$buttonAdd}}" onclick="jqueryCommon.clickShowFormChildElement('{{$item_id}}','{{$row_id}}','{{$buttonAdd}}');" ><i class="pe-7s-plus"></i> {{viewLanguage('Add')}}</button>
        </div>
        @endif
        <div class="col-md-12 marginT5 table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr>
                    <th width="2%" class="text-center">{{viewLanguage('STT')}}</th>
                    <th width="8%" class="text-center">{{viewLanguage('Action')}}</th>
                    <th width="40%" class="text-center">{{viewLanguage('Mối quan hệ')}}</th>
                    <th width="40%" class="text-center">{{viewLanguage('Tổ chức khác')}}</th>
                </tr>
                </thead>
                {{---Block them moi---}}
                <thead class="tr_data display-none-block" id="{{$row_id}}{{$item_id}}">
                @include('Systems.OpenId.organization.component.organization._detailFormOtherItem')
                </thead>

                <tbody>
                @foreach ($data as $kb => $relationship)
                    <tr class="detailOtherCommon" data-show-id="{{$row_id}}{{$relationship->ORG_CODE}}" data-url="{{$urlAjaxGetData}}" data-function-action="_ajaxGetOrgItem" data-input="{{json_encode(['type'=>$typeTab,'formEdit'=>1,'item_id'=>$relationship->ORG_CODE])}}" data-object-id="{{$relationship->ORG_CODE_PARENT}}">
                        <td class="text-center">{{$kb+1}}</td>
                        <td class="text-center">
                            @if($is_root || $permission_edit || $permission_add)
                                <a href="javascript:void(0);" style="color: @if($relationship->IS_ACTIVE == STATUS_INT_MOT)green @else red @endif" class="sys_delete_item_common" data-form-name="deleteItem" title="{{viewLanguage('Cập nhật trạng thái: ')}}{{$relationship->ORG_CODE}}" data-method="post" data-url="{{$urlDeleteOtherItem}}" data-input="{{json_encode(['item'=>$relationship,'typeTab'=>$typeTab,'divShowId'=>$divShowId])}}">
                                    @if($relationship->IS_ACTIVE == STATUS_INT_MOT)
                                        <i class="pe-7s-check fa-2x"></i>
                                    @else
                                        <i class="pe-7s-less fa-2x"></i>
                                    @endif
                                </a>
                            @endif
                        </td>
                        <td class="text-center">{{$relationship->RELATIONSHIP_NAME}}</td>
                        <td class="text-left">@if(isset($arrOrg[$relationship->ORG_CODE])){{$arrOrg[$relationship->ORG_CODE]}}@endif</td>
                    </tr>
                <thead class="tr_data" id="{{$row_id}}{{$relationship->ORG_CODE}}" style="background-color: #F5F5F6!important;"></thead>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="paging_simple_numbers">
            {!! $pagingItem !!}
        </div>
    </div>
@endif

<input type="hidden" name="urlAjax" id="urlAjax" value="{{$urlAjaxGetData}}">
<input type="hidden" name="divShowIdAjax" id="divShowIdAjax" value="{{$divShowId}}">
<input type="hidden" name="dataInputAjax" id="dataInputAjax" value="{{json_encode(['type'=>$typeTab,'item_id'=>0])}}">
<input type="hidden" name="functionActionAjax" id="functionActionAjax" value="{{$functionAction}}">
<input type="hidden" name="objectIdAjax" id="objectIdAjax" value="{{$obj_id}}">

<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});

        $('.detailOtherCommon').dblclick(function () {
            jqueryCommon.ajaxGetData(this);
        });

        $(".sys_delete_item_common").on('click', function () {
            var _token = $('input[name="_token"]').val();
            var url = $(this).attr('data-url');
            var method = $(this).attr('data-method');
            var dataInput = $(this).attr('data-input');
            var title = $(this).attr('title');
            jqueryCommon.isConfirm(title).then((confirmed) => {
                $.ajax({
                    dataType: 'json',
                    type: method,
                    url: url,
                    data: {
                        '_token': _token,
                        'dataInput': dataInput,
                    },
                    success: function (res) {
                        $('#loadingAjax').hide();
                        if (res.success == 1) {
                            jqueryCommon.showMsg('success',res.message);
                            $('#'+res.divShowAjax).html(res.html);
                        } else {
                            jqueryCommon.showMsg('error','','Thông báo lỗi',res.message);
                        }
                    }
                });
            });
        });
    });
</script>
