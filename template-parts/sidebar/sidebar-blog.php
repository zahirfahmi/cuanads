<div class="sidebar">
    <div class="author-social">
        <div class="title">
            <h3 class="spanborder"><span>Visit Social Media</span></h3>
        </div>
        <div class="social-media">
            <?php $get_sosmed = get_field('social_media', 'option'); ?>
            <a href="<?= $get_sosmed['facebook']; ?>" rel="noopener" target="_blank">
                <div class="facebook"><i class="fa-brands fa-facebook-f fa-lg"></i></div>
            </a>
            <a href="<?= $get_sosmed['whatsapp']; ?>" rel="noopener" target="_blank">
                <div class="whatsapp"><i class="fa-brands fa-whatsapp"></i></div>
            </a>
            <a href="<?= $get_sosmed['instagram']; ?>" rel="noopener" target="_blank">
                <div class="instagram"><i class="fa-brands fa-instagram fa-lg"></i></div>
            </a>
            <a href="mailto:<?= $get_sosmed['email']; ?>" rel="noopener" target="_blank">
                <div class="email"><i class="fa-regular fa-envelope fa-lg"></i></div>
            </a>
            <a href="<?= $get_sosmed['tiktok']; ?>" rel="noopener" target="_blank">
                <div class="tiktok"><i class="fa-brands fa-tiktok fa-lg"></i></div>
            </a>
        </div>
    </div>
    <div class="latest-post">
        <div class="title">
            <h3 class="spanborder"><span>Latest Posts</span></h3>
        </div>
        <?php
        ?>
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
                        <span>
                            <a href="<?php echo get_the_permalink(); ?>">
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
                                    ?>
                                </p>
                            </a>
                        </span>
                    </li>
            <?php
                endwhile;
            endif;
            ?>
        </ol>
    </div>
</div>