<?php

/**
 * Bootscore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootscore
 * @version 6.0.0
 */


// Exit if accessed directly
defined('ABSPATH') || exit;


/**
 * Update Checker
 * https://github.com/YahnisElsts/plugin-update-checker
 */
require 'inc/update/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;


/**
 * Load required files
 */
require_once('inc/theme-setup.php');             // Theme setup and custom theme supports
require_once('inc/breadcrumb.php');              // Breadcrumb
require_once('inc/columns.php');                 // Main/sidebar column width and breakpoints
require_once('inc/comments.php');                // Comments
require_once('inc/enable-html.php');             // Enable HTML in category and author description
require_once('inc/enqueue.php');                 // Enqueue scripts and styles
require_once('inc/excerpt.php');                 // Adds excerpt to pages
require_once('inc/fontawesome.php');             // Adds shortcode for inserting Font Awesome icons
require_once('inc/hooks.php');                   // Custom hooks
require_once('inc/navwalker.php');               // Register the Bootstrap 5 navwalker
require_once('inc/navmenu.php');                 // Register the nav menus
require_once('inc/pagination.php');              // Pagination for loop and single posts
require_once('inc/password-protected-form.php'); // Form if post or page is protected by password
require_once('inc/template-tags.php');           // Meta information like author, date, comments, category and tags badges
require_once('inc/template-functions.php');      // Functions which enhance the theme by hooking into WordPress
require_once('inc/widgets.php');                 // Register widget area and disables Gutenberg in widgets
require_once('inc/deprecated.php');              // Fallback functions being dropped in v6
require_once('inc/custom/cookies.php');
require_once('inc/custom/additional.php');		 // Custom function

// //script
require_once('inc/custom/register-script.php');
require_once('inc/custom/functions-smm.php');
require_once('inc/custom/load-global.php');
require_once('inc/custom/bot.php');
require_once('inc/custom/features/instagram.php');


//cron
require_once('inc/custom/cron.php');

// Blocks
require_once('inc/blocks/block-widget-archives.php');        // Archive block
require_once('inc/blocks/block-widget-calendar.php');        // Calendar block
require_once('inc/blocks/block-widget-categories.php');      // Categories block
require_once('inc/blocks/block-widget-latest-comments.php'); // Latest posts block
require_once('inc/blocks/block-widget-latest-posts.php');    // Latest posts block
require_once('inc/blocks/block-widget-search.php');          // Searchform block


/**
 * Load WooCommerce scripts if plugin is activated
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/woocommerce/wc-functions.php';
}


/**
 * Load Jetpack compatibility file
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}


// Tambahkan ajaxurl ke dalam head
function ajaxurl()
{
?>
	<script type="text/javascript">
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>
<?php
}
add_action('wp_head', 'ajaxurl');

add_filter('language_attributes', function ($lang) {
	return 'lang="id-ID"';
});

add_action('wp_head', function () {
	$locale = 'id-ID';
	echo '<meta property="og:locale" content="' . esc_attr($locale) . '" />' . PHP_EOL;
	echo '<meta property="og:locale:alternate" content="en_US" />' . PHP_EOL;
	echo '<meta property="og:locale:alternate" content="fr_FR" />' . PHP_EOL;
});

function add_custom_button_to_nav_menu($items, $args)
{
	if ($args->theme_location == 'main-menu') {
		$button = '<li class="nav-item d-flex" style="d"><a href="/fitur" class="primary_btn d-flex align-items-center justify-content-center text-white ms-0 ms-lg-4">Lihat Semua Fitur</a></li>';
		$items .= $button;
	}
	return $items;
}
add_filter('wp_nav_menu_items', 'add_custom_button_to_nav_menu', 10, 2);
