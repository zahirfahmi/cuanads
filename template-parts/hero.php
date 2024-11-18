<?php
wp_enqueue_style('home', get_stylesheet_directory_uri() . '/assets/css/home.min.css');
$field = get_field('home');
if ($field):
?>

    <section class="hero">
        <div class="container">
            <div class="row justify-content-between hero_wrap">
                <div class="col-12 col-lg-6 pt-6 pb-6 align-self-center c_left">
                    <h1><?= $field['heading']; ?></h1>
                    <p class="mb-3"><?= $field['desc']; ?></p>
                    <div class="button_wrap">
                        <a href="<?= $field['button_1']; ?>" class="primary_btn" target="self">Tiktok Likes
                            Gratis</a>
                        <a href="<?= $field['button_1']; ?>" class="secondary_btn" target="self">Tiktok View
                            Gratis</a>
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-none d-lg-block pr-0">
                    <img src="https://placehold.co/600x400" alt="">
                </div>
            </div>
        </div>
    </section>

<?php
endif;
?>