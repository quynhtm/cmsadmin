<div class="main-content-inner">
	<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="{{URL::route('admin.dashboard')}}">Home</a>
			</li>
			<li class="active">Quản lý tỉnh thành</li>
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
							<label for="province_id">Id tỉnh thành</label>
							<input type="text" class="form-control input-sm" id="province_id" name="province_id" placeholder="ID tỉnh thành" @if(isset($search['province_id']) && $search['province_id'] != '')value="{{$search['province_id']}}"@endif>
						</div>
						<div class="form-group col-lg-3">
							<label for="province_name">Tên tỉnh thành</label>
							<input type="text" class="form-control input-sm" id="province_name" name="province_name" placeholder="Tên tỉnh thành" @if(isset($search['province_name']) && $search['province_name'] != '')value="{{$search['province_name']}}"@endif>
						</div>
						<div class="form-group col-lg-3">
							<label for="category_status">Trạng thái</label>
							<select name="province_status" id="province_status" class="form-control input-sm">
								{{$optionStatus}}
							</select>
						</div>
					</div>
					<div class="panel-footer text-right">
						@if($is_root || $permission_full ==1 || $permission_create == 1)
							<span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.provinceEdit')}}">
								<i class="ace-icon fa fa-plus-circle"></i>
								Thêm mới
							</a>
                        </span>
						@endif
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
							<th width="55%">Tên tỉnh thành</th>
							<th width="10%" class="text-center">Vị trí</th>
							<th width="10%" class="text-center">Trạng thái</th>
							<th width="20%" class="text-center">Thao tác</th>
						</tr>
						</thead>
						<tbody>
						@foreach ($data as $key => $item)
							<tr>
								<td class="text-center">{{ $stt + $key+1 }}</td>
								<td>
									[<b>{{ $item['province_id'] }}</b>] {{ $item['province_name'] }}
								</td>
								<td class="text-center">{{ $item['province_position'] }}</td>
								<td class="text-center">
									@if($item['province_status'] == 1)
										<a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
									@else
										<a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
									@endif
								</td>
								<td class="text-center">
									@if($is_root || $permission_full ==1|| $permission_edit ==1  )
										<a href="{{URL::route('admin.provinceEdit',array('id' => $item['province_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
									@endif
									@if($is_root || $permission_full ==1 || $permission_delete == 1)
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['province_id']}},4)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
									@endif
									<span class="img_loading" id="img_loading_{{$item['province_id']}}"></span>
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