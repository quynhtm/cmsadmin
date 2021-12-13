<div class="div-parent-background">
    <div class="div-background">
        <div class="div-block-right">
            <a href="javascript:void(0);" class="btn-close-search-list btn btn-default" title="{{viewLanguage('Search')}}">
                <i class="pe-7s-close fa-w-16 fa-3x"></i>
            </a>

            {{-- Button use--}}
            <!-- <a href="javascript:void(0);" class="area-btn-right btn-action1 btn-search-right btn-success" title="{{viewLanguage('Search')}}">
                <i class="pe-7s-search fa-w-16 fa-2x"></i>
            </a>-->
            @if($permission_full || $permission_edit || $permission_add)
                <a href="javascript:void(0);"class="area-btn-right btn-action2 btn-edit-right btn-warning sys_show_popup_common" data-form-name="addForm" data-input="{{json_encode([])}}" title="{{viewLanguage('Thêm ')}}{{$pageTitle}}" data-method="get" data-url="{{$urlGetItem}}" data-objectId="0">
                    <i class="pe-7s-plus fa-w-16 fa-2x"></i>
                </a>
            @endif

            {{-- Nội dung form--}}
            <h3 class="themeoptions-heading">Tìm kiếm </h3>
            <div class="ibox-content display-none-block">
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                        <input type="text" class="form-control input-sm" id="s_search" name="s_search" autocomplete="off" @if(isset($search['s_search']))value="{{$search['s_search']}}"@endif>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="status" class="control-label">{{viewLanguage('Define Code')}}</label>
                        <select name="s_define_code" id="s_define_code" class="form-control input-sm">
                            {!! $optionDefineCode !!}}
                        </select>
                    </div>
                    <hr>
                    <div class="form-group col-lg-12">
                        @if($permission_full || $permission_edit || $permission_add)
                            <button class="mb-2 mr-2 btn-icon btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                        @endif
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
