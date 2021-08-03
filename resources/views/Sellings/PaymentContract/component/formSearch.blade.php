<div class="div-parent-background">
    <div class="div-background">
        <div class="div-block-right">
            <a href="javascript:void(0);" onclick="jqueryCommon.hideContentRightPageLayout();" class="btn-close-search-list btn btn-default" title="{{viewLanguage('Đóng lại')}}">
                <i class="pe-7s-close fa-w-16 fa-3x"></i>
            </a>
            {{-- Nội dung form search--}}
            <div class="content-search-page" >
                <h3 class="themeoptions-heading">Tìm kiếm </h3>
                <div class="ibox-content">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="depart_name">{{viewLanguage('Tên khách hàng')}}</label>
                            <input type="text" class="form-control input-sm" id="p_cusname" name="p_cusname" @if(isset($search['p_cusname']))value="{{$search['p_cusname']}}"@endif>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="depart_name">{{viewLanguage('Số điện thoại')}}</label>
                            <input type="text" class="form-control input-sm" id="p_phone" name="p_phone" @if(isset($search['p_phone']))value="{{$search['p_phone']}}"@endif>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="depart_name">{{viewLanguage('Số CMNĐ')}}</label>
                            <input type="text" class="form-control input-sm" id="p_idcard" name="p_idcard" @if(isset($search['p_idcard']))value="{{$search['p_idcard']}}"@endif>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="depart_name">{{viewLanguage('Sản phẩm')}}</label>
                            <select  class="form-control input-sm chosen-select w-100" name="p_product_code" id="p_product_code" >
                                {!! $optionProduct !!}
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="depart_name">{{viewLanguage('Đơn vị cấp')}}</label>
                            <select  class="form-control input-sm chosen-select w-100" name="p_org_code" id="p_org_code" >
                                {!! $optionOrg !!}
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="depart_name">{{viewLanguage('Số tiền từ')}}</label>
                            <input type="text" id="p_amount_from" name="p_amount_from" class="form-control input-sm formatMoney text-left" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" " data-p-sign="s" @if(isset($search['p_amount_from']))value="{{$search['p_amount_from']}}"@endif>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="depart_name">{{viewLanguage(' đến')}}</label>
                            <input type="text" id="p_amount_to" name="p_amount_to" class="form-control input-sm formatMoney text-left" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" " data-p-sign="s" @if(isset($search['p_amount_to']))value="{{$search['p_amount_to']}}"@endif >
                        </div>
                        <hr>
                        <div class="form-group col-lg-12">
                            @if($is_root || $permission_view)
                                <button class="mb-2 mr-2 btn-icon btn btn-success" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nội dung form Edit show by ajax--}}
            <div id="content-page-right"></div>
            <div id="content-page-right-layout"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
    });
</script>
