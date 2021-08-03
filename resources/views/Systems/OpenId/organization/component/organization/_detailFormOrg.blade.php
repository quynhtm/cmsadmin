{{---ID > 0 và có thông tin data---}}
<div class="formInforItem @if($objectId <= 0)display-none-block @endif">

    <div class="card-header">
        @if($objectId > 0)
            Thông tin&nbsp;<span class="showInforItem" data-field="ORG_NAME"></span>
        @endif
    </div>
    <div class="marginT15">
        <div class="form-group" style="position: relative">
            @include('admin.AdminLayouts.buttonShowFormEdit')
            <div class="row form-group">
                <div class="col-lg-4">
                    Mã tổ chức: <b class="showInforItem" data-field="ORG_CODE"></b>
                </div>
                <div class="col-lg-4">
                    Loại tổ chức: <b class="showInforItem">@if(isset($data->ORG_TYPE) && $objectId > 0)@if(isset($arrType[$data->ORG_TYPE])){{$arrType[$data->ORG_TYPE]}} @endif @endif</b>
                </div>
                <div class="col-lg-4">
                    Kiểu tổ chức: <b class="showInforItem">@if(isset($data->ORG_MODE) && $objectId > 0)@if(isset($arrMode[$data->ORG_MODE])){{$arrMode[$data->ORG_MODE]}} @endif @endif</b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-4">
                    Người đại diện: <b class="showInforItem" data-field="CEO_NAME"></b>
                </div>
                <div class="col-lg-8">
                    Tổ chức cha: <b class="showInforItem">@if(isset($data->PARENT_CODE) && $objectId > 0)@if(isset($arrOrg[$data->PARENT_CODE])){{$arrOrg[$data->PARENT_CODE]}} @endif @endif</b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-4">
                    Mã số thuế: <b class="showInforItem" data-field="TAX_CODE"></b>
                </div>
                <div class="col-lg-4">
                    Website: <b class="showInforItem" data-field="WEBSITE"></b>
                </div>
                <div class="col-lg-4">
                    Số điện thoại: <b class="showInforItem" data-field="PHONE"></b>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-4">
                    Email: <b class="showInforItem" data-field="EMAIL"></b>
                </div>
                <div class="col-lg-8">
                    Địa chỉ: <b class="showInforItem" data-field="ADDRESS_SHORT"></b>
                </div>
            </div>
        </div>
    </div>
</div>

{{----Edit và thêm mới----}}
<div class="formEditItem @if($objectId > 0)display-none-block @endif" >
    <div class="card-header">
        @if($objectId > 0)
            Thông tin &nbsp;<span class="showInforItem" data-field="ORG_NAME"></span>
        @else
            Thông tin tổ chức
        @endif
    </div>
    <div class="marginT15">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="url_action" name="url_action" value="{{$url_action}}">
        <input type="hidden" id="formName" name="formName" value="{{$formName}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">

        <input type="hidden" id="load_page" name="load_page" value="{{STATUS_INT_KHONG}}">
        <input type="hidden" id="div_show_edit_success" name="div_show_edit_success" value="formShowEditSuccess">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Mã tổ chức')}}</label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="100" @if($objectId > 0) readonly @endif required name="ORG_CODE" id="form_{{$formName}}_ORG_CODE">
                </div>
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tên tổ chức')}} </label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" data-valid = "text" title="Tên tổ chức" required name="ORG_NAME" id="form_{{$formName}}_ORG_NAME">
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Loại tổ chức')}} </label><span class="red"> (*)</span>
                    <select class="form-control input-sm" required name="ORG_TYPE" id="form_{{$formName}}_ORG_TYPE" >
                        {!! $optionType !!}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Người đại diện')}} </label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="250" required name="CEO_NAME" id="form_{{$formName}}_CEO_NAME">
                </div>
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tổ chức cha')}} </label>
                    <select class="form-control input-sm" name="PARENT_CODE" id="form_{{$formName}}_PARENT_CODE" >
                        {!! $optionOrg !!}
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Kiểu tổ chức')}} </label><span class="red"> (*)</span>
                    <select class="form-control input-sm" required name="ORG_MODE" id="form_{{$formName}}_ORG_MODE" >
                        {!! $optionMode !!}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Mã số thuế')}} </label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="20" required name="TAX_CODE" id="form_{{$formName}}_TAX_CODE" >
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Website')}}</label>
                    <input type="text" class="form-control input-sm" maxlength="100" name="WEBSITE" id="form_{{$formName}}_WEBSITE">
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Số điện thoại')}} </label><span class="red"> (*)</span>
                    <input type="number" class="form-control input-sm" required name="PHONE" maxlength="12" id="form_{{$formName}}_PHONE">
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Email')}} </label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" maxlength="100" required name="EMAIL" id="form_{{$formName}}_EMAIL">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Địa chỉ')}} </label><span class="red"> (*)</span>
                    <input type="text" class="form-control input-sm" required name="ADDRESS_SHORT" id="form_{{$formName}}_ADDRESS_SHORT">
                </div>
                <div class="col-lg-2 paddingLeft-unset paddingLeft-unset">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Tỉnh')}}</label>
                    <select class="form-control input-sm chosen-select" name="PROVINCE_CODE" id="form_{{$formName}}_PROVINCE_CODE" onchange="jqueryCommon.buildOptionCommon('form_{{$formName}}_PROVINCE_CODE','OPTION_DISTRICT_CODE','form_{{$formName}}_DISTRICT_CODE')">
                        {!! $optionProvince !!}
                    </select>
                </div>
                <div class="col-lg-2 paddingLeft-unset paddingLeft-unset">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Huyện')}}</label>
                    <select class="form-control input-sm" name="DISTRICT_CODE" id="form_{{$formName}}_DISTRICT_CODE" onchange="jqueryCommon.buildOptionCommon('form_{{$formName}}_DISTRICT_CODE','OPTION_WARD_CODE','form_{{$formName}}_WARD_CODE')">
                        {!! $optionDistrict !!}
                    </select>
                </div>
                <div class="col-lg-2 paddingLeft-unset paddingLeft-unset">
                    <label for="NAME" class="text-right control-label">{{viewLanguage('Xã')}}</label>
                    <select class="form-control input-sm" name="WARD_CODE" id="form_{{$formName}}_WARD_CODE" >
                        {!! $optionWard !!}
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        showDataIntoForm('form_{{$formName}}');
    });
    //tim kiem
    var config = {
        '.chosen-select'           : {width: "100%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>