<!--footer-->
<div id="footer" class="footer" data-src="images/MaskGroup__footer.png" uk-img>
    <!--footer__top-->
    <div class="footer__top"></div>
    <!--/footer__top-->

    <!--footer__center-->
    <div class="footer__center uk-section-xsmall">
        <div class="uk-container">
            <div class="uk-grid-small uk-grid-30-m" uk-grid>
                <div class="uk-width-1-3@m">
                    <div class="footer__center__item24">
                        <figure class="uk-margin-remove"><a href=""><img src="images/logo_f.png" alt=""></a></figure>
                    </div>
                    <div class="footer__center__item24">
                        <p class="footer__center__desc">If you’re in need of medicines – we’re here by your side.
                            Stay safe and buy online!</p>
                    </div>
                    <div class="footer__center__item24">
                        <ul class="uk-list footer__center__list2">
                            <li>+(84) 534-2319</li>
                            <li>customercare@pharmacy.com</li>
                        </ul>
                    </div>
                </div>
                <div class="uk-width-expand">
                    <h5 class="uk-h5 footer__center__title">Địa chỉ</h5>
                    <div>
                        <div class="footer__center__item16">
                            <h5 class="uk-h5 footer__center__title1">Poke USA City Center</h5>
                            <ul class="uk-list footer__center__list1 uk-list-bullet">
                                <li>Thứ 2 đến Chủ nhật (8h-18h)</li>
                                <li>45 Hudson Street Villa Rica, GA 30180</li>
                            </ul>
                        </div>
                        <div class="footer__center__item16">
                            <h5 class="uk-h5 footer__center__title1">Poke USA Old Town</h5>
                            <ul class="uk-list footer__center__list1 uk-list-bullet">
                                <li>Thứ 2 đến Thứ 7 (8h-18h)</li>
                                <li>95 East Baker Street Union City, NJ 07087</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="uk-width-2-5@m">
                    <div class="" uk-grid>
                        <div class="uk-width-auto@m">
                            <h5 class="uk-h5 footer__center__title">Chức năng</h5>
                            <ul class="uk-list footer__center__list uk-list-bullet">
                                <li><a href="">Về chúng tôi</a></li>
                                <li><a href="catalog.php">Sản phẩm</a></li>
                                <li><a href="tintuc.php">Tin hoạt động Poke</a></li>
                                <li><a href="">Thông tin y dược</a></li>
                                <li><a href="">Tuyển dụng</a></li>
                                <li><a href="lienhe.php">Liên hệ</a></li>
                                <li><a href="faq.php">FAQ</a></li>
                            </ul>
                        </div>
                        <div class="uk-width-expand">
                            <h5 class="uk-h5 footer__center__title">Chính sách</h5>
                            <ul class="uk-list footer__center__list uk-list-bullet">
                                <li><a href="">Chính sách thanh toán</a></li>
                                <li><a href="">Chính sách xử lý khiếu nại</a></li>
                                <li><a href="">Chính sách vận chuyển và giao nhận</a></li>
                                <li><a href="">Chính sách đổi trả và hoàn tiền</a></li>
                                <li><a href="">Chính sách bảo hành</a></li>
                                <li><a href="">Chính sách bảo mật thông tin</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/footer__center-->

    <!--footer__bottom-->
    <div class="footer__bottom uk-text-center">
        <div class="uk-container">
            <span class="footer__bottom__txtCopyright">© 2021 Pharmacy , All Rights Reserved</span>
        </div>
    </div>
    <!--/footer__bottom-->
