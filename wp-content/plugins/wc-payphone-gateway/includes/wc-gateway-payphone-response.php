<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once(dirname(wc_gateway_payphone()->file) . '/includes/exceptions/wc-payphone-exception.php');

class WC_Gateway_PayPhone_Response {

    public $order_id;
    public $transaction_id;
    public $token;
    public $url;
    public $contador;

    public function __construct($order_id, $transaction_id, $token, $url) {
        $this->order_id = $order_id;
        $this->transaction_id = $transaction_id;
        $this->token = $token;
        $this->url = $url;
        $this->contador = 0;
    }

    public function confirm() {
        global $woocommerce;
        $order = new WC_Order($this->order_id);           
        
        $result = $this->confirm_call($this->contador);
        
        if ($result == null) {
            $order->update_status('cancelled', __('No valid response was obtained', 'payphone'));
            wc_add_notice(__('Payment error:', 'payphone') . __("Url not found, payment with PayPhone will be automatically reversed, contact the administrator", 'payphone'), 'error');
        } else {
            if ($order->has_status(array('processing', 'completed'))) {
                //wc_gateway_ppec_log('Aborting, Order #' . $order_id . ' is already complete.');
                return $result;
            }

            if ($result->statusCode == 2) {
                $order->update_status('cancelled', __($result->message, 'payphone'));
                wc_add_notice(__('Payment error:', 'payphone') . $result->message, 'error');                
            }

            if ($result->statusCode == 3) {
                $order->payment_complete();
                wc_add_notice(__('Payment result:', 'payphone') . $result->transactionStatus, 'success');
                $woocommerce->cart->empty_cart();                                
            }

            return $result;
        }
        return $result;
    }

    private function confirm_call($cont) {
        $payphone_args = $this->get_confirm_args();
        $json = json_encode($payphone_args);
        $headers = array(
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
            'Content-Length' => strlen($json)
        );
        
        $args = array(
                  'body' => $json,
                  'timeout' => '5',
                  'redirection' => '5',
                  'httpversion' => '1.0',
                  'blocking' => true,
                  'headers' => $headers
        );
        $response = wp_remote_post( $this->url . "/api/button/V2/Confirm", $args );
        $info = wp_remote_retrieve_response_code( $response );
        if (is_array($response)){
            reset($response);
            $tipo = get_class(current($response));
        }else{
            $tipo = get_class($response);
        }
        if (strcmp($tipo, 'WP_Error') !== 0)
        {
            $obj_response = json_decode($response['body']);
            if ($info == 200 && $obj_response != null) {
                return json_decode($response['body']);
            }

            $cont = $cont + 1;
            if ($cont <= 1) {
                return $this->confirm_call($cont);
            }
            
            if ($obj_response == null)
            {
                throw new WC_PayPhone_Exception("Url not found", $info['http_code'], $obj_response);
            }

            if ($obj_response->message) {
                throw new WC_PayPhone_Exception($obj_response->message, $info['http_code'], $obj_response);
            }
        }
        else
        {
            throw new Exception(__('The request could not be completed', 'payphone'));
        }
        //throw new Exception(__('The request could not be completed', 'payphone'));
    }

    private function get_confirm_args() {
        $args = new stdClass();

        $args->id = $this->transaction_id;
        $args->clientTxId = $this->order_id;
        return $args;
    }
}
