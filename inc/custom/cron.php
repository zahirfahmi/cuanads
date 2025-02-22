<?php
function delete_all_ip_addresses_like()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_ips';
    $result = $wpdb->query("DELETE FROM $table_name");

    if ($result === false) {
        error_log("Failed to delete records from table: $table_name");
    } else {
        error_log("Deleted $result records from table: $table_name");
    }
}
add_action('delete_all_ip_addresses_like_hook', 'delete_all_ip_addresses_like');

function delete_all_ip_addresses_view()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_ips_view';
    $result = $wpdb->query("DELETE FROM $table_name");

    if ($result === false) {
        error_log("Failed to delete records from table: $table_name");
    } else {
        error_log("Deleted $result records from table: $table_name");
    }
}
add_action('delete_all_ip_addresses_view_hook', 'delete_all_ip_addresses_view');
