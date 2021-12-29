<div>
    <div class="uk-cover-container">
        <img src="{{getLinkImageShow(FOLDER_BANNER.'/'.$banner->id,$banner->banner_image)}}" alt="{{$banner->banner_name}}" uk-cover>
        <canvas width="600" height="300"></canvas>
        <a href="{{$banner->banner_link}}" title="{{$banner->banner_name}}" @if($banner->banner_is_target == STATUS_INT_MOT) target="_blank" @endif class="uk-position-cover"></a>
    </div>
</div>

