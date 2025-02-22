<?php

/**
 * Template Name: Instagram Followers
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 */
wp_enqueue_style(
    'fitur',
    get_stylesheet_directory_uri() . '/assets/css/fitur.min.css',
    false,
    filemtime(get_theme_file_path('/assets/css/fitur.min.css')),
    'all'
);

get_header();
?>
<div class="entry-content">
    <!-- Hook to add something nice -->
    <?php bs_after_primary(); ?>
    <section class="content" style="padding:32px 0">
        <div class="container">
            <div class="row">
                <div class="title mb-4">
                    <h1><?php echo get_the_title(); ?></h1>
                </div>
                <div class="col-12">
                    <?php get_template_part('template-parts/features/instagram-followers'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="post-content">
                        <?php echo the_content(); ?>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <?php get_template_part('template-parts/components/sidebar'); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    var new_login = {
        nonce: "<?php echo wp_create_nonce('new_login_nonce'); ?>"
    };
</script>
<?php
get_footer();
