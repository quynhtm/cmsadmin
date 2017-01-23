<div class="site-right col-lg-4 col-sm-4">
   @if(Route::current()->getName() != 'site.pageVideo')
	   @if(sizeof($newVideo) > 0)
	   <div class="section video-post">
	      <div class="title-section">
	         <i class="icon-title"></i>
	         <a href="{{URL::route('site.pageVideo')}}" class="pull-left" title="{{Langs::getItemByKeywordLang('text_video_clip', $lang)}}">{{Langs::getItemByKeywordLang('text_video_clip', $lang)}}</a>
	      </div>
	      <div class="saperator">
	        @foreach($newVideo as $k=>$item)
	      	@if($k == 0)
	         <?php 
	         $_video = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $item->video_link);
	         $embed = '<iframe width="100%" height="300" src="'.$_video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
			 echo $embed;
			 ?>
	         <div class="title-active">
	            <i class="icon-other icon-video"></i>
	            <a href="{{FunctionLib::buildLinkDetailVideo($item->video_name, $item->video_id)}}" title="{{$item->video_name}}">{{$item->video_name}}</a>
	         </div>
	         @endif
	         @endforeach
	      </div>
	      <ul class="list-video-post">
	         @foreach($newVideo as $k=>$item)
	      	 @if($k > 0)
	         <li>
	            <i class="icon-other icon-video"></i>
	            <a href="{{FunctionLib::buildLinkDetailVideo($item->video_name, $item->video_id)}}" title="{{$item->video_name}}">{{$item->video_name}}</a>
	         </li>
	         @endif
	         @endforeach
	      </ul>
	   </div>
	   @endif
   @endif
   @if(Route::current()->getName() != 'site.pageLibrary')
	   @if(sizeof($newImage) > 0)
	   <div class="section image-post">
	      <div class="title-section">
	         <i class="icon-title"></i>
	         <a href="{{URL::route('site.pageLibrary')}}" class="pull-left" title="{{Langs::getItemByKeywordLang('text_library', $lang)}}">
	            <p>{{Langs::getItemByKeywordLang('text_library', $lang)}}</p>
	         </a>
	      </div>
	      @foreach($newImage as $k=>$item)
	      @if($k == 0)
	      <div class="saperator">
	         @if($item['image_image'] != '')
	         <img src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $item['image_id'], $item['image_image'], CGlobal::sizeImage_500)}}" />
	          @endif
	         <div class="title-active">
	            <i class="icon-other icon-image"></i>
	            <a title="{{$item->image_title}}" href="{{FunctionLib::buildLinkDetailLibrary($item->image_title, $item->image_id)}}">{{$item->image_title}}</a>
	         </div>
	      </div>
	      @endif
	      @endforeach
	      <ul class="list-image-post">
	         @foreach($newImage as $k=>$item)
	      	 @if($k > 0)
	         <li>
	            <i class="icon-other icon-image"></i>
	            <a title="{{$item->image_title}}" href="{{FunctionLib::buildLinkDetailLibrary($item->image_title, $item->image_id)}}">{{$item->image_title}}</a>
	         </li>
	          @endif
	     	 @endforeach
	      </ul>
	   </div>
	   @endif
   @endif
   <div class="section cv-post">
	   @if(isset($arrBannerRight) && sizeof($arrBannerRight) > 0)
			@foreach($arrBannerRight as $bannerShowRight)
			@foreach($bannerShowRight as $k=>$sliderRight)
			<div class="item-ads-right">
			  <a @if($sliderRight->banner_is_rel == CGlobal::LINK_NOFOLLOW) rel="nofollow" @endif @if($sliderRight->banner_is_target == CGlobal::BANNER_TARGET_BLANK) target="_blank" @endif href="@if($sliderRight->banner_link != '') {{$sliderRight->banner_link}} @else javascript:void(0) @endif" title="{{$sliderRight->banner_name}}">
			      <img src="{{ThumbImg::thumbImageBannerNormal($sliderRight->banner_id,$sliderRight->banner_parent_id, $sliderRight->banner_image, CGlobal::sizeImage_1700,CGlobal::sizeImage_372, $sliderRight->banner_name,true,true)}}" alt="{{$sliderRight->banner_name}}" />
			  </a>
		    </div>
			@endforeach
			@endforeach
		@endif
	</div>
</div>