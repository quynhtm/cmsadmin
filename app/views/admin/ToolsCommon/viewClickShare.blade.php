<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Quản lý lượt share của thành viên</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        @if($is_root)
                            <div class="form-group col-lg-3">
                                <label for="object_name">ID đối tượng share</label>
                                <input type="text" class="form-control input-sm" id="object_id" name="object_id" placeholder="ID đối tượng share" @if(isset($search['object_id']) && $search['object_id'] != '')value="{{$search['object_id']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="object_name">Tên đối tượng share</label>
                                <input type="text" class="form-control input-sm" id="object_name" name="object_name" placeholder="Tên đối tượng share" @if(isset($search['object_name']) && $search['object_name'] != '')value="{{$search['object_name']}}"@endif>
                            </div>
                        @endif
                        <div class="form-group col-lg-3">
                            <label for="object_name">Ngày từ</label>
                            <input type="text" class="form-control" id="start_time" name="start_time"  data-date-format="dd-mm-yyyy" value="@if(isset($search['start_time']) && $search['start_time'] > 0){{date('d-m-Y',$search['start_time'])}}@endif">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="object_name">đến</label>
                            <input type="text" class="form-control" id="end_time" name="end_time"  data-date-format="dd-mm-yyyy" value="@if(isset($search['end_time']) && $search['end_time'] > 0){{date('d-m-Y',$search['end_time'])}}@endif">
                        </div>
                        @if(!$is_root)
                            <div class="form-group col-lg-9">
                                Link share của thành viên: <b>{{$url_link_share}}</b>
                            </div>
                        @endif
                    </div>
                    <div class="panel-footer text-right">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="5%" class="text-center">STT</th>
                            <th width="65%">Tên đối tượng</th>
                            <th width="20%" class="text-center">IP share</th>
                            <th width="10%" class="text-center">Thời gian</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">
                                    {{ $stt + $key+1 }}
                                </td>
                                <td>
                                    [<b>{{ $item->object_id }}</b>] {{ $item->object_name }}
                                </td>
                                <td class="text-center">
                                    {{ $item->share_ip }}
                                </td>
                                <td class="text-center">
                                    {{date('d-m-Y H:i:s',$item->share_time)}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        {{$paging}}
                    </div>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
                            <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>

<script>
    $(document).ready(function(){
        var checkin = $('#start_time').datepicker({ });
        var checkout = $('#end_time').datepicker({ });
    });
</script>
