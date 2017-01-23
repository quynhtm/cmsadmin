<div class="site-left col-lg-8 col-sm-8">
	<div class="main-view contact">
	   <div class="main-content-view">
	      <div class="link-breadcrumb">
	         <a href="{{URL::route('site.home')}}" title="{{Langs::getItemByKeywordLang('text_home', $lang)}}">{{Langs::getItemByKeywordLang('text_home', $lang)}}</a> › 
	         <a href="{{URL::route('site.pageVideo')}}" title="{{Langs::getItemByKeywordLang('text_video_clip', $lang)}}">{{Langs::getItemByKeywordLang('text_video_clip', $lang)}}</a>
	      </div>
	      <h1 class="title-news">{{$item->video_name}}</h1>
	      <div class="list-library">
	     	@if(isset($item) && sizeof($item) > 0)
	         	 <div class="row page-list-library">
					 <?php 
					 $_video = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $item->video_link);
					 $embed = '<iframe width="100%" height="400" src="'.$_video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
					 echo $embed;
					 ?>
	         	</div>
	         	@if($item->video_content != '')
	         	<div class="library-intro">
	         		{{stripslashes($item->video_content)}}
	         	</div>
	         	@endif
	        	@endif
	      </div>
	   </div>
	</div>
</div>