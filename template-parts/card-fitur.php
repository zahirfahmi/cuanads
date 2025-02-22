<?php
wp_enqueue_style(
    'card-fitur',
    get_stylesheet_directory_uri() . '/assets/css/card-fitur.min.css',
    false,
    filemtime(get_theme_file_path('/assets/css/card-fitur.min.css')),
    'all'
);
if (have_rows('list_features')):
    while (have_rows('list_features')): the_row();
        $fields = get_field('list_features')['list_features'];
        if ($fields):
?>
            <section class="list-fitur">
                <div class="container">
                    <?php
                    if ($fields['item']):
                        foreach ($fields['item'] as $item) : ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="title spanborder">
                                        <h2><span><?= $item['title']; ?> Fitur</span></h2>
                                    </div>

                                </div>
                            </div>
                            <div class="row mb-5">
                                <?php
                                if ($item['features_card']):
                                    foreach ($item['features_card'] as $card) : ?>
                                        <div class="col-12 col-md-6 mb-3 mb-lg-0">
                                            <div class="card-fitur">
                                                <div class="inner-card">
                                                    <div class="title">
                                                        <h3><?= $card['title'] ?> <?= $item['title']; ?></h3>
                                                    </div>
                                                    <div class="desc">
                                                        <p><?= $card['description'] ?></p>
                                                    </div>
                                                    <div class="qty">
                                                        <span class=" <?= $card['status']; ?>"><?= $card['status_label']; ?></span>
                                                    </div>
                                                    <div class="button_wrap">
                                                        <a href="<?= $card['link']; ?>" class="primary_btn">Dapatkan Sekarang</a>
                                                        <a href="https://wa.link/kfgi69" class="secondary_btn">Beli <?= $card['title'] ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    endforeach;
                                endif; ?>
                            </div>
                    <?php
                        endforeach;
                    endif; ?>
                </div>
            </section>
<?php
        endif;
    endwhile;
endif;
?>