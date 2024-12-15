<?php
wp_enqueue_style(
    'choose-article',
    get_stylesheet_directory_uri() . '/assets/css/choose-article.min.css',
    false,
    filemtime(get_theme_file_path('/assets/css/choose-article.min.css')),
    'all'
);
?>
<section class="choose_article">
    <div class="container">
        <div class="row">
            <?php
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 4,
                'orderby'        => 'meta_value_num',
            );

            $loop = new WP_Query($args);
            if ($loop->have_posts()) :
                $post_count = 0;
                while ($loop->have_posts()) : $loop->the_post();
                    $post_count++;

                    if ($post_count === 1) : ?>
            <div class="col-12 col-md-6">
                <div class="card border-0 mb-4 box-shadow h-xl-300 card_blog_features">
                    <div class="thumbnail_images"
                        style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), array(640, 427), array('class' => 'img-responsive')); ?>); height: 150px; background-size: cover; background-repeat: no-repeat; border-radius: 4px; background-position: center;">
                    </div>
                    <a href="<?= get_the_permalink(); ?>"
                        class="card-body px-0 pb-0 d-flex flex-column align-items-start">
                        <h2 class="h4 font-weight-bold title">
                            <?= get_the_title(); ?>
                        </h2>
                        <p class="card-text"><?= wp_trim_words(get_the_content(), 20, '...'); ?></p>
                        <div>
                            <small class="d-block">
                                <div class="text-muted" href="#">
                                    <?php echo get_the_author(); ?>
                                </div>
                            </small>
                            <small class="text-muted meta"><?= get_the_date('d M, Y'); ?> ·
                                <?= reading_time(get_the_ID()) ?></small>
                        </div>
                    </a>
                </div>
            </div>
            <?php else : ?>
            <?php if ($post_count === 2) : ?>
            <div class="col-12 col-md-6">
                <div class="flex-md-row mb-4 box-shadow h-xl-300 check_article">
                    <?php endif; ?>
                    <a href="<?= get_the_permalink(); ?>" class="mb-3 d-flex align-items-center single-article">
                        <?php echo get_the_post_thumbnail(get_the_ID(), array(640, 427), array('class' => 'img-responsive')); ?>
                        <div class="ps-3">
                            <h2 class="mb-2 font-weight-bold">
                                <?= get_the_title(); ?>
                            </h2>
                            <div class="card-text text-muted small single-article-cat">
                                <?php
                                            $categories = get_the_category();
                                            $category_list = [];
                                            foreach ($categories as $category) {
                                                $category_list[] = $category->name;
                                            }
                                            $categories_text = implode(', ', $category_list);
                                            echo $categories_text;
                                            ?>
                            </div>
                            <small class="text-muted"><?= get_the_date('d M, Y'); ?> ·
                                <?= reading_time(get_the_ID()) ?></small>
                        </div>
                    </a>
                    <?php if ($post_count === 4) : ?>
                </div>
            </div>
            <?php endif; ?>
            <?php endif; ?>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>