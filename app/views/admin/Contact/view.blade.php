<div class="main-content-inner">
	<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="{{URL::route('admin.dashboard')}}">Home</a>
			</li>
			<li class="active">Quản lý Liên hệ quản trị</li>
		</ul><!-- /.breadcrumb -->
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-xs-12">
				<!-- PAGE CONTENT BEGINS -->
				<div class="panel panel-info">
					{{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
					<div class="panel-body">
						<div class="form-group col-lg-3">
							<label for="province_name">Tiêu đề liên hệ</label>
							<input type="text" class="form-control input-sm" id="contact_title" name="contact_title" placeholder="Tiêu đề liên hệ" @if(isset($search['contact_title']) && $search['contact_title'] != '')value="{{$search['contact_title']}}"@endif>
						</div>
						<div class="form-group col-lg-3">
							<label for="province_name">Tên người liên hệ</label>
							<input type="text" class="form-control input-sm" id="contact_user_name_send" name="contact_user_name_send" placeholder="Người liên hệ" @if(isset($search['contact_user_name_send']) && $search['contact_user_name_send'] != '')value="{{$search['contact_user_name_send']}}"@endif>
						</div>
					</div>
					<div class="panel-footer text-right">
						<span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
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
							<th width="20%">Tiêu đề</th>
							<th width="50%">Nội dung</th>
							<th width="20%">Thông tin người liên hệ</th>
							<th width="5%" class="text-center">Thao tác</th>
						</tr>
						</thead>
						<tbody>
						@foreach ($data as $key => $item)
							<tr>
								<td class="text-center">{{ $stt + $key+1 }}</td>
								<td>
									[<b>{{ $item['contact_id'] }}</b>] {{ $item['contact_title'] }}
								</td>
								<td class="text-center">{{ $item['contact_content'] }}</td>
								<td class="text-center">
									Họ Tên: {{ $item['contact_user_name_send'] }}
									<br/>Email: {{ $item['contact_email_send'] }}
								</td>

								<td class="text-center">
									@if($is_root || $permission_full ==1 || $permission_delete == 1)
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['contact_id']}},12)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
									@endif
									<span class="img_loading" id="img_loading_{{$item['contact_id']}}"></span>
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