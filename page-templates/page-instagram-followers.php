<?php

/**
 * Template Name: Instagram Followers
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 */

get_header();
?>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
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
                    <div class="sidebar">
                        <?php get_template_part('template-parts/components/sidebar'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
get_footer();