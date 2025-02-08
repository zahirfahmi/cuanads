<?php
function reading_time($ID)
{
    $content = get_post_field('post_content', $ID);
    $word_count = str_word_count(strip_tags($content));
    $readingtime = ceil($word_count / 200);

    if ($readingtime == 1) {
        $timer = " min";
    } else {
        $timer = " mins";
    }
    $totalreadingtime = $readingtime . $timer;

    return $totalreadingtime;
}

function load_more_posts()
{
    check_ajax_referer('ajax-pagination-nonce', 'nonce');
    $paged = isset($_POST['page']) ? (int) $_POST['page'] : 1;
    $posts_per_page = 20;

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    $query = new WP_Query($args);
    ob_start();
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
?>
            <div class="loop_article mb-3 d-flex justify-content-between">
                <div class="pe-0 pe-sm-3">
                    <a href="<?= get_the_permalink(); ?>" class="content" rel="noopener noreferrer" title="<?php the_title(); ?>">
                        <h2 class="mb-2"><?= get_the_title(); ?></h2>
                        <p><?= wp_trim_words(get_the_content(), 16, '...'); ?></p>
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
                        <small class="text-muted"><?= get_the_date('d M, Y'); ?></small>
                    </div>
                </div>
                <a href="<?= get_the_permalink(); ?>" class="images d-none d-md-block" rel="noopener noreferrer"
                    title="<?php the_title(); ?>">
                    <?= get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'img-responsive')); ?>
                </a>
            </div>
<?php
        endwhile;
    endif;
    wp_reset_postdata();

    $posts = ob_get_clean();

    wp_send_json($posts);
    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');
