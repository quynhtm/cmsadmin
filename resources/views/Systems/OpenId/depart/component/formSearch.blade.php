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
            @if($is_root || $permission_edit || $permission_add)
                <a href="javascript:void(0);" class="area-btn-right btn-action2 btn-edit-right btn-warning sys_show_popup_common" data-form-name="addForm" data-input="{{json_encode(['orgCodeDefault'=>$orgCodeDefault])}}" data-show="2" data-div-show="content-page-right" title="{{viewLanguage('Thêm ')}}{{$pageTitle}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="0">
                    <i class="pe-7s-plus fa-w-16 fa-2x"></i>
                </a>
            @endif

            {{-- Nội dung form search--}}
            <div class="content-search-page" >
                <h3 class="themeoptions-heading">Tìm kiếm </h3>
                <div class="ibox-content">
                    <div class="row">
                    </div>
                </div>
            </div>

            {{-- Nội dung form Edit show by ajax--}}
            <div id="content-page-right"></div>
        </div>
    </div>
</div>
