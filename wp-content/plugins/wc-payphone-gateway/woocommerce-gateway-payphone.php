<?php

/*
  Plugin Name: WooCommerce - PayPhone Gateway
  Plugin URI: https://ecommerce.livepayphone.com/
  Description: PayPhone Payment Gateway for WooCommerce. Recibe pagos en internet mediante payphone!
  Version: 1.1.4
  Author: PAYPHONE.
  Author URI: https://livepayphone.com/
  License: GNU General Public License v3.0
  License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!defined('WC_GATEWAY_PAYPHONE_VERSION')) {
    define('WC_GATEWAY_PAYPHONE_VERSION', '1.0.0');
}

/**
 * Return instance of WC_Gateway_PayPhone_Plugin.
 *
 * @return WC_Gateway_PayPhone_Plugin
 */
function wc_gateway_payphone() {
    static $plugin;

    if (!isset($plugin)) {
        require_once( 'includes/wc-gateway-payphone-plugin.php' );

        $plugin = new WC_Gateway_PayPhone_Plugin(__FILE__, WC_GATEWAY_PAYPHONE_VERSION);
    }

    return $plugin;
}

wc_gateway_payphone()->maybe_run();

if (!function_exists('write_log')) {

    function write_log($log) {
        if (is_array($log) || is_object($log)) {
            error_log(print_r($log, true));
        } else {
            error_log($log);
        }
    }

}