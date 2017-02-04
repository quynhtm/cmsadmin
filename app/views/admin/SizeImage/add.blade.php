<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.sizeImageView')}}"> Size Image </a></li>
            <li class="active">@if($id > 0)Cập nhật Size Image @else Tạo mới Size Image @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content marginTop30">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST','role'=>'form','files' => true))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div style="float: left;width: 60%">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name" class="control-label">Name Size Image <span class="red"> (*) </span></label>
                        <input type="text" placeholder="Name Size Image" id="size_img_name" name="size_img_name"  class="form-control input-sm" value="@if(isset($data['size_img_name'])){{$data['size_img_name']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name" class="control-label">Width</label>
                        <input type="text" placeholder="Chiều rộng" id="size_img_width" name="size_img_width" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" " data-p-sign="s" value="@if(isset($data['size_img_width'])){{$data['size_img_width']}}@endif">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name" class="control-label">Height</label>
                        <input type="text" placeholder="Chiều cao" id="size_img_height" name="size_img_height" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" " data-p-sign="s" value="@if(isset($data['size_img_height'])){{$data['size_img_height']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Status</label>
                        <div class="form-group">
                            <select name="size_img_status" id="size_img_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group col-sm-12 text-left">
                    <a class="btn btn-warning" href="{{URL::route('admin.sizeImageView')}}"><i class="fa fa-reply"></i> Back</a>
                    <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                </div>
                <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                {{ Form::close() }}
                <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>

<script>
    $(document).ready(function(){
        jQuery('.formatMoney').autoNumeric('init');
    });
</script>
