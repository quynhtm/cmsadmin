<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.lang')}}"> Danh sách thông tin chung</a></li>
            <li class="active">@if($id > 0)Cập nhật thông tin chung @else Tạo mới thông tin chung @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content marginTop30">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST','role'=>'form','files' => true))}}
                @if(isset($error) && is_array($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @else
                    @if($error != '')
                    <div class="alert alert-danger" role="alert">{{$error}}</div>
                    @endif
                @endif
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Keyword</i>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" name="language_keyword" value="@if(isset($data['language_keyword'])){{$data['language_keyword']}}@endif" @if(isset($data['language_keyword']) && $data['language_keyword'] != '') readonly @endif>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Language</i>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <select class="form-control input-sm" name="language_lang" >
                            {{$optionLanguage}}
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Trạng thái</i>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <select class="form-control input-sm" name="language_status" >
                            {{$optionStatus}}
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                   <div class="form-group">
                      <i>Nội dung</i>
                   </div>
                 </div>
                 <div class="col-sm-8">
                    <div class="form-group">
                        <textarea class="form-control input-sm" name="language_content">@if(isset($data['language_content'])){{stripslashes($data['language_content'])}}@endif</textarea>
                    </div>
                 </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-2 text-left"></div>
                <div class="form-group col-sm-10 text-left">
                    <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                </div>
                <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>