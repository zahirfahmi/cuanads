<?php
wp_enqueue_style('all-post', get_stylesheet_directory_uri() . '/assets/css/all-post.min.css');
?>
<section class="all-post">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-lg-8">
                <?php get_template_part('template-parts/home/post-category'); ?>
                <div class="title spanborder"><span>Semua Post</span></div>
                <?php
                $args = array(
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' =>  -1,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
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
                                        $categories_text = implode(', ', $category_list);
                                        echo $categories_text;
                                        ?>
                                    </div>
                                    <small class="text-muted"><?= get_the_date('d M, Y'); ?> ·
                                        <?= reading_time(get_the_ID()) ?></small>
                                </div>
                            </div>
                            <div class="images d-none d-md-block">
                                <?php echo get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'img-responsive')); ?>
                            </div>
                        </div>
                <?php endwhile;
                endif;
                ?>
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
                            'posts_per_page' =>  3,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        );
                        $query = new WP_Query($args);

                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post(); ?>
                                <li>
                                    <a href="<?php echo get_the_permalink(); ?>" class="text-dark">
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
                                                $categories_text = implode(', ', $category_list);
                                                echo $categories_text;
                                                ?></p>
                                        </span>
                                    </a>
                                </li>
                        <?php
                            endwhile;
                        endif;
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>