<div class="sticky-top mb-4">
    <?php
    ?>
    <h5 class="font-weight-bold spanborder"><span>Artikel Terbaru</span></h5>
    <ol class="list-featured">
        <?php
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' =>  4,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post(); ?>
                <li>
                    <span>
                        <a href="<?php echo get_the_permalink(); ?>">
                            <h3>
                                <?= get_the_title(); ?>
                            </h3>
                        </a>
                        <p class="text-muted">
                            <?php
                            $categories = get_the_category();
                            $category_list = [];
                            foreach ($categories as $category) {
                                $category_list[] = $category->name;
                            }
                            $categories_text = implode(', ', $category_list);
                            echo $categories_text;
                            ?>
                        </p>
                    </span>
                </li>
        <?php
            endwhile;
        endif;
        ?>
    </ol>
</div>