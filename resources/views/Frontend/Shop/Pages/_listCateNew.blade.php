<div class="uk-width-1-4@m">
    <div class="uk-card tintuc__asideCard">
        <div class="tintuc__asideCard__item">
            <div class="uk-position-relative tintuc__asideCard__search">
                <input class="uk-input tintuc__asideCard__search__input" type="text" placeholder="Tìm kiếm">
                <button type="button" class="tintuc__asideCard__search__btn uk-button uk-button-default uk-position-right"></button>
            </div>
        </div>
        <div class="tintuc__asideCard__item">
            <ul class="uk-nav uk-nav-default tintuc__asideCard__nav">
                @foreach($arrCategoryNews as $kyc=>$catNew)
                    <li @if(isset($cat_id) && $cat_id == $catNew->id)class="uk-active"@endif>
                        <a href="{{buildLinkNewsWithCategory($catNew->id,$catNew->category_name)}}" title="{{$catNew->category_name}}">{{$catNew->category_name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
