<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<div id="home">

    <?php if (isset($banners) && !empty($banners)) { ?>
    <section id="banners" class="section-animated">
        <div class="banners-wrapper animate__animated" data-animation="animate__fadeInDownBig">
            <?php foreach ($banners as $banner) { ?>
            <div class=" banner">
                <?= lazyload(
                            array(
                                'src' => base_url('image/resize_crop?w=' . ($mobile ? '480' : '1920') . '&h=' . ($mobile ? '720' : '1080') . '&src=userfiles/banners/' . (!$mobile ? $banner->image : $banner->image_mobile)),
                                'alt' => 'Banner',
                                'data-background' => 1,
                                'class' => 'lazyload',
                            )
                        ); ?>

                <div class="common-limiter">
                    <?php if ($banner->title): ?>
                    <div class="content animate__animated animate__delay-1s" data-animation="animate__fadeInLeftBig">
                        <h3 class="common-title white">
                            <?= $banner->title; ?>
                        </h3>
                        <?php if ($banner->subtitle): ?>
                        <p class="common-subtitle white">
                            <?= $banner->subtitle; ?>
                        </p>
                        <?php endif ?>
                    </div>
                    <?php endif ?>
                </div>
            </div>

            <?php } ?>
        </div>
        <div class="banners-dots"></div>
    </section>
    <?php } ?>

    <?php if (isset($products) && !empty($products)) { ?>
    <section id="products" class="section-animated">
        <div class="products-wrapper">
            <div class="common-slider products-slider">

                <?php foreach ($products as $each) { ?>
                <div class="product-item">
                    <div class="content <?= (isset($each->background_image) && !empty($each->background_image)) ? '' : 'full-width' ?> animate__animated"
                        data-animation="animate__flipInX">
                        <span class="tile-title"><?= T_('Telhas') ?></span>
                        <b class="product-title"><?= $each->title ?></b>
                        <p class="common-text"><?= $each->subtitle; ?></p>
                        <a href="<?= $langLinks['produtos'] . $each->slug; ?>"
                            class="common-button outlined"><span><?= T_('Saiba mais'); ?></span></a>
                    </div>

                    <?php if (isset($each->background_image) && !empty($each->background_image)) {
                                echo lazyload(
                                    array(
                                        'src' => base_url('image/resize?w=500&h=420&src=userfiles/produtos/' . $each->background_image),
                                        'alt' => $each->title,
                                        'class' => 'lazyload',
                                        'data-background' => 1,
                                    )
                                );
                            } ?>

                </div>
                <?php } ?>

            </div>
            <div class="common-dots"></div>

        </div>
    </section>
    <?php } ?>

</div>