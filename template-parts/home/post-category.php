<?php
wp_enqueue_style(
    'post-category',
    get_stylesheet_directory_uri() . '/assets/css/post-category.min.css',
    false,
    filemtime(get_theme_file_path('/assets/css/post-category.min.css')),
    'all'
);
$cat = 'Keuangan';
$cat_posts = new WP_Query(array(
    'posts_per_page' => 4,
    'order'          => 'DESC',
    'post_status'    => 'publish',
    'category_name'  => $cat,
));
?>
<div class="title spanborder"><span>Semua <?= $cat ?></span></div>
<div class="wrapper-post-cat">
    <?php
    if ($cat_posts->have_posts()) {
        while ($cat_posts->have_posts()) {
            $cat_posts->the_post();
    ?>
            <a href="<?= get_the_permalink(); ?>" class="post-card">
                <div class="thumbnail_images">
                    <?php echo get_the_post_thumbnail(get_the_ID(), array(640, 427), array('class' => 'img-responsive')); ?>
                </div>
                <div class="card-body px-0 pb-0 d-flex flex-column align-items-start">
                    <h2 class="h4 font-weight-bold title">
                        <?= get_the_title(); ?>
                    </h2>
                    <p class="card-text"><?= wp_trim_words(get_the_content(), 12, '...'); ?></p>
                    <div>
                        <small class="d-block">
                            <div class="text-muted">
                                <?php echo get_the_author(); ?>
                            </div>
                        </small>
                        <small class="text-muted meta"><?= get_the_date('d M, Y'); ?> ·
                            <?= reading_time(get_the_ID()) ?></small>
                    </div>
                </div>
            </a>
    <?php
        }
        wp_reset_postdata();
    }
    ?>
</div>
<div class="category-url">
    <?php
    $category = get_category_by_slug($cat);
    if ($category) :
    ?>
        <a href="/category/<?= $category->slug; ?>"><span>Lihat Semua <?= $category->slug; ?></span><i
                class="fa-solid fa-chevron-down"></i></a>
    <?php

    endif;
    ?>
</div>