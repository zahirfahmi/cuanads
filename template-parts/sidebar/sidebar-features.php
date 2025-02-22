<div class="sidebar">
    <?php
    $features = get_field('sidebar_features', 'option');
    if ($features) : ?>
        <div class="other-feature">
            <div class="title">
                <h3><?= $features['heading']; ?></h3>
            </div>
            <?php if (!empty($features['item'])) : ?>
                <div class="features d-flex flex-column gap-2">
                    <?php foreach ($features['item'] as $list) : ?>
                        <a href="<?= $list['link']; ?>" class="text-decoration-none">
                            <div class="card-features">
                                <div class="features-desc">
                                    <div class="title-card"><?= $list['title']; ?> <i class="fa-solid fa-arrow-up-right-from-square"></i></div>
                                    <div class="sub-title">
                                        <?= $list['description']; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php
    endif; ?>
    <div class="latest-post">
        <div class="title">
            <h3>Artikel terbaru</h3>
        </div>
        <div class="post">
            <?php
            $latest_args = array(
                'post_type' => 'post',
                'posts_per_page' => 5,
                'post_status' => 'publish',
                'orderby' => 'date',
            );
            $latest = new WP_Query($latest_args);

            if ($latest->have_posts()) :
                while ($latest->have_posts()) :
                    $latest->the_post();
            ?>
                    <div class="post-card">
                        <div class="title">
                            <a href="<? the_permalink(); ?>">
                                <h4><?php the_title(); ?></h4>
                            </a>
                        </div>
                        <div class="credits">
                            <div class="category">
                                <?php foreach (get_the_category($latest->ID) as $cat) : ?>
                                    <a href="../category/<?= $cat->slug ?>"><?= ' ' . $cat->name; ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
            <?php endwhile;
            endif; ?>
        </div>
    </div>
</div>