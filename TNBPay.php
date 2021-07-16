<?php

/**
 * Plugin Name: TNBPay
 * Author: Akande Japhet
 * Author URI: https://github.com/akandejaphet/TNBPay
 * Version:1.0.1
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tnbpay
 * Domain Path: /languages
 *
 */


/**
 * Initialize the translation
 */
function tnbpay_init()
{

    load_plugin_textdomain('tnbpay', false, basename(dirname(__FILE__)) . '/languages/');

    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'tnbpay_plugin_action_links');

    class WC_Gateway_Your_Gateway extends WC_Payment_Gateway
    {
        public $supported_currencies = array('USD', 'TNBC');

        public function __construct()
        {

            if (in_array(get_woocommerce_currency(), $this->supported_currencies)) {
                $this->id                 = 'tnbpay';
            }
            $this->method_title       = __('TNBPay', 'woo-tnbpay');
            $this->method_description = sprintf(__('TNBPay is a payment method on the TNB network'));
            // $this->has_fields         = true;
            $this->icon = 'https://www.thenewboston.com/static/media/thenewboston-primary.52b925da.svg';


            $this->title              = "TNB Pay";
            $this->supports = array('products');

            $this->init();
        }

        /**
         * Init your settings
         *
         * @access public
         * @return void
         */
        function init()
        {
            // Load the settings API
            $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
            $this->init_settings(); // This is part of the settings API. Loads settings you previously init.

            define("GREETING", "Welcome to W3Schools.com!");

            // Save settings in admin if you have any defined
            $this->description = $this->method_description;
            add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));

            add_action('woocommerce_thankyou_' . $this->id, array($this, 'thank_you_page'));
        }

        /**
         * Initialise Gateway Settings Form Fields
         */
        function init_form_fields()
        {
            $this->form_fields = array(
                'tnb_wallet_address' => array(
                    'title' => __('Store Address', 'woocommerce'),
                    'type' => 'text',
                    'description' => __('This is the address the user pays to.', 'woocommerce'),
                    'desc_tip'      => true
                ),
                'tnb_rate' => array(
                    'title' => __('Custom Rate', 'woocommerce'),
                    'type' => 'text',
                    'description' => __('This is the custom rate (integer only).', 'woocommerce'),
                    'desc_tip'      => true
                )
            );
        }


        /**
         * Process the payment.
         *
         * @param int $order_id  The order ID to update.
         */
        function process_payment($order_id)
        {
            global $woocommerce;
            $order = new WC_Order($order_id);

            if ($order->get_meta('tnb_memo') == '') {
                $memo = base64_encode(rand(100000000, 999999999));
                $order->update_meta_data('tnb_timer', strtotime('+5 minutes')*1000);
                $order->update_meta_data('tnb_memo', $memo);
                $order->add_order_note("Transaction memo added $memo");
                $order->save();
            }

            // Mark as on-hold (we're awaiting the cheque)
            $order->update_status('pending-payment', __('Awaiting TNB payment', 'woocommerce'));

            // Remove cart
            $woocommerce->cart->empty_cart();


            // Return thankyou redirect
            return array(
                'result' => 'success',
                'redirect' => $this->get_return_url($order)
            );
        }


        /**
         * Output the payment information onto the thank you page.
         *
         * @param  int $order_id  The order ID.
         */
        public function thank_you_page($order_id)
        {
            $order = wc_get_order($order_id);

            if (!$order->needs_payment()) {
                // $this->log( 'Order does not need payment' );
                return;
            }


            $rate = floatval($this->get_option('tnb_rate'));
            $meta = $order->get_meta('tnb_memo');
            $timer = $order->get_meta('tnb_timer');


            if($timer <= (strtotime("now")*1000)){
                //Check if time is passed already and cancel order
                $order->set_status('cancelled');
                $order->save();
                return;
            }

            if ('TNBC' === get_woocommerce_currency()) {
                $price = $order->get_total();
            } else {
                $price = $order->get_total() / $rate;
            }

            if($order->get_meta('tnb_split_payment') != ''){
                $price == $price - $order->get_meta('tnb_split_payment');
            }
            $store_address = $this->get_option('tnb_wallet_address');

            require plugin_dir_path(__FILE__) . 'inc/success_modal.php';

?>


            <script type="text/javascript">
                jQuery('#paymentVerify').click(function($) {

                    var data = {
                        'action': 'check_tnb_transaction',
                        'order_id': window.location.pathname.split('/')[4]
                    };

                    document.getElementById("tnbLoader").style.display = "block";

                    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                    jQuery.post(tnb_ajax_object.ajax_url, data, function(response) {
                        if (response == 1) {
                            alert('Payment Made');
                            location.reload();
                        }else if (response == 2) {
                            alert('You over paid the store owner will refund you or reach out to them');
                            location.reload();
                        }else if (response == 3) {
                            alert('You underpaid, please pay the balance. You timer has been reset');
                            location.reload();
                        }else {
                            alert('Payment not made yet please verify.');
                        }
                        console.log('Server:', response);
                        document.getElementById("tnbLoader").style.display = "none";
                    });
                });
            </script>

            <script>
                // Set the date we're counting down to
                var countDownDate = <?php echo $timer; ?>;

                // Update the count down every 1 second
                var x = setInterval(function() {

                    // Get today's date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;

                    // Time calculations for minutes and seconds
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Display the result in the element with id="demo"
                    document.getElementById("tnb_timer").innerHTML = minutes + "m " + seconds + "s ";

                    // If the count down is finished, write some text
                    if (distance < 0) {
                        clearInterval(x);
                        alert('Failed to pay within time limit, order canceled');
                        location.reload();
                        document.getElementById("tnb_timer").innerHTML = "EXPIRED";
                    }
                }, 1000);
            </script>

<?php
        }
    }
}
add_action('plugins_loaded', 'tnbpay_init');

