<?php
function delete_all_tracking_likes()
{
    $args = array(
        'post_type'      => 'tracking-likes',
        'posts_per_page' => -1,
        'fields'         => 'ids'
    );

    $all_ip_logs = get_posts($args);

    if (!empty($all_ip_logs)) {
        foreach ($all_ip_logs as $post_id) {
            wp_delete_post($post_id, true);
        }
    }
}
add_action('delete_tracking_likes_cron', 'delete_all_tracking_likes');

function delete_all_tracking_views()
{
    $args = array(
        'post_type'      => 'tracking-views',
        'posts_per_page' => -1,
        'fields'         => 'ids'
    );

    $all_ip_logs = get_posts($args);

    if (!empty($all_ip_logs)) {
        foreach ($all_ip_logs as $post_id) {
            wp_delete_post($post_id, true);
        }
    }
}
add_action('delete_tracking_views_cron', 'delete_all_tracking_views');
