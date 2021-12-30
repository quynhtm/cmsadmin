<div>
    <div class="uk-cover-container home__tintuc__coverContainer">
        <a href="{{buildLinkDetailNew($new->id,$new->news_title,$new->news_category)}}">
            <img src="{{getLinkImageShow(FOLDER_NEWS.'/'.$new->id,$new->news_image)}}" alt="{{$new->news_title}}" uk-cover>
        </a>
        <canvas width="600" height="338"></canvas>
    </div>
    <h4 class="uk-h4 home__tintuc__title"><a href="{{buildLinkDetailNew($new->id,$new->news_title,$new->news_category)}}">{{$new->news_title}}</a></h4>
    <div class="home__tintuc__date">{{getDateShow($new->created_at)}}</div>
</div>
