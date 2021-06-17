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
    
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'tnbpay_plugin_action_links' );

    class WC_Gateway_Your_Gateway extends WC_Payment_Gateway {


        public function __construct() {

            $this->id                 = 'tnbpay';
            $this->method_title       = __( 'TNBPay', 'woo-tnbpay' );
            $this->method_description = sprintf( __( 'TNBPay is a payment method on the TNB network' ));
            $this->has_fields         = true;
            $this->icon = 'https://www.thenewboston.com/static/media/thenewboston-primary.52b925da.svg';

            
            $this->title              = "TNB Pay";

            $this->init();
        }

        /**
         * Init your settings
         *
         * @access public
         * @return void
         */
        function init() {
            // Load the settings API
            $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
            $this->init_settings(); // This is part of the settings API. Loads settings you previously init.

            // Save settings in admin if you have any defined
            add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
        }

        /**
         * Initialise Gateway Settings Form Fields
         */
        function init_form_fields() {
            $this->form_fields = array(
                'title' => array(
                    'title' => __( 'Store Address', 'woocommerce' ),
                    'type' => 'text',
                    'description' => __( 'This is the address the user pays to.', 'woocommerce' ),
                    'desc_tip'      => true
                )
            );
        }
    }
}
add_action('plugins_loaded', 'tnbpay_init');

function add_your_gateway_class( $methods ) {
    $methods[] = 'WC_Gateway_Your_Gateway'; 
    return $methods;
}

add_filter( 'woocommerce_payment_gateways', 'add_your_gateway_class' );


/**
 * Add Settings link to the plugin entry in the plugins menu.
 *
 * @param array $links Plugin action links.
 *
 * @return array
 **/
function tnbpay_plugin_action_links( $links ) {

	$settings_link = array(
		'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=tnbpay' ) . '" title="' . __( 'View TNBPay WooCommerce Settings', 'woo-tnbpay' ) . '">' . __( 'Settings', 'woo-tnbpay' ) . '</a>',
	);

	return array_merge( $settings_link, $links );

}

