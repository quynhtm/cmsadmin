<?php $data["title"] = "Danh sách sản phẩm"; ?>
<?php require "template-parts/layouts/header.php"; ?>
<?php
$databreadcrumb = array(
    array(
        'txt' => 'Trang chủ',
        'link' => '.',
    ),
    array(
        'txt' => 'Danh mục 1',
        'link' => '',
    ),
);
require "template-parts/layouts/breadcrumb.php";
?>
<div class="catalog__section" uk-height-viewport="offset-top: true;offset-bottom: true">
    <div class="uk-container">
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
        <div class="home__item40">
            <div class="uk-grid-small uk-grid-30-m" uk-grid>
                <div class="uk-width-1-4@m uk-visible@m">
                    <div class="uk-card uk-card-body catalog__card">
                        <?php require "template-parts/layouts/boloc.php"; ?>
                    </div>
                </div>
                <div class="uk-width-expand">
                    <div class="uk-flex-middle uk-grid-small catalog__grid" uk-grid>
                        <div class="uk-width-expand">
                            <div class="catalog__txtSearch">Hiển thị 5/10 kết quả</div>
                        </div>
                        <div class="uk-width-auto">
                            <div class="" uk-form-custom="target: > * > span:first-child">
                                <select>
                                    <option value="">Sắp xếp</option>
                                    <option value="1">Ông (Mr.)</option>
                                    <option value="2">Bà (Mrs.)</option>
                                </select>
                                <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                    <span></span>
                                    <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                </button>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-hidden@m">
                            <div class="boloc__btnFillter" uk-toggle="target: #offcanvas-flip-boloc"></div>
                        </div>
                    </div>
                    <div class="uk-child-width-1-2 uk-grid-match uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-4@l uk-grid-small uk-grid-30-m" uk-grid>
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
                        <div class="home__product__column uk-width-1-1">
                            <ul class="uk-pagination uk-flex-center pagination" uk-margin>
                                <li><a href="#"><span uk-pagination-previous></span></a></li>
                                <li><a href="#">1</a></li>
                                <li class="uk-disabled"><span>...</span></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">6</a></li>
                                <li class="uk-active"><span>7</span></li>
                                <li><a href="#">8</a></li>
                                <li><a href="#"><span uk-pagination-next></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="offcanvas-flip-boloc" uk-offcanvas="flip: true; overlay: true">
    <div class="uk-offcanvas-bar">
        <button class="uk-offcanvas-close header__bottom__close header__bottom__close--text" type="button" uk-close></button>
        <?php require "template-parts/layouts/boloc.php"; ?>
    </div>
</div>
<?php require "template-parts/layouts/footer.php"; ?>