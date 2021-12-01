<?php $data["title"] = "Trang chủ"; ?>
<?php require "template-parts/layouts/header.php"; ?>

<div class="home__section" uk-height-viewport="offset-top: true;offset-bottom: true">
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
                                        <img src="images/slider1.jpg" alt="" uk-cover>
                                    </li>
                                    <li>
                                        <img src="images/slider2.jpg" alt="" uk-cover>
                                    </li>
                                    <li>
                                        <img src="images/light.jpg" alt="" uk-cover>
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
                                    'images/banner1.jpg',
                                    'images/banner2.jpg',
                                    'images/banner3.jpg',
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

    <div class="home__item40">
        <div class="uk-container">
            <!--Nổi bật-->
            <div class="home__item40">
                <div class="home__header home__header--switch">
                    <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                        <div class="uk-width-auto">
                            <h3 class="uk-h3 home__header__title">Nổi bật</h3>
                        </div>
                        <div class="uk-width-expand">
                            <div class="uk-child-width-auto uk-flex-middle uk-flex-right uk-flex-between@m" uk-grid>
                                <div>
                                    <a href="" class="home__header__link uk-button uk-button-default uk-border-pill"><span>Xem tất cả</span></a>
                                </div>
                                <div class="uk-visible@m">
                                    <ul class="uk-subnav uk-subnav-pill home__header__switch uk-grid-16" uk-grid uk-switcher="connect: .switcher-container">
                                        <li><a href="#">Hãng A</a></li>
                                        <li><a href="#">Hãng B</a></li>
                                        <li><a href="#">Hãng C</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-hidden@m home__header__mbSwitch">
                    <ul class="uk-subnav uk-subnav-pill home__header__switch uk-grid-16" uk-grid uk-switcher="connect: .switcher-container">
                        <li><a href="#">Hãng A</a></li>
                        <li><a href="#">Hãng B</a></li>
                        <li><a href="#">Hãng C</a></li>
                    </ul>
                </div>
                <div class="uk-child-width-1-2 uk-grid-match uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-5@l uk-grid-small uk-grid-30-m" uk-grid>
                    <?php
                    $data = array(
                        array(
                            'src' => 'images/spnoibat/img1.png',
                            'title' => 'Solgar ESTER 250 PLUS Kapsul 500MG A50',
                        ),
                        array(
                            'src' => 'images/spnoibat/img2.png',
                            'title' => 'Hand Creams for Dry, Sensitive Skin',
                        ),
                        array(
                            'src' => 'images/spnoibat/img3.png',
                            'title' => 'EllaOne Film-Coated tablet Contraception',
                        ),
                        array(
                            'src' => 'images/spnoibat/img4.png',
                            'title' => 'Ibuprofen 150mg Capsule',
                        ),
                        array(
                            'src' => 'images/spnoibat/img5.png',
                            'title' => 'Bioderma Atoderm Intensive Gel 250ml',
                        ),
                        array(
                            'src' => 'images/spnoibat/img6.png',
                            'title' => 'Ibuprofen 250mg capsules x18',
                        ),
                        array(
                            'src' => 'images/spnoibat/img7.png',
                            'title' => 'VICHY LIFTACTIV Supreme Serum 10 30ML',
                        ),
                        array(
                            'src' => 'images/spnoibat/img8.png',
                            'title' => 'Ibuprofen 500mg Capsule',
                        ),
                        array(
                            'src' => 'images/spnoibat/img9.png',
                            'title' => 'Film-coated tablet 250 mg 30 pieces',
                        ),
                        array(
                            'src' => 'images/spnoibat/img10.png',
                            'title' => 'Cetirizine 25mg Film-coated Tablets',
                        ),
                    );
                    shuffle($data);
                    foreach ($data as $k=>$v):
                    $stock = rand(true,false);
                    $isPrice = rand(true,false);
                    $price = array('27.000đ','49.000đ','310.000đ','17.500đ','250.000đ','320.000đ','19.000đ','32.000đ');
                    $percent = array(20,40,60,80,100);
                    $label = array('new','hot','sale','notSale');
                    ?>
                    <div class="home__product__column">
                        <div class="uk-card home__product__card uk-transition-toggle">
                            <div class="uk-grid-match uk-grid-collapse uk-height-1-1 uk-flex-column" uk-grid>
                                <div class="uk-width-1-1">
                                    <div class="uk-cover-container home__product__card__cover">
                                        <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                            <img class="uk-responsive-height uk-responsive-width" src="<?= $v['src'] ?>" alt="">
                                        </div>
                                        <canvas width="468" height="360"></canvas>
                                        <?php if ($stock): ?>
                                        <div class="uk-transition-fade uk-position-cover home__product__card__stock uk-flex uk-flex-middle uk-flex-center">
                                            <div>
                                                <a href="#modal-quickView" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>
                                                <a href="" class="home__product__card__stock__icon home__product__card__stock__icon--cart uk-border-circle"></a>
                                                <a href="#modal-wishList" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--wishList uk-border-circle"></a>
                                            </div>
                                        </div>

                                        <?php
                                        $x = $label[array_rand($label)];
                                        switch ($x){
                                            case 'new': ?>
                                            <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-success">Mới</span>
                                            <?php break; ?>

                                            <?php case 'hot': ?>
                                            <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-warning">Hot</span>
                                            <?php break; ?>

                                            <?php case 'sale': ?>
                                            <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-danger">-10%</span>
                                            <?php break; ?>

                                            <?php default: ?>

                                        <?php } ?>


                                        <?php else: ?>
                                        <div class="uk-position-cover home__product__card__outStock uk-flex uk-flex-middle uk-flex-center">
                                            <div class="home__product__card__outStock__label uk-border-pill"><span>Hết hàng</span></div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="uk-width-1-1 uk-flex-auto uk-padding-small">
                                    <div class="uk-grid-match uk-grid-12 uk-flex-column" uk-grid>
                                        <div class="uk-width-1-1 uk-flex-auto">
                                            <div>
                                                <div class="uk-text-center">
                                                    <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                        <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                        <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                        <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                        <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                        <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                        <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: <?= $percent[array_rand($percent)] ?>%">
                                                            <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                            <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                            <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                            <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                            <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h3 class="uk-h3 home__product__card__title"><a href=""><?= $v['title'] ?></a></h3>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <?php if ($isPrice): ?>
                                                <div class="home__product__card__price"><?= $price[array_rand($price)] ?></div>
                                            <?php else: ?>
                                                <div class="home__product__card__contact">Liên hệ</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!--/Nổi bật-->

            <!--banner-->
            <div class="home__item40">
                <div class="uk-child-width-1-4@m uk-grid-small uk-grid-30-m" uk-grid>
                    <div>
                        <div class="uk-cover-container">
                            <img src="images/baner1.jpg" alt="" uk-cover>
                            <canvas width="600" height="300"></canvas>
                            <a href="" class="uk-position-cover"></a>
                        </div>
                    </div>
                    <div class="uk-visible@m">
                        <div class="uk-cover-container">
                            <img src="images/baner2.jpg" alt="" uk-cover>
                            <canvas width="600" height="300"></canvas>
                            <a href="" class="uk-position-cover"></a>
                        </div>
                    </div>
                    <div class="uk-visible@m">
                        <div class="uk-cover-container">
                            <img src="images/baner3.jpg" alt="" uk-cover>
                            <canvas width="600" height="300"></canvas>
                            <a href="" class="uk-position-cover"></a>
                        </div>
                    </div>
                    <div class="uk-visible@m">
                        <div class="uk-cover-container">
                            <img src="images/baner4.jpg" alt="" uk-cover>
                            <canvas width="600" height="300"></canvas>
                            <a href="" class="uk-position-cover"></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--/banner-->

            <!--bán chạy, mới,khác-->
            <div class="home__item40">
                <div class="uk-child-width-1-3@m uk-grid-40 uk-grid-30-m" uk-grid>
                    <?php
                    $itemName = array('Bán chạy','Mới','Khác');
                    foreach ($itemName as $item): ?>
                    <div>
                        <div class="home__header">
                            <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                                <div class="uk-width-auto">
                                    <h3 class="uk-h3 home__header__title"><?= $item ?></h3>
                                </div>
                                <div class="uk-width-expand">

                                </div>
                            </div>
                        </div>
                        <div uk-slider>

                            <div class="uk-position-relative">

                                <div class="uk-slider-container">
                                    <ul class="uk-slider-items uk-child-width-1-1">
                                        <?php
                                        shuffle($data);
                                        for ($i=0;$i<=3;$i++): ?>
                                        <li>
                                            <div class="uk-grid-16" uk-grid>
                                                <?php
                                                shuffle($data);
                                                foreach ($data as $k=>$v):
                                                $stock = rand(true,false);
                                                $isPrice = rand(true,false);
                                                $price = array('27.000đ','49.000đ','310.000đ','17.500đ','250.000đ','320.000đ','19.000đ','32.000đ');
                                                $percent = array(20,40,60,80,100);
                                                $label = array('new','hot','sale','notSale');
                                                ?>
                                                <?php if ($k<=2): ?>
                                                    <div class="uk-width-1-1">
                                                        <div class="uk-card home__product1__card uk-transition-toggle">
                                                            <div class="uk-grid-collapse uk-grid-match" uk-grid>
                                                                <div class="uk-width-2-5" style="width: 46.34%">
                                                                    <div class="uk-cover-container">
                                                                        <div class="uk-position-cover uk-flex uk-flex-middle uk-flex-center">
                                                                            <img class="uk-responsive-width uk-responsive-height" src="<?= $v['src'] ?>" alt="">
                                                                        </div>
                                                                        <canvas width="190" height="146"></canvas>
                                                                        <?php if ($stock): ?>
                                                                            <div class="uk-transition-fade uk-position-cover home__product__card__stock uk-flex uk-flex-middle uk-flex-center">
                                                                                <div>
                                                                                    <a href="#modal-quickView" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--quick uk-border-circle"></a>
                                                                                    <a href="" class="home__product__card__stock__icon home__product__card__stock__icon--cart uk-border-circle"></a>
                                                                                    <a href="#modal-wishList" uk-toggle class="home__product__card__stock__icon home__product__card__stock__icon--wishList uk-border-circle"></a>
                                                                                </div>
                                                                            </div>

                                                                            <?php
                                                                            $x = $label[array_rand($label)];
                                                                            switch ($x){
                                                                                case 'new': ?>
                                                                                    <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-success">Mới</span>
                                                                                    <?php break; ?>

                                                                                <?php case 'hot': ?>
                                                                                <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-warning">Hot</span>
                                                                                <?php break; ?>

                                                                            <?php case 'sale': ?>
                                                                                <span class="home__product__card__label uk-border-pill uk-position-top-left uk-label uk-label-danger">-10%</span>
                                                                                <?php break; ?>

                                                                            <?php default: ?>

                                                                            <?php } ?>


                                                                        <?php else: ?>
                                                                            <div class="uk-position-cover home__product__card__outStock uk-flex uk-flex-middle uk-flex-center">
                                                                                <div class="home__product__card__outStock__label uk-border-pill"><span>Hết hàng</span></div>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="uk-width-expand">
                                                                    <div class="uk-card-body home__product1__card__body uk-padding-small">
                                                                        <div class="uk-grid-match uk-grid-12 uk-flex-column uk-height-1-1" uk-grid>
                                                                            <div class="uk-width-1-1 uk-flex-auto">
                                                                                <div>
                                                                                    <div class="uk-text-left">
                                                                                        <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                                                                            <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                            <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                            <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                            <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                            <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                                                                            <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: <?= $percent[array_rand($percent)] ?>%">
                                                                                                <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                                <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                                <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                                <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                                <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <h3 class="uk-h3 home__product__card__title"><a href=""><?= $v['title'] ?></a></h3>
                                                                                </div>
                                                                            </div>
                                                                            <div class="uk-width-1-1">
                                                                                <?php if ($isPrice): ?>
                                                                                    <div class="home__product__card__price"><?= $price[array_rand($price)] ?></div>
                                                                                <?php else: ?>
                                                                                    <div class="home__product__card__contact">Liên hệ</div>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>

                                <div class="uk-position-top-right home__product1__position">
                                    <a class="home__product1__nav home__product1__nav--prev" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                                    <a class="home__product1__nav home__product1__nav--next" href="#" uk-slidenav-next uk-slider-item="next"></a>
                                </div>

                            </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!--/bán chạy, mới,khác-->

            <!--Bạn đang cần tư vấn ?-->
            <div class="home__item40">
                <div class="uk-card home__tuvan__card uk-card-body uk-background-norepeat uk-background-center-center uk-background-cover" data-src="images/bg_tuvan.jpg" uk-img>
                    <div class="uk-grid-16 uk-grid-30-m" uk-grid>
                        <div class="uk-width-2-5@m">
                            <h3 class="uk-h3 home__tuvan__title">Bạn đang cần tư vấn ?</h3>
                            <p class="home__tuvan__desc">Hãy để lại thông tin và đội ngũ CSKH của chúng tôi sẽ liên lạc để hỗ trợ, tư vấn quý khác 1 cách nhiệt tình nhất</p>
                        </div>
                        <div class="uk-width-expand">
                            <form class="uk-grid-16 uk-grid-30-m" uk-grid>
                                <div class="uk-width-1-2 home__tuvan__column">
                                    <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                        <select>
                                            <option value="">Danh xưng</option>
                                            <option value="1">Ông (Mr.)</option>
                                            <option value="2">Bà (Mrs.)</option>
                                        </select>
                                        <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                            <span></span>
                                            <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="uk-width-1-2 home__tuvan__column">
                                    <input class="uk-input modal__wishList__form__input" type="text" placeholder="Họ tên *">
                                </div>
                                <div class="uk-width-1-2 home__tuvan__column">
                                    <input class="uk-input modal__wishList__form__input" type="text" placeholder="Số điện thoại *">
                                </div>
                                <div class="uk-width-1-2 home__tuvan__column">
                                    <input class="uk-input modal__wishList__form__input" type="text" placeholder="Email">
                                </div>
                                <div class="uk-width-1-1 home__tuvan__column">
                                    <textarea class="uk-textarea modal__wishList__form__input" rows="5" placeholder="Lời nhắn *"></textarea>
                                </div>
                                <div class="uk-width-1-2@s home__tuvan__column">
                                    <button onclick="wishListNotification()" type="button" class="uk-button uk-button-default modal__wishList__form__btnSend"><span>Gửi</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Bạn đang cần tư vấn ?-->

            <!--Tin tức-->
            <div class="home__item40">
                <div class="home__header">
                    <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                        <div class="uk-width-expand">
                            <h3 class="uk-h3 home__header__title">Tin tức</h3>
                        </div>
                        <div class="uk-width-auto">
                            <a href="" class="home__header__link uk-button uk-button-default uk-border-pill"><span>Xem tất cả</span></a>
                        </div>
                    </div>
                </div>
                <div class="uk-child-width-1-2 uk-child-width-1-4@m uk-grid-16 uk-grid-30-m" uk-grid>
                    <?php
                    $dataNews = array(
                        array(
                            'src' => 'images/news1.png',
                            'txt' => 'Tầm soát ung thư - Giải pháp bảo vệ sức khoẻ toàn diện',
                        ),
                        array(
                            'src' => 'images/news2.png',
                            'txt' => 'Dạy con cách tự bảo vệ bản thân trước những nguy hiểm',
                        ),
                        array(
                            'src' => 'images/news3.png',
                            'txt' => 'Sản phẩm bảo hiểm tốt nhất cho gia đình hiện nay',
                        ),
                        array(
                            'src' => 'images/news4.png',
                            'txt' => 'Khám sức khỏe định kỳ - Giải pháp chăm sóc sức khỏe toàn diện',
                        ),
                    );
                    shuffle($dataNews);
                    foreach ($dataNews as $k=>$v): ?>
                    <div>
                        <div class="uk-cover-container home__tintuc__coverContainer">
                            <img src="<?= $v['src'] ?>" alt="" uk-cover>
                            <canvas width="600" height="338"></canvas>
                        </div>
                        <h4 class="uk-h4 home__tintuc__title"><a href=""><?= $v['txt'] ?></a></h4>
                        <div class="home__tintuc__date">Thứ 2 ,08/07/2019</div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!--/Tin tức-->

            <!--Thông tin y dược-->
            <div class="home__item40">
                <div class="home__header">
                    <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                        <div class="uk-width-expand">
                            <h3 class="uk-h3 home__header__title">Thông tin y dược</h3>
                        </div>
                        <div class="uk-width-auto">
                            <a href="" class="home__header__link uk-button uk-button-default uk-border-pill"><span>Xem tất cả</span></a>
                        </div>
                    </div>
                </div>
                <div class="uk-child-width-1-2 uk-child-width-1-4@m uk-grid-16 uk-grid-30-m" uk-grid>
                    <?php
                    $dataNews = array(
                        array(
                            'src' => 'images/info1.png',
                            'txt' => 'Tầm soát ung thư - Giải pháp bảo vệ sức khoẻ toàn diện',
                        ),
                        array(
                            'src' => 'images/info2.png',
                            'txt' => 'Dạy con cách tự bảo vệ bản thân trước những nguy hiểm',
                        ),
                        array(
                            'src' => 'images/info3.png',
                            'txt' => 'Sản phẩm bảo hiểm tốt nhất cho gia đình hiện nay',
                        ),
                        array(
                            'src' => 'images/info4.png',
                            'txt' => 'Khám sức khỏe định kỳ - Giải pháp chăm sóc sức khỏe toàn diện',
                        ),
                    );
                    shuffle($dataNews);
                    foreach ($dataNews as $k=>$v): ?>
                        <div>
                            <div class="uk-cover-container home__tintuc__coverContainer">
                                <img src="<?= $v['src'] ?>" alt="" uk-cover>
                                <canvas width="600" height="338"></canvas>
                            </div>
                            <h4 class="uk-h4 home__tintuc__title"><a href=""><?= $v['txt'] ?></a></h4>
                            <div class="home__tintuc__date">Thứ 2 ,08/07/2019</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!--/Thông tin y dược-->
        </div>
    </div>
</div>

<?php require "template-parts/layouts/footer.php"; ?>
