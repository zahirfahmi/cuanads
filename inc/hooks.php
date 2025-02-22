<?php

/**
 * Hooks
 *
 * @package Bootscore 
 * @version 6.0.0
 */


// Exit if accessed directly
defined('ABSPATH') || exit;
function bs_after_primary()
{
    do_action('bs_after_primary');
}
