<?php
/**
 * Plugin Name: wp-stripe
 * Plugin URI: https://github.com/chrispruitt/wp-stripe
 * Description: A brief description of the plugin.
 * Version: 1.0.0
 * Author: Chris Pruitt so far
 * Author URI: http://URI_Of_The_Plugin_Author
 * License: A short license name. Example: GPL2
 */

require_once('wp-wrapper/WPStripe.php');
require_once('stripe/lib/Stripe.php');

/** Step 2 (from text above). */
add_action( 'admin_menu', 'my_plugin_menu' );

/** Step 1. */
function my_plugin_menu() {
    add_options_page( 'WP Stripe Options', 'WP Stripe', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
}

/** Step 3. */
function my_plugin_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    include 'options.php';
}