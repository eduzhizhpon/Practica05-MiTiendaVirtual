<style>
    .jem-table-rate-hidden {
        overflow: hidden;
    }
    .jem-table-rate-popup-overlay .jem-table-rate-internal-message {
        margin: 3px 0 3px 22px;
        display: none;
    }
    .jem-table-rate-reason-input {
        margin: 3px 0 3px 22px;
        display: none;
    }
    .jem-table-rate-reason-input input[type="text"] {
        width: 100%;
        display: block;
    }
    .jem-table-rate-popup-overlay {
        background: rgba(0, 0, 0, .8);
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: 1000;
        overflow: auto;
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.3s ease-in-out :
    }
    .jem-table-rate-popup-overlay.jem-table-rate-active {
        opacity: 1;
        visibility: visible;
    }
    .jem-table-rate-serveypanel {
        width: 600px;
        background: #fff;
        margin: 65px auto 0;
    }
    .jem-table-rate-popup-header {
        background: #f1f1f1;
        padding: 20px;
        border-bottom: 1px solid #ccc;
    }
    .jem-table-rate-popup-header h2 {
        margin: 0;
        text-transform: uppercase;
    }
    .jem-table-rate-popup-body {
        padding: 10px 20px;
    }
    .jem-table-rate-popup-footer {
        background: #f9f3f3;
        padding: 10px 20px;
        border-top: 1px solid #ccc;
    }
    .jem-table-rate-popup-footer:after {
        content: "";
        display: table;
        clear: both;
    }
    .action-btns {
        float: right;
    }
    .jem-table-rate-spinner {
        display: none;
    }
    .jem-table-rate-spinner img {
        margin-top: 3px;
    }
    .jem-table-rate-option {
        display: none;
        width: calc(100% - 20px);
        margin: 5px 0 0 20px;
    }
    span.jem-table-rate-error-message {
        color: #dd0000;
        font-weight: 600;
    }
    .jem-table-rate-option.input-error {
        border-color: red;
    }
    span.jem-error-message {
        display: inline-block;
        padding: 0px 0 0 20px;
        color: red;
    }
</style>

