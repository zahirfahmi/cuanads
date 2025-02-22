<?php

function get_reset_time_tiktok_likes()
{
    $fields = get_field('tiktok', 'option');
    return isset($fields['reset_time_likes']) ? (int)$fields['reset_time_likes'] * 60 : 60;
}

function get_reset_time_tiktok_Views()
{
    $fields = get_field('tiktok', 'option');
    return isset($fields['reset_time_views']) ? (int)$fields['reset_time_views'] * 60 : 60;
}

function get_api()
{
    $fields = get_field('api_setting', 'option');
    if ($fields && isset($fields['api_key'], $fields['api_url'])) {
        $args = [
            'api_key' => $fields['api_key'],
            'api_url' => $fields['api_url'],
        ];
        return $args;
    }
    return null;
}

function get_recapcha()
{
    $fields = get_field('api_setting', 'option');
    if ($fields && isset($fields['site_key'], $fields['secret_key'])) {
        $args = [
            'site_key' => $fields['site_key'],
            'secret_key' => $fields['secret_key'],
        ];
        return $args;
    }
    return null;
}

function get_turnstile()
{
    $fields = get_field('credentials', 'option');
    if ($fields && isset($fields['site_key'], $fields['secret_key'])) {
        $args = [
            'site_key' => $fields['site_key'],
            'secret_key' => $fields['secret_key'],
            'endpoint' => $fields['endpoint']
        ];
        return $args;
    }
    return null;
}

function get_likes()
{
    $fields = get_field('tiktok', 'option');
    if ($fields && isset($fields['order_id_likes'], $fields['quantity_likes'])) {
        $args = [
            'order_id' => $fields['order_id_likes'],
            'qty' => $fields['quantity_likes'],
        ];
        return $args;
    }
    return null;
}

function get_views()
{
    $fields = get_field('tiktok', 'option');
    if ($fields && isset($fields['order_id_views'], $fields['quantity_views'])) {
        $args = [
            'order_id' => $fields['order_id_views'],
            'qty' => $fields['quantity_views'],
        ];
        return $args;
    }
    return null;
}

function format_time_difference($seconds)
{
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    $time_string = '';
    if ($hours > 0) {
        $time_string .= $hours . ' jam ';
    }
    if ($minutes > 0) {
        $time_string .= $minutes . ' menit ';
    }
    if ($seconds > 0 || $time_string == '') {
        $time_string .= $seconds . ' detik';
    }

    return $time_string;
}

function set_key_captcha()
{
    $sitekey = get_field('credentials', 'option');

    $set_key =
        '<script>
            let site_key_captcha = "' . $sitekey['site_key'] . '";
        </script>';
    echo $set_key;
}
add_action('wp_head', 'set_key_captcha');
