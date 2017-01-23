<div class="main-view contact">
   <div class="main-content-view">
      <div class="link-breadcrumb">
         <a href="{{URL::route('site.home')}}" title="{{Langs::getItemByKeywordLang('text_home', $lang)}}">{{Langs::getItemByKeywordLang('text_home', $lang)}}</a> › 
         <a href="{{URL::route('site.pageContact')}}" title="{{Langs::getItemByKeywordLang('text_contact', $lang)}}">{{Langs::getItemByKeywordLang('text_contact', $lang)}}</a>
      </div>
      <h1 class="title-news"><a href="{{URL::route('site.pageContact')}}" title="{{Langs::getItemByKeywordLang('text_contact', $lang)}}">{{Langs::getItemByKeywordLang('text_contact', $lang)}}</a></h1>
      <div class="line-intro-other-view">
      	{{Langs::getItemByKeywordLang('text_intro_contact', $lang)}}
      </div>
      <ul class="tab-address">
         <li data="office">{{Langs::getItemByKeywordLang('text_office', $lang)}}</li>
      </ul>
      <div class="list-tab-address">
         <div class="address office act">
            {{$infoContact}}
         </div>
      </div>
   </div>
</div>