@extends('Frontend.Shop.Layouts.index')
@section('content')
    @include('Frontend.Shop.Layouts.breadcrumb')
    <div class="tintuc__section chitiettintuc__section" uk-height-viewport="offset-top: true;offset-bottom: true">
        <div class="uk-container">
            <div class="home__item40">
                <div class="uk-grid-24 uk-grid-30-m" uk-grid>
                    <div class="uk-width-expand">
                        <div class="chitiettintuc__card uk-card">
                            <div class="uk-cover-container">
                                <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/image193.png" alt="" uk-cover>
                                <canvas width="960" height="541"></canvas>
                            </div>
                            <div class="uk-card-body chitiettintuc__card__body">
                                <div class="footer__center__item24">
                                    <h1 class="uk-h1 chitiettintuc__title">Khám sức khỏe định kỳ - Giải pháp chăm sóc sức khỏe toàn diện</h1>
                                    <div class="home__tintuc__date">Thứ 2 ,08/07/2019</div>
                                </div>
                                <article class="chitiettintuc__article uk-article footer__center__item24">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Mauris pharetra et ultrices neque. Id aliquet lectus proin nibh nisl condimentum id venenatis a. Arcu non sodales neque sodales ut. Purus non enim praesent elementum facilisis. Donec ac odio tempor orci. Eu consequat ac felis donec et odio pellentesque diam volutpat. Pretium aenean pharetra magna ac placerat vestibulum lectus mauris ultrices. Nisi est sit amet facilisis magna etiam tempor orci. Congue nisi vitae suscipit tellus mauris. Vel facilisis volutpat est velit egestas dui. Maecenas accumsan lacus vel facilisis volutpat est velit egestas. Facilisis mauris sit amet massa vitae tortor condimentum lacinia quis. Metus vulputate eu scelerisque felis.</p>

                                    <p>Tincidunt ornare massa eget egestas purus viverra. Ut pharetra sit amet aliquam id diam maecenas ultricies mi. Sit amet porttitor eget dolor morbi. Vulputate ut pharetra sit amet. Quam pellentesque nec nam aliquam sem. Euismod quis viverra nibh cras pulvinar mattis nunc sed blandit. A arcu cursus vitae congue. Fringilla urna porttitor rhoncus dolor purus. Justo donec enim diam vulputate ut. Ipsum dolor sit amet consectetur adipiscing elit. Viverra maecenas accumsan lacus vel. Diam maecenas ultricies mi eget. Nulla facilisi etiam dignissim diam quis. Non sodales neque sodales ut etiam sit.</p>

                                    <p>In egestas erat imperdiet sed euismod nisi porta lorem mollis. Commodo odio aenean sed adipiscing diam. Nunc sed augue lacus viverra vitae congue eu. Amet nulla facilisi morbi tempus iaculis urna id volutpat. Aliquam nulla facilisi cras fermentum odio. Aliquam id diam maecenas ultricies mi. Viverra mauris in aliquam sem fringilla. In hac habitasse platea dictumst vestibulum rhoncus. Libero nunc consequat interdum varius sit amet mattis vulputate enim. Et leo duis ut diam. Tortor vitae purus faucibus ornare suspendisse sed. Integer vitae justo eget magna. Eu nisl nunc mi ipsum faucibus vitae aliquet nec. Sem nulla pharetra diam sit amet nisl suscipit adipiscing bibendum. Posuere sollicitudin aliquam ultrices sagittis orci a scelerisque purus semper.</p>

                                    <p>Cursus mattis molestie a iaculis. Nisi scelerisque eu ultrices vitae. Quam nulla porttitor massa id neque aliquam. Posuere lorem ipsum dolor sit amet. Tincidunt dui ut ornare lectus sit amet est placerat. Maecenas accumsan lacus vel facilisis volutpat est velit. Purus ut faucibus pulvinar elementum. Cursus eget nunc scelerisque viverra mauris in aliquam sem fringilla. Et sollicitudin ac orci phasellus egestas tellus rutrum. Tempus quam pellentesque nec nam aliquam sem. Porttitor lacus luctus accumsan tortor posuere ac ut consequat. Sed risus ultricies tristique nulla aliquet enim. Velit euismod in pellentesque massa placerat duis ultricies lacus sed. Elit eget gravida cum sociis natoque penatibus et. Sed arcu non odio euismod lacinia. Nec ultrices dui sapien eget mi proin sed libero. Vulputate odio ut enim blandit. Suscipit adipiscing bibendum est ultricies integer quis. Purus in massa tempor nec feugiat nisl.</p>

                                    <p>Elit sed vulputate mi sit amet mauris commodo quis imperdiet. Cursus in hac habitasse platea dictumst quisque sagittis. Urna neque viverra justo nec ultrices. In est ante in nibh mauris cursus mattis molestie. Vitae auctor eu augue ut lectus arcu. Semper quis lectus nulla at volutpat diam. Risus quis varius quam quisque id. Molestie at elementum eu facilisis. Orci porta non pulvinar neque laoreet suspendisse interdum consectetur libero. At tempor commodo ullamcorper a lacus. Sed turpis tincidunt id aliquet risus. Arcu non sodales neque sodales ut etiam. Scelerisque varius morbi enim nunc faucibus. Fames ac turpis egestas integer. Sed turpis tincidunt id aliquet risus feugiat. Quis blandit turpis cursus in hac habitasse platea dictumst quisque. Gravida dictum fusce ut placerat orci nulla pellentesque. Convallis tellus id interdum velit laoreet id donec. Risus ultricies tristique nulla aliquet enim. Sed libero enim sed faucibus turpis in eu mi bibendum.</p>
                                </article>
                                <div class="footer__center__item24">
                                    <div class="chitiettintuc__boxComment">
                                        <h3 class="uk-h3 home__header__title">Để lại bình luận</h3>
                                        <form class="uk-grid-small uk-grid-30-m" uk-grid>
                                            <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                                <input class="uk-input chitiettintuc__boxComment__input" type="text" placeholder="Họ tên">
                                            </div>
                                            <div class="uk-width-1-3@s chitiettintuc__boxComment__column">
                                                <input class="uk-input chitiettintuc__boxComment__input" type="text" placeholder="Email">
                                            </div>
                                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                <textarea class="uk-textarea chitiettintuc__boxComment__textarea" rows="3" placeholder="Bình luận"></textarea>
                                            </div>
                                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                <label class="chitiettintuc__boxComment__label"><input class="uk-checkbox chitiettintuc__boxComment__check" type="checkbox" checked> <span class="chitiettintuc__boxComment__checkTxt">Tôi đồng ý rằng dữ liệu của tôi đã gửi đang được thu thập và lưu trữ. Để biết thêm chi tiết về việc xử lý dữ liệu người dùng, hãy xem Chính sách quyền riêng tư của chúng tôi.</span></label>
                                            </div>
                                            <div class="uk-width-1-1 chitiettintuc__boxComment__column">
                                                <button type="submit" class="uk-button uk-button-default chitiettintuc__boxComment__btn"><span>Đánh giá</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="footer__center__item24">
                                    <h3 class="uk-h3 home__header__title">Bình luận</h3>
                                    <div class="uk-grid uk-grid-16" uk-grid="">
                                        <div class="uk-width-1-1">
                                            <div class="uk-grid uk-grid-16" uk-grid="">
                                                <div class="uk-width-auto">
                                                    <div class="uk-cover-container uk-border-circle">
                                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/lemanhhai_anhthe.jpg" alt="" uk-cover>
                                                        <canvas width="36" height="36"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 chitiettintuc__item8 chitiettintuc__boxComment__titleName">Trần Văn A</h4>
                                                    <div class="chitiettintuc__item8 chitiettintuc__boxComment__checkTxt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                                    <div class="chitiettintuc__item8 tintuc__card__desc">12 phút trước</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <div class="uk-grid uk-grid-16" uk-grid="">
                                                <div class="uk-width-auto">
                                                    <div class="uk-cover-container uk-border-circle">
                                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/lemanhhai_anhthe.jpg" alt="" uk-cover>
                                                        <canvas width="36" height="36"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 chitiettintuc__item8 chitiettintuc__boxComment__titleName">Trần Văn A</h4>
                                                    <div class="chitiettintuc__item8 chitiettintuc__boxComment__checkTxt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                                    <div class="chitiettintuc__item8 tintuc__card__desc">12 phút trước</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <div class="uk-grid uk-grid-16" uk-grid="">
                                                <div class="uk-width-auto">
                                                    <div class="uk-cover-container uk-border-circle">
                                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/lemanhhai_anhthe.jpg" alt="" uk-cover>
                                                        <canvas width="36" height="36"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 chitiettintuc__item8 chitiettintuc__boxComment__titleName">Trần Văn A</h4>
                                                    <div class="chitiettintuc__item8 chitiettintuc__boxComment__checkTxt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                                    <div class="chitiettintuc__item8 tintuc__card__desc">12 phút trước</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <div class="uk-grid uk-grid-16" uk-grid="">
                                                <div class="uk-width-auto">
                                                    <div class="uk-cover-container uk-border-circle">
                                                        <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/lemanhhai_anhthe.jpg" alt="" uk-cover>
                                                        <canvas width="36" height="36"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-h4 chitiettintuc__item8 chitiettintuc__boxComment__titleName">Trần Văn A</h4>
                                                    <div class="chitiettintuc__item8 chitiettintuc__boxComment__checkTxt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                                    <div class="chitiettintuc__item8 tintuc__card__desc">12 phút trước</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <div class="uk-grid uk-grid-16" uk-grid="">
                                                <div class="uk-width-auto">
                                                    <div class="uk-cover-container uk-border-circle">
                                                        <img hidden src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/lemanhhai_anhthe.jpg" alt="" uk-cover>
                                                        <canvas width="36" height="36"></canvas>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <div class="uk-text-center uk-padding-small chitiettintuc__box1">
                                                        <a href="">Xem thêm</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        </div>                </div>
                </div>
            </div>
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
                    <div>
                        <div class="uk-cover-container home__tintuc__coverContainer">
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/news4.png" alt="" uk-cover>
                            <canvas width="600" height="338"></canvas>
                        </div>
                        <h4 class="uk-h4 home__tintuc__title"><a href="">Khám sức khỏe định kỳ - Giải pháp chăm sóc sức khỏe toàn diện</a></h4>
                        <div class="home__tintuc__date">Thứ 2 ,08/07/2019</div>
                    </div>
                    <div>
                        <div class="uk-cover-container home__tintuc__coverContainer">
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/news2.png" alt="" uk-cover>
                            <canvas width="600" height="338"></canvas>
                        </div>
                        <h4 class="uk-h4 home__tintuc__title"><a href="">Dạy con cách tự bảo vệ bản thân trước những nguy hiểm</a></h4>
                        <div class="home__tintuc__date">Thứ 2 ,08/07/2019</div>
                    </div>
                    <div>
                        <div class="uk-cover-container home__tintuc__coverContainer">
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/news1.png" alt="" uk-cover>
                            <canvas width="600" height="338"></canvas>
                        </div>
                        <h4 class="uk-h4 home__tintuc__title"><a href="">Tầm soát ung thư - Giải pháp bảo vệ sức khoẻ toàn diện</a></h4>
                        <div class="home__tintuc__date">Thứ 2 ,08/07/2019</div>
                    </div>
                    <div>
                        <div class="uk-cover-container home__tintuc__coverContainer">
                            <img src="{{Config::get('config.WEB_ROOT')}}assets/frontend/shop/images/news3.png" alt="" uk-cover>
                            <canvas width="600" height="338"></canvas>
                        </div>
                        <h4 class="uk-h4 home__tintuc__title"><a href="">Sản phẩm bảo hiểm tốt nhất cho gia đình hiện nay</a></h4>
                        <div class="home__tintuc__date">Thứ 2 ,08/07/2019</div>
                    </div>
                </div>        </div>
            <!--/Tin tức-->
        </div>
    </div>
@stop