add_action('wp_ajax_check_tnb_transaction', 'check_tnb_transaction');
add_action('wp_ajax_nopriv_check_tnb_transaction', 'check_tnb_transaction');

function check_tnb_transaction()
{
    global $wpdb; // this is how you get access to the database

    $value = $wpdb->get_results($wpdb->prepare(
        " SELECT option_value FROM {$wpdb->prefix}options WHERE option_name = 'woocommerce_tnbpay_settings' "
    ));
    $serialized_data = (object)unserialize($value[0]->option_value);

    $order = wc_get_order($_POST['order_id']);

    $rate = floatval($serialized_data->tnb_rate);
    $meta = $order->get_meta('tnb_memo');
    $store_address = $serialized_data->tnb_wallet_address;

    if ('TNBC' === get_woocommerce_currency()) {
        $price = $order->get_total();
    } else {
        $price = $order->get_total() / $rate;
    }


    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://54.183.16.194/bank_transactions?limit=100");
    // Receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($server_output, true);

    $response = $data['results'];

    foreach ($response as $key => $value) {
        if ($value['memo'] == $meta && $value['recipient'] == $store_address && $value['amount'] <=> $price && $value['amount'] > 0) {
            //Figure out which memo to send
            if($value['amount'] > $price){
                //User overpaid
                $order->add_order_note("User Overpaid: Please refund the user and amount of TNBC".($value['amount']-$price)." to this account number ".$value['block']['sender']);
                $order->set_status('completed');
                $order->save();
                echo (2);
                wp_die();
            }else if($value['amount'] < $price){
                //User underpaid || Split payment
                $order->add_order_note("User Underpaid: awaiting an additional payment of TNBC".($price-$value['amount'])." this account number was used: ".$value['block']['sender']);
                if($order->get_meta('tnb_split_payment') != '')
                {
                    $remainingSlitPayment = $price-$order->get_meta('tnb_split_payment');
                    if($order->get_meta('tnb_split_payment') == $remainingSlitPayment){
                        $order->add_order_note("Completed purchase with account number ".$value['block']['sender']);
                        $order->set_status('completed');
                        $order->save();
                        echo (1);
                        wp_die();
                    }else{
                        //Reset timer for split payment
                        $order->update_meta_data('tnb_timer', strtotime('+5 minutes')*1000);
                        $order->update_meta_data('tnb_split_payment', $order->get_meta('tnb_split_payment')+$value['amount']);
                    }
                }else{
                    //Initial split payment
                    $order->update_meta_data('tnb_timer', strtotime('+5 minutes')*1000);
                    $order->update_meta_data('tnb_split_payment', $value['amount']);
                }
                // $order->set_status('completed');
                $order->save();
                echo (3);
                wp_die();
            }else if($value['amount'] == $price){
                //User overpaid
                $order->add_order_note("Completed purchase with account number ".$value['block']['sender']);
                $order->set_status('completed');
                $order->save();
                echo (1);
                wp_die();
            }
            echo (0);
            wp_die();
        }else if($value['memo'] == $meta && $value['recipient'] == $store_address){
            //end the check quicker if amount is null
            echo (0);
            wp_die();
        }
    }
    // $order->set_status('canceled');
    // $order->save();
    echo (0);

    wp_die(); // this is required to terminate immediately and return a proper response
}


function my_enqueue()
{
    // wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
    wp_enqueue_script('boot1', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array('jquery'), '', true);
    wp_enqueue_script('boot2', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'), '', true);
    wp_enqueue_script('boot3', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array('jquery'), '', true);

    wp_enqueue_script('ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery'));

    wp_localize_script(
        'ajax-script',
        'tnb_ajax_object',
        array('ajax_url' => admin_url('admin-ajax.php'))
    );
}
add_action('wp_enqueue_scripts', 'my_enqueue');

function add_your_gateway_class($methods)
{
    $methods[] = 'WC_Gateway_Your_Gateway';
    return $methods;
}

add_filter('woocommerce_payment_gateways', 'add_your_gateway_class');


/**
 * Add Settings link to the plugin entry in the plugins menu.
 *
 * @param array $links Plugin action links.
 *
 * @return array
 **/
function tnbpay_plugin_action_links($links)
{

    $settings_link = array(
        'settings' => '<a href="' . admin_url('admin.php?page=wc-settings&tab=checkout&section=tnbpay') . '" title="' . __('View TNBPay WooCommerce Settings', 'woo-tnbpay') . '">' . __('Settings', 'woo-tnbpay') . '</a>',
    );

    return array_merge($settings_link, $links);
}

/**
 * Custom currency and currency symbol
 */
add_filter('woocommerce_currencies', 'add_my_currency');

function add_my_currency($currencies)
{
    $currencies['TNBC'] = __('Tnbc', 'woocommerce');
    return $currencies;
}

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);

function add_my_currency_symbol($currency_symbol, $currency)
{
    switch ($currency) {
        case 'TNBC':
            $currency_symbol = 'TNBC';
            break;
    }
    return $currency_symbol;
}
