<?php

$wc_main_settings = [];
$wc_main_settings = get_option('woocommerce_servientrega_shipping_settings');

if(isset($_POST['shipping_servientrega_wc_ss_license']))
{
    if (!wp_verify_nonce( $_POST['shipping_servientrega_wc_ss_license'], 'shipping_servientrega_wc_ss_license' ))
        return;

    $wc_main_settings['servientrega_license'] = $_POST['servientrega_license'];

    if (!empty($wc_main_settings['servientrega_license'])){

        $secret_key = '5c88321cdb0dc9.43606608';

        $api_params = array(
            'slm_action' => 'slm_check',
            'secret_key' => $secret_key,
            'license_key' => $wc_main_settings['servientrega_license'],
        );

        $siteGet = 'https://shop.saulmoralespa.com';

        $response = wp_remote_get(
            add_query_arg($api_params, $siteGet),
            array('timeout' => 60,
                'sslverify' => true
            )
        );

        if (is_wp_error($response)){
            shipping_servientrega_wc_ss()->log($response->get_error_message());
            exit();
        }

        $data = json_decode(wp_remote_retrieve_body($response));

        //max_allowed_domains

        //registered_domains  array() registered_domain

        if ($data->result === 'error'){
            $wc_main_settings['servientrega_license'] = '';
        }elseif ($data->result === 'success' && $data->status === 'pending'){
            $api_params = array(
                'slm_action' => 'slm_activate',
                'secret_key' => $secret_key,
                'license_key' => $wc_main_settings['servientrega_license'],
                'registered_domain' => get_bloginfo( 'url' ),
                'item_reference' => '',
            );

            $query = esc_url_raw(add_query_arg($api_params, $siteGet));
            $response = wp_remote_get($query,
                array('timeout' => 60,
                    'sslverify' => true
                )
            );

            if (is_wp_error($response)){
                shipping_servientrega_wc_ss()->log( $response->get_error_message() );
                exit();
            }

            $data = json_decode(wp_remote_retrieve_body($response));

            if($data->result === 'error')
                $wc_main_settings['servientrega_license'] = '';

        }

        update_option('woocommerce_servientrega_shipping_settings',$wc_main_settings);

        header("Refresh:0");

    }
}

$htmlLicense = '<table>
    <tr valign="top">
         <td style="width:25%;padding-top:40px;font-weight:bold;">
            <label for="servientrega_license">' .  __('Licencia') . '</label><span class="woocommerce-help-tip" data-tip="' . __('La licencia que se adquirió para el uso del plugin completo') . '"></span>
         </td>
         <td scope="row" class="titledesc" style="display:block;margin-bottom:20px;margin-top:3px;padding-top:40px;">
            <fieldset style="padding:3px;">
                <input id="servientrega_license" name="servientrega_license" type="password"';
$htmlLicense .= 'value="';
$value = (isset($wc_main_settings['servientrega_license'])) ? $wc_main_settings['servientrega_license'] : '';
$htmlLicense .= "$value\">";
$htmlLicense .= '</fieldset>
         </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center;">' .
    wp_nonce_field( "shipping_servientrega_wc_ss_license", "shipping_servientrega_wc_ss_license" ) . '
            <button type="submit" class="button button-primary">' . __('Guardar cambios') . '</button>
        </td>
    </tr>
    ';
return $htmlLicense;
