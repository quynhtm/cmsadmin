<?php $data["title"] = "Liên hệ"; ?>
<?php require "template-parts/layouts/header.php"; ?>
<?php
$databreadcrumb = array(
    array(
        'txt' => 'Trang chủ',
        'link' => '.',
    ),
    array(
        'txt' => 'Liên hệ',
        'link' => '',
    ),
);
require "template-parts/layouts/breadcrumb.php";
?>
<div class="uk-position-relative uk-background-center-center uk-background-norepeat uk-background-cover" data-src="images/Customer-service1.jpg" uk-img>
    <div class="uk-position-cover lienhe__section1__overlay"></div>
    <div class="uk-section-small lienhe__section1">
        <div class="uk-container">
            <h1 class="uk-h1 lienhe__section1__title">Liên hệ với chúng tôi</h1>
        </div>
    </div>
</div>
<div class="lienhe__section2 uk-background-center-center uk-background-norepeat uk-background-cover" data-src="images/bg_lienheMaskGroup.png" uk-img>
    <div class="uk-container">
        <div class="lienhe__section2__card uk-card uk-card-body">
            <div class="uk-grid-24 uk-grid-30-m uk-child-width-1-2@m uk-grid-match" uk-grid>
                <div>
                    <div class="lienhe__section2__card1 uk-card uk-card-body">
                        <div class="lienhe__section2__item">
                            <div class="lienhe__section2__item__title">Pharmacy City Center</div>
                            <ul class="uk-list uk-list-bullet lienhe__section2__item__list">
                                <li>Thứ 2 đến Chủ nhật (8h-18h)</li>
                                <li>45 Hudson Street Villa Rica, GA 30180</li>
                            </ul>
                        </div>
                        <div class="lienhe__section2__item">
                            <div class="lienhe__section2__item__title">Pharmacy Old Town</div>
                            <ul class="uk-list uk-list-bullet lienhe__section2__item__list">
                                <li>Thứ 2 đến Chủ nhật (8h-18h)</li>
                                <li>95 East Baker Street Union City, NJ 07087</li>
                            </ul>
                        </div>
                        <div class="lienhe__section2__item">
                            <div class="lienhe__section2__item__title">E-mail</div>
                            <div class="lienhe__section2__item__txt">customercare@pharmacy.com</div>
                        </div>
                        <div class="lienhe__section2__item">
                            <div class="lienhe__section2__item__title">Số điện thoại</div>
                            <div class="lienhe__section2__item__txt">+(84) 534-2319</div>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="lienhe__section2__card__desc">Hãy để lại thông tin và đội ngũ CSKH của chúng tôi sẽ liên lạc để hỗ trợ, tư vấn quý khách 1 cách nhiệt tình nhất</p>
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
</div>
<div class="lienhe__section3">
    <div class="uk-container uk-container-expand-right uk-padding-remove">
        <div class="uk-grid-24 uk-grid-30-m uk-flex-middle uk-grid-match" uk-grid>
            <div class="uk-width-expand uk-flex-last@m">
                <div class="uk-cover-container">
                    <canvas width="945" height="642"></canvas>
                    <iframe class="uk-position-cover" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d29749.62043544398!2d105.3949952!3d21.243640449999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1637650714767!5m2!1sen!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <div class="uk-width-auto@m">
                <div class="lienhe__section3__card uk-card uk-card-body">
                    <h2 class="uk-h2 lienhe__section3__title">Danh sách đại lý</h2>
                    <p class="lienhe__section3__desc">Tìm địa chỉ đại lý của chúng tôi ở gần quý khác nhất</p>
                    <form class="lienhe__section3__form uk-grid-16 uk-grid-30-m" uk-grid>
                        <div class="uk-width-1-2 home__tuvan__column">
                            <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                <select>
                                    <option value="">Tỉnh/ Thành phố</option>
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
                            <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                <select>
                                    <option value="">Quận/ Huyện</option>
                                    <option value="1">Ông (Mr.)</option>
                                    <option value="2">Bà (Mrs.)</option>
                                </select>
                                <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                    <span></span>
                                    <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div>
                        <?php
                        $dataList = array(
                            array(
                                'txt' => '01 Nguyễn Chí Thanh, quận Cầu Giấy, Hà Nội',
                                'tel' => 'Tel: (024) 3789 7890',
                            ),
                            array(
                                'txt' => '01 Nguyễn Chí Thanh, quận Cầu Giấy, Hà Nội',
                                'tel' => 'Tel: (024) 3789 7891',
                            ),
                            array(
                                'txt' => '01 Nguyễn Chí Thanh, quận Cầu Giấy, Hà Nội',
                                'tel' => 'Tel: (024) 3789 7891',
                            ),
                        );
                        foreach ($dataList as $k=>$v): ?>
                        <div class="lienhe__section3__item">
                            <div class="uk-grid-16" uk-grid>
                                <div class="uk-width-expand">
                                    <h3 class="uk-h3 lienhe__section3__title1">Đại lý <?= $k+1 ?></h3>
                                    <ul class="uk-list lienhe__section3__list">
                                        <li><?= $v['txt'] ?></li>
                                        <li><?= $v['tel'] ?></li>
                                    </ul>
                                </div>
                                <div class="uk-width-auto@m">
                                    <a href="" class="lienhe__section3__btn uk-button uk-button-default"><span>Chỉ đường</span></a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "template-parts/layouts/footer.php"; ?>