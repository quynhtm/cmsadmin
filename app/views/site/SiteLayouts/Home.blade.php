<div class="site-left col-lg-8 col-sm-8">
   <div id="block-site-block-content-hot" class="block block-site">
      <div class="content">
         <div class="section hot-post">
            <div class="title-section">
               <i class="icon-title"></i>
               <a href="javascript:void(0)" class="pull-left">{{Langs::getItemByKeywordLang('txt_news_hot', $lang)}}</a>
            </div>
            @if(sizeof($NewsHot) > 0)
            @foreach($NewsHot as $k=>$item)
            @if($k==0)
            <div class="row">
               <div class="col-lg-7 col-left col-sm-7">
                  <div class="box-hot-post">
                     <div class="block-post-big">
                        <a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
                        	@if($item['news_image'] != '')
								<img alt="{{$item['news_title']}}"
									src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'], $item['news_image'], CGlobal::sizeImage_500)}}">
							@endif
                        </a>
                     </div>
                  </div>
               </div>
               <div class="col-lg-5 col-sm-5 col-sm-12">
                  <div class="title-post">
                     <a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">{{$item['news_title']}}</a>
                     <div class="date"><i class="icon-other icon-date"></i>{{date('h:i', $item['news_create'])}} {{Langs::getItemByKeywordLang('text_date', $lang)}} {{date('d/m/Y', $item['news_create'])}}</div>
                  </div>
                  <div class="desc-post">
                    	@if($item['news_intro'] != '')
							{{FunctionLib::substring($item['news_intro'], 500, '...') }}
						@else
							{{FunctionLib::substring($item['news_content'], 500, '...') }}
						@endif			
                  </div>
               </div>
            </div>
            @endif
            @endforeach
            <div class="sub-post">
               <div class="row">
                   @foreach($NewsHot as $k=>$item)
            	   @if($k>0)
                  <div class="col-lg-4 col-sm-4">
                     <a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
                        @if($item['news_image'] != '')
							<img alt="{{$item['news_title']}}"
								src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'], $item['news_image'], CGlobal::sizeImage_500)}}">
						@endif
                        <div class="intro-post-other">
                           <div class="title-post-other"><b>{{$item['news_title']}}</b></div>
                           <div class="desc-post-other">
                               @if($item['news_intro'] != '')
									{{FunctionLib::substring($item['news_intro'], 500, '...') }}
								@else
									{{FunctionLib::substring($item['news_content'], 500, '...') }}
								@endif					
                           </div>
                        </div>
                     </a>
                  </div>
                   @endif
                   @endforeach
               </div>
            </div>
            @endif
         </div>
      </div>
   </div>
   <div id="block-site-block-content" class="block block-site">
      <div class="content">
         <div class="row">
            @if(!empty($menuCategoriessAll))
			@foreach($menuCategoriessAll as $cat)
			@if($cat['type_language'] == $lang && $cat['category_show_content'] == CGlobal::status_show)
            <?php $arrNews = News::getNewsInCat('', $cat['category_id'], CGlobal::number_show_5, $lang); ?>
             @if(sizeof($arrNews) > 0)
            <div class="col-lg-6 col-sm-6">
               <div class="category">
                  <div class="title-category">
                     <a title="{{$cat['category_name']}}" href="{{FunctionLib::buildLinkCategory($cat['category_id'], $cat['category_name'])}}"></i>{{$cat['category_name']}}</a>
                  </div>
                  @foreach($arrNews as $k=>$item)
           		  @if($k==0)
                  <div class="item-fist-post">
                     <div class="clearfix">
                        <a class="pull-left thumb" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
                        	@if($item['news_image'] != '')
								<img alt="{{$item['news_title']}}"
									src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'], $item['news_image'], CGlobal::sizeImage_500)}}">
							@endif
                        </a>
                        <div class="title-post"><a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">{{$item['news_title']}}</a></div>
                        <div class="date"><i class="icon-other icon-date"></i>{{date('h:i', $item['news_create'])}} {{Langs::getItemByKeywordLang('text_date', $lang)}} {{date('d/m/Y', $item['news_create'])}}</div>
                     </div>
                     <div class="post-lead">
                        @if($item['news_intro'] != '')
							{{FunctionLib::substring($item['news_intro'], 150, '...') }}
						@else
							{{FunctionLib::substring($item['news_content'], 150, '...') }}
						@endif			
                     </div>
                  </div>
                  @endif
                  @endforeach
                  <div class="list-link-category">
                     <ul>
                        @foreach($arrNews as $k=>$item)
            	   		@if($k>0)
                        <li><a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">{{$item['news_title']}}</a></li>
                     	@endif
                  		@endforeach
                     </ul>
                  </div>
               </div>
            </div>
             @endif
             @endif
			@endforeach
			@endif
         </div>
      </div>
   </div>
</div>