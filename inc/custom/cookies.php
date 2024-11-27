<?php


require_once 'Api.php';

function process_likes_submission()
{
    global $wpdb;

    $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
    $recaptcha_secret = get_recapcha()['secret_key'];

    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body);

    if (empty($result) || !isset($result->success) || !$result->success) {
        wp_send_json_error(['message' => 'reCAPTCHA tidak valid atau tidak ada.']);
        wp_die();
    }

    $ip_address = sanitize_text_field($_POST['ip_address']);
    $current_time = current_time('mysql');
    $table_name = $wpdb->prefix . 'user_ips';

    $existing_ip = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE ip_address = %s", $ip_address));

    if ($existing_ip) {
        $last_clicked_time = strtotime($existing_ip->clicked_at);
        $time_difference = time() - $last_clicked_time;

        if ($time_difference < get_reset_time_tiktok_likes()) {
            $time_anonce = (get_reset_time_tiktok_likes() - $time_difference);
            $message = 'Anda harus menunggu ' . format_time_difference($time_anonce) . ' sebelum submit lagi.';
            wp_send_json_error(['message' => $message]);
            wp_die();
        }
    }

    $link = sanitize_text_field($_POST['link']);
    $api_settings = get_api();
    $get_likes = get_likes();

    if (!$api_settings || !$get_likes) {
        wp_send_json_error(['message' => 'Pengaturan data likes tidak tersedia.']);
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
        if ($existing_ip) {
            $wpdb->update(
                $table_name,
                ['clicked_at' => $current_time],
                ['ip_address' => $ip_address]
            );
        } else {
            $wpdb->insert($table_name, [
                'ip_address' => $ip_address,
                'clicked_at' => $current_time,
            ]);
        }

        wp_send_json_success(['message' => 'Berhasil, Likes anda akan segera bertambah.']);
    } else {
        wp_send_json_error(['message' => 'Gagal mengirim likes. Coba lagi nanti.']);
    }
    wp_die();
}

add_action('wp_ajax_process_likes', 'process_likes_submission');
add_action('wp_ajax_nopriv_process_likes', 'process_likes_submission');




function process_views_submission()
{
    global $wpdb;

    $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
    $recaptcha_secret = get_recapcha()['secret_key'];

    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body);

    if (empty($result) || !isset($result->success) || !$result->success) {
        wp_send_json_error(['message' => 'reCAPTCHA tidak valid atau tidak ada.']);
        wp_die();
    }

    $ip_address = sanitize_text_field($_POST['ip_address']);
    $current_time = current_time('mysql');
    $table_name = $wpdb->prefix . 'user_ips_view';

    $existing_ip = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE ip_address = %s", $ip_address));

    if ($existing_ip) {
        $last_clicked_time = strtotime($existing_ip->clicked_at);
        $time_difference = time() - $last_clicked_time;

        if ($time_difference < get_reset_time_tiktok_views()) {
            $time_anonce = (get_reset_time_tiktok_views() - $time_difference);
            $message = 'Anda harus menunggu ' . format_time_difference($time_anonce) . ' sebelum submit lagi.';
            wp_send_json_error(['message' => $message]);
            wp_die();
        }
    }

    $link = sanitize_text_field($_POST['link']);
    $api_settings = get_api();
    $get_views = get_views();

    if (!$api_settings || !$get_views) {
        wp_send_json_error(['message' => 'Pengaturan data views tidak tersedia.']);
        wp_die();
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
        if ($existing_ip) {
            $wpdb->update(
                $table_name,
                ['clicked_at' => $current_time],
                ['ip_address' => $ip_address]
            );
        } else {
            $wpdb->insert($table_name, [
                'ip_address' => $ip_address,
                'clicked_at' => $current_time,
            ]);
        }

        wp_send_json_success(['message' => 'Berhasil, Views Anda akan segera bertambah.']);
    } else {
        wp_send_json_error(['message' => 'Gagal mengirim views. Coba lagi nanti.']);
    }
    wp_die();
}

add_action('wp_ajax_process_views', 'process_views_submission');
add_action('wp_ajax_nopriv_process_views', 'process_views_submission');
