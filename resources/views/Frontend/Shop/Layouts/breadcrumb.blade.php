<!--breadcrumb-->
<div class="uk-section-xsmall uk-overflow-auto breadcrumb__section" uk-sticky="offset: 56;media:(max-width: 959px)">
    <div class="uk-container uk-padding-remove">
        <ul class="uk-breadcrumb uk-flex uk-flex-nowrap">
            @foreach($arrPageBreadCrumb as $k=>$page)
                @if($page['url'] != '')
                    <li><a href="{{$page['url']}}" title="{{$page['page_name']}}">{{$page['page_name']}}</a></li>
                @else
                    <li><span>{{$page['page_name']}}</span></li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
<!--/breadcrumb-->
