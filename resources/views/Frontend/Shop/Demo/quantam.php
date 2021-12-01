<?php $data["title"] = "Quan tâm"; ?>
<?php require "template-parts/layouts/header.php"; ?>
<?php
$databreadcrumb = array(
    array(
        'txt' => 'Trang chủ',
        'link' => '.',
    ),
    array(
        'txt' => 'Quan tâm',
        'link' => '',
    ),
);
require "template-parts/layouts/breadcrumb.php";
?>
<div class="quantam__section" uk-height-viewport="offset-top: true;offset-bottom: true">
    <div class="uk-container">
        <h1 class="uk-h1 quantam__title">Quan tâm</h1>
        <div class="uk-grid-30-m uk-grid-24" uk-grid>
            <div class="uk-width-expand">
                <div class="uk-card uk-card-body quantam__card uk-table-responsive">
                    <table class="uk-table uk-table-divider uk-table-middle uk-table-hover quantam__table">
                        <thead>
                        <tr>
                            <th class="uk-table-expand">Sản phẩm</th>
                            <th class="uk-table-shrink">Đơn giá</th>
                            <th class="uk-width-small"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data as $k=>$v):
                        $stock = rand(true,false);
                        $isPrice = rand(true,false);
                        $price = array('27.000đ','49.000đ','310.000đ','17.500đ','250.000đ','320.000đ','19.000đ','32.000đ');
                        $percent = array(20,40,60,80,100);
                        $label = array('new','hot','sale','notSale');
                        $txt = array('Bottle','30ml');
                        ?>
                        <tr>
                            <td>
                                <div class="uk-flex-middle uk-grid-small uk-grid-24-m" uk-grid>
                                    <div class="uk-width-auto">
                                        <a href="" class="quantam__table__close"></a>
                                    </div>
                                    <div class="uk-width-expand">
                                        <div class="uk-grid-small uk-grid-20-m uk-flex-middle" uk-grid>
                                            <div class="uk-width-auto">
                                                <div class="uk-cover-container quantam__table__cover">
                                                    <div class="uk-position-cover">
                                                        <img class="uk-responsive-height uk-responsive-width" src="<?= $v['src'] ?>" alt="">
                                                    </div>
                                                    <canvas width="80" height="80"></canvas>
                                                </div>
                                            </div>
                                            <div class="uk-width-expand">
                                                <h4 class="uk-h4 quantam__table__title"><a href=""><?= $v['title'] ?></a></h4>
                                                <div class="quantam__table__price"><?= $txt[array_rand($txt)] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="quantam__table__price"><?= $price[array_rand($price)] ?></span></td>
                            <td>
                                <button type="button" class="modal__quickView__addCart uk-button uk-button-default uk-border-rounded"><span>Thêm giỏ hàng</span></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a href="" class="quantam__btnBack uk-button uk-button-default"><span>Tiếp tục mua hàng</span></a>
            </div>
            <div class="uk-width-1-3@m">
                <div class="home__header">
                    <div class="uk-flex-middle uk-grid-24-m" uk-grid>
                        <div class="uk-width-auto">
                            <h3 class="uk-h3 home__header__title">Nổi bật</h3>
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
        </div>
    </div>
</div>
<?php require "template-parts/layouts/footer.php"; ?>