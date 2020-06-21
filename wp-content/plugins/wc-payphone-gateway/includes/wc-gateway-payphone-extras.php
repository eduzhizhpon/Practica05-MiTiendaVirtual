<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class WC_Gateway_PayPhone_Extras {

    public function __construct() {

        add_action('wp_ajax_update_payphone_status', array($this, 'update_payphone_status'));
        add_filter('woocommerce_admin_order_actions', array($this, 'add_update_order_actions_button'), 10, 2);
        add_action('woocommerce_cancel_unpaid_orders', array($this, 'get_payphone_result_schedule'), 1, 0);
    }

    function update_payphone_status() {
        if (!wp_verify_nonce($_REQUEST['_wpnonce'], "update_payphone_nonce")) {
            exit("No naughty business please");
        }

        $order_id = $_REQUEST['order_id'];

        $order = wc_get_order($order_id);
        $client_tx_id = get_post_meta($order_id, 'client_tx_id', TRUE);

        $this->get_tx_status($client_tx_id, $order);

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode('success');
            echo $result;
        } else {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }

        die();
    }

    function add_update_order_actions_button($actions, $order) {
        wp_enqueue_style('PayPhoneStyle', CSSDIR . 'payphone_style.css');
        //payphone
        $method = $order->get_payment_method();
        if ($order->has_status(array('pending')) && $method == 'payphone') {
            $actions['update'] = array(
                'url' => wp_nonce_url(admin_url('admin-ajax.php?action=update_payphone_status&order_id=' . $order->get_id()), 'update_payphone_nonce'),
                'name' => __('Verify transaction', 'payphone'),
                'action' => "pp_refresh", // setting "view" for proper button CSS
            );
        }

        return $actions;
    }

    /*
     * Ejecuta esta tarea al correr el cron de woocommerce
     * Se configura por los ajustes de inventario
     * */

    function get_payphone_result_schedule() {
        $held_duration = get_option('woocommerce_hold_stock_minutes');

        try {
            global $wpdb;
            write_log('-----get_payphone_result_schedule start------');

            if ($held_duration < 1 || get_option('woocommerce_manage_stock') != 'yes') {
                $held_duration = 1;
            }

            $date = date("Y-m-d H:i:s", strtotime('-' . absint($held_duration) . ' MINUTES', current_time('timestamp')));

            $unpaid_orders = $wpdb->get_col($wpdb->prepare("
		SELECT posts.ID
		FROM {$wpdb->posts} AS posts
		WHERE 	posts.post_type   IN ('" . implode("','", wc_get_order_types()) . "')
		AND 	posts.post_status = 'wc-pending'
		AND 	posts.post_modified < %s", $date));
            write_log($unpaid_orders);
            if ($unpaid_orders) {
                foreach ($unpaid_orders as $unpaid_order) {
                    $order = wc_get_order($unpaid_order);
                    $client_tx_id = get_post_meta($unpaid_order, 'client_tx_id', TRUE);

                    $this->get_tx_status($client_tx_id, $order);
                }
            }
            write_log('-----get_payphone_result_schedule finish------');
            wp_clear_scheduled_hook('woocommerce_cancel_unpaid_orders');
            wp_schedule_single_event(time() + ( absint($held_duration) * 60 ), 'woocommerce_cancel_unpaid_orders');
        } catch (Exception $exc) {
            write_log($exc->getTraceAsString());
            wp_clear_scheduled_hook('woocommerce_cancel_unpaid_orders');
            wp_schedule_single_event(time() + ( absint($held_duration) * 60 ), 'woocommerce_cancel_unpaid_orders');
        }
    }

    /**
     * Obtiene el estado de una transaccion 
     * @global type $woocommerce
     * @param type $client_tx_id
     * @param type $order
     */
    /*
     * Pending payment – Order received (unpaid)
     * Failed – Payment failed or was declined (unpaid). Note that this status may not show immediately and instead show as Pending until verified (i.e., PayPal)
     * Processing – Payment received and stock has been reduced – the order is awaiting fulfillment. All product orders require processing, except those for Digital/Downloadable products.
     * Completed – Order fulfilled and complete – requires no further action
     * On-Hold – Awaiting payment – stock is reduced, but you need to confirm payment
     * Cancelled – Cancelled by an admin or the customer – no further action required
     * Refunded – Refunded by an admin – no further action required
     */
    function get_tx_status($client_tx_id, $order) {

        try {
            //write_log('-----get_tx_status start------');
            global $woocommerce;

            $url = wc_gateway_payphone()->settings->get_payphone_redirect_url();
            $token = wc_gateway_payphone()->settings->get_active_api_credentials();

            $response = $this->statusCall($client_tx_id, $token, $url);
            $sale = $response[0];

            if ($sale->statusCode == 3) {
                $order->payment_complete();
                update_post_meta($order->get_id(), __('Authorization Code', 'payphone-woocommerce'), $sale->authorizationCode);
                update_post_meta($order->get_id(), __('Card Brand', 'payphone'), $sale->cardBrand);
                update_post_meta($order->get_id(), 'payphone_tx_id', $sale->transactionId);
                do_action('wc_gateway_payphone_pay_approved', $order->get_id(), $order);
                $woocommerce->cart->empty_cart();
            } else if ($sale->statusCode == 2) {
                $order->update_status('cancelled', sprintf(__('Payment denied. Reasons: %s', 'payphone'), ( $sale->message)));
                update_post_meta($order->get_id(), __('Transaction Status', 'payphone'), $sale->transactionStatus);
                update_post_meta($order->get_id(), __('Error Message', 'payphone'), $sale->message);
                update_post_meta($order->get_id(), 'payphone_tx_id', $sale->transactionId);
                do_action('wc_gateway_payphone_pay_cancel', $order->get_id(), $order);
            } else if ($sale->statusCode == 1) {
                $order->update_status('pending', sprintf(__('Pending payment, message: %s', 'payphone'), ( $sale->message)));
                do_action('wc_gateway_payphone_pay_pending', $order->get_id(), $order);
            }
        } catch (WC_PayPhone_Exception $exc) {
            //write_log(json_encode($exc->ErrorList));
            $order->update_status('cancelled', sprintf(__('Failed order: %s', 'payphone'), ( $exc->get_error()->message)));
        } catch (Exception $exc) {
            //write_log(json_encode($exc->getMessage()));
            $order->update_status('failed', sprintf(__('Failed order: %s', 'payphone'), ( $exc->getMessage())));
        }
    }

    private function statusCall($client_tx_id, $token, $url) {
        $headers = array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        );

        $args = array(
                  'headers' => $headers
        );
        $response = wp_remote_get( $url . "/api/sale/client/" . $client_tx_id, $args );
        $obj_response = json_decode($response['body']);
        $info = wp_remote_retrieve_response_code( $response );
        $statusCode = $info;
        $tipo = get_class($response);
        if (strcmp($tipo, 'WP_Error') !== 0)
        {  
            if ($statusCode == 200) {
                return $obj_response;
            }
            else {
                throw new WC_PayPhone_Exception($obj_response->message, $statusCode, $obj_response);
            }
        }
        else {
            throw new Exception(__('An error has ocurred', 'payphone'));
        }
    }
}
