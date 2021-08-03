<div class="div-parent-background">
    <div class="div-background">
        <div class="div-block-right">
            <a href="javascript:void(0);" onclick="jqueryCommon.hideContentRightPageLayout();" class="btn-close-search-list btn btn-default" title="{{viewLanguage('Đóng lại')}}"><i class="pe-7s-close fa-w-16 fa-3x"></i></a>
            {{-- Nội dung form search--}}
            <div class="content-search-page" >
                <h3 class="themeoptions-heading">Tìm kiếm </h3>
                <div class="ibox-content">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="depart_name">{{viewLanguage('Từ ngày')}}</label>
                            <input type="text" class="form-control input-sm input-date" id="p_eff_date" name="p_eff_date"@if(isset($search['p_eff_date']))value="{{$search['p_eff_date']}}"@endif>
                            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="depart_name">{{viewLanguage(' Đến ngày')}}</label>
                            <input type="text" class="form-control input-sm input-date" id="p_exp_date" name="p_exp_date"@if(isset($search['p_exp_date']))value="{{$search['p_exp_date']}}"@endif>
                            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="depart_name">{{viewLanguage('Tên khách hàng')}}</label>
                            <input type="text" class="form-control input-sm" id="p_name_insured" name="p_name_insured" @if(isset($search['p_name_insured']))value="{{$search['p_name_insured']}}"@endif>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="depart_name">{{viewLanguage('Số giấy tờ')}}</label>
                            <input type="text" class="form-control input-sm" id="p_idcard" name="p_idcard" @if(isset($search['p_idcard']))value="{{$search['p_idcard']}}"@endif>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="depart_name">{{viewLanguage('Số hợp đồng')}}</label>
                            <input type="text" class="form-control input-sm" id="p_cer_no" name="p_cer_no" @if(isset($search['p_cer_no']))value="{{$search['p_cer_no']}}"@endif>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="depart_name">{{viewLanguage('Mã đại lý')}}</label>
                            <input type="text" class="form-control input-sm" id="p_org_seller" name="p_org_seller" @if(isset($search['p_org_seller']))value="{{$search['p_org_seller']}}"@endif>
                        </div>

                        <hr>
                        <div class="form-group col-lg-12">
                            @if($is_root || $permission_view)
                                <button class="mb-2 mr-2 btn-icon btn btn-success" type="button" name="submit" value="1" onclick="jqueryCommon.searchAjaxWithForm('{{$formSeachIndex}}','{{$urlSearchAjax}}'); jqueryCommon.hideContentRightPage();"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nội dung form Edit show by ajax--}}
            <div id="content-page-right"></div>
            <div id="content-page-right-layout" style="display: none">
                <div style="position: relative">
                    <div id="loaderRight"><span class="loadingAjaxRight"></span></div>
                    <div id="divDetailItem">
                        <div class="card-header">
                            <span id="title_cap_don"></span>
                            <div class="btn-actions-pane-right">
                                <div class="btn-actions-pane-right">
                                    <a href="javascript:void(0);" class="color_hdi" onclick="jqueryCommon.hideContentRightPageLayout()" title="{{viewLanguage('Close')}}"><i class="pe-7s-close fa-3x"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="div-infor-right">
                            <div class="card-body" id="body-insurance-policy">
                                {{-----Nội dung form cấp đơn hiển thị ở đây----}}
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
        //var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
</script>
