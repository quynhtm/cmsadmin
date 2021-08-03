<div class="div-parent-background">
    <div class="div-background">
        <div class="div-block-right">
            <a href="javascript:void(0);" onclick="jqueryCommon.hideContentRightPageLayout();" class="btn-close-search-list btn btn-default" title="{{viewLanguage('Đóng lại')}}"><i class="pe-7s-close fa-w-16 fa-3x"></i></a>
            {{-- Button use--}}
            <!--<a href="javascript:void(0);" class="area-btn-right btn-action2 btn-search-right btn-success" title="{{viewLanguage('Search')}}">
                <i class="pe-7s-search fa-w-16 fa-2x"></i>
            </a>-->
            {{-- Nội dung form search--}}
            <div class="content-search-page" >
                <h3 class="themeoptions-heading">Tìm kiếm </h3>
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
                                    <a href="javascript:void(0);" class="color_hdi" onclick="jqueryCommon.hideContentRightPageLayout()" title="{{viewLanguage('Close')}}">&nbsp;&nbsp;<i class="pe-7s-close fa-3x"></i>&nbsp;&nbsp;</a>
                                    &nbsp;&nbsp;&nbsp;
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
    });
</script>
