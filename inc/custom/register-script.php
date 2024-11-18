<?php

/**
 * Registers scripts.
 */
function enqueue_custom_scripts()
{
    wp_register_script(
        'cookies-js',
        get_stylesheet_directory_uri() . '/assets/js/custom/cookies.js',
        array('jquery'),
        null,
        true
    );

    wp_register_script(
        'form-js',
        get_stylesheet_directory_uri() . '/assets/js/custom/form.js',
        array('jquery', 'cookies-js'),
        null,
        true
    );

    wp_enqueue_script('cookies-js');
    wp_enqueue_script('form-js');
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
