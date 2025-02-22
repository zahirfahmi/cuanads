<?php
wp_enqueue_style(
    'side-category',
    get_stylesheet_directory_uri() . '/assets/css/side-category.min.css',
    false,
    filemtime(get_theme_file_path('/assets/css/side-category.min.css')),
    'all'
);
$categories = get_categories(array(
    'orderby' => 'name',
    'order'   => 'ASC',
    'hide_empty' => false,
));
$categories = array_filter($categories, function ($category) {
    return $category->name !== 'Uncategorized';
});
if ($categories) :
?>
    <div class="title spanborder"><span>Semua Kategori</span></div>
    <div class="wrapper-card">
        <?php
        foreach ($categories as $category) : ?>
            <a href=" <?php echo esc_url(get_category_link($category->term_id)); ?>" class="single-card">
                <h3><?= $category->name; ?></h3>
            </a>
        <?php
        endforeach;
        ?>
    </div>
<?php
endif;
?>