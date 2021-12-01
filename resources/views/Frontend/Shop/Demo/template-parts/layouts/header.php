<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy - <?= /** @var TYPE_NAME  */
        (isset($data['title'])) ? $data['title'] : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <!--CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.7.6/dist/css/uikit.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="style.css?v=<?php echo(time()) ?>">
    <link rel="stylesheet" href="{{URL::asset('assets/style_pro/vendors/ionicons-npm/css/ionicons.css').$ver}}">

    <!--JS-->
    <script src="https://cdn.jsdelivr.net/npm/@shinsenter/defer.js/dist/defer_plus.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.6/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.6/dist/js/uikit-icons.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="js/app.js?v=<?php echo(time()) ?>"></script>
</head>
<body class="">
<?php
$isLogin = rand(true,false);
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
?>

<!--menumobile-->
<div id="offcanvas-menumobile" class="header__offcanvas" uk-offcanvas="overlay: true">
    <div class="uk-offcanvas-bar">
        <button class="uk-offcanvas-close header__bottom__close header__bottom__close--text" type="button" uk-close></button>
        <div class="" style="margin-bottom: 16px">
            <?php require "template-parts/layouts/search.php"; ?>
        </div>
        <ul class="header__offcanvas__nav uk-nav-default uk-nav-parent-icon" uk-nav="toggle: .header__offcanvas__nav__arrow">
            <li class="uk-active"><a href="#">Về chúng tôi</a></li>
            <li><a href="catalog.php">Sản phẩm</a></li>
            <li class="uk-parent">
                <a href="tintuc.php">Tin tức</a>
                <i class="header__offcanvas__nav__arrow"></i>
                <ul class="uk-nav-sub">
                    <li><a href="tintuc.php">Tin hoạt động Poke</a></li>
                    <li><a href="tintuc.php">Thông tin y dược</a></li>
                </ul>
            </li>
            <li><a href="">Tuyển dụng</a></li>
            <li><a href="lienhe.php">Liên hệ</a></li>
            <li><a href="faq.php">FAQ</a></li>
        </ul>
        <div class="uk-text-center header__offcanvas__boxLang">
            <div class="header__top__language" tabindex="0" aria-expanded="true">
                <span>Tiếng Việt</span>
            </div>
            <div class="uk-navbar-dropdown header__dropdown" uk-dropdown="mode: click;pos:bottom-center">
                <ul class="uk-nav uk-navbar-dropdown-nav">
                    <li><a href="#">Tiếng Việt</a></li>
                    <li><a href="#">Tiếng Anh</a></li>
                    <li><a href="#">Tiếng Nhật</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--/menumobile-->
<!--acc-->
<div id="offcanvas-acc" class="header__offcanvas" uk-offcanvas="overlay: true;flip: true">
    <div class="uk-offcanvas-bar">
        <button class="uk-offcanvas-close header__bottom__close header__bottom__close--text" type="button" uk-close></button>
        <?php if ($isLogin): ?>
            <div class="header__offcanvas__user">
                <span>Anh</span>
            </div>
            <ul class="header__offcanvas__nav uk-nav-default uk-nav-parent-icon" uk-nav="toggle: .header__offcanvas__nav__arrow">
                <li><a href="#">Thông tin tài khoản</a></li>
                <li><a href="">Đăng xuất</a></li>
            </ul>
        <?php else: ?>
            <ul class="header__offcanvas__nav uk-nav-default uk-nav-parent-icon" uk-nav="toggle: .header__offcanvas__nav__arrow">
                <li><a href="#">Đăng nhập</a></li>
                <li><a href="">Đăng ký</a></li>
            </ul>
        <?php endif; ?>
    </div>
