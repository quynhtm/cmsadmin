<div class="div-parent-background">
    <div class="div-background">
        <div class="div-block-right">
            <a href="javascript:void(0);" onclick="jqueryCommon.hideContentRightPage();" class="btn-close-search-list btn btn-default" title="{{viewLanguage('Đóng lại')}}">
                <i class="pe-7s-close fa-w-16 fa-3x"></i>
            </a>

            {{-- Button use--}}
<!--            <a href="javascript:void(0);" class="area-btn-right btn-action1 btn-search-right btn-success" title="{{viewLanguage('Search')}}">
                <i class="pe-7s-search fa-w-16 fa-2x"></i>
            </a>-->
            {{-- Nội dung form search--}}
            <div class="content-search-page" >
                <h3 class="themeoptions-heading">Tìm kiếm </h3>
                <div class="ibox-content">

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                            <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="depart_alias">{{viewLanguage('Tổ chức')}}</label>
                            <select class="form-control input-sm" name="ORG_CODE" id="ORG_CODE">

                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                            <select  class="form-control input-sm" name="IS_ACTIVE" id="IS_ACTIVE">

                            </select>
                        </div>
                        <hr>
                        <div class="form-group col-lg-12">
                            @if($is_root || $permission_view)
                                <button class="mb-2 mr-2 btn-icon btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                            @endif
                        </div>
                    </div>

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
    //tim kiem
    var config = {
        '.chosen-select'           : {width: "58%"},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
