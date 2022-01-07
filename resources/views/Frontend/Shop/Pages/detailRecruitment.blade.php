@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')
    <div class="tuyendung__section chitiettuyendung__section" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="uk-container">
            <div class="home__item40">
                <div class="uk-grid-small uk-grid-30-m" uk-grid>
                    <div class="uk-width-expand">
                        <div class="uk-card uk-card-default uk-card-body chitiettuyendung__cardLeft">
                            <div>
                                <div class="uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand">
                                        <h1 class="uk-h1 tintuc__title">{{$dataDetail->recruitment_title}}</h1>
                                    </div>
                                    <div class="uk-width-auto">
                                        <a href="#my-apply" uk-scroll="offset:100;" class="tuyendung__table__btn uk-button uk-button-default uk-active"><span>Ứng tuyển ngay</span></a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if(trim($dataDetail->recruitment_description) != '')
                                <div class="footer__center__item24">
                                    <div class="footer__center__item16">
                                        <h3 class="uk-h3 chitiettuyendung__cardRight__title">Mô tả</h3>
                                    </div>
                                    <div class="footer__center__item16">
                                        <article class="uk-article chitiettuyendung__cardLeft__article">
                                            {!! $dataDetail->recruitment_description !!}
                                        </article>
                                    </div>
                                </div>
                                @endif

                                @if(trim($dataDetail->recruitment_request) != '')
                                    <div class="footer__center__item24">
                                        <div class="footer__center__item16">
                                            <h3 class="uk-h3 chitiettuyendung__cardRight__title">Yêu cầu</h3>
                                        </div>
                                        <div class="footer__center__item16">
                                            <article class="uk-article chitiettuyendung__cardLeft__article">
                                                {!! $dataDetail->recruitment_request !!}
                                            </article>
                                        </div>
                                    </div>
                                @endif
                                @if(trim($dataDetail->recruitment_benefits) != '')
                                    <div class="footer__center__item24">
                                        <div class="footer__center__item16">
                                            <h3 class="uk-h3 chitiettuyendung__cardRight__title">Quyền lợi</h3>
                                        </div>
                                        <div class="footer__center__item16">
                                            <article class="uk-article chitiettuyendung__cardLeft__article">
                                                {!! $dataDetail->recruitment_benefits !!}
                                            </article>
                                        </div>
                                    </div>
                                @endif
                                @if(trim($dataDetail->recruitment_request_profile) != '')
                                    <div class="footer__center__item24">
                                        <div class="footer__center__item16">
                                            <h3 class="uk-h3 chitiettuyendung__cardRight__title">Yêu cầu hồ sơ</h3>
                                        </div>
                                        <div class="footer__center__item16">
                                            <article class="uk-article chitiettuyendung__cardLeft__article">
                                                {!! $dataDetail->recruitment_request_profile !!}
                                            </article>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div id="my-apply">
                                <div class="footer__center__item24">
                                    <h2 class="uk-h2 tintuc__title uk-text-center">Ứng tuyển ngay</h2>
                                </div>
                                <div class="footer__center__item24">
                                    <form class="uk-grid-small uk-grid-30-m" uk-grid>
                                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                            <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                                <select name="gender">
                                                    {!! $optionGender !!}
                                                </select>
                                                <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                    <span></span>
                                                    <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                            <input class="uk-input modal__wishList__form__input" type="text" placeholder="Tên người ứng tuyển *" name="full_name">
                                        </div>

                                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                            <input class="uk-input modal__wishList__form__input" type="text" placeholder="Số điện thoại *" name="phone">
                                        </div>
                                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                            <input class="uk-input modal__wishList__form__input" type="text" placeholder="Email" name="email">
                                        </div>

                                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                            <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                                <select name="recruitment_position">
                                                    {!! $optionPosition !!}
                                                </select>
                                                <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                    <span></span>
                                                    <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2@s chitiettintuc__boxComment__column">
                                            <div class="uk-width-1-1" uk-form-custom="target: > * > span:first-child">
                                                <select name="recruitment_province">
                                                    {!! $optionProvince !!}
                                                </select>
                                                <button class="modal__wishList__form__btnSelect uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1">
                                                    <span></span>
                                                    <span class="uk-position-center-right" uk-icon="icon: chevron-down"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                            <div class="uk-width-1-1" uk-form-custom>
                                                <input type="file" name="files_apply">
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
                    <div class="uk-width-1-3@m">
                        <div class="chitiettuyendung__cardRight uk-card uk-card-body uk-card-default uk-position-z-index" uk-sticky="offset: 100; bottom: true">
                            <div>
                                <h3 class="uk-h3 chitiettuyendung__cardRight__title">Tóm tắt công việc</h3>
                            </div>
                            <div>
                                <table class="chitiettuyendung__cardRight__table uk-table uk-table-small">
                                    <tbody>
                                    <tr>
                                        <th>Vị trí:</th>
                                        <td>Nhân viên bán hàng</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày bắt đầu:</th>
                                        <td>09/10/2019</td>
                                    </tr>
                                    <tr>
                                        <th>Số lượng:</th>
                                        <td>0/1 người</td>
                                    </tr>
                                    <tr>
                                        <th>Kinh nghiệm:</th>
                                        <td>2-3 năm</td>
                                    </tr>
                                    <tr>
                                        <th>Địa điểm:</th>
                                        <td>Hà Nội</td>
                                    </tr>
                                    <tr>
                                        <th>Mức lương:</th>
                                        <td>Cạnh tranh</td>
                                    </tr>
                                    <tr>
                                        <th>Hạn nộp hồ sơ:</th>
                                        <td>31/12/2019</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                            <tr>
                                <td>
                                    <div class="tuyendung__table__title"><a href="">Nhân viên bán hàng</a></div>
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
                            <tr>
                                <td>
                                    <div class="tuyendung__table__title"><a href="">Nhân viên bán hàng</a></div>
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
                            <tr>
                                <td>
                                    <div class="tuyendung__table__title"><a href="">Nhân viên bán hàng</a></div>
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
                            <tr>
                                <td>
                                    <div class="tuyendung__table__title"><a href="">Nhân viên bán hàng</a></div>
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
                            <tr>
                                <td>
                                    <div class="tuyendung__table__title"><a href="">Nhân viên bán hàng</a></div>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
