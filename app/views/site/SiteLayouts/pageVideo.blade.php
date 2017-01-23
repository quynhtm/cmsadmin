<div class="main-view contact">
   <div class="main-content-view">
      <div class="link-breadcrumb">
         <a href="{{URL::route('site.home')}}" title="{{Langs::getItemByKeywordLang('text_home', $lang)}}">{{Langs::getItemByKeywordLang('text_home', $lang)}}</a> › 
         <a href="{{URL::route('site.pageVideo')}}" title="{{Langs::getItemByKeywordLang('text_video_clip', $lang)}}">{{Langs::getItemByKeywordLang('text_video_clip', $lang)}}</a>
      </div>
      <h1 class="title-news"><a href="{{URL::route('site.pageVideo')}}" title="{{Langs::getItemByKeywordLang('text_video_clip', $lang)}}">{{Langs::getItemByKeywordLang('text_video_clip', $lang)}}</a></h1>
      <div class="list-library">
     	@if(isset($arrItem) && sizeof($arrItem) > 0)
         	 <div class="row page-list-library">
				@foreach($arrItem as $k=>$item)
				 <div class="col-lg-3 col-sm-3 item-video">
				 	<a title="{{$item->video_name}}" href="{{FunctionLib::buildLinkDetailVideo($item->video_name, $item->video_id)}}">
				      <div>
				      	<?php 
				         $_video = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $item->video_link);
				         $embed = '<iframe width="100%" height="250" src="'.$_video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
						 echo $embed;
						 ?>
				  	  </div>
				  	  <div class="titleL">{{$item->video_name}}</div>
				  </a>
			    </div>
				@endforeach
         	</div>
        	@endif
      </div>
      <div class="show-box-paging" style="margin-top:20px; ">
		<div class="showListPage">
			{{$paging}}
		</div>
	  </div>
   </div>
</div>