</div>
<!--/acc-->
<!--app-->
<div id="app" class="uk-height-viewport uk-offcanvas-content uk-overflow-hidden uk-position-relative">
<!--header-->
<div class="header">
    <!--header__top-->
    <div class="header__top uk-visible@m">
        <div class="uk-container">
            <nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>

                <div class="uk-navbar-left">
                    <ul class="uk-navbar-nav">
                        <li><a href="#">Về chúng tôi</a></li>
                        <li><a href="catalog.php">Sản phẩm</a></li>
                        <li>
                            <a href="tintuc.php">Tin tức</a>
                            <div class="uk-navbar-dropdown header__dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="tintuc.php">Tin hoạt động Poke</a></li>
                                    <li><a href="tintuc.php">Thông tin y dược</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#">Tuyển dụng</a></li>
                        <li><a href="lienhe.php">Liên hệ</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                    </ul>
                </div>

                <div class="uk-navbar-right">
                    <!--language-->
                    <div class="uk-navbar-item">
                        <div class="header__top__language">
                            <span>Tiếng Việt</span>
                        </div>
                        <div class="uk-navbar-dropdown header__dropdown" uk-dropdown="mode: hover">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="#">Tiếng Việt</a></li>
                                <li><a href="#">Tiếng Anh</a></li>
                                <li><a href="#">Tiếng Nhật</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--/language-->
                </div>

            </nav>
        </div>
    </div>
    <!--/header__top-->

    <!--header__bottom-->
    <div class="header__bottom" uk-sticky>
        <div class="uk-container uk-padding-remove">
            <nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>

                <div class="uk-navbar-left">
                    <a href="#offcanvas-menumobile" class="uk-navbar-item uk-hidden@m" uk-toggle>
                        <div class="header__bottom__box2 header__bottom__box2--menu"></div>
                    </a>
                    <a href="." class="uk-navbar-item uk-logo"><img src="images/logo_h.png" alt=""></a>
                </div>

                <div class="uk-navbar-right">
                    <!--search-->
                    <div class="uk-navbar-item uk-visible@m">
                        <?php require "template-parts/layouts/search.php"; ?>
                    </div>
                    <!--/search-->

                    <!--quantam-->
                    <a href="quantam.php" class="uk-navbar-item uk-hidden@m">
                        <div class="header__bottom__box2 header__bottom__box2--wishList"></div>
                    </a>
                    <div class="uk-navbar-item header__bottom__marginLeft uk-visible@m">
                        <div class="header__bottom__box1 header__bottom__box1--wishList">
                            <div class="header__bottom__box1__txt1"><a class="uk-link-toggle" href="quantam.php">Quan tâm</a></div>
                            <div class="header__bottom__box1__txt2">0 sản phẩm</div>
                        </div>
                    </div>
                    <!--/quantam-->

                    <!--giohang-->
                    <a href="" class="uk-navbar-item uk-hidden@m">
                        <div class="header__bottom__box2 header__bottom__box2--cart"></div>
                    </a>
                    <div class="uk-navbar-item header__bottom__marginLeft uk-visible@m">
                        <div class="header__bottom__box1 header__bottom__box1--cart">
                            <div class="header__bottom__box1__txt1"><a class="uk-link-toggle" href="">Giỏ hàng</a></div>
                            <div class="header__bottom__box1__txt2">0 sản phẩm</div>
                        </div>
                    </div>
                    <!--/giohang-->

                    <!--account-->
                    <a href="#offcanvas-acc" class="uk-navbar-item uk-hidden@m" uk-toggle>
                        <div class="header__bottom__box2 header__bottom__box2--acc"></div>
                    </a>
                    <div class="uk-navbar-item header__bottom__marginLeft uk-visible@m">
                        <div class="header__bottom__box1 header__bottom__box1--acc">
                            <div class="header__bottom__box1__txt1"><?= ($isLogin)?'Anh':'Tài khoản' ?></div>
                            <div class="header__bottom__box1__txt2"><?= ($isLogin)?'Thông tin tài khoản':'Đăng nhập/ đăng ký' ?></div>
                        </div>
                        <div class="uk-navbar-dropdown header__dropdown" uk-dropdown="mode: hover">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <?php if ($isLogin): ?>
                                    <li><a href="#">Thông tin tài khoản</a></li>
                                    <li><a href="#">Đăng xuất</a></li>
                                <?php else: ?>
                                    <li><a href="#">Đăng nhập</a></li>
                                    <li><a href="#">Đăng ký</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <!--/account-->
                </div>

            </nav>
        </div>
    </div>
    <!--/header__bottom-->
</div>
<!--/header-->
