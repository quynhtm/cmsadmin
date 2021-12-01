<?php $data["title"] = "Tin tức"; ?>
<?php require "template-parts/layouts/header.php"; ?>
<?php
$databreadcrumb = array(
    array(
        'txt' => 'Trang chủ',
        'link' => '.',
    ),
    array(
        'txt' => 'Tin hoạt động Poke',
        'link' => '',
    ),
);
require "template-parts/layouts/breadcrumb.php";
?>
<div class="tintuc__section" uk-height-viewport="offset-top: true;offset-bottom: true">
    <div class="uk-container">
        <h1 class="uk-h1 tintuc__title">Tin hoạt động Poke</h1>
        <div class="uk-grid-24 uk-grid-30-m" uk-grid>
            <div class="uk-width-expand">
                <div class="uk-child-width-1-3@m uk-grid-16 uk-grid-30-m uk-grid-match" uk-grid>
                    <?php
                    $dataNews = array(
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w960/Uploaded/yfsgs/2021_11_24/z2962520207714_ddaef7bda566df0dc759c4e7f5172e81.jpg',
                            'title' => 'Tổng bí thư: Nhận thức của Đảng về văn hóa ngày càng toàn diện',
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w480/Uploaded/aohunkx/2021_03_22/a2d417ad8eb072ee2ba1.jpg',
                            'title' => 'Giá vàng trong nước lại đắt hơn thế giới gần 11 triệu đồng',
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w480/Uploaded/mdf_reovdl/2021_11_24/F8D21D38_24ED_4826_A08B_2D17305B8909.jpeg',
                            'title' => "Lý do Việt Nam không theo đuổi mục tiêu 'Zero Covid-19'",
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w660/Uploaded/qxwpzdjwp/2021_11_23/qx32.jpg',
                            'title' => 'Nhóm thanh niên gây náo loạn đường phố Hà Nội',
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w360/Uploaded/ebhuiwh/2021_11_24/Lamborghini_Urus.jpg',
                            'title' => 'Cận cảnh Lamborghini Urus màu độc tại TP.HCM',
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w360/Uploaded/pnbcuhbatgunb/2021_11_23/avaelle.jpg',
                            'title' => 'Sự thay đổi của Elle Fanning',
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w360/Uploaded/ryksdreyxq/2021_11_23/1_1_1_1.jpg',
                            'title' => 'Cách mặc đồ tôn chiều cao của Jang Ki Yong',
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w360/Uploaded/kbd_ivdb/2021_11_24/1_1.jpg',
                            'title' => 'Uống 3 lon bia, người đàn ông bị CSGT TP.HCM xử phạt 7 triệu',
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w360/Uploaded/ofh_huqfztmf/2021_11_24/zz.jpg',
                            'title' => 'Zidane sẽ tới PSG nếu Pochettino đến MU',
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w360/Uploaded/jopluat/2020_08_26/U22_Viet_Nam.jpg',
                            'title' => 'U23 Việt Nam dự giải tiền SEA Games ở Campuchia',
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w360/Uploaded/xbfuooo/2021_11_24/a.jpg',
                            'title' => 'Khi hàng xóm chung cư sửa nhà',
                        ),
                        array(
                            'src' => 'https://znews-photo.zadn.vn/w360/Uploaded/pnbcuhbatgunb/2021_11_24/avasong.jpg',
                            'title' => 'Song Hye Kyo giúp loạt sản phẩm cháy hàng',
                        ),
                    );
                    shuffle($dataNews);
                    foreach ($dataNews as $item): ?>
                    <div class="tintuc__column">
                        <div class="uk-card tintuc__card">
                            <div class="uk-cover-container">
                                <img src="<?= $item['src'] ?>" alt="" uk-cover>
                                <canvas width="600" height="338"></canvas>
                            </div>
                            <div class="uk-card-body tintuc__card__body">
                                <h3 class="uk-h3 tintuc__card__title"><a href=""><?= $item['title'] ?></a></h3>
                                <div class="home__tintuc__date">Thứ 2 ,08/07/2019</div>
                                <p class="tintuc__card__desc line-clamp-5">Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus....</p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="tintuc__box1">
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
            <div class="uk-width-1-4@m">
                <div class="uk-card tintuc__asideCard">
                    <div class="tintuc__asideCard__item">
                        <div class="uk-position-relative tintuc__asideCard__search">
                            <input class="uk-input tintuc__asideCard__search__input" type="text" placeholder="Tìm kiếm">
                            <button type="button" class="tintuc__asideCard__search__btn uk-button uk-button-default uk-position-right"></button>
                        </div>
                    </div>
                    <div class="tintuc__asideCard__item">
                        <ul class="uk-nav uk-nav-default tintuc__asideCard__nav">
                            <li class="uk-active"><a href="#">Danh mục bài viết 1</a></li>
                            <li><a href="#">Danh mục bài viết 2</a></li>
                            <li><a href="#">Danh mục bài viết 3</a></li>
                            <li><a href="#">Danh mục bài viết 4</a></li>
                            <li><a href="#">Danh mục bài viết 5</a></li>
                            <li><a href="#">Danh mục bài viết 6</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "template-parts/layouts/footer.php"; ?>