</div>
<!--/footer-->
</div>
<!--/app-->
<div id="modal-quickView" uk-modal>
    <div class="uk-modal-dialog uk-modal-dialog-m uk-modal-body modal__quickView__body">
        <button class="uk-modal-close-default header__bottom__close" type="button" uk-close></button>
        <div class="uk-child-width-1-2@m uk-grid-small uk-grid-37-m" uk-grid>
            <div>
                <div class="uk-position-relative uk-visible-toggle uk-slideshow" tabindex="-1" uk-slideshow="ratio: 1:1;animation: fade;">

                    <div class="uk-position-relative modal__quickView__left__imgFor modal__wishList__item">
                        <ul class="uk-slideshow-items" style="min-height: 436px;">
                            <?php for ($i=0;$i<=6;$i++): ?>
                                <li tabindex="-1">
                                    <div class="">
                                        <img src="images/h1-product2-featured.png" alt="" uk-cover>
                                    </div>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>

                    <div class="uk-slider modal__wishList__item" uk-slider="">

                        <div class="uk-position-relative">

                            <div class="uk-slider-container">
                                <ul class="uk-thumbnav uk-slider-items uk-child-width-1-4 uk-grid-small uk-grid-16-m uk-grid" uk-grid="" style="transform: translate3d(-111.875px, 0px, 0px);">
                                    <?php for ($i=0;$i<=6;$i++): ?>
                                        <li uk-slideshow-item="<?= $i ?>" tabindex="-1">
                                            <div class="uk-cover-container modal__quickView__left__img">
                                                <img src="images/h1-product2-featured.png" alt="" uk-cover>
                                                <canvas width="100" height="100"></canvas>
                                            </div>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>

                            <div class="">
                                <a class="modal__quickView__nav modal__quickView__nav--prev uk-position-center-left uk-position-small uk-icon uk-slidenav-previous uk-slidenav" href="#" uk-slidenav-previous="" uk-slider-item="previous"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline></svg></a>
                                <a class="modal__quickView__nav modal__quickView__nav--next uk-position-center-right uk-position-small uk-icon uk-slidenav-next uk-slidenav" href="#" uk-slidenav-next="" uk-slider-item="next"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 "></polyline></svg></a>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <div>
                <div class="modal__wishList__item">
                    <div class="uk-child-width-auto uk-grid-small" uk-grid>
                        <div>
                            <div class="uk-position-relative uk-display-inline-block home__product__card__rate">
                                <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                <i class="home__product__card__rate__icon home__product__card__rate__star-o"></i>
                                <div class="uk-position-cover uk-text-nowrap uk-position-z-index uk-overflow-hidden" style="width: 100%">
                                    <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                    <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                    <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                    <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                    <i class="home__product__card__rate__icon home__product__card__rate__star"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="modal__quickView__desc">(1 đánh giá)</span>
                        </div>
                    </div>
                </div>
                <div class="modal__wishList__item">
                    <h2 class="uk-modal-title modal__quickView__title">Hand Creams for Dry, Sensitive Skin</h2>
                    <div class="modal__quickView__price">55.000đ</div>
                </div>
                <div class="modal__wishList__item">
                    <p class="modal__quickView__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <div class="modal__wishList__item">
                    <div class="modal__quickView__box1">
                        <div class="modal__wishList__item">
                            <div class="uk-child-width-auto uk-grid-small uk-flex-middle" uk-grid>
                                <div>
                                    <div class="modal__quickView__label">Số lượng:</div>
                                </div>
                                <div>
                                    <div class="uk-position-relative">
                                        <a href="javascript: void(0)" class="modal__quickView__btnCount modal__quickView__btnCount--minues"></a>
                                        <a href="javascript: void(0)" class="modal__quickView__btnCount modal__quickView__btnCount--plus"></a>
                                        <input class="uk-input uk-form-width-small modal__quickView__input" type="text" placeholder="" value="1">
                                    </div>
                                </div>
                                <div class="uk-width-expand">
                                    <button type="button" class="modal__quickView__addCart uk-button uk-button-default uk-border-rounded"><span>Thêm giỏ hàng</span></button>
                                </div>
                            </div>
                        </div>
                        <div class="modal__wishList__item">
                            <div class="modal__quickView__label">Thành tiền: <span>55.000đ</span></div>
                        </div>
                    </div>
                </div>
                <div class="modal__wishList__item">
                    <h3 class="uk-h3 modal__quickView__titleTag">Tags:</h3>
                    <div class="modal__quickView__boxTag">
                        <a href="" class="uk-button uk-button-default uk-button-small uk-border-pill">Kem</a>
                        <a href="" class="uk-button uk-button-default uk-button-small uk-border-pill">Bôi</a>
                        <a href="" class="uk-button uk-button-default uk-button-small uk-border-pill">Dưỡng da</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-wishList" uk-modal>
    <div class="uk-modal-dialog uk-modal-dialog-m uk-modal-body uk-padding-remove">
        <button class="uk-modal-close-default header__bottom__close" type="button" uk-close></button>
        <div class="uk-child-width-1-2@m uk-grid-match uk-grid-collapse uk-flex-middle" uk-grid>
            <div>
                <div class="uk-cover-container">
                    <img class="uk-visible@m" src="images/bg_wishList.png" alt="" uk-cover>
                    <img class="uk-hidden@m" src="images/bg_wishList_mb.png" alt="" uk-cover>
                    <canvas class="uk-visible@m" width="385" height="433"></canvas>
                    <canvas class="uk-hidden@m" width="344" height="172"></canvas>
                    <div class="modal__wishList__mask uk-position-right"></div>
                </div>
            </div>
            <div>
                <div class="uk-padding-small modal__wishList__box">
                    <h2 class="uk-modal-title modal__wishList__title">Quan tâm</h2>
                    <p class="modal__wishList__desc">Vui lòng điền các thông tin bên dưới để đánh dấu quan tâm và chúng tôi được phục vụ bạn tốt hơn</p>
                    <form>
                        <fieldset class="uk-fieldset">
                            <div class="modal__wishList__item">
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
                            <div class="modal__wishList__item">
                                <input class="uk-input modal__wishList__form__input" type="text" placeholder="Họ tên">
                            </div>
                            <div class="modal__wishList__item">
                                <input class="uk-input modal__wishList__form__input" type="tel" placeholder="Số điện thoại">
                            </div>
                            <div class="modal__wishList__item">
                                <input class="uk-input modal__wishList__form__input" type="email" placeholder="Email">
                            </div>
                            <div class="modal__wishList__item uk-text-center uk-text-left@m">
                                <button onclick="wishListNotification()" type="button" class="uk-button uk-button-default modal__wishList__form__btnSend"><span>Gửi</span></button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // UIkit.modal('#modal-quickView').show();
    // UIkit.modal('#modal-wishList').show();
    const notiDefault1 = '<div class="notification__content notification__content--success">' +
        '<div class="notification__content__txt">Gửi yêu cầu tư vấn thành công. Chúng tôi sẽ liên hệ quý khách trong thời gian sớm nhất.</div>' +
        '</div>';
    const wishListNotification = () => {
        UIkit.notification({
            message: notiDefault1,
            status: 'success',
            pos: 'bottom-left',
            timeout: 5000
        });
        UIkit.modal('#modal-wishList').hide();
    }
</script>
</body>
</html>