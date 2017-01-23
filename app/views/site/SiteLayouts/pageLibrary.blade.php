<div class="main-view contact">
   <div class="main-content-view">
      <div class="link-breadcrumb">
         <a href="{{URL::route('site.home')}}" title="{{Langs::getItemByKeywordLang('text_home', $lang)}}">{{Langs::getItemByKeywordLang('text_home', $lang)}}</a> › 
         <a href="{{URL::route('site.pageLibrary')}}" title="{{Langs::getItemByKeywordLang('text_library', $lang)}}">{{Langs::getItemByKeywordLang('text_library', $lang)}}</a>
      </div>
      <h1 class="title-news"><a href="{{URL::route('site.pageLibrary')}}" title="{{Langs::getItemByKeywordLang('text_library', $lang)}}">{{Langs::getItemByKeywordLang('text_library', $lang)}}</a></h1>
      <div class="list-library">
     	@if(isset($arrItem) && sizeof($arrItem) > 0)
         	 <div class="row page-list-library">
				@foreach($arrItem as $k=>$item)
				 <div class="col-lg-3 col-sm-3 item-library">
				 	<a title="{{$item->image_title}}" href="{{FunctionLib::buildLinkDetailLibrary($item->image_title, $item->image_id)}}">
				      <div class="thumbL">
				      	<img src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $item['image_id'], $item['image_image'], CGlobal::sizeImage_500)}}" />
				  	  </div>
				  	  <div class="titleL">{{$item->image_title}}</div>
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