<div class="jem-table-rate-popup-overlay">
    <div class="jem-table-rate-serveypanel">
        <form action="#" method="post" id="jem-table-rate-deactivate-form">
            <div class="jem-table-rate-popup-header">
                <h2><?php _e('Quick feedback', 'JEM_DOMAIN'); ?></h2>
            </div>
            <div class="jem-table-rate-popup-body">
                <h3><?php _e('If you have a moment, please let us know why you are deactivating:', 'JEM_DOMAIN'); ?></h3>
                <div class="form-control">
                    <ul>
                        <?php foreach($options as $key=>$option) { ?>
                            <li>
                                <label for="option_<?php echo $key ?>"><input value="<?php echo $key ?>" id="option_<?php echo $key ?>" type="radio" name="jem_options"><?php _e($option['title'], 'JEM_DOMAIN') ?></label>
                                <?php if($option['has_input'] == 1) {
                                    echo '<input class="jem-table-rate-option" type="text" id="option_comment_'.$key.'" name="option_comment_'.$key.'" placeholder="'.$option["placeholder"].'" />';
                                } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="jem-table-rate-popup-footer">
                <input type="button" class="button button-secondary button-skip jem-table-rate-popup-skip-feedback" value="Skip &amp; Deactivate">
                <div class="action-btns">
                    <span class="jem-table-rate-spinner">
                        <img src="<?php echo admin_url('/images/spinner.gif'); ?>" alt="">
                    </span>
                    <input type="submit" class="button button-secondary button-deactivate jem-table-rate-popup-allow-deactivate" value="Submit &amp; Deactivate" disabled="disabled">
                    <a href="#" class="button button-primary jem-table-rate-popup-button-close"><?php _e('Cancel', 'JEM_DOMAIN'); ?></a>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
(function ($) {
    $(function () {
        $(document).on("click", ".jem-table-rate-deactivate-button", function(e){
            e.stopPropagation();
            jQuery(".jem-table-rate-popup-button-close").trigger("click");
            jQuery(".jem-table-rate-help-btn").toggle();
            jQuery(".jem-table-rate-help-form").toggleClass("active");
            jQuery("#user_email").focus();
        });
        var jemTableRateSlug = 'woocommerce-easy-table-rate-shipping';
        $(document).on('click', 'tr[data-slug="' + jemTableRateSlug + '"] .deactivate', function (e) {
            e.preventDefault();
            $("input[name='jem_options']").attr("checked", false);
            $('.jem-table-rate-popup-overlay').addClass('jem-table-rate-active');
            $('body').addClass('jem-table-rate-hidden');
        });
        $(document).on('click', '.jem-table-rate-popup-button-close', function () {
            close_popup();
        });
        $(document).on('click', ".jem-table-rate-serveypanel,tr[data-slug='" + jemTableRateSlug + "'] .deactivate", function (e) {
            e.stopPropagation();
        });
        $(document).click(function () {
            close_popup();
        });
        $(document).on("change", "input[name='jem_options'], input[name='jem_options']:checked", function(){
            $(".jem-table-rate-popup-allow-deactivate").attr("disabled", false);
            $(".jem-table-rate-option").hide();
            selected_value = $("input[name='jem_options']:checked").val();
            $("#option_comment_"+selected_value).show();
        });
        $(document).on("keyup", "#jem-table-rate-comment", function(){
            if($.trim($(this).val()) == "") {
                $(".jem-table-rate-popup-allow-deactivate").attr("disabled", true);
            } else {
                $(".jem-table-rate-popup-allow-deactivate").attr("disabled", false);
            }
        });
        $(document).on('submit', '#jem-table-rate-deactivate-form', function (event) {
            event.preventDefault();
            $(".jem-error-message").remove();
            selected_value = $("input[name='jem_options']:checked").val();
            errorCounter = 0;
            reason_description = "";
            if($("#option_comment_"+selected_value).length) {
                if($.trim($("#option_comment_"+selected_value).val()) == "") {
                    $("#option_comment_"+selected_value).after("<span class='jem-error-message'>This field is required</span>");
                    $("#option_comment_"+selected_value).addClass("input-error");
                    errorCounter = 1;
                } else {
                    reason_description = $.trim($("#option_comment_"+selected_value).val());
                }
            }
            if(errorCounter == 0) {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'jem_table_rate_plugin_deactivate',
                        reason: selected_value,
                        reason_description: reason_description,
                        nonce: '<?php echo wp_create_nonce('jem_table_rate_deactivate_nonce') ?>'
                    },
                    beforeSend: function () {
                        $(".jem-table-rate-spinner").show();
                        $(".jem-table-rate-popup-allow-deactivate").attr("disabled", "disabled");
                    }
                }).done(function (res) {
                    console.log(res);
                    res = jQuery.parseJSON(res);
                    if (res.valid == "0") {
                        alert(res.message);
                        window.location.reload(true);
                    } else {
                        $(".jem-table-rate-spinner").hide();
                        window.location.href = $("tr[data-slug='" + jemTableRateSlug + "'] .deactivate a").attr('href');
                    }
                });
            }
        });
        $('.jem-table-rate-popup-skip-feedback').on('click', function (e) {
            window.location.href = $("tr[data-slug='" + jemTableRateSlug + "'] .deactivate a").attr('href');
        });
        function close_popup() {
            $('.jem-table-rate-popup-overlay').removeClass('jem-table-rate-active');
            $('#jem-table-rate-deactivate-form').trigger("reset");
            $(".jem-table-rate-popup-allow-deactivate").attr('disabled', 'disabled');
            $(".jem-table-rate-reason-input").hide();
            $('body').removeClass('jem-table-rate-hidden');
            $('.message.error-message').hide();
        }
    });
})(jQuery);
</script>