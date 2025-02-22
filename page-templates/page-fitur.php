<?php

/**
 * Template Name: All Fitur
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 */


get_header();
?>

<div id="content" class="site-content">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php get_template_part('template-parts/hero-fitur'); ?>
            <?php get_template_part('template-parts/card-fitur'); ?>
        </main>
    </div>
</div>

<?php
get_footer();
?>