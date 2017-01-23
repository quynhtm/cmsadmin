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
	      @if(sizeof($item) > 0)
		      <h1 class="title-news">{{$item['news_title']}}</h1>
		      <div class="date"><i class="icon-other icon-date"></i>{{date('h:i', $item['news_create'])}} {{Langs::getItemByKeywordLang('text_date', $lang)}} {{date('d/m/Y', $item['news_create'])}}</div>
		      <div class="line-content-view view-one-cat">
		         @if($item['news_intro'] != '')
		         <b>{{stripslashes($item['news_intro'])}}</b><br><br>
		         @endif
		         {{stripslashes($item['news_content'])}}
		      </div>
	      @endif
	   </div>
	   @if(sizeof($newsSame) > 0)
	   <div class="title-same">{{Langs::getItemByKeywordLang('text_other_post', $lang)}}<span></span></div>
	   <div class="content-same-post">
			<ul>
				@foreach($newsSame as $k=>$item)
				<li><a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">{{$item['news_title']}}</a></li>
				@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>