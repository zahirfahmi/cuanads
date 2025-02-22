<div class="recommended-post">
    <h2>Related Articles</h2>
    <div class="row article-card">
        <?php
        $terms = get_the_terms(get_the_ID(), 'category');
        $term_list = wp_list_pluck($terms, 'slug');
        $related_args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            'post_status' => 'publish',
            'post__not_in' => array(get_the_ID()),
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $term_list
                )
            )
        );
        $query = new WP_Query($related_args);
        if ($query->have_posts()) :
            while ($query->have_posts()) :
                $query->the_post();
        ?>
                <div class="post-card d-flex">
                    <div class="col-12 col-lg-3 d-none d-lg-block">
                        <a href="<? the_permalink(); ?>">
                            <div class="images ratio ratio-4x3">
                                <?php echo get_the_post_thumbnail(get_the_ID(), array(320, 213), array('class' => 'img-fluid')); ?>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-9">
                        <div class="desc-article">
                            <div class="title d-flex">
                                <a href="<? the_permalink(); ?>">
                                    <h4><?php the_title(); ?></h4>
                                </a>
                            </div>
                            <div class="info d-flex">
                                <?php echo wp_trim_words(get_the_content(), 20, '..'); ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php endwhile;
        endif; ?>
    </div>
</div>