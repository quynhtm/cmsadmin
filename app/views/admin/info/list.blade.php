<div class="main-content-inner">
	<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="{{URL::route('admin.dashboard')}}">Home</a>
			</li>
			<li class="active">Quản lý Thông tin SEO</li>
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
							<label for="province_id">Từ khóa</label>
							<input type="text" class="form-control input-sm" id="info_title" name="info_title" placeholder="ID tỉnh thành" @if(isset($search['info_title']) && $search['info_title'] != '')value="{{$search['info_title']}}"@endif>
						</div>

						<div class="form-group col-lg-3">
							<label for="category_status">Trạng thái</label>
							<select name="info_status" id="info_status" class="form-control input-sm">
								{{$optionStatus}}
							</select>
						</div>
					</div>
					<div class="panel-footer text-right">
						@if($is_root || $permission_full ==1 || $permission_create == 1)
							<span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.infoEdit')}}">
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
						<thead>
						<tr>
							<th width="2%" class="text-center">STT</th>
							<th width="1%" class="text-center"><input id="checkAll" type="checkbox"></th>
							<th width="20%">Tiêu đề</th>
							<th width="10%">Loại thông tin</th>
							<th width="5%" class="text-left">Ngôn ngữ</th>
							<th width="5%" class="text-center">Ngày tạo</th>
							<th width="5%" class="text-center">Trạng thái</th>
							<th width="5%">Action</th>
						</tr>
						</thead>
						<tbody>
						@foreach($data as $k=>$item)
							<tr>
								<td class="text-center">{{$k+1}}</td>
								<td class="text-center"><input class="checkItem" name="checkItem[]" value="{{$item['info_id']}}" type="checkbox"></td>
								<td>{{$item['info_title']}}</td>
								<td>@if(isset($arrInforSite[$item['info_type']])){{$arrInforSite[$item['info_type']]}}@else -- @endif</td>
								<td class="text-left">@if(isset($arrLanguage[$item['type_language']])){{$arrLanguage[$item['type_language']]}}@else -- @endif</td>
								<td class="text-center">{{date('d/m/Y', $item['info_created'])}}</td>
								<td class="text-center">
									@if($item['info_status'] == '1')
										<i class="fa fa-check fa-admin fa-2x green"></i>
									@else
										<i class="fa fa-remove fa-admin fa-2x red"></i>
									@endif
								</td>
								<td>
									<a href="{{URL::route('admin.infoEdit',array('id' => $item['info_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
									@if($is_root || $permission_full ==1 || $permission_delete == 1)
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['info_id']}},11)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
									@endif
									<span class="img_loading" id="img_loading_{{$item['info_id']}}"></span>
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
			</div>
		</div>
	</div><!-- /.page-content -->
</div>