<?php
/* Template Name: Home Pages */
get_header();
?>

<div id="content" class="site-content">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="entry-content">
                <?php
                get_template_part('template-parts/hero');
                get_template_part('template-parts/choose-article');
                get_template_part('template-parts/all-post');
                ?>
            </div>
        </main>
    </div>
</div>

<?php
get_footer();
?>