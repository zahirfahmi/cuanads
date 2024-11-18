<?php
wp_enqueue_style('home', get_stylesheet_directory_uri() . '/assets/css/home.min.css');
$field = get_field('home');
if ($field):
?>

<section class="hero">
    <div class="container">
        <div class="row justify-content-between hero_wrap py-2 py-md-4">
            <div class="col-12 col-lg-6 pt-6 pb-6 align-self-center c_left">
                <?= $field['meta']; ?>
                <h1><?= $field['heading']; ?></h1>
                <p class="mb-3"><?= $field['desc']; ?></p>
                <p style="color:#03a87c; font-weight: 600;"><?= $field['features']; ?></p>
                <div class="button_wrap">
                    <?php
                        if ($field['button']):
                            foreach ($field['button'] as $btn): ?>
                    <a href="<?= $btn['url']; ?>" class="<?= $btn['class']; ?>" target="_self"
                        id="<?= $btn['id']; ?>"><?= $btn['label']; ?></a>
                    <?php
                            endforeach;
                        endif;
                        ?>
                </div>
            </div>
            <div class="col-12 col-lg-6 d-none d-lg-block pr-0 text-center">
                <?php echo wp_get_attachment_image($field['images'], array(400, 400), array('class' => 'img-responsive')); ?>
            </div>
        </div>
    </div>
</section>

<?php
endif;
?>