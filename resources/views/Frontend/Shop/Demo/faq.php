<?php $data["title"] = "Câu hỏi thường gặp"; ?>
<?php require "template-parts/layouts/header.php"; ?>
<?php
$databreadcrumb = array(
    array(
        'txt' => 'Trang chủ',
        'link' => '.',
    ),
    array(
        'txt' => 'FAQ',
        'link' => '',
    ),
);
require "template-parts/layouts/breadcrumb.php";
?>
<div class="faq__section" uk-height-viewport="offset-top: true;offset-bottom: true">
    <div class="uk-container">
        <h1 class="uk-h1 lienhe__section3__title">Câu hỏi thường gặp</h1>
        <p class="lienhe__section3__desc">Giải đáp thắc mắc của quý khách bằng cách tìm kiếm hoặc xem các câu hỏi theo chủ đề</p>
        <div class="uk-grid-24 uk-grid-30-m" uk-grid>
            <div class="uk-width-1-3@m">
                <?php require "template-parts/layouts/search.php"; ?>
                <ul class="uk-tab-left faq__tab" uk-tab="connect: #component-tab-left-faq; animation: uk-animation-fade">
                    <li><a href="#">Thanh toán</a></li>
                    <li><a href="#">Vận chuyển</a></li>
                    <li><a href="#">Chủ đề 1</a></li>
                    <li><a href="#">Chủ đề 2</a></li>
                    <li><a href="#">Chủ đề 3</a></li>
                    <li><a href="#">Chủ đề 4</a></li>
                </ul>
            </div>
            <div class="uk-width-expand">
                <ul id="component-tab-left-faq" class="uk-switcher">
                    <li>
                        <h2 class="uk-h2 faq__title">Thanh toán</h2>
                        <ul class="faq__accordion" uk-accordion>
                            <?php
                            $dataFaq = array(
                                array(
                                    'title' => 'Tại sao tôi không thể thanh toán hóa đơn bằng ví điện tử',
                                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Mauris pharetra et ultrices neque. Id aliquet lectus proin nibh nisl condimentum id venenatis a. Arcu non sodales neque sodales ut. Purus non enim praesent elementum facilisis. Donec ac odio tempor orci. Eu consequat ac felis donec et odio pellentesque diam volutpat. Pretium aenean pharetra magna ac placerat vestibulum lectus mauris ultrices. Nisi est sit amet facilisis magna etiam tempor orci. Congue nisi vitae suscipit tellus mauris. Vel facilisis volutpat est velit egestas dui. Maecenas accumsan lacus vel facilisis volutpat est velit egestas. Facilisis mauris sit amet massa vitae tortor condimentum lacinia quis. Metus vulputate eu scelerisque felis.'
                                ),
                                array(
                                    'title' => 'Thanh toán qua chuyển khoản',
                                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
                                ),
                                array(
                                    'title' => 'Thanh toán qua thẻ tín dụng',
                                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
                                ),
                                array(
                                    'title' => 'Có thể thanh toán sau khi nhận hàng được không',
                                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
                                ),
                                array(
                                    'title' => 'Thanh toán không thành công',
                                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
                                ),
                                array(
                                    'title' => 'Câu hỏi khác',
                                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
                                ),
                            );
                            foreach ($dataFaq as $k=>$v): ?>
                            <li class="faq__accordion__li <?= ($k==0)?'uk-open':'' ?>">
                                <a class="uk-accordion-title faq__accordion__title" href="#"><?= $v['title'] ?></a>
                                <div class="uk-accordion-content faq__accordion__content">
                                    <p><?= $v['content'] ?></p>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                    <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur, sed do eiusmod.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require "template-parts/layouts/footer.php"; ?>