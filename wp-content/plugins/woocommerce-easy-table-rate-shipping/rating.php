<?php
if(!class_exists('JEM_Table_Rating_Review_Feedback')) {
    class JEM_Table_Rating_Review_Feedback
    {

        /* Rating message to show after number of days */
        public static $show_message_after_days = "7,14,30,100";

        /* Rating URL */
        public static $rating_url = "https://wordpress.org/support/plugin/woocommerce-easy-table-rate-shipping/reviews/";

        /* Message to shown on Rating screen message, use %%num_of_days%% to display number of days in message */
        public static $rating_message = "Hey, I noticed that you've been using WooCommerce Table Rate Shipping for a while, that's awesome! Could you please do me a BIG favor and give it is a 5-star rating on WordPress? We'd really appreciate it!";

        /* Author name */
        public static $author_name = "Simon";

        public function __construct()
        {
            add_action('admin_init', array($this, 'jem_table_rate_check_for_installed_date'));
        }

        public static function jem_table_rate_activate()
        {
            /* checking for plugin is previously installed or not */
            $installed_on = get_option("jem_table_rate_installed_on_date");
            $message_date = get_option("jem_table_rate_show_message_on_or_after");
            if (empty($installed_on) || $installed_on == null || empty($message_date) || $message_date == null) {

                /* setting plugin installed date*/
                $today_date = date("Y-m-d");
                update_option("jem_table_rate_installed_on_date", $today_date);

                $days = self::$show_message_after_days;
                $days_array = explode(",", $days);
                if (is_array($days_array)) {
                    $day = $days_array[0];
                    $date = date("Y-m-d", strtotime(" +" . $day . " days"));
                    /* save next date when we need to show message */
                    update_option("jem_table_rate_show_message_on_or_after", $date);
                }
            }
        }

        public function jem_table_rate_check_for_installed_date()
        {
            /* checking for plugin is previously installed or not */
            $installed_on = get_option("jem_table_rate_installed_on_date");
            $message_date = get_option("jem_table_rate_show_message_on_or_after");
            if (empty($installed_on) || $installed_on == null || empty($message_date) || $message_date == null) {

                /* setting plugin installed date*/
                $today_date = date("Y-m-d");
                update_option("jem_table_rate_installed_on_date", $today_date);

                $days = self::$show_message_after_days;
                $days_array = explode(",", $days);
                if (is_array($days_array)) {
                    $day = $days_array[0];
                    $date = date("Y-m-d", strtotime(" +" . $day . " days "));
                    /* save next date when we need to show message */
                    update_option("jem_table_rate_show_message_on_or_after", $date);
                }
            }

            /* checking for message update status */
            if (isset($_REQUEST['jem_table_rate_action']) && !empty($_REQUEST['jem_table_rate_action']) && isset($_REQUEST['nonce']) && !empty($_REQUEST['nonce'])) {
                $action = $_REQUEST['jem_table_rate_action'];
                $nonce = $_REQUEST['nonce'];
                if ($action == "remind_me_later") {
                    if (wp_verify_nonce($nonce, 'jem_table_rate_remind_me_later')) {
                        $day = self::number_of_days_since_plugin_is_installed();
                        $days = self::$show_message_after_days;
                        $days_array = explode(",", $days);
                        $status = 0;
                        if (is_array($days_array)) {
                            for ($i = 0; $i < count($days_array) - 1; $i++) {
                                if ($day >= $days_array[$i] && $day < $days_array[$i + 1]) {
                                    $no_of_day = $days_array[$i + 1];
                                    $shown_after = $no_of_day - $day;
                                    $date = date("Y-m-d", strtotime("+" . $shown_after . " days"));
                                    $status = 1;
                                    update_option("jem_table_rate_show_message_on_or_after", $date);
                                    break;
                                }
                            }
                        }
                        /* It will set message box after each 30 days if specified number of days in $show_message_after_days are completed */
                        if ($status == 0) {
                            $date = date("Y-m-d", strtotime("+1 months"));
                            update_option("jem_table_rate_show_message_on_or_after", $date);
                        }
                    }
                } else if ($action == "do_not_show") {
                    if (wp_verify_nonce($nonce, 'jem_table_rate_do_not_show')) {
                        update_option("jem_table_rate_do_not_show_again_flag", 1);
                    }
                } else if ($action == "i_already_did_it") {
                    if (wp_verify_nonce($nonce, 'jem_table_rate_i_already_did_it')) {
                        update_option("jem_table_rate_do_not_show_again_flag", 1);
                    }
                }
                wp_redirect($_SERVER["HTTP_REFERER"]);
                die;
            }
        }

        public static function number_of_days_since_plugin_is_installed()
        {
            $installed_on = get_option("jem_table_rate_installed_on_date");
            $today_date = date("Y-m-d");
            if (!empty($installed_on) && !$installed_on == null) {
                $end_date = strtotime($today_date);
                $start_date = strtotime($installed_on);
                $days = ($end_date - $start_date) / 60 / 60 / 24;
            } else {
                /* Setting plugin installed date*/
                update_option("jem_table_rate_installed_on_date", $today_date);
                $days = 0;
            }
            return $days;
        }

        public static function is_message_needs_to_show_on_screen()
        {
            $is_hidden = get_option("jem_table_rate_do_not_show_again_flag");
            if ($is_hidden != 1) {
                $date = date("Y-m-d");
                $message_date = get_option("jem_table_rate_show_message_on_or_after");
                if ($message_date <= $date) {
                    return true;
                }
            } else {
                return false;
            }
        }

        public static function display_message_on_screen()
        {
            $day_difference = self::number_of_days_since_plugin_is_installed();
            $status = self::is_message_needs_to_show_on_screen($day_difference);
            if ($status) {
                $message = self::$rating_message;
                $message = str_replace("%%num_of_days%%", $day_difference, $message);
                ob_start();
                $admin_url = admin_url();

                $remind_me_later_nonce = wp_create_nonce("jem_table_rate_remind_me_later");
                $do_no_show_nonce = wp_create_nonce("jem_table_rate_do_not_show");
                $i_already_did_nonce = wp_create_nonce("jem_table_rate_i_already_did_it");

                $may_be_later_url = $admin_url . "?jem_table_rate_action=remind_me_later&nonce=" . $remind_me_later_nonce;
                $do_no_show_url = $admin_url . "?jem_table_rate_action=do_not_show&nonce=" . $do_no_show_nonce;
                $i_already_did_url = $admin_url . "?jem_table_rate_action=i_already_did_it&nonce=" . $i_already_did_nonce;
                ?>
                <style>
                    .jem-admin-review-box {
                        border-left: solid 3px #1c3b7e;
                        margin: 20px 0;
                        padding: 15px;
                        background: #fff;
                        position: relative;
                    }

                    .jem-admin-review-message {
                        font-size: 16px;
                        color: #078500;
                    }

                    .jem-admin-review-author {
                        color: #078500;
                        font-style: italic;
                        padding: 5px 0 15px 0;
                    }

                    .jem-admin-review-box ul {
                        list-style: initial;
                        padding: 0 0 0 20px;
                        margin: 0;
                        font-weight: bold;
                    }

                    .jem-admin-discard-message {
                        position: absolute;
                        right: 15px;
                        bottom: 15px;
                    }
                </style>
                <div class="jem-admin-review-box">
                    <div class="jem-admin-review-message"><?php echo $message ?></div>
                    <div class="jem-admin-review-author">- <?php echo self::$author_name ?></div>
                    <ul>
                        <li><a target="_blank" href="<?php echo self::$rating_url ?>">Ok. you deserve it</a></li>
                        <li><a href="<?php echo $may_be_later_url ?>">Nope, maybe later</a></li>
                        <li><a href="<?php echo $i_already_did_url ?>">I already did</a></li>
                    </ul>
                    <div class="jem-admin-discard-message"><a href="<?php echo $do_no_show_url ?>">Do not show it
                            again</a></div>
                </div>
                <?php
                echo $content = ob_get_clean();
            }
        }
    }

    if (class_exists("JEM_Table_Rating_Review_Feedback")) {
        $JEM_Table = new JEM_Table_Rating_Review_Feedback();
    }
}