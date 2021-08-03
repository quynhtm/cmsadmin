<div class="div-parent-background">
    <div class="div-background">
        <div class="div-block-right">
            <a href="javascript:void(0);" onclick="jqueryCommon.hideContentRightPageLayout();" class="btn-close-search-list btn btn-default" title="{{viewLanguage('Đóng lại')}}"><i class="pe-7s-close fa-w-16 fa-3x"></i></a>
            {{-- Nội dung form search--}}
            <div class="content-search-page" >
                <h3 class="themeoptions-heading">Tìm kiếm </h3>
                <div class="ibox-content">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="depart_name">{{viewLanguage('Từ khóa')}}</label>
                            <input type="text" class="form-control input-sm" id="p_cusname" name="p_cusname" @if(isset($search['p_cusname']))value="{{$search['p_cusname']}}"@endif>
                        </div>
<!--                        <div class="form-group col-lg-12">
                            <label for="user_group">Sản phẩm bảo hiểm</label>
                            <select  class="form-control input-sm" name="p_status" id="p_status">
                                {!! $optionStatus !!}
                            </select>
                        </div>-->
                        <div class="form-group col-lg-6">
                            <label for="user_email">Thời gian yêu cầu</label>
                            <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_from_date" id="p_from_date" @if(isset($search['p_from_date']))value="{{$search['p_from_date']}}"@endif>
                            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="user_email">đến</label>
                            <input type="text" class="form-control input-sm input-date" data-valid = "text" name="p_to_date" id="p_to_date" @if(isset($search['p_to_date']))value="{{$search['p_to_date']}}"@endif >
                            <div class="icon_calendar"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        <hr>
                        <div class="form-group marginT20 col-lg-12">
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
