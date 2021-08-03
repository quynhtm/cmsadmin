<div class="marginT5">
    <div class="form-group">
        <div class="row">
            <div class="col-lg-6">
                <label for="type_calendar" class="text-right control-label">Loại lịch<span class="red">*</span></label>
                <select class="input-sm form-control" required @if(isset($oject_id) && $oject_id <= 0) name="type_calendar" id="type_calendar" onchange="onchangeTyleCalendar();" @else disabled @endif>
                    {!! $optionType !!}
                </select>
            </div>
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">Thuộc khu vực<span class="red">*</span></label>
                <select class="input-sm form-control" required name="provice_id" id="provice_id" >
                    {!! $optionCity !!}
                </select>
            </div>
        </div>
    </div>
</div>
<div id="calender_1">
    <div class="clearfix"></div>
    <h4 class="green">Thông tin lịch họp</h4>
    <div class="clearfix"></div>
    <div class="marginT5">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">Ngày họp</label>
                    <input type="text" class="form-control input-date" id="date_meeting" name="date_meeting" format="d-m-yy" @if(isset($data->date_meeting))value="{{$data->date_meeting}}" @else value="{{date('d-m-Y',time())}}"@endif>
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-center col-lg-12 control-label">Giờ bắt đầu (h:i)</label>
                    <div class="row">
                        <input type="text" class="form-control text-center" id="start_meeting" name="start_meeting" @if(isset($data->start_meeting))value="{{$data->start_meeting}}" @else value="{{date('H:i',time())}}" @endif>
                    </div>
                </div>
                <div class="col-lg-3">
                    <label for="NAME" class="text-center col-lg-12 control-label">Giờ kết thúc (h:i)</label>
                    <div class="row">
                        <input type="text" class="form-control text-center" id="end_meeting" name="end_meeting" @if(isset($data->end_meeting))value="{{$data->end_meeting}}" @else value="{{date('H:i',(time()+3600))}}" @endif>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="marginT10">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">Địa điểm <span class="red">*</span></label>
                    <select name="address" id="address" class="input-sm form-control">
                        {!! $optionParticipants !!}}
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="NAME" class="text-right control-label">Thiết bị</label>
                    <select name="device" id="device" class="input-sm form-control">
                        {!! $optionParticipants !!}}
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="form-group">
        <div class="row">
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">Địa điểm khác</label>
                <input type="text" class="input-sm form-control" required name="address_other" id="address_other" @if(isset($data->address_other))value="{{$data->address_other}}"@endif>
            </div>
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">Yêu cầu khác</label>
                <input type="text" class="input-sm form-control" required name="requirements_other" id="requirements_other" @if(isset($data->requirements_other))value="{{$data->requirements_other}}"@endif>
            </div>
        </div>
    </div>
</div>

<div id="calender_2" style="display: none">
    <div class="clearfix"></div>
    <h4 class="green">Thông tin lịch công tác</h4>
    <div class="clearfix"></div>

    <div class="form-group">
        <div class="row">
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">Ngày khởi hành</label>
                <input type="text" class="input-sm form-control input-date" id="date_start_working" name="date_start_working" format="d-m-yy" @if(isset($data->date_start_working))value="{{$data->date_start_working}}"@endif>
            </div>
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">Ngày kết thúc</label>
                <input type="text" class="input-sm form-control input-date" id="date_end_working" name="date_end_working" format="d-m-yy" @if(isset($data->date_end_working))value="{{$data->date_end_working}}"@endif>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="form-group">
        <div class="row">
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">Địa điểm<span class="red">*</span></label>
                <input type="text" class="input-sm form-control" required name="address" id="address" @if(isset($data->address))value="{{$data->address}}"@endif>
            </div>
            <div class="col-lg-6">
                <label for="NAME" class="text-right control-label">Phương tiện đi lại</label>
                <input type="text" class="input-sm form-control" required name="vehicles_working" id="vehicles_working" @if(isset($data->vehicles_working))value="{{$data->vehicles_working}}"@endif>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="form-group">
    <label for="NAME" class="text-right control-label">Nội dung <span class="red">*</span></label>
    <textarea class="form-control" id="content" name="content" rows="2">@if(isset($data->content)){{$data->content}}@endif</textarea>
</div>
<script type="text/javascript">
    $(document).ready(function(){

    });

</script>
