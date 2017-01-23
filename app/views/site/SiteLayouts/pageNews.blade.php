<div class="site-left col-lg-8 col-sm-8">
	<div class="main-view">
	   <div class="main-content-view">
	      <div class="link-breadcrumb">
	        <a href="{{URL::route('site.home')}}" title="{{Langs::getItemByKeywordLang('text_home', $lang)}}">{{Langs::getItemByKeywordLang('text_home', $lang)}}</a>
	        @if(sizeof($arrCat) > 0)
	         › 
	        <a href="{{FunctionLib::buildLinkCategory($arrCat->category_id, $arrCat->category_name)}}" title="{{$arrCat->category_name}}">{{$arrCat->category_name}}</a>
	      	@endif
	      </div>
	      @if(count($arrItem) > 1)
	      	<?php $total = count($arrItem); ?>
	      	<div class="list-post">
		      	@foreach($arrItem as $i=>$item)
		      	<div class="item-post @if($total == $i+1) last @endif">
					@if($item['news_image'] != '')
						<img alt="{{$item['news_title']}}"
							src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'], $item['news_image'], CGlobal::sizeImage_500)}}">
					@endif
					<div class="title-list-item">
						<a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
							{{$item['news_title']}}
						</a>
					</div>
					<div class="date"><i class="icon-other icon-date"></i>{{date('h:i', $item['news_create'])}} {{Langs::getItemByKeywordLang('text_date', $lang)}} {{date('d/m/Y', $item['news_create'])}}</div>
					<div class="post-intro">
						@if($item['news_intro'] != '')
							{{FunctionLib::substring($item['news_intro'], 500, '...') }}
						@else
							{{FunctionLib::substring($item['news_content'], 500, '...') }}
						@endif
					</div>
				</div>
		      	@endforeach
		    </div>
	      	<div class="show-box-paging" style="margin-top:20px; ">
				<div class="showListPage">
					{{$paging}}
				</div>
			</div>
	      @else
	      @foreach($arrItem as $item)
	      <h1 class="title-news">{{$item['news_title']}}</h1>
	      <div class="date"><i class="icon-other icon-date"></i>{{date('h:i', $item['news_create'])}} {{Langs::getItemByKeywordLang('text_date', $lang)}} {{date('d/m/Y', $item['news_create'])}}</div>
	      <div class="line-content-view view-one-cat">
	         @if($item['news_intro'] != '')
	         <b>{{stripslashes($item['news_intro'])}}</b><br><br>
	         @endif
	         {{stripslashes($item['news_content'])}}
	      </div>
	      @endforeach
	      @endif
	   </div>
	</div>
</div>