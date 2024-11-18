<?php

// Pastikan class Api sudah termasuk
require_once 'Api.php';


add_action('wp_ajax_submit_free_likes', 'submit_free_likes');
add_action('wp_ajax_nopriv_submit_free_likes', 'submit_free_likes');

function submit_free_likes()
{
    if (empty($_POST['g-recaptcha-response'])) {
        wp_send_json_error('<div class="message_tiktok"><i class="fa-solid fa-circle-exclamation y_message"></i>reCAPTCHA tidak valid atau tidak ada.</div>');
        wp_die();
    }

    $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
    $recaptcha_secret = get_recapcha()['secret_key'];

    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body);

    if (empty($result) || !isset($result->success) || !$result->success) {
        wp_send_json_error('<div class="message_tiktok"><i class="fa-solid fa-circle-exclamation y_message"></i>reCAPTCHA tidak valid atau tidak ada.</div>');
        wp_die();
    }

    if (empty($_POST['ip_user']) || empty($_POST['link'])) {
        wp_send_json_error('IP atau link tidak ditemukan.');
        wp_die();
    }

    $ip_user = sanitize_text_field($_POST['ip_user']);
    $link = esc_url_raw($_POST['link']);

    if (check_tracking_like($ip_user)) {
        $reset_time = get_reset_time_tiktok_likes() / 60;
        wp_send_json_error("<div class='message_tiktok'><i class='fa-solid fa-circle-exclamation y_message'></i>Silakan tunggu $reset_time menit sebelum mengirim lagi.</div>");
        wp_die();
    } else {
        $api_settings = get_api();
        $get_likes = get_likes();

        if (!$api_settings) {
            wp_send_json_error('Pengaturan API tidak tersedia.');
            wp_die();
        }

        $api = new Api();
        $api->api_key = $api_settings['api_key'];
        $api->api_url = $api_settings['api_url'];

        $order_data = [
            'service' => $get_likes['order_id'],
            'link' => $link,
            'quantity' => $get_likes['qty']
        ];

        $order_response = $api->order($order_data);

        if ($order_response && isset($order_response->order)) {
            track_ip_likes($ip_user);
            wp_send_json_success('Form berhasil dikirim. Likes akan segera diproses.');
        } else {
            wp_send_json_error('Gagal mengirim likes. Coba lagi nanti.');
        }
    }
    wp_die();
}


function check_tracking_like($ip_user)
{
    $args = [
        'post_type' => 'tracking-likes',
        'title' => $ip_user,
        'posts_per_page' => 1,
    ];

    $existing_ip_log = new WP_Query($args);

    if ($existing_ip_log->have_posts()) {
        $post = $existing_ip_log->posts[0];
        $last_submission_time = get_the_date('U', $post->ID);
        $time_difference = time() - $last_submission_time;

        if ($time_difference < get_reset_time_tiktok_likes()) {
            return true;
        }
    }
    return false;
}

function track_ip_likes($ip_user)
{
    $args = [
        'post_type' => 'tracking-likes',
        'title' => $ip_user,
        'posts_per_page' => 1,
    ];

    $existing_ip_log = new WP_Query($args);

    if ($existing_ip_log->have_posts()) {
        $post_id = $existing_ip_log->posts[0]->ID;

        wp_update_post([
            'ID' => $post_id,
            'post_date' => current_time('mysql'),
            'post_date_gmt' => current_time('mysql', 1),
        ]);
    } else {
        wp_insert_post([
            'post_title' => $ip_user,
            'post_type' => 'tracking-likes',
            'post_status' => 'publish',
            'post_date' => current_time('mysql'),
            'post_date_gmt' => current_time('mysql', 1),
        ]);
    }
}




add_action('wp_ajax_submit_free_views', 'submit_free_views');
add_action('wp_ajax_nopriv_submit_free_views', 'submit_free_views');

function submit_free_views()
{
    if (empty($_POST['g-recaptcha-response'])) {
        wp_send_json_error('reCAPTCHA tidak valid atau tidak ada.');
        wp_die();
    }

    $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
    $recaptcha_secret = get_recapcha()['secret_key'];

    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body);

    if (empty($result) || !isset($result->success) || !$result->success) {
        wp_send_json_error('reCAPTCHA tidak valid atau tidak ada.');
        wp_die();
    }

    if (empty($_POST['ip_user']) || empty($_POST['link'])) {
        wp_send_json_error('IP atau link tidak ditemukan.');
    }

    $ip_user = sanitize_text_field($_POST['ip_user']);
    $link = esc_url_raw($_POST['link']);

    if (check_tracking_views($ip_user)) {
        $reset_time = get_reset_time_tiktok_views() / 60;
        wp_send_json_error("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Silakan tunggu $reset_time menit sebelum mengirim lagi.</span</div>>");
    } else {
        $api_settings = get_api();
        $get_views = get_views();

        if (!$api_settings) {
            wp_send_json_error('Pengaturan API tidak tersedia.');
        }

        $api = new Api();
        $api->api_key = $api_settings['api_key'];
        $api->api_url = $api_settings['api_url'];

        $order_data = [
            'service' => $get_views['order_id'],
            'link' => $link,
            'quantity' => $get_views['qty']
        ];

        $order_response = $api->order($order_data);

        if ($order_response && isset($order_response->order)) {
            track_ip_views($ip_user);
            wp_send_json_success('Form berhasil dikirim. Views akan segera diproses.');
        } else {
            wp_send_json_error('Gagal mengirim views. Coba lagi nanti.');
        }
    }
    wp_die();
}


function check_tracking_views($ip_user)
{
    $args = [
        'post_type' => 'tracking-views',
        'title' => $ip_user,
        'posts_per_page' => 1,
    ];

    $existing_ip_log = new WP_Query($args);

    if ($existing_ip_log->have_posts()) {
        $post = $existing_ip_log->posts[0];
        $last_submission_time = get_the_date('U', $post->ID);
        $time_difference = time() - $last_submission_time;

        if ($time_difference < get_reset_time_tiktok_views()) {
            return true;
        }
    }
    return false;
}

function track_ip_views($ip_user)
{
    $args = [
        'post_type' => 'tracking-views',
        'title' => $ip_user,
        'posts_per_page' => 1,
    ];

    $existing_ip_log = new WP_Query($args);

    if ($existing_ip_log->have_posts()) {
        $post_id = $existing_ip_log->posts[0]->ID;

        wp_update_post([
            'ID' => $post_id,
            'post_date' => current_time('mysql'),
            'post_date_gmt' => current_time('mysql', 1),
        ]);
    } else {
        wp_insert_post([
            'post_title' => $ip_user,
            'post_type' => 'tracking-views',
            'post_status' => 'publish',
            'post_date' => current_time('mysql'),
            'post_date_gmt' => current_time('mysql', 1),
        ]);
    }
}
