<div class="home__item40">
    <div class="uk-container uk-padding-remove">
        <div class="uk-grid-30-m uk-grid-match" uk-grid>
            <div class="uk-width-1-4@m uk-visible@m">
                <div class="uk-card uk-card-default uk-padding-small home__danhmuc">
                    <h3 class="uk-h3 home__danhmuc__title">Danh mục</h3>

                </div>
            </div>
            <div class="uk-width-expand">
                <div class="uk-grid-24 uk-grid-25-m uk-flex-middle" uk-grid>
                    <div class="uk-width-expand">
                        <div class="home__slider uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="autoplay: true">

                            <ul class="uk-slideshow-items">
                                <li>
                                    <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/slider1.jpg" alt="" uk-cover>
                                </li>
                                <li>
                                    <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/slider2.jpg" alt="" uk-cover>
                                </li>
                                <li>
                                    <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/light.jpg" alt="" uk-cover>
                                </li>
                            </ul>

                            <a class="home__slider__nav home__slider__nav--prev uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
                            <a class="home__slider__nav home__slider__nav--next uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

                        </div>
                    </div>
                    <div class="uk-width-auto@m home__banner__width">
                        <div class="home__banner__grid uk-child-width-auto uk-grid-small uk-grid-24-m" uk-grid uk-toggle="cls: uk-flex-nowrap; mode: media; media: (max-width: 959.8px)">
                            <?php
                            $data = array(
                                Config::get('config.WEB_ROOT').'assets/frontend/shop/images/banner1.jpg',
                                Config::get('config.WEB_ROOT').'assets/frontend/shop/images/banner2.jpg',
                                Config::get('config.WEB_ROOT').'assets/frontend/shop/images/banner3.jpg',
                            );
                            foreach ($data as $k=>$v): ?>
                            <div class="uk-width-1-1@m home__banner__column">
                                <div class="home__banner__card uk-cover-container">
                                    <img src="<?= $v ?>" alt="" uk-cover>
                                    <canvas width="380" height="190"></canvas>
                                    <a href="" class="uk-position-cover"></a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

