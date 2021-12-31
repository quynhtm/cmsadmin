<h3 class="uk-h3 catalog__card__title">Bộ lọc</h3>
<div class="uk-margin-remove-top uk-grid-10 uk-child-width-1-1 uk-grid" uk-grid>
    @if(isset($arrProductCate) && !empty($arrProductCate))
        @foreach($arrProductCate as $keypc => $proCate)
            <label>
                <input class="uk-checkbox" type="checkbox" checked value="{{$proCate->id}}"> <span class="catalog__card__txt">{{$proCate->category_name}}</span>
            </label>
        @endforeach
    @endif
</div>
