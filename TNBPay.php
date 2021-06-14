<?php

/**
 * Plugin Name: TNBPay
 * Author: Akande Japhet
 * Author URI: https://github.com/akandejaphet/TNBPay
 * Version:0.1.0
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tnbpay
 * Domain Path: /languages
 *
 */


/**
 * Initialize the translation
 */
function tnbpay_init() {
    load_plugin_textdomain( 'tnbpay', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'tnbpay_init');

