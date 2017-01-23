<div class="bg-top">
   <div class="container">
      <div class="col-lg-5 col-sm-5">
         <div class="address">
            {{$headAddress}}
         </div>
      </div>
      <div class="col-lg-3 col-sm-3">
         <div class="email">{{$headMail}}</div>
      </div>
      <div class="col-lg-4 col-sm-4 hotline">
         <div class="mobile">{{$headPhone}}</div>
      </div>
   </div>
</div>
<div class="header-midd">
   <div class="container">
      <a href="{{URL::route('site.home')}}" class="logo"></a>
      <div class="slogan">
         {{$headSologan}}		
      </div>
      <div class="pull-right">
         <div class="language">
            <a class="vi @if($lang == CGlobal::TYPE_LANGUAGE_VIET) act @endif" href="{{URL::route('site.home')}}?lang=vi">Tiếng Việt</a>
            <a class="lao @if($lang == CGlobal::TYPE_LANGUAGE_LAO) act @endif" href="{{URL::route('site.home')}}?lang=lao">ລາວ</a>
            <a class="en @if($lang == CGlobal::TYPE_LANGUAGE_ENG) act @endif" href="{{URL::route('site.home')}}?lang=en">English</a>
         </div>
         <div class="search">
            <form action="{{URL::route('site.home')}}/tim-kiem.html" method="GET">
               <input class="txtSearch" name="keyword" placeholder="..." type="text">
               <input name="s" value="{{Langs::getItemByKeywordLang('text_search', $lang)}}" class="search" type="submit">
            </form>
         </div>
      </div>
   </div>
</div>
<div id="nav-header" class="menu">
   <div class="navbar navbar-default" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
	         <span class="sr-only">Toggle navigation</span>
	         <span class="icon-bar"></span>
	         <span class="icon-bar"></span>
	         <span class="icon-bar"></span>
         </button>
      </div>
      <div class="collapse navbar-collapse">
         <div class="container wrapper">
            <ul class="nav navbar-nav">
               <li><a href="{{URL::route('site.home')}}" title="{{Langs::getItemByKeywordLang('text_home', $lang)}}">{{Langs::getItemByKeywordLang('text_home', $lang)}}</a></li>
				@if(!empty($menuCategoriessAll))
				@foreach($menuCategoriessAll as $cat)
				@if($cat['type_language'] == $lang && $cat['category_type'] == CGlobal::CATEGORY_TYPE_MENU)
				<li>
			        <a title="{{$cat['category_name']}}" href="{{FunctionLib::buildLinkCategory($cat['category_id'], $cat['category_name'])}}" @if(isset($catid) && $catid == $cat['category_id']) class="act" @endif><i class="{{$cat['category_icons']}}"></i>{{$cat['category_name']}}</a>
			    </li>
			    @endif
				@endforeach
				@endif
               <li><a href="{{URL::route('site.pageCustomer')}}" title="{{Langs::getItemByKeywordLang('text_customer', $lang)}}">{{Langs::getItemByKeywordLang('text_customer', $lang)}}</a></li>
               <li><a href="{{URL::route('site.pageContact')}}" title="{{Langs::getItemByKeywordLang('text_contact', $lang)}}">{{Langs::getItemByKeywordLang('text_contact', $lang)}}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>

@if(Route::current()->getName() == 'site.home')
	@if(isset($arrBannerHead) && sizeof($arrBannerHead) > 0)
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
	   <ol class="carousel-indicators">
	      @foreach($arrBannerHead as $key_posi_header =>$bannerShowHeader)
		      @foreach($bannerShowHeader as $k=>$sliderHeader)
		      <li data-target="#myCarousel" data-slide-to="{{$k}}" class="@if($k==0) active @endif"></li>
		      @endforeach
		  @endforeach
	   </ol>
	   <div class="carousel-inner" role="listbox">
	      @foreach($arrBannerHead as $key_posi_header =>$bannerShowHeader)
		      @foreach($bannerShowHeader as $k=>$sliderHeader)
		      <div class="item @if($k==0) active @endif">
		         <a @if($sliderHeader->banner_is_rel == CGlobal::LINK_NOFOLLOW) rel="nofollow" @endif @if($sliderHeader->banner_is_target == CGlobal::BANNER_TARGET_BLANK) target="_blank" @endif href="@if($sliderHeader->banner_link != '') {{$sliderHeader->banner_link}} @else javascript:void(0) @endif" title="{{$sliderHeader->banner_name}}">
					<img src="{{ThumbImg::thumbImageBannerNormal($sliderHeader->banner_id,$sliderHeader->banner_parent_id, $sliderHeader->banner_image, CGlobal::sizeImage_1700,CGlobal::sizeImage_372, $sliderHeader->banner_name,true,true)}}" alt="{{$sliderHeader->banner_name}}" />
				</a>
		         <div class="carousel-caption">
		            <div class="section corner-post">
		               <div class="title-section">
		                  <a href="javascript:void(0)" class="pull-left"><span class="block"></span>{{$sliderHeader->banner_name}}</a>
		               </div>
		               <div class="desc-post">{{$sliderHeader->banner_intro}}</div>
		            </div>
		         </div>
		      </div>
		       @endforeach
	      @endforeach
	   </div>
	   <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	   <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	   <span class="sr-only">Previous</span>
	   </a>
	   <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	   <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	   <span class="sr-only">Next</span>
	   </a>
	</div>
	<script>
	   jQuery(document).ready(function(){
	   	jQuery('#myCarousel').carousel({
	   	  interval: 1000 * 5
	   	});
	   });
	</script>
	@endif
@endif