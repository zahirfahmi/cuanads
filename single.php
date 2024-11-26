<?php

/**
 * 
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 */

get_header();
wp_enqueue_style(
    'single',
    get_stylesheet_directory_uri() . '/assets/css/single.min.css',
    false,
    filemtime(get_theme_file_path('/assets/css/single.min.css')),
    'all'
);

wp_enqueue_style(
    'sidebar',
    get_stylesheet_directory_uri() . '/assets/css/sidebar.min.css',
    false,
    filemtime(get_theme_file_path('/assets/css/sidebar.min.css')),
    'all'
);

$postID = get_the_ID();
$args = array('post_id' => $postID);

?>
<div class="entry-content">
    <!-- Hook to add something nice -->
    <?php bs_after_primary(); ?>
    <section class="header-blog">
        <div class="container">
            <div class="row align-items-center header-border">
                <div class="col-12">
                    <div class="blog-top">
                        <div class="bredcrumb">
                            <?php echo do_shortcode('[rank_math_breadcrumb]'); ?>
                        </div>
                        <div class="post-title">
                            <h1>
                                <?= get_the_title() ?></h1>
                        </div>
                        <div class="credits">
                            <div class="author">
                                <span><i
                                        class="fa-solid fa-tag"></i></span><?php foreach (get_the_category(get_the_ID()) as $cat) : ?>
                                    <a href="/category/<?= $cat->slug ?>"><?= ' ' . $cat->name; ?></a>
                                <?php endforeach; ?>
                            </div>

                            <div class="date"><span><i class="fa-regular fa-calendar"></i></span>
                                <?= get_the_date('j F Y'); ?>
                            </div>

                            <div class="readtime"><span><i class="fa-regular fa-clock"></i></span>
                                <?= reading_time(get_the_ID()); ?>
                                read</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="post-content">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="in-content">
                        <div class="features-images ratio ratio-16x9">
                            <?php echo get_the_post_thumbnail(get_the_ID(), array(640, 427), array('class' => 'img-responsive')); ?>
                        </div>
                        <div class="caption text-muted"><?= the_title() ?></div>
                        <div class="content-article">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <?php get_template_part('template-parts/blog-parts/bot-content'); ?>
                    <?php get_template_part('template-parts/blog-parts/related-articles'); ?>

                </div>
                <div class="col-12 col-lg-4 sidebar-border">
                    <?php get_template_part('template-parts/sidebar/sidebar-blog'); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
get_footer();
?>