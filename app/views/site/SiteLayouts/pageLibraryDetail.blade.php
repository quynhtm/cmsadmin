<div class="main-view contact">
   <div class="main-content-view">
      <div class="link-breadcrumb">
         <a href="{{URL::route('site.home')}}" title="{{Langs::getItemByKeywordLang('text_home', $lang)}}">{{Langs::getItemByKeywordLang('text_home', $lang)}}</a> › 
         <a href="{{URL::route('site.pageLibrary')}}" title="{{Langs::getItemByKeywordLang('text_library', $lang)}}">{{Langs::getItemByKeywordLang('text_library', $lang)}}</a>
      </div>
      <h1 class="title-news">{{$item->image_title}}</h1>
      <div class="list-library">
     	@if(isset($item) && sizeof($item) > 0)
     		<?php $image_image_other = unserialize($item->image_image_other); ?>
         	 <div class="row page-list-library" id="gallery">
				 @foreach($image_image_other as $k=>$img)
				 <div class="col-lg-3 col-sm-3 item-library-detail">
				 	<a title="{{$item->image_title}}" href="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $item['image_id'], $img, CGlobal::sizeImage_750)}}">
				      <div class="thumbLDetail">
				      	<img src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $item['image_id'], $img, CGlobal::sizeImage_500)}}" />
				  	  </div>
				  </a>
			    </div>
			    @endforeach
         	</div>
         	<div class="library-intro">
         		{{$item->image_content}}
         	</div>
        	@endif
      </div>
      @if(sizeof($newsSame) > 0)
      <div class="title-same">{{Langs::getItemByKeywordLang('text_other_post', $lang)}}<span></span></div>
      <div class="list-library mgt10">
     	@if(isset($newsSame) && sizeof($newsSame) > 0)
         	 <div class="row page-list-library">
				@foreach($newsSame as $k=>$aitem)
				 <div class="col-lg-3 col-sm-3 item-library">
				 	<a title="{{$aitem->image_title}}" href="{{FunctionLib::buildLinkDetailLibrary($aitem->image_title, $aitem->image_id)}}">
				      <div class="thumbL">
				      	<img src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $aitem['image_id'], $aitem['image_image'], CGlobal::sizeImage_500)}}" />
				  	  </div>
				  	  <div class="titleL">{{$aitem->image_title}}</div>
				  </a>
			    </div>
				@endforeach
         	</div>
        	@endif
      </div>
      @endif
   </div>
</div>
<script>
	jQuery(document).ready(function() {
		jQuery('#gallery').magnificPopup({
			delegate: 'a',
			type: 'image',
			tLoading: 'Loading...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1],
			},
			image: {
				tError: 'Not load image!',
				titleSrc: function(item) {
					return item.el.attr('title') + '<small>{{CGlobal::web_name}}</small>';
				}
			}
		});
	});
</script>