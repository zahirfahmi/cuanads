<?php
wp_enqueue_style(
    'hero-fitur',
    get_stylesheet_directory_uri() . '/assets/css/hero-fitur.min.css',
    false,
    filemtime(get_theme_file_path('/assets/css/hero-fitur.min.css')),
    'all'
);
if (have_rows('hero')):
    while (have_rows('hero')): the_row();
        $fields = get_field('hero')['hero'];
        if ($fields):
?>

            <section class="fitur-hero">
                <div class="container">
                    <div class="row text-center justify-content-center">
                        <div class="col-12 col-md-8">
                            <div class="wrapper">
                                <div class="subtitle">
                                    <?= $fields['sub_title']; ?>
                                </div>
                                <div class="title">
                                    <h1><?= $fields['title']; ?></h1>
                                </div>
                                <div class="desc">
                                    <p><?= $fields['desc']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
<?php
        endif;
    endwhile;
endif;
?>