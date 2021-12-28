<div class="home__section" uk-height-viewport="offset-top: true;offset-bottom: true">
    <div class="uk-container uk-padding-remove">
        <div class="uk-grid-30-m uk-grid-match" uk-grid>
            <div class="uk-width-1-4@m uk-visible@m">
                <div class="uk-card uk-card-default uk-padding-small home__danhmuc">
                    <h3 class="uk-h3 home__danhmuc__title">Danh mục</h3>
                    <ul class="home__nav uk-nav uk-nav-default">
                        <?php
                        $dataIconsMenu = array(
                            0 => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-1.png',
                            1 => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-2.png',
                            2 => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-3.png',
                            3 => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-4.png',
                            4 => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-5.png',
                            5 => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-11.png',
                            6 => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-11.png',
                            7 => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-11.png',
                        );
                        ?>
                        @if(!empty($arrCategoryProduct))
                            @foreach ($arrCategoryProduct as $keyP => $catePr)
                            <?php
                                $iconMenu = isset($dataIconsMenu[$keyP]) ? $dataIconsMenu[$keyP]: Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-11.png';
                            ?>
                            <li class="home__nav__li <?= ($keyP==0)?'uk-active':'' ?>">
                                <a href="{{buildLinkProductWithCategory($catePr->id,$catePr->category_name)}}" class="home__nav__a">
                                    <img class="home__nav__img uk-position-center-left" src="{{$iconMenu}}" alt="">
                                    <span class="home__nav__txt">{{$catePr->category_name}}</span>
                                </a>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="uk-width-expand">
                <div class="uk-grid-24 uk-grid-25-m uk-flex-middle" uk-grid>

                    <div class="uk-width-expand">
                        <div class="home__slider uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="autoplay: true">
                            @if(!empty($arrBannerBig))
                            <ul class="uk-slideshow-items">
                                @foreach ($arrBannerBig as $keyB => $bannerBig)
                                    <li>
                                        <a href="{{$bannerBig->banner_link}}" @if($bannerBig->banner_is_target == STATUS_INT_MOT) target="_blank" @endif>
                                            <img src="{{getLinkImageShow(FOLDER_BANNER.'/'.$bannerBig->id,$bannerBig->banner_image)}}" alt="{{$bannerBig->banner_name}}" uk-cover>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <a class="home__slider__nav home__slider__nav--prev uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
                            <a class="home__slider__nav home__slider__nav--next uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
                            @endif
                        </div>
                    </div>

                    <div class="uk-width-auto@m home__banner__width">
                        <div class="home__banner__grid uk-child-width-auto uk-grid-small uk-grid-24-m" uk-grid uk-toggle="cls: uk-flex-nowrap; mode: media; media: (max-width: 959.8px)">
                            @if(!empty($arrBannerSmall))
                                @foreach ($arrBannerSmall as $keyS => $bannerSmall)
                                <div class="uk-width-1-1@m home__banner__column">
                                    <div class="home__banner__card uk-cover-container">
                                        <img src="{{getLinkImageShow(FOLDER_BANNER.'/'.$bannerSmall->id,$bannerSmall->banner_image)}}" alt="" uk-cover>
                                        <canvas width="380" height="190"></canvas>
                                        <a href="{{$bannerSmall->banner_link}}" @if($bannerSmall->banner_is_target == STATUS_INT_MOT) target="_blank" @endif class="uk-position-cover"></a>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

