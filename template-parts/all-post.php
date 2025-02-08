<?php
wp_enqueue_style(
    'all-post',
    get_stylesheet_directory_uri() . '/assets/css/all-post.min.css',
    false,
    filemtime(get_theme_file_path('/assets/css/all-post.min.css')),
    'all'
);
wp_enqueue_script('ajax-pagination', get_stylesheet_directory_uri() . '/assets/js/custom/pagination.js', array('jquery'), null, true);

wp_localize_script('ajax-pagination', 'ajaxpagination', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce'   => wp_create_nonce('ajax-pagination-nonce')
));

$posts_per_page = 20;
$paged = 1;

$args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$query = new WP_Query($args);
?>
<section class="all-post">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-lg-8">
                <?php get_template_part('template-parts/home/post-category'); ?>
                <div class="title spanborder"><span>Semua Post</span></div>
                <div id="post-container">
                    <?php
                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post(); ?>
                            <div class="loop_article mb-3 d-flex justify-content-between">
                                <div class="pe-0 pe-sm-3">
                                    <a href="<?= get_the_permalink(); ?>" class="content" rel="noopener noreferrer"
                                        title="<?php the_title(); ?>">
                                        <h2 class="mb-2"><?= get_the_title(); ?></h2>
                                        <p><?= wp_trim_words(get_the_content(), 16, '...'); ?></p>
                                    </a>
                                    <div class="meta">
                                        <div class="cat small">
                                            <?php
                                            $categories = get_the_category();
                                            $category_list = [];
                                            foreach ($categories as $category) {
                                                $category_list[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" rel="noopener noreferrer">' . esc_html($category->name) . '</a>';
                                            }
                                            echo implode(', ', $category_list);
                                            ?>
                                        </div>
                                        <small class="text-muted"><?= get_the_date('d M, Y'); ?></small>
                                    </div>
                                </div>
                                <a href="<?= get_the_permalink(); ?>" class="images d-none d-md-block" rel="noopener noreferrer"
                                    title="<?php the_title(); ?>">
                                    <?= get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'img-responsive')); ?>
                                </a>
                            </div>
                    <?php endwhile;
                    endif;
                    wp_reset_postdata(); ?>
                </div>

                <?php if ($query->max_num_pages != 1): ?>
                    <div id="pagination" class="pagination text-center mt-4">
                        <button id="prev-btn" class="btn-pagination-prev" data-page="0" disabled>Sebelumnya</button>
                        <?php
                        $total_pages = $query->max_num_pages;
                        if ($total_pages > 1) :
                            for ($i = 1; $i <= $total_pages; $i++) {
                                if ($i === 1) {
                                    echo '<button class="page-btn current__page" data-page="' . $i . '">' . $i . '</button>';
                                } else {
                                    echo '<button class="page-btn" data-page="' . $i . '">' . $i . '</button>';
                                }
                            }
                        endif;
                        ?>
                        <button id="next-btn" class="btn-pagination-next" data-page="2">Berikutnya</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-12 col-lg-4 ps-0 ps-lg-4">
                <div class="sticky-top">
                    <?php get_template_part('template-parts/home/side-category'); ?>
                    <div class="title spanborder"><span>Post Terbaru</span></div>
                    <ol class="list-featured">
                        <?php
                        $args = array(
                            'post_type'      => 'post',
                            'post_status'    => 'publish',
                            'posts_per_page' => 3,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        );
                        $recent_query = new WP_Query($args);

                        if ($recent_query->have_posts()) :
                            while ($recent_query->have_posts()) : $recent_query->the_post(); ?>
                                <li>
                                    <a href="<?php echo get_the_permalink(); ?>" class="text-dark" rel="noopener noreferrer"
                                        title="<?php the_title(); ?>">
                                        <span>
                                            <h3>
                                                <?= get_the_title(); ?>
                                            </h3>
                                            <p class="text-muted">
                                                <?php
                                                $categories = get_the_category();
                                                $category_list = [];
                                                foreach ($categories as $category) {
                                                    $category_list[] = $category->name;
                                                }
                                                echo implode(', ', $category_list);
                                                ?>
                                            </p>
                                        </span>
                                    </a>
                                </li>
                        <?php
                            endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>