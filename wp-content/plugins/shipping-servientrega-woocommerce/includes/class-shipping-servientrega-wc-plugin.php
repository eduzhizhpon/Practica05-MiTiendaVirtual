<?php
/**
 * Created by PhpStorm.
 * User: smp
 * Date: 26/03/19
 * Time: 05:47 PM
 */

class Shipping_Servientrega_WC_Plugin
{

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
     * assets plugin.
     *
     * @var string
     */
    public $assets;
    /**
     * Absolute path to plugin includes dir.
     *
     * @var string
     */
    public $includes_path;
    /**
     * Absolute path to plugin lib dir
     *
     * @var string
     */
    public $lib_path;
    /**
     * @var bool
     */
    private $_bootstrapped = false;

    public function __construct($file, $version)
    {
        $this->file = $file;
        $this->version = $version;

        $this->plugin_path   = trailingslashit( plugin_dir_path( $this->file ) );
        $this->plugin_url    = trailingslashit( plugin_dir_url( $this->file ) );
        $this->assets = $this->plugin_url . trailingslashit('assets');
        $this->includes_path = $this->plugin_path . trailingslashit( 'includes' );
        $this->lib_path = $this->plugin_path . trailingslashit( 'lib' );
    }

    public function run_servientrega_wc()
    {
        try{
            if ($this->_bootstrapped){
                throw new Exception( 'Servientrega shipping can only be called once');
            }
            $this->_run();
            $this->_bootstrapped = true;
        }catch (Exception $e){
            if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
                add_action('admin_notices', function() use($e) {
                    shipping_servientrega_wc_ss_notices($e->getMessage());
                });
            }
        }
    }

    protected function _run()
    {
        if (!class_exists('\WebService\Servientrega'))
            require_once ($this->lib_path . 'servientrega-webservice-php/src/WebService.php');
        require_once ($this->includes_path . 'class-method-shipping-servientrega-wc.php');
        require_once ($this->includes_path . 'class-shipping-servientrega-wc.php');
    
        add_filter( 'plugin_action_links_' . plugin_basename( $this->file), array( $this, 'plugin_action_links' ) );
        add_filter( 'woocommerce_shipping_methods', array( $this, 'shipping_servientrega_wc_add_method') );
        add_filter( 'woocommerce_billing_fields', array($this, 'custom_woocommerce_billing_fields'));
        add_filter( 'manage_edit-shop_order_columns', array($this, 'print_guide'), 20 );
        add_action( 'woocommerce_order_status_changed', array('Shipping_Servientrega_WC', 'generate_guide'), 20, 4 );
        add_action( 'woocommerce_process_product_meta', array($this, 'save_custom_shipping_option_to_products') );
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts_admin') );
        add_action( 'wp_ajax_servientrega_generate_sticker', array($this, 'servientrega_generate_sticker'));
        add_action( 'manage_shop_order_posts_custom_column', array($this, 'content_column_print_guide'), 2 );
    }

    public function plugin_action_links($links)
    {
        $plugin_links = array();
        $plugin_links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=shipping&section=shipping_servientrega_wc') . '">' . 'Configuraciones' . '</a>';
        $plugin_links[] = '<a target="_blank" href="https://shop.saulmoralespa.com/shipping-servientrega-woocommerce/">' . 'Documentación' . '</a>';
        return array_merge( $plugin_links, $links );
    }

    public function shipping_servientrega_wc_add_method( $methods )
    {
        $methods['shipping_servientrega_wc'] = 'WC_Shipping_Method_Shipping_Servientrega_WC';
        return $methods;
    }

    public function log($message)
    {
        if (is_array($message) || is_object($message))
            $message = print_r($message, true);
        $logger = new WC_Logger();
        $logger->add('shipping-servientrega', $message);
    }

    public function DB_matriz()
    {
        try{
            $json = file_get_contents($this->lib_path . 'shipping_servientrega_matriz.json');
            $data = json_decode($json, true);
            $rows = $data[0]['data'];

            global $wpdb;
            $table_name = $wpdb->prefix . 'shipping_servientrega_matriz';

            if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name ){
                $sql = "DELETE FROM $table_name";
                $wpdb->query($sql);
            }

           self::create_table();

            foreach ($rows as $column){
                $wpdb->insert(
                    $table_name,
                    $column
                );
            }
        }catch (\Exception $exception){
            $this->log($exception->getMessage());
        }
    }

    public static function add_custom_shipping_option_to_products()
    {
        global $post;

        woocommerce_wp_text_input( [
            'id'          => '_shipping_custom_price_product_smp',
            'label'       => __( 'Valor declarado del producto'),
            'placeholder' => 'Valor declarado del envío',
            'desc_tip'    => true,
            'description' => __( 'El valor que desea declarar para el envío'),
            'value'       => get_post_meta( $post->ID, '_shipping_custom_price_product_smp', true )
        ] );
    }

    public function save_custom_shipping_option_to_products($post_id)
    {
        $custom_price_product = sanitize_text_field($_POST['_shipping_custom_price_product_smp']);
        if( isset( $custom_price_product ) )
            update_post_meta( $post_id, '_shipping_custom_price_product_smp', esc_attr( $custom_price_product ) );
    }

    public static function create_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'shipping_servientrega_matriz';

        if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name )
            return;

        $sql = "CREATE TABLE $table_name (
		id_ciudad_destino INT NOT NULL,
		tiempo_entrega_comercial FLOAT(2,0) NOT NULL,
		tipo_trayecto VARCHAR(30) NOT NULL,
		restriccion_fisica VARCHAR(60),
		PRIMARY KEY  (id_ciudad_destino)
	) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }

    public function enqueue_scripts_admin($hook)
    {
        if ($hook === 'woocommerce_page_wc-settings' || $hook === 'edit.php'){
            wp_enqueue_script( 'shipping_servientrega_wc_ss', $this->plugin_url. 'assets/js/config.js', array( 'jquery' ), $this->version, true );
            wp_enqueue_script( 'shipping_servientrega_wc_ss_sweet_alert', $this->plugin_url. 'assets/js/sweetalert2.js', array( 'jquery' ), $this->version, true );
        }
    }

    public function custom_woocommerce_billing_fields($fields)
    {
        $wc_main_settings = get_option('woocommerce_servientrega_shipping_settings');
        $num_recaudo = isset($wc_main_settings['servientrega_num_recaudo']) ? $wc_main_settings['servientrega_num_recaudo'] : false;

        if ($num_recaudo && !isset($fields['billing_identificacion'])){
            $fields['billing_identificacion'] = array(
                'label' => __('Número de cédula'),
                'placeholder' => _x('Su número de cédula....', 'placeholder'),
                'required' => true,
                'clear' => false,
                'type' => 'number'
            );
        }

        return $fields;

    }

    public function print_guide($columns)
    {
        $wc_main_settings = get_option('woocommerce_servientrega_shipping_settings');
        $wc_main_settings['servientrega_license'];

        if(isset($wc_main_settings['servientrega_license']) && !empty($wc_main_settings['servientrega_license']))
            $columns['generate_sticker'] = 'Generar Sticker Servientrega';
        return $columns;
    }

    public function content_column_print_guide($column)
    {
        global $post;

        $order = new WC_Order($post->ID);

        $order_id_origin = $order->get_parent_id() > 0 ? $order->get_parent_id() : $order->get_id();

        $guide_servientrega = get_post_meta($order_id_origin, 'guide_servientrega', true);

        if(!empty($guide_servientrega) && $column == 'generate_sticker' ){
            echo "<button class='button-secondary generate_sticker' data-guide='".$guide_servientrega."' data-nonce='".wp_create_nonce( "shipping_servientrega_generate_sticker") ."'>Generar stickers</button>";
        }
    }

    public function servientrega_generate_sticker()
    {
        if ( ! wp_verify_nonce(  $_REQUEST['nonce'], 'shipping_servientrega_generate_sticker' ) )
            return;

        $guide_number = $_REQUEST['guide_number'];
        $sticker = Shipping_Servientrega_WC::generate_stickers($guide_number);

        $upload_dir = wp_upload_dir();
        $dir = $upload_dir['basedir'] . '/servientrega-stickers/';

        if (!is_dir($dir))
            mkdir($dir,0755);

        if(isset($sticker->GenerarGuiaStickerResult) && !$sticker->GenerarGuiaStickerResult)
            wp_send_json(['status' => false, 'message' => 'Se ha alacanzado el limite de generación de stcikers']);

        if (empty($sticker))
            wp_send_json(['status' => false, 'message' => 'Ha surgido un error interno al intentar generar los stickers']);

        $sticker_file = file_put_contents("{$dir}$guide_number.pdf", $sticker->bytesReport);

        if ($sticker_file){
            $guide_number_url = $upload_dir['baseurl'] . '/servientrega-stickers/' . "$guide_number.pdf";
            wp_send_json(['status' => true, 'url' => $guide_number_url]);
        }
    }
}