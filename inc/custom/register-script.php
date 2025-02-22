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



function scriptsEntry()
{
    wp_register_script('main', get_stylesheet_directory_uri() . '/assets/js/custom/cookies.js', array('jquery'), false, false);
    wp_register_script('validate-token', get_stylesheet_directory_uri() . '/assets/js/custom/validate-token.js', array('jquery'), 'v1.0', false);
    wp_register_script('instagram-login', get_stylesheet_directory_uri() . '/assets/js/custom/instagram/login.js', array('jquery'), false, false);
    wp_register_script('instagram-followers', get_stylesheet_directory_uri() . '/assets/js/custom/instagram/instagram-followers.js', array('jquery'), false, false);
    wp_register_script('new-instagram-likes', get_stylesheet_directory_uri() . '/assets/js/custom/instagram/new-instagram-likes.js', array('jquery'), false, false);
    wp_register_script('alert', get_stylesheet_directory_uri() . '/assets/js/plugins/sweetalert2@11.js', array('jquery'), false, false);
    wp_register_script('ajax-pagination', get_stylesheet_directory_uri() . '/assets/js/custom/pagination.js', array('jquery'), false, false);
    wp_register_script('auth', get_stylesheet_directory_uri() . '/assets/js/custom/instagram/auth.js', array('jquery'), false, false);
    wp_register_script('utils', get_stylesheet_directory_uri() . '/assets/js/custom/instagram/utils.js', array('jquery'), false, false);
    wp_register_script('cf-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', [], null, true);
}
add_action("wp_enqueue_scripts", "scriptsEntry");
