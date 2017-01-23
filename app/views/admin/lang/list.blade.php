<div class="main-content-inner">
	<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="{{URL::route('admin.dashboard')}}">Home</a>
			</li>
			<li class="active">Quản lý ngôn ngữ</li>
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
							<label for="language_keyword">Từ khóa</label>
							<input type="text" class="form-control input-sm" name="language_keyword" placeholder="Từ khóa" @if(isset($search['language_keyword']) && $search['language_keyword'] != '')value="{{$search['language_keyword']}}"@endif>
						</div>

						<div class="form-group col-lg-3">
							<label for="category_status">Trạng thái</label>
							<select name="language_status" id="language_status" class="form-control input-sm">
								{{$optionStatus}}
							</select>
						</div>
					</div>
					<div class="panel-footer text-right">
						@if($is_root || $permission_full ==1 || $permission_create == 1)
							<span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.langEdit')}}">
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
							<th width="20%">Từ khóa</th>
							<th width="20%">Nội dung</th>
							<th width="5%" class="text-left">Ngôn ngữ</th>
							<th width="5%" class="text-center">Trạng thái</th>
							<th width="2%">Action</th>
						</tr>
						</thead>
						<tbody>
						@foreach($data as $k=>$item)
							<tr>
								<td class="text-center">{{$k+1}}</td>
								<td class="text-center"><input class="checkItem" name="checkItem[]" value="{{$item['language_id']}}" type="checkbox"></td>
								<td>{{$item['language_keyword']}}</td>
								<td>{{$item['language_content']}}</td>
								<td class="text-left">@if(isset($arrLanguage[$item['language_lang']])){{$arrLanguage[$item['language_lang']]}}@else -- @endif</td>
								<td class="text-center">
									@if($item['language_status'] == '1')
										<i class="fa fa-check fa-admin fa-2x green"></i>
									@else
										<i class="fa fa-remove fa-admin fa-2x red"></i>
									@endif
								</td>
								<td>
									<a href="{{URL::route('admin.langEdit',array('id' => $item['language_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
									<!--
									@if($is_root || $permission_full ==1 || $permission_delete == 1)
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['language_id']}},13)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
									@endif
									-->
									<span class="img_loading" id="img_loading_{{$item['language_id']}}"></span>
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