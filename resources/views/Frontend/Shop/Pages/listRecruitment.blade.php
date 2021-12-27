@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')
    <div class="uk-position-relative uk-background-center-center uk-background-norepeat uk-background-cover" data-src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/tdMaskGroup.png" uk-img>
        <div class="uk-position-cover lienhe__section1__overlay"></div>
        <div class="uk-section-small lienhe__section1">
            <div class="uk-container">
                <h1 class="uk-h1 lienhe__section1__title">Tuyển dụng</h1>
            </div>
        </div>
    </div>
    <div class="tuyendung__section" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="uk-container">
            <div class="home__item40">
                <div class="uk-card tuyendung__card">
                    <form class="uk-child-width-1-1 uk-child-width-1-4@m uk-grid-16 uk-grid-30-m uk-grid" uk-grid="">
                        <div>
                            <input class="uk-input modal__wishList__form__input" type="text" placeholder="Vị trí công việc">
                        </div>
                        <div>
                            <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                <select>
                                    <option value="">Chức vụ</option>
                                    <option value="1">Ông (Mr.)</option>
                                    <option value="2">Bà (Mrs.)</option>
                                </select>
                                <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                    <span></span>
                                    <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                <select>
                                    <option value="">Địa điểm</option>
                                    <option value="1">Ông (Mr.)</option>
                                    <option value="2">Bà (Mrs.)</option>
                                </select>
                                <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                    <span></span>
                                    <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="uk-button uk-button-default modal__wishList__form__btnSend uk-width-1-1"><span>Tìm kiếm</span></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="home__item40">
                <div class="footer__center__item24">
                    <div class="footer__center__item16">
                        <div class="uk-flex-middle" uk-grid="">
                            <div class="uk-width-expand">
                                <h2 class="uk-h2 tintuc__title">Các vị trí đang tuyển</h2>
                            </div>
                            <div class="uk-width-auto">
                                <span class="chitiettintuc__boxComment__checkTxt">Hiển thị 5/10 kết quả</span>
                            </div>
                        </div>
                    </div>
                    <div class="footer__center__item16">
                        <table class="uk-table uk-table-divider uk-table-middle uk-table-small uk-table-responsive tuyendung__table" uk-toggle="cls: uk-table-hover; mode: media; media: @m">
                            <tbody>
                            <?php

                            for ($i=0;$i<=7;$i++): ?>
                            <tr>
                                <td>
                                    <div class="tuyendung__table__title"><a href="chitiettuyendung.php">Nhân viên bán hàng</a></div>
                                </td>
                                <td>
                                    <div class="tuyendung__table__catalog"><span class="tuyendung__table__txt">Chuyên viên</span></div>
                                </td>
                                <td>
                                    <div class="tuyendung__table__map"><span class="tuyendung__table__txt">Hà Nội</span></div>
                                </td>
                                <td>
                                    <span class="tuyendung__table__txt">Hạn nộp: 31/12/2020</span>
                                </td>
                                <td>
                                    <a href="chitiettuyendung.php" class="tuyendung__table__btn uk-button uk-button-default"><span>Ứng tuyển ngay</span></a>
                                </td>
                            </tr>
                            <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="footer__center__item24">
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
    <div class="tuyendung__section1 uk-section uk-background-norepeat uk-background-center-center uk-background-cover" data-src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/top-view-health-still-life-with-copy-space1.png" uk-img="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/top-view-health-still-life-with-copy-space1.png">
        <div class="uk-container uk-container-small">
            <div class="tuyendung__section1__card uk-card uk-card-body uk-card-default">
                <div class="footer__center__item24">
                    <h2 class="uk-h2 tintuc__title uk-text-center">Ứng tuyển ngay</h2>
                </div>
                <div class="footer__center__item24">
                    <form class="uk-grid-small uk-grid-30-m" uk-grid>
                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                            <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                <select>
                                    <option value="">Danh xưng *</option>
                                    <option value="1">Ông (Mr.)</option>
                                    <option value="2">Bà (Mrs.)</option>
                                </select>
                                <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                    <span></span>
                                    <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                </button>
                            </div>
                        </div>
                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                            <input class="uk-input modal__wishList__form__input" type="text" placeholder="Tên người ứng tuyển *">
                        </div>

                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                            <input class="uk-input modal__wishList__form__input" type="text" placeholder="Số điện thoại *">
                        </div>
                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                            <input class="uk-input modal__wishList__form__input" type="text" placeholder="Email">
                        </div>

                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                            <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                <select>
                                    <option value="">Vị trí ứng tuyển *</option>
                                    <option value="1">Ông (Mr.)</option>
                                    <option value="2">Bà (Mrs.)</option>
                                </select>
                                <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                    <span></span>
                                    <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                </button>
                            </div>
                        </div>
                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                            <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                <select>
                                    <option value="">Địa điểm ứng tuyển *</option>
                                    <option value="1">Ông (Mr.)</option>
                                    <option value="2">Bà (Mrs.)</option>
                                </select>
                                <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                    <span></span>
                                    <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                </button>
                            </div>
                        </div>

                        <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                            <div class="uk-width-1-1" uk-form-custom>
                                <input type="file">
                                <div class="tuyendung__section1__boxFile">
                                    <span>Ấn vào đây để chọn File CV *</span>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                            <div class="uk-text-center">
                                <button type="button" class="uk-button uk-button-default modal__wishList__form__btnSend"><span>Gửi</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

