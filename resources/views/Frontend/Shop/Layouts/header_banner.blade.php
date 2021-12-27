<div class="home__section" uk-height-viewport="offset-top: true;offset-bottom: true">
    <div class="uk-container uk-padding-remove">
        <div class="uk-grid-30-m uk-grid-match" uk-grid>
            <div class="uk-width-1-4@m uk-visible@m">
                <div class="uk-card uk-card-default uk-padding-small home__danhmuc">
                    <h3 class="uk-h3 home__danhmuc__title">Danh mục</h3>
                    <ul class="home__nav uk-nav uk-nav-default">
                        <?php
                        $dataMenu = array(
                            array(
                                'txt' => 'Danh mục 1',
                                'icon' => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-1.png',
                            ),
                            array(
                                'txt' => 'Danh mục 2',
                                'icon' => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-2.png',
                            ),
                            array(
                                'txt' => 'Danh mục 3',
                                'icon' => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-3.png',
                            ),
                            array(
                                'txt' => 'Danh mục 4',
                                'icon' => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-4.png',
                            ),
                            array(
                                'txt' => 'Danh mục 5',
                                'icon' => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-5.png',
                            ),
                            array(
                                'txt' => 'Danh mục 6',
                                'icon' => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-5.png',
                            ),
                            array(
                                'txt' => 'Danh mục 7',
                                'icon' => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-5.png',
                            ),
                            array(
                                'txt' => 'Danh mục 8',
                                'icon' => Config::get('config.WEB_ROOT').'assets/frontend/shop/images/menu/verticalmenu-icon-11.png',
                            ),
                        );
                        foreach ($dataMenu as $k=>$v): ?>
                        <li class="home__nav__li <?= ($k==0)?'uk-active':'' ?>">
                            <a href="#" class="home__nav__a">
                                <img class="home__nav__img uk-position-center-left" src="<?= $v['icon'] ?>" alt="">
                                <span class="home__nav__txt"><?= $v['txt'] ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
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

