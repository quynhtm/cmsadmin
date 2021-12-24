
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
                    <a href="." class="uk-navbar-item uk-logo">
                        <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/logo_h.png" alt="" >
                    </a>
                </div>

                <div class="uk-navbar-right">
                    <!--search-->
                    <div class="uk-navbar-item uk-visible@m">
                        <form action="ketquasearch.php" class="uk-position-relative header__bottom__search">
                            <input class="uk-input uk-border-pill header__bottom__search__input" type="text" placeholder="Bạn cần tìm gì">
                            <button type="submit" class="header__bottom__search__btn uk-button uk-button-default uk-position-center-right"></button>
                        </form>
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
                            <div class="header__bottom__box1__txt1"><a class="uk-link-toggle" href="{{URL::route('site.cartProduct')}}">Giỏ hàng</a></div>
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
                            <div class="header__bottom__box1__txt1"><?= isset($isLogin)?'Anh':'Tài khoản' ?></div>
                            <div class="header__bottom__box1__txt2"><?= isset($isLogin)?'Thông tin tài khoản':'Đăng nhập/ đăng ký' ?></div>
                        </div>
                        <div class="uk-navbar-dropdown header__dropdown" uk-dropdown="mode: hover">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <?php if (isset($isLogin)): ?>
                                <li><a href="#">Thông tin tài khoản</a></li>
                                <li><a href="#">Đăng xuất</a></li>
                                <?php else: ?>
                                <li><a href="{{URL::route('site.indexLoginShop')}}">Đăng nhập</a></li>
                                <li><a href="{{URL::route('site.indexRegistrationShop')}}">Đăng ký</a></li>
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

<!--menumobile-->
<div id="offcanvas-menumobile" class="header__offcanvas" uk-offcanvas="overlay: true">
    <div class="uk-offcanvas-bar">
        <button class="uk-offcanvas-close header__bottom__close header__bottom__close--text" type="button" uk-close></button>
        <div class="" style="margin-bottom: 16px">
            <form action="ketquasearch.php" class="uk-position-relative header__bottom__search">
                <input class="uk-input uk-border-pill header__bottom__search__input" type="text" placeholder="Bạn cần tìm gì">
                <button type="submit" class="header__bottom__search__btn uk-button uk-button-default uk-position-center-right"></button>
            </form>
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
        <?php if (isset($isLogin)): ?>
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

