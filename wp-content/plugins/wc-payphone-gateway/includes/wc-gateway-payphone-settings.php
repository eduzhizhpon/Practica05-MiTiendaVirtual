<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handles settings retrieval from the settings API.
 */
class WC_Gateway_PayPhone_Settings {

    /**
     * Setting values from get_option.
     *
     * @var array
     */
    protected $_settings = array();

    /**
     * List of locales supported by PayPal.
     *
     * @var array
     */
    protected $_supported_locales = array(
        'en_GB',
        'en_US',
        'es_ES',
    );

    /**
     * Flag to indicate setting has been loaded from DB.
     *
     * @var bool
     */
    private $_is_setting_loaded = false;

    public function __set($key, $value) {
        if (array_key_exists($key, $this->_settings)) {
            $this->_settings[$key] = $value;
        }
    }

    public function __get($key) {
        if (array_key_exists($key, $this->_settings)) {
            return $this->_settings[$key];
        }
        return null;
    }

    public function __isset($key) {
        return array_key_exists($key, $this->_settings);
    }

    public function __construct() {
        $this->load();
    }

    /**
     * Load settings from DB.
     *
     * @since 1.2.0
     *
     * @param bool $force_reload Force reload settings
     *
     * @return WC_Gateway_PPEC_Settings Instance of WC_Gateway_PPEC_Settings
     */
    public function load($force_reload = false) {
        if ($this->_is_setting_loaded && !$force_reload) {
            return $this;
        }
        $this->_settings = (array) get_option('woocommerce_payphone_settings', array());
        $this->_is_setting_loaded = true;
        return $this;
    }

    /**
     * Load settings from DB.
     *
     * @deprecated
     */
    public function load_settings($force_reload = false) {
        _deprecated_function(__METHOD__, '1.2.0', 'WC_Gateway_PPEC_Settings::load');
        return $this->load($force_reload);
    }

    /**
     * Save current settings.
     *
     * @since 1.2.0
     */
    public function save() {
        update_option('woocommerce_payphone_settings', $this->_settings);
    }

    /**
     * Get API credentials for live envionment.
     *
     * @return WC_Gateway_PPEC_Client_Credential_Signature|WC_Gateway_PPEC_Client_Credential_Certificate
     */
    public function get_live_api_credentials() {
        return $this->token;
    }

    /**
     * Get API credentials for sandbox envionment.
     *
     * @return WC_Gateway_PPEC_Client_Credential_Signature|WC_Gateway_PPEC_Client_Credential_Certificate
     */
    public function get_sandbox_api_credentials() {
        return $this->test_token;
    }

    /**
     * Get API credentials for the current envionment.
     *
     * @return object
     */
    public function get_active_api_credentials() {
        //return 'no' === $this->test_mode ? $this->get_live_api_credentials() : $this->get_sandbox_api_credentials();
        return $this->get_live_api_credentials();
    }

    /**
     * Get PayPal redirect URL.
     *
     * @param string $token  Token
     * @param bool   $commit If set to true, 'useraction' parameter will be set
     *                       to 'commit' which makes PayPal sets the button text
     *                       to **Pay Now** ont the PayPal _Review your information_
     *                       page.
     * @param bool   $ppc    Whether to use PayPal credit.
     *
     * @return string PayPal redirect URL
     */
    public function get_payphone_redirect_url() {
        $url = 'https://pay.payphonetodoesposible.com';

//        if ('no' !== $this->test_mode) {
//            $url .= 'pay-cert.';
//        }else{
//            $url .= 'pay.';
//        }
//        
//        if ('no' !== $this->test_mode) {
//            $url .= 'payphone.com.ec';
//        }else{
//            $url .= 'payphonetodoesposible.com';
//        }

        

        return $url;
    }

    /**
     * Is PPEC enabled.
     *
     * @return bool
     */
    public function is_enabled() {
        return 'yes' === $this->enabled;
    }

    /**
     * Is logging enabled.
     *
     * @return bool
     */
    public function is_logging_enabled() {
        return 'yes' === $this->debug;
    }

    /**
     * Get payment action from setting.
     *
     * @return string
     */
    public function get_paymentaction() {
        return 'authorization' === $this->paymentaction ? 'authorization' : 'sale';
    }

    /**
     * Get active environment from setting.
     *
     * @return string
     */
    public function get_environment() {
        return 'sandbox' === $this->environment ? 'sandbox' : 'live';
    }

    /**
     * Get locale for PayPhone.
     *
     * @return string
     */
    public function get_payphone_locale() {
        $locale = get_locale();
        if (!in_array($locale, $this->_supported_locales)) {
            $locale = 'en_US';
        }
        return $locale;
    }

    /**
     * Get brand name form settings.
     *
     * Default to site's name if brand_name in settings empty.
     *
     * @since 1.2.0
     *
     * @return string
     */
    public function get_brand_name() {
        $brand_name = $this->brand_name ? $this->brand_name : get_bloginfo('name', 'display');

        /**
         * Character length and limitations for this parameter is 127 single-byte
         * alphanumeric characters.
         *
         * @see https://developer.paypal.com/docs/classic/api/merchant/SetExpressCheckout_API_Operation_NVP/
         */
        if (!empty($brand_name)) {
            $brand_name = substr($brand_name, 0, 127);
        }

        /**
         * Filters the brand name in PayPal hosted checkout pages.
         *
         * @since 1.2.0
         *
         * @param string Brand name
         */
        return apply_filters('woocommerce_paypal_express_checkout_get_brand_name', $brand_name);
    }
}
