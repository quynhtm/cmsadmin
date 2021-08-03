@if($typeTab == 'orgBank')
    <td colspan="6">
        <?php
            $form_name = $row_id.$item_id;
        ?>
        <form id="form_{{$form_name}}">
            <input type="hidden" id="{{$form_name}}ORG_CODE" name="ORG_CODE" value="{{$obj_id}}">
            <input type="hidden" id="{{$form_name}}ACTION_FORM" name="ACTION_FORM" value="{{$actionEdit}}">
            <input type="hidden" id="{{$form_name}}typeTabAction" name="typeTabAction" value="{{$typeTab}}">
            <input type="hidden" id="{{$form_name}}divShowIdAction" name="divShowIdAction" value="{{$divShowId}}">
            <input type="hidden" id="{{$form_name}}IS_ACTIVE" name="IS_ACTIVE" value="@if(isset($inforItem->IS_ACTIVE)){{$inforItem->IS_ACTIVE}}@else 1 @endif">
            <div class="main-card mb-3">
                <div class="row">
                    <div class="col-lg-6">
                        <h4><strong>{{$titleForm}}</strong></h4>
                    </div>
                    @if($is_root || $permission_edit || $permission_add)
                    <div class="col-lg-6 text-right">
                        <button type="button" class="btn btn-primary" onclick="jqueryCommon.submitFormChildElement('{{$form_name}}','{{$url_action_other_item}}');">{{viewLanguage('Save')}}</button>
                        <button type="button" class="btn btn-secondary" onclick="jqueryCommon.clickHideFormChildElement('{{$item_id}}','{{$row_id}}','{{$buttonAdd}}');">{{viewLanguage('Exit')}}</button>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Ngân hàng - Chi nhánh')}}</label><span class="red"> (*)</span>
                            <select class="form-control input-sm" @if($actionEdit == STATUS_INT_MOT) disabled @else  required name="BANK_CODE" id="BANK_CODE" @endif>
                                {!! $optionBank !!}
                            </select>
                            @if($actionEdit == STATUS_INT_MOT)
                                <input type="hidden" id="{{$form_name}}BANK_CODE" name="BANK_CODE" value="{{$inforItem->BANK_CODE}}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Chủ tài khoản')}} </label><span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" required name="BANK_HOLDER" id="BANK_HOLDER" @if(isset($inforItem->BANK_HOLDER))value="{{$inforItem->BANK_HOLDER}}"@endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số tài khoản')}} </label><span class="red"> (*)</span>
                            <input type="number" class="form-control input-sm" required name="BANK_ACCOUNT" id="BANK_ACCOUNT" min="0" maxlength="14" @if(isset($inforItem->BANK_ACCOUNT))value="{{$inforItem->BANK_ACCOUNT}}"@endif>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </td>
@endif

