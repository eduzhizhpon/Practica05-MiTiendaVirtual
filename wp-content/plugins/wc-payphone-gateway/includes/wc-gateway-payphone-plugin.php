<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WC_Gateway_PayPhone_Plugin {

    const ALREADY_BOOTSTRAPED = 1;
    const DEPENDENCIES_UNSATISFIED = 2;

    /**
     * Filepath of main plugin file.
     *
     * @var string
     */
    public $file;

    /**
     * Plugin version.
     *
     * @var string
     */
    public $version;

    /**
     * Absolute plugin path.
     *
     * @var string
     */
    public $plugin_path;

    /**
     * Absolute plugin URL.
     *
     * @var string
     */
    public $plugin_url;

    /**
     * Absolute path to plugin includes dir.
     *
     * @var string
     */
    public $includes_path;

    /**
     * Flag to indicate the plugin has been boostrapped.
     *
     * @var bool
     */
    private $_bootstrapped = false;

    /**
     * Instance of WC_Gateway_PPEC_Settings.
     *
     * @var WC_Gateway_PPEC_Settings
     */
    public $settings;
    public $settings2;
    public $aux;

    public function __construct($file, $version) {
        $this->file = $file;
        $this->version = $version;

        // Path.
        $this->plugin_path = trailingslashit(plugin_dir_path($this->file));
        $this->plugin_url = trailingslashit(plugin_dir_url($this->file));
        $this->includes_path = $this->plugin_path . trailingslashit('includes');

        // Updates
        if (version_compare($version, get_option('wc_payphone_version'), '>')) {
            $this->run_updater($version);
        }

        if (!defined('IMGDIR')) {
            define('IMGDIR', WP_PLUGIN_URL . "/" . plugin_basename(dirname($this->file)) . '/assets/img/');
        }
        
        if (!defined('CSSDIR')) {
            define('CSSDIR', WP_PLUGIN_URL . "/" . plugin_basename(dirname($this->file)) . '/assets/css/');
        }
        
        if (!defined('APIDIR')) {
            define('APIDIR', WP_PLUGIN_URL . "/" . plugin_basename(dirname($this->file)) . '/PayPhoneApi/');
        }
        //Defined constants vars
        
        
        
    }

    /**
     * Handle updates.
     * @param  [type] $new_version [description]
     * @return [type]              [description]
     */
    private function run_updater($new_version) {
        // Map old settings to settings API
        if (get_option('pp_woo_enabled')) {
            $settings_array = (array) get_option('woocommerce_payphone_settings', array());
            $settings_array['enabled'] = get_option('pp_woo_enabled') ? 'yes' : 'no';
            $settings_array['logo_image_url'] = get_option('pp_woo_logoImageUrl');
            $settings_array['paymentAction'] = strtolower(get_option('pp_woo_paymentAction', 'sale'));
            $settings_array['subtotal_mismatch_behavior'] = 'addLineItem' === get_option('pp_woo_subtotalMismatchBehavior') ? 'add' : 'drop';
            $settings_array['environment'] = get_option('pp_woo_environment');
            $settings_array['button_size'] = get_option('pp_woo_button_size');
            $settings_array['instant_payments'] = get_option('pp_woo_blockEChecks');
            $settings_array['require_billing'] = get_option('pp_woo_requireBillingAddress');
            $settings_array['debug'] = get_option('pp_woo_logging_enabled') ? 'yes' : 'no';

            // Make sure button size is correct.
            if (!in_array($settings_array['button_size'], array('small', 'medium', 'large'))) {
                $settings_array['button_size'] = 'medium';
            }

            // Load client classes before `is_a` check on credentials instance.
            $this->_load_client();

            $live = get_option('pp_woo_liveApiCredentials');
            $sandbox = get_option('pp_woo_sandboxApiCredentials');

            update_option('woocommerce_payphone_settings', $settings_array);
            delete_option('pp_woo_enabled');
        }

        update_option('wc_payphone_version', $new_version);
    }

    /**
     * Maybe run the plugin.
     */
    public function maybe_run() {
        register_activation_hook($this->file, array($this, 'activate'));

        add_action('plugins_loaded', array($this, 'bootstrap'));
        add_action('init', array($this, 'load_plugin_textdomain'));        

        add_filter('plugin_action_links_' . plugin_basename($this->file), array($this, 'plugin_action_links'));
        add_action('wp_ajax_pp_dismiss_notice_message', array($this, 'ajax_dismiss_notice'));
    }

    public function bootstrap() {
        try {
            if ($this->_bootstrapped) {
                throw new Exception(__('%s in WooCommerce Gateway PayPhone plugin can only be called once', 'payphone-woocommerce'), self::ALREADY_BOOTSTRAPED);
            }

            $this->_check_dependencies();
            $this->_run();

            $this->_bootstrapped = true;
            delete_option('wc_gateway_payphone_bootstrap_warning_message');
        } catch (Exception $e) {
            if (in_array($e->getCode(), array(self::ALREADY_BOOTSTRAPED, self::DEPENDENCIES_UNSATISFIED))) {
                update_option('wc_gateway_payphone_bootstrap_warning_message', $e->getMessage());
            }
            //Desactiva el plugin
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            deactivate_plugins($this->file);
            //Muestra la noticia con el error provocado
            add_action('admin_notices', array($this, 'show_bootstrap_warning'));
            //Elimina el mensaje de activado
            if (isset($_GET['activate'])) {
                unset($_GET['activate']);
            }
        }
    }

    /**
     * 
     */
    public function show_bootstrap_warning() {
        $dependencies_message = get_option('wc_gateway_payphone_bootstrap_warning_message', '');
        if (!empty($dependencies_message) && 'yes' !== get_option('wc_gateway_payphone_bootstrap_warning_message_dismissed', 'no')) {
            ?>
            <div class="notice notice-warning is-dismissible pp-dismiss-bootstrap-warning-message">
                <p>
                    <strong><?php echo esc_html($dependencies_message); ?></strong>
                </p>
            </div>
            <script>
                (function ($) {
                    $('.pp-dismiss-bootstrap-warning-message').on('click', '.notice-dismiss', function () {
                        jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
                            action: "pp_dismiss_notice_message",
                            dismiss_action: "pp_dismiss_bootstrap_warning_message",
                            nonce: "<?php echo esc_js(wp_create_nonce('pp_dismiss_notice')); ?>"
                        });
                    });
                })(jQuery);
            </script>
            <?php
        }
    }

    /**
     * AJAX handler for dismiss notice action.
     *
     * @since 1.4.7
     * @version 1.4.7
     */
    public function ajax_dismiss_notice() {
        if (empty($_POST['dismiss_action'])) {
            return;
        }

        check_ajax_referer('pp_dismiss_notice', 'nonce');
        switch ($_POST['dismiss_action']) {
            case 'pp_dismiss_bootstrap_warning_message':
                update_option('wc_gateway_payphone_bootstrap_warning_message_dismissed', 'yes');
                break;
        }
        wp_die();
    }

    /**
     * Check dependencies.
     *
     * @throws Exception
     */
    protected function _check_dependencies() {
        if (!function_exists('WC')) {
            throw new Exception(__('WooCommerce Gateway PayPhone requires WooCommerce to be activated', 'payphone-woocommerce'), self::DEPENDENCIES_UNSATISFIED);
        }

        if (!class_exists('WC_Payment_Gateway')) {
            throw new Exception(__('WooCommerce Gateway PayPhone requires WC_Payment_Gateway class', 'payphone-woocommerce'), self::DEPENDENCIES_UNSATISFIED);
        }

        if (version_compare(WC()->version, '2.5', '<')) {
            throw new Exception(__('WooCommerce Gateway PayPhone requires WooCommerce version 2.5 or greater', 'payphone-woocommerce'), self::DEPENDENCIES_UNSATISFIED);
        }

        if (!function_exists('curl_init')) {
            throw new Exception(__('WooCommerce Gateway PayPhone requires cURL to be installed on your server', 'payphone-woocommerce'), self::DEPENDENCIES_UNSATISFIED);
        }

        $openssl_warning = __('WooCommerce Gateway PayPhone requires OpenSSL >= 1.0.1 to be installed on your server', 'payphone-woocommerce');
        if (!defined('OPENSSL_VERSION_TEXT')) {
            throw new Exception($openssl_warning, self::DEPENDENCIES_UNSATISFIED);
        }

        preg_match('/^(?:Libre|Open)SSL ([\d.]+)/', OPENSSL_VERSION_TEXT, $matches);
        if (empty($matches[1])) {
            throw new Exception($openssl_warning, self::DEPENDENCIES_UNSATISFIED);
        }

        if (!version_compare($matches[1], '1.0.1', '>=')) {
            throw new Exception($openssl_warning, self::DEPENDENCIES_UNSATISFIED);
        }
    }

    /**
     * Run the plugin.
     */
    protected function _run() {
        //require_once( $this->includes_path . 'functions.php' );
        $this->_load_handlers();
    }

    /**
     * Callback for activation hook.
     */
    public function activate() {
        if (!isset($this->setings)) {
            require_once( $this->includes_path . 'wc-gateway-payphone-settings.php' );
            $settings = new WC_Gateway_PayPhone_Settings();
        } else {
            $settings = $this->settings;
        }
    }

    /**
     * Load handlers.
     */
    protected function _load_handlers() {
        // Load handlers.
        require_once( $this->includes_path . 'wc-gateway-payphone-settings.php' );
        require_once( $this->includes_path . 'wc-gateway-payphone-loader.php' );
        require_once ($this->includes_path . 'wc-gateway-payphone-extras.php');
        //require_once( $this->includes_path . 'wc-gateway-payphone-admin-handler.php' );

        $this->settings = new WC_Gateway_PayPhone_Settings();
        $this->gateway_loader = new WC_Gateway_PayPhone_Loader();
        $this->extras = new WC_Gateway_PayPhone_Extras();
        //$this->admin = new WC_Gateway_PPEC_Admin_Handler();
    }
    
    public function getSettings(){
         require_once($this->includes_path . 'wc-gateway-payphone-settings.php');
         $this->settings2 = new WC_Gateway_PayPhone_Settings();
         return $this->settings2;
    }
    

    public function load_plugin_textdomain() {
        load_plugin_textdomain('payphone', false, dirname(plugin_basename($this->file)) . "/languages");
    }

    /**
     * Add relevant links to plugins page.
     *
     * @since 1.2.0
     *
     * @param array $links Plugin action links
     *
     * @return array Plugin action links
     */
    public function plugin_action_links($links) {
        $plugin_links = array();

        if (function_exists('WC')) {
            $setting_url = $this->get_admin_setting_link();
            $plugin_links[] = '<a href="' . esc_url($setting_url) . '">' . esc_html__('Settings', 'payphone-woocommerce') . '</a>';
        }

        $plugin_links[] = '<a href="https://docs.livepayphone.com">' . esc_html__('Docs', 'payphone-woocommerce') . '</a>';

        return array_merge($plugin_links, $links);
    }

    /**
     * Link to settings screen.
     */
    public function get_admin_setting_link() {
        if (version_compare(WC()->version, '2.6', '>=')) {
            $section_slug = 'payphone';
        } else {
            $section_slug = strtolower('WC_Gateway_PayPhone');
        }
        return admin_url('admin.php?page=wc-settings&tab=checkout&section=' . $section_slug);
    }

    /**
     * Get pages for return page setting
     *
     * @access public
     * @return bool
     */
    public function get_pages($title = false, $indent = true) {
        $wp_pages = get_pages('sort_column=menu_order');
        $page_list = array();
        if ($title)
            $page_list[] = $title;
        foreach ($wp_pages as $page) {
            $prefix = '';
            // show indented child pages?
            if ($indent) {
                $has_parent = $page->post_parent;
                while ($has_parent) {
                    $prefix .= ' - ';
                    $next_page = get_page($has_parent);
                    $has_parent = $next_page->post_parent;
                }
            }
            // add to page list array array
            $page_list[$page->ID] = $prefix . $page->post_title;
        }
        return $page_list;
    }

}