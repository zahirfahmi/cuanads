<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 * @version 6.0.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;
wp_enqueue_style('archive', get_stylesheet_directory_uri() . '/assets/css/archive.min.css');
get_header();

?>

<div id="content" class="site-content">
  <div id="primary" class="content-area">
    <main id="main" class="site-main">
      <section class="cat_page">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <!-- features post next Development -->
              <?php //echo get_template_part('template-parts/archive/features-by-category'); 
              ?>
              <?php get_template_part('template-parts/archive/post-by-category'); ?>
            </div>
            <div class="col-md-4 pl-4">
              <?php get_template_part('template-parts/archive/sidebar'); ?>
            </div>
          </div>
          <?php get_template_part('template-parts/archive/cta'); ?>
        </div>
      </section>
    </main>
  </div>
</div>


<?php
get_footer();
