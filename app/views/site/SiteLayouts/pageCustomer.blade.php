<div class="main-view contact">
   <div class="main-content-view">
      <div class="link-breadcrumb">
         <a href="{{URL::route('site.home')}}" title="{{Langs::getItemByKeywordLang('text_home', $lang)}}">{{Langs::getItemByKeywordLang('text_home', $lang)}}</a> › 
         <a href="{{URL::route('site.pageCustomer')}}" title="{{Langs::getItemByKeywordLang('text_customer', $lang)}}">{{Langs::getItemByKeywordLang('text_customer', $lang)}}</a>
      </div>
      <h1 class="title-news"><a href="{{URL::route('site.pageCustomer')}}" title="{{Langs::getItemByKeywordLang('text_customer', $lang)}}">{{Langs::getItemByKeywordLang('text_customer', $lang)}}</a></h1>
      <div class="line-intro-other-view">
      	{{Langs::getItemByKeywordLang('text_intro_customer', $lang)}}
      </div>
      <div class="list-customer">
     	@if(isset($arrBannerPartner) && sizeof($arrBannerPartner) > 0)
         	 <div class="row page-list-customer">
				@foreach($arrBannerPartner as $bannerShowPartner)
				@foreach($bannerShowPartner as $k=>$sliderPartner)
				 <div class="col-lg-3 col-sm-3 item-ads-partner">
				  <a @if($sliderPartner->banner_is_rel == CGlobal::LINK_NOFOLLOW) rel="nofollow" @endif @if($sliderPartner->banner_is_target == CGlobal::BANNER_TARGET_BLANK) target="_blank" @endif href="@if($sliderPartner->banner_link != '') {{$sliderPartner->banner_link}} @else javascript:void(0) @endif" title="{{$sliderPartner->banner_name}}">
				      <img src="{{ThumbImg::thumbImageBannerNormal($sliderPartner->banner_id,$sliderPartner->banner_parent_id, $sliderPartner->banner_image, CGlobal::sizeImage_300,CGlobal::sizeImage_300, $sliderPartner->banner_name,true,true)}}" alt="{{$sliderPartner->banner_name}}" />
				  </a>
			    </div>
				@endforeach
				@endforeach
         	</div>
        	@endif
      </div>
   </div>
</div>