@if($typeTab == 'orgContract')

    <td colspan="7">
        <?php
        $form_name = $row_id.$item_id;
        ?>
        {{Form::open(array('method' => 'POST','class'=>$form_name,'id'=>'form_'.$form_name,'role'=>'form','files' => true))}}
            <input type="hidden" id="{{$form_name}}ORG_CODE" name="ORG_CODE" value="{{$obj_id}}">
            <input type="hidden" id="{{$form_name}}IS_ACTIVE" name="IS_ACTIVE" value="@if(isset($inforItem->IS_ACTIVE)){{$inforItem->IS_ACTIVE}}@else 1 @endif">
            <input type="hidden" id="{{$form_name}}ACTION_FORM" name="ACTION_FORM" value="{{$actionEdit}}">
            <input type="hidden" id="{{$form_name}}typeTabAction" name="typeTabAction" value="{{$typeTab}}">
            <input type="hidden" id="{{$form_name}}divShowIdAction" name="divShowIdAction" value="{{$divShowId}}">
            <input type="hidden" id="{{$form_name}}url_action" name="url_action" value="{{$url_action_other_item}}">
            <input type="hidden" id="{{$form_name}}formEdit" name="formEdit" value="">
            <input type="hidden" id="{{$form_name}}MENU_CODE" name="MENU_CODE" value="menu_code">

            {{ csrf_field() }}
            <div class="main-card mb-3">
                <div class="row">
                    <div class="col-lg-6">
                        <h4><strong>{{$titleForm}}</strong></h4>
                    </div>
                    <div class="col-lg-6 text-right">
                        @if($is_root || $permission_edit || $permission_add)
                        <button type="submit" class="btn btn-primary" id="{{$form_name}}" >{{viewLanguage('Save')}}</button>
                        <button type="button" class="btn btn-secondary" onclick="jqueryCommon.clickHideFormChildElement('{{$item_id}}','{{$row_id}}','{{$buttonAdd}}');">{{viewLanguage('Exit')}}</button>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Số hợp đồng')}} </label><span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" @if($actionEdit == STATUS_INT_MOT) readonly @endif required name="STRUCT_NO" id="STRUCT_NO" @if(isset($inforItem->STRUCT_NO))value="{{$inforItem->STRUCT_NO}}"@endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Đối tác')}}</label><span class="red"> (*)</span>
                            <select class="form-control input-sm" @if($actionEdit == STATUS_INT_MOT) disabled @else  required name="ORG_PARTNER_CODE" id="ORG_PARTNER_CODE" @endif>
                                {!! $optionOrgParent !!}
                            </select>
                            @if($actionEdit == STATUS_INT_MOT)
                                <input type="hidden" id="{{$form_name}}ORG_PARTNER_CODE" name="ORG_PARTNER_CODE" value="{{$inforItem->ORG_PARTNER_CODE}}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày hiệu lực')}} </label><span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm input-date" required name="EFFECTIVE_DATE" @if(isset($inforItem->EFFECTIVE_DATE))value="{{convertDateDMY($inforItem->EFFECTIVE_DATE)}}"@endif>
                        </div>
                        <div class="col-lg-4">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Ngày hết hiệu lực')}} </label>
                            <input type="text" class="form-control input-sm input-date" name="EXPIRATION_DATE" @if(isset($inforItem->EXPIRATION_DATE))value="{{convertDateDMY($inforItem->EXPIRATION_DATE)}}"@endif>
                        </div>
                        <div class="col-lg-4">
                            <input type="hidden" name="DIR_PATH" id="DIR_PATH" value="@if(isset($inforItem->DIR_PATH)){{$inforItem->DIR_PATH}}@endif">
                            <div class="marginT25">
                                <input type="file" name="inputFile" id="inputFile">
                            </div>
                            <label for="NAME" class="text-right control-label">@if(isset($inforItem->DIR_PATH)){{$inforItem->DIR_PATH}}@endif</label>
                            {{--<label title="Upload image file" for="inputImage" class="btn btn-info marginT20">
                                --}}{{--<input type="file" name="inputFile" id="inputImage">--}}{{--
                                <input type="file" name="inputFile" id="inputImage" style="visibility: hidden;"/>
                                Chọn file
                            </label>--}}
                        </div>
                    </div>
                </div>
            </div>
       {{ Form::close() }}
    </td>
@endif

@if($typeTab == 'orgStructs')
    <td colspan="6">
        <?php
        $form_name = $row_id.$item_id;
        ?>
        <form id="form_{{$form_name}}">
            <input type="hidden" id="{{$form_name}}ORG_CODE" name="ORG_CODE" value="{{$obj_id}}">
            <input type="hidden" id="{{$form_name}}ORG_TYPE" name="ORG_TYPE" value="@if(isset($dataOrg->ORG_TYPE)){{$dataOrg->ORG_TYPE}}@endif">
            <input type="hidden" id="{{$form_name}}IS_ACTIVE" name="IS_ACTIVE" value="@if(isset($inforItem->IS_ACTIVE)){{$inforItem->IS_ACTIVE}}@else 1 @endif">
            <input type="hidden" id="{{$form_name}}IS_ACTIVE" name="IS_ACTIVE" value="{{STATUS_INT_MOT}}">
            <input type="hidden" id="{{$form_name}}ACTION_FORM" name="ACTION_FORM" value="{{$actionEdit}}">
            <input type="hidden" id="{{$form_name}}typeTabAction" name="typeTabAction" value="{{$typeTab}}">
            <input type="hidden" id="{{$form_name}}divShowIdAction" name="divShowIdAction" value="{{$divShowId}}">

            <div class="main-card mb-3">
                <div class="row">
                    <div class="col-lg-6">
                        <h4><strong>{{$titleForm}}</strong></h4>
                    </div>
                    <div class="col-lg-6 text-right">
                        @if($is_root || $permission_edit || $permission_add)
                        <button type="button" class="btn btn-primary" onclick="jqueryCommon.submitFormChildElement('{{$form_name}}','{{$url_action_other_item}}');">{{viewLanguage('Save')}}</button>
                        <button type="button" class="btn btn-secondary" onclick="jqueryCommon.clickHideFormChildElement('{{$item_id}}','{{$row_id}}','{{$buttonAdd}}');">{{viewLanguage('Exit')}}</button>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Cấp độ')}} </label><span class="red"> (*)</span>
                            <input type="number" class="form-control input-sm" required name="ORG_LEVEL" id="ORG_LEVEL" min="0" maxlength="14" @if(isset($inforItem->ORG_LEVEL))value="{{$inforItem->ORG_LEVEL}}"@endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Thành phần tổ chức')}}</label><span class="red"> (*)</span>
                            <select class="form-control input-sm" @if($actionEdit == STATUS_INT_MOT) disabled @else required name="ORG_STRUCT" id="ORG_STRUCT" @endif>
                                {!! $optionOrgStruct !!}
                            </select>
                            @if($actionEdit == STATUS_INT_MOT)
                                <input type="hidden" id="{{$form_name}}ORG_STRUCT" name="ORG_STRUCT" value="{{$inforItem->ORG_STRUCT}}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </td>
