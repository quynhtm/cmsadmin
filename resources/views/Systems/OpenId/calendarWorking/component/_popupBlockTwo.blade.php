<div class="clearfix"></div>
<h4 class="green">Thành phần tham gia</h4>
<div class="clearfix"></div>

<div class="form-group">
    <div class="row">
        <div class="col-lg-4">
            <label for="NAME" class="text-right control-label">Loại <span class="red">*</span></label>
            <div class="">
                <input type="radio" id="canhan" name="type_whose" value="1">
                <label for="male">Cá nhân</label> &nbsp;&nbsp;
                <input type="radio" id="phongban" name="type_whose" value="2">
                <label for="female">Phòng ban</label>
            </div>
        </div>
        <div class="col-lg-4">
            <label for="NAME" class="text-right control-label">Chủ trì <span class="red">*</span></label>
            <input type="text" class="input-sm form-control" required name="preside_id" id="preside_id" @if(isset($data->preside_id))value="{{$data->preside_id}}"@endif>
        </div>
        <div class="col-lg-4">
            <label for="NAME" class="text-right control-label">Trạng thái</label>
            <select class="input-sm form-control" required name="status" id="status" >
                {!! $optionStatus !!}
            </select>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="form-group">
    <div class="row">
        <div class="col-lg-4">
            <label for="NAME" class="text-right control-label">Thành phần tham gia<span class="red">*</span></label>
            <input type="text" class="input-sm form-control" required name="participants_name" id="participants_name" @if(isset($data->participants_name))value="{{$data->participants_name}}"@endif>
        </div>
        <div class="col-lg-4">
            <label for="NAME" class="text-right control-label">Thành phần khác</label>
            <input type="text" class="input-sm form-control" required name="participants_name_other" id="participants_name_other" @if(isset($data->participants_name_other))value="{{$data->participants_name_other}}"@endif>
        </div>
        <div class="col-lg-4">
            <label for="NAME" class="text-left">Tệp đính kèm</label>
            <div>
                <label title="Upload image file" for="inputImage" class="btn btn-info">
                    <input type="file" accept="image/*" name="file" id="inputImage" style="display:none">
                    Upload image
                </label>
            </div>
        </div>
    </div>
</div>


