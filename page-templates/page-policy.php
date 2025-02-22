<?php

/**
 * Template Name: Policy
 * Template Post Type: page
 *
 * @version 5.3.1
 */

get_header();
wp_enqueue_style('policy', get_stylesheet_directory_uri() . '/assets/css/policy.min.css');
?>



<div id="content" class="site-content py-5 mt-4">
    <div id="primary" class="content-area container">

        <div class="row">
            <div class="col-12 order-first order-md-last">

                <main id="main" class="site-main">

                    <header class="entry-header text-center">
                        <div class="policy_head">
                            <h1><?= get_the_title(); ?></h1>
                        </div>
                        <nav class="policy_nav">
                            <a href="/privacy-policy/" <?php if ($_SERVER['REQUEST_URI'] == "/privacy-policy/") { ?>
                                class="active_nav_policy" <?php   }  ?>>Privacy Policy</a>
                            <a href="/terms-and-conditions/"
                                <?php if ($_SERVER['REQUEST_URI'] == "/terms-and-conditions/") { ?>
                                class="active_nav_policy" <?php   }  ?>>Terms & Conditions</a>
                            <a href="/cookie-policy/" <?php if ($_SERVER['REQUEST_URI'] == "/cookie-policy/") { ?>
                                class="active_nav_policy" <?php   }  ?>>Cookie Policy</a>
                        </nav>
                    </header>

                    <div class="entry-content policy__">
                        <?= get_the_content(); ?>
                    </div>

                    <footer class="entry-footer clear-both">
                        <div class="mb-4">
                            <?php bootscore_tags(); ?>
                        </div>
                    </footer>

                </main>

            </div>
        </div>

    </div>
</div>


<?php
get_footer();
