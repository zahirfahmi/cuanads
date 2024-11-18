<?php
function load_global_styles()
{
    wp_enqueue_style('global-style', get_template_directory_uri() . '/assets/css/global.min.css');
}
add_action('wp_enqueue_scripts', 'load_global_styles');
