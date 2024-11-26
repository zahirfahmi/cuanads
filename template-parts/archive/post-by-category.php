<?php
wp_enqueue_style('post-by-category', get_template_directory_uri() . '/assets/css/post-by-category.min.css');
$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
$current_category = get_queried_object();
?>
<h1 class="title spanborder"><span>Semua dari <?= $current_category->name; ?></span></h1>
<?php

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 10,
    'cat'            => $current_category->term_id,
    'paged'          => $paged,
);

$query = new WP_Query($args);

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post(); ?>
        <div class="loop_article mb-3 d-flex justify-content-between">
            <div class="pe-0 pe-sm-3">
                <a href="<?= get_the_permalink(); ?>" class="content">
                    <h2 class="mb-2">
                        <?= get_the_title(); ?>
                    </h2>
                    <p><?= wp_trim_words(get_the_content(), 20, '...'); ?></p>
                </a>
                <div class="meta">
                    <div class="cat small">
                        <?php
                        $categories = get_the_category();
                        $category_list = [];
                        foreach ($categories as $category) {
                            $category_list[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                        }
                        echo implode(', ', $category_list);
                        ?>
                    </div>
                    <small class="text-muted"><?= get_the_date('d M, Y'); ?> · <?= reading_time(get_the_ID()) ?></small>
                </div>
            </div>
            <div class="images d-none d-md-block">
                <?php echo get_the_post_thumbnail(get_the_ID(), array(640, 427), array('class' => 'img-responsive')); ?>
            </div>
        </div>
<?php endwhile;

    //  Pagination
    $total_pages = $query->max_num_pages;

    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));

        echo '<nav aria-label="Page navigation" style="padding: 32px 0;">';
        echo '<ul class="pagination justify-content-center">';

        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                echo '<li class="page-item active" aria-current="page"><span class="page-link">' . $i . '</span></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
            }
        }

        if ($current_page < $total_pages) {
            echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        }

        echo '</ul>';
        echo '</nav>';
    }

    wp_reset_postdata();
else :
    echo '<p>No posts found in this category.</p>';
endif;
?>