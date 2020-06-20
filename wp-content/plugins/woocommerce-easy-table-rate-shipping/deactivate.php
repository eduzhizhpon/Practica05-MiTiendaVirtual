<?php
if(!class_exists('JEM_Table_Rate_Deactivate_Modal')) {

    class JEM_Table_Rate_Deactivate_Modal
    {

        public static $options;

        /* Email address to whom email is wil be send */
        public static $sendEmailTo = "simon@jem-products.com";

        public function __construct()
        {
            add_action('admin_footer', array($this, 'admin_footer'));

            /* List of options needs to show on Plugin Deactivate Popup */
            self::$options = array(
                array(
                    "title" => "I only needed the plugin for short period",
                    "has_input" => 0  // set has_input = 1, if you like to show input text on selected this value
                ), array(
                    "title" => "The plugin broke my site",
                    "has_input" => 0
                ), array(
                    "title" => "I no longer need the plugin",
                    "has_input" => 0
                ), array(
                    "title" => "I found a better plugin",
                    "has_input" => 1,
                    "placeholder" => __("What's the plugin's name?", 'JEM_DOMAIN')
                ), array(
                    "title" => "The plugin suddenly stop working",
                    "has_input" => 0
                ), array(
                    "title" => "It's a temporary deactivation, I'm debugging an issue",
                    "has_input" => 0
                ), array(
                    "title" => "Other",
                    "has_input" => 1,
                    "placeholder" => __("Reason", 'JEM_DOMAIN')
                )
            );

            add_action('wp_ajax_jem_table_rate_plugin_deactivate', array($this, 'jem_table_rate_plugin_deactivate'));
        }

        public function admin_footer()
        {
            global $pagenow;
            if ('plugins.php' === $pagenow) {
                $options = self::$options;
                include_once dirname(__FILE__) . "/plugin-deactivate-modal.php";
            }
        }

        public function jem_table_rate_plugin_deactivate()
        {
            global $current_user;
            $postData = $_POST;
            $errorCounter = 0;
            $response = array();
            $response['status'] = 0;
            $response['message'] = "";
            $response['valid'] = 1;
            if (!isset($postData['reason']) || empty($postData['reason'])) {
                $errorCounter++;
                $response['message'] = "Please provide reason";
            } else if (!isset($postData['nonce']) || empty($postData['nonce'])) {
                $response['message'] = "Your request is not valid";
                $errorCounter++;
                $response['valid'] = 0;
            } else {
                $nonce = $postData['nonce'];
                /* checking for nonce */
                if (!wp_verify_nonce($nonce, 'jem_table_rate_deactivate_nonce')) {
                    $response['message'] = "Your request is not valid";
                    $errorCounter++;
                    $response['valid'] = 0;
                }
            }
            if ($errorCounter == 0) {
                $reason = $postData['reason'];
                $options = self::$options;
                $reason_description = "";
                if ($options[$reason]['has_input'] == 1) {
                    $reason_description = $postData['reason_description'];
                }
                $reason = $options[$reason]['title'];
                $email = get_option('admin_email');
                $domain = site_url();
                $user_name = $current_user->first_name . " " . $current_user->last_name;
                $subject = "Woocommerce Table Rate Shipping was removed from {$domain}";
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $headers .= 'From: ' . $user_name . ' <' . $email . '>' . PHP_EOL;
                $headers .= 'Reply-To: ' . $user_name . ' <' . $email . '>' . PHP_EOL;
                $headers .= 'X-Mailer: PHP/' . phpversion();
                ob_start();
                ?>
                <table border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <th align="left">Plugin</th>
                        <td>Woocommerce Table Rate Shipping</td>
                    </tr>
                    <tr>
                        <th align="left">Domain</th>
                        <td><?php echo $domain ?></td>
                    </tr>
                    <tr>
                        <th align="left">Email</th>
                        <td><?php echo $email ?></td>
                    </tr>
                    <tr>
                        <th align="left">Reason</th>
                        <td><?php echo $reason ?></td>
                    </tr>
                    <?php if (!empty($reason_description)) { ?>
                        <tr>
                            <th align="left">Description</th>
                            <td><?php echo $reason_description ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th align="left">WordPress Version</th>
                        <td><?php echo get_bloginfo('version') ?></td>
                    </tr>
                    <tr>
                        <th align="left">PHP Version</th>
                        <td><?php echo PHP_VERSION ?></td>
                    </tr>
                </table>
                <?php
                $content = ob_get_clean();
                $to = self::$sendEmailTo;
                wp_mail($to, $subject, $content, $headers);  // Sending mail to email address
                $response['status'] = 1;
            }
            echo json_encode($response);
            die;
        }
    }

    if (class_exists("JEM_Table_Rate_Deactivate_Modal")) {
        $JEM_Table_Rate = new JEM_Table_Rate_Deactivate_Modal();
    }
}