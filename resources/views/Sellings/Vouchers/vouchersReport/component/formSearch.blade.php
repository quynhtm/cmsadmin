<div class="div-parent-background">
    <div class="div-background">
        <div class="div-block-right">
            <a href="javascript:void(0);" onclick="jqueryCommon.hideContentRightPage();" class="btn-close-search-list btn btn-default" title="{{viewLanguage('Đóng lại')}}">
                <i class="pe-7s-close fa-w-16 fa-3x"></i>
            </a>

            {{-- Button use--}}
            <a href="javascript:void(0);" class="area-btn-right btn-action1 btn-search-right btn-success" title="{{viewLanguage('Search')}}">
                <i class="pe-7s-search fa-w-16 fa-2x"></i>
            </a>
            @if($is_root || $permission_add)
                <a href="javascript:void(0);" class="area-btn-right btn-action2 btn-edit-right btn-warning sys_show_popup_common" data-form-name="addFormItem" data-input="{{json_encode([])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Thêm ')}}{{$pageTitle}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="0">
                    <i class="pe-7s-plus fa-w-16 fa-2x"></i>
                </a>
            @endif

            {{-- Nội dung form search--}}
            <div class="content-search-page" >
                <h3 class="themeoptions-heading">Tìm kiếm </h3>
                <div class="ibox-content">
                    {!!Form::open(array('method' => 'POST', 'role'=>'form')) !!}
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                            <input type="text" class="form-control input-sm" placeholder="Mã tiền tố, tên chiến dịch" id="p_keyword" name="p_keyword" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="status" class="control-label">{{viewLanguage('Đối tác')}}</label>
                            <select  class="form-control input-sm chosen-select w-100" name="ORG_CODE" id="ORG_CODE">
                                {!! $optionOrg !!}}
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="status" class="control-label">{{viewLanguage('Voucher cho')}}</label>
                            <select  class="form-control input-sm" name="GIFT_TYPE" id="GIFT_TYPE">
                                {!! $optionGiftType !!}}
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="status" class="control-label">{{viewLanguage('Trạng thái cấp phát voucher')}}</label>
                            <select  class="form-control input-sm" name="STATUS" id="STATUS">
                                {!! $optionStatusSearch !!}}
                            </select>
                        </div>
                        <hr>
                        <div class="form-group col-lg-12">
                            @if($is_root || $permission_view)
                                <button class="mb-2 mr-2 btn-icon btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                            @endif
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            {{-- Nội dung form Edit show by ajax--}}
            <div id="content-page-right"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
</script>