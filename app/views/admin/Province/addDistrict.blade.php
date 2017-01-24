<div id="div-3" class="body">
{{ Form::open(array('class'=>'form-horizontal')) }}
<div class="form-group">
    <label for="textName" class="control-label col-lg-4 font2">Tên quận huyện<span style="color: red"> (*)</span></label>
    <div class="col-lg-8">
        <input type="text" id="district_name" name="district_name" checked placeholder="" class="form-control" @if(isset($data['district_name']))value="{{$data['district_name']}}"@endif>
    </div>
</div>
<div class="form-group">
    <label for="textEmail" class="control-label col-lg-4 font2">Trạng thái</label>
    <div class="col-lg-8">
        <select name="district_status" id="district_status" class="form-control input-sm">
            {{$optionStatus}}
        </select>
    </div>
</div>
<div class="form-group">
    <label for="textName" class="control-label col-lg-4 font2">Vị trí</label>
    <div class="col-lg-8">
        <input type="text" id="district_position" name="district_position" checked placeholder="" class="form-control" @if(isset($data['district_position']))value="{{$data['district_position']}}"@endif>
    </div>
</div>

<div class="form-group">
    <div class=" col-lg-12 text-right">
        <input type="hidden" id="district_province_id" name="district_province_id" value="{{$district_province_id}}">
        <input type="hidden" id="district_id" name="district_id" value="{{$district_id}}">
        <a href="javascript:void(0);" class="btn btn-primary" onclick="return Admin.submitInforDistrictOfProvince()" title="sửa">Cập nhật</a>
    </div>
</div>
{{ Form::close() }}
</div>