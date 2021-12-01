<!--breadcrumb-->
<div class="uk-section-xsmall uk-overflow-auto breadcrumb__section" uk-sticky="offset: 56;media:(max-width: 959px)">
    <div class="uk-container uk-padding-remove">
        <ul class="uk-breadcrumb uk-flex uk-flex-nowrap">
            <?php if (isset($databreadcrumb)): ?>
                <?php foreach ($databreadcrumb as $k=>$v): ?>
                    <?php if ($k < (count($databreadcrumb) - 1)): ?>
                        <li><a href="<?= $v['link'] ?>"><?= $v['txt'] ?></a></li>
                    <?php else: ?>
                        <li><span><?= $v['txt'] ?></span></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
<!--/breadcrumb-->