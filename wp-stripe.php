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
require_once('SettingsPage.php');

set_stripe_keys();

if( is_admin() )
    $my_settings_page = new SettingsPage();


function set_stripe_keys() {
    $options = get_option('my_option_name');

    if ($options['key_to_use'] == 'live') {
        $stripe = array(
            'secret_key'      => $options['live_secret_key'],
            'publishable_key' => $options['live_publishable_key']
        );
    } else {
        $stripe = array(
            'secret_key'      => $options['test_secret_key'],
            'publishable_key' => $options['test_publishable_key']
        );
    }

    if (isset( $stripe['secret_key'] )) {
        Stripe::setApiKey($stripe['secret_key']);
    }
}