@endif

@if($typeTab == 'orgRelationship')
    <td colspan="6">
        <?php
        $form_name = $row_id.$item_id;
        ?>
        <form id="form_{{$form_name}}">
            <input type="hidden" id="{{$form_name}}ORG_CODE_PARENT" name="ORG_CODE_PARENT" value="{{$obj_id}}">
            <input type="hidden" id="{{$form_name}}MENU_CODE" name="MENU_CODE" value="menu_code">
            <input type="hidden" id="{{$form_name}}IS_ACTIVE" name="IS_ACTIVE" value="@if(isset($inforItem->IS_ACTIVE)){{$inforItem->IS_ACTIVE}}@else 1 @endif">
            <input type="hidden" id="{{$form_name}}ACTION_FORM" name="ACTION_FORM" value="{{$actionEdit}}">
            <input type="hidden" id="{{$form_name}}typeTabAction" name="typeTabAction" value="{{$typeTab}}">
            <input type="hidden" id="{{$form_name}}divShowIdAction" name="divShowIdAction" value="{{$divShowId}}">

            <div class="main-card mb-3">
                <div class="row">
                    <div class="col-lg-6">
                        <h4><strong>{{$titleForm}}</strong></h4>
                    </div>
                    <div class="col-lg-6 text-right">
                        @if($is_root || $permission_edit || $permission_add)
                        <button type="button" class="btn btn-primary" onclick="jqueryCommon.submitFormChildElement('{{$form_name}}','{{$url_action_other_item}}');">{{viewLanguage('Save')}}</button>
                        <button type="button" class="btn btn-secondary" onclick="jqueryCommon.clickHideFormChildElement('{{$item_id}}','{{$row_id}}','{{$buttonAdd}}');">{{viewLanguage('Exit')}}</button>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Mối quan hệ')}} </label><span class="red"> (*)</span>
                            <input type="text" class="form-control input-sm" required name="RELATIONSHIP_NAME" id="RELATIONSHIP_NAME" @if(isset($inforItem->RELATIONSHIP_NAME))value="{{$inforItem->RELATIONSHIP_NAME}}"@endif>
                        </div>
                        <div class="col-lg-6">
                            <label for="NAME" class="text-right control-label">{{viewLanguage('Tổ chức khác')}}</label><span class="red"> (*)</span>
                            <select class="form-control input-sm"  @if($actionEdit == STATUS_INT_MOT) disabled @else required name="ORG_CODE" id="ORG_CODE" @endif >
                                {!! $optionOrgParent !!}
                            </select>
                            @if($actionEdit == STATUS_INT_MOT)
                                <input type="hidden" id="{{$form_name}}ORG_CODE" name="ORG_CODE" value="{{$inforItem->ORG_CODE}}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </td>
@endif

<script type="text/javascript">
    $("form#form_{{$form_name}}").submit(function(e) {
        e.preventDefault();
        var dataForm = new FormData(this);
        var msg = 'Bạn có chắc chắc cập nhật thông tin này?';
        $('#loaderRight').show();
        $.ajax({
            type: 'POST',
            url: "{{URL::route('organization.ajaxUpdateOrgRelation')}}",
            data: dataForm,
            success: function (res) {
                $('#loaderRight').hide();
                if (res.success == 1) {
                    jqueryCommon.showMsg('success',res.message);
                    $('#'+res.divShowAjax).html(res.html);
                } else {
                    jqueryCommon.showMsg('error','','Thông báo lỗi',res.message);
                }
            },
            contentType: false,
            processData: false,
            cache: false
        });
        return false;
    });

    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
</script>
