<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
<style type="text/css">
    #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
    /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
       We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
    #optin {
        background: #dde2ec;
        border: 2px solid #1c3b7e;
        /* padding: 20px 15px; */
        text-align: center;
        width: 800px;
    }
    #optin input {
        background: #fff;
        border: 1px solid #ccc;
        font-size: 15px;
        margin-bottom: 10px;
        padding: 8px 10px;
        border-radius: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        box-shadow: 0 2px 2px #ddd;
        -moz-box-shadow: 0 2px 2px #ddd;
        -webkit-box-shadow: 0 2px 2px #ddd
    }
    #optin input.name { background: #fff url('<?php echo JEM_URL; ?>/images/name.png') no-repeat 10px center; padding-left: 35px }
    #optin input.myemail { background: #fff url('<?php echo JEM_URL; ?>/images/email.png') no-repeat 10px center; padding-left: 35px }
    #optin button {
        background: #217b30 url('<?php echo JEM_URL; ?>/images/green.png') repeat-x top;
        border: 1px solid #137725;
        color: #fff;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        padding: 2px 0;
        text-shadow: -1px -1px #1c5d28;
        width: 120px;
        height: 38px;
    }
    #optin button:hover { color: #c6ffd1 }
    .optin-header{
        font-size: 24px;
        color: #ffffff;
        background-color: #1c3b7e;
        padding: 20px 15px;
    }
    #jem-submit-results{
        padding: 10px 0px;
        font-size: 24px;
    }
</style>
<div id="optin">

    <div id="mc_embed_signup_scroll">
        <div class="optin-header">Upgrade to Pro - get a 20% Discount Coupon</div>
        <div class="mc-field-group" style="padding: 20px 15px;; text-align: left;">
            <input type="text" value="Enter your email" size="30" name="EMAIL" class="myemail" id="mce-EMAIL" onfocus="if (this.value == this.defaultValue)
                    this.value = '';" onblur="if (this.value == '')
                                this.value = this.defaultValue;"
                   >
            <input type="text" value="Enter your name" size="30" name="FNAME" class="name" id="mce-FNAME" onfocus="if (this.value == this.defaultValue)
                    this.value = '';" onblur="if (this.value == '')
                                this.value = this.defaultValue;"
                   >
            <button id="mc_button" class="button" >Get Discount</button>
        </div>
        <div id="mce-responses" class="clear">
            <div class="response" id="mce-error-response" style="display:none"></div>
            <div class="response" id="mce-success-response" style="display:none"></div>
        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_6d531bf4acbb9df72cd2e718d_de987ac678" tabindex="-1" value=""></div>
        <div class="clear"><img src="<?php echo JEM_URL ?>/images/lock.png">We respect your privacy and will never sell or rent your details</div>
        <div id="jem-submit-results"></div>
    </div>
</div>
<script>
    jQuery("#mc_button").click(function (e) {
        e.preventDefault();
        console.log('clicked');
        data = {};

        data["EMAIL"] = jQuery("#mce-EMAIL").val();
        data["NAME"] = jQuery("#mce-FNAME").val();

        jQuery.ajax({
            url: '//jem-products.us12.list-manage.com/subscribe/post-json?u=6d531bf4acbb9df72cd2e718d&amp;id=de987ac678&c=?',
            type: 'post',
            data: data,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                if (data['result'] != "success") {
                    //ERROR
                    console.log("error");
                    console.log(data['msg']);
                } else {
                    //SUCCESS - Do what you like here
                    jQuery("#jem-submit-results").text("Please Check Your Email for your Code");
                }
            }
        });

    });

</script>

<!--  end email -->




<tr>
    <th scope="row" class="titledesc"><?php _e('Table Rates', JEM_DOMAIN); ?></th>
    <td id="<?php echo $this->id; ?>_settings">
        <table class="shippingrows widefat">
            <col style="width:0%">
            <col style="width:0%">
            <col style="width:0%">
            <col style="width:100%;">
            <thead>
                <tr>
                    <th class="check-column"></th>
                    <th>Shipping Zone Name</th>
                    <th>Condition</th>
                    <th>Countries</th>
                </tr>
            </thead>
            <tbody style="border: 1px solid black;">
                <tr style="border: 1px solid black;">
                    <td colspan="5" class="add-zone-buttons">
                        <a href="#" class="add button">Add New Shipping Zone</a>
                        <a href="#" class="delete button">Delete Selected Zones</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<script>
    var options = <?php echo json_encode($this->create_dropdown_options()); ?>;

    var country_array = <?php echo json_encode($this->country_array); ?>;
    var condition_array = <?php echo json_encode($this->condition_array); ?>;
    var pluginID = <?php echo json_encode($this->id); ?>;

    var lastID = 0;

<?php
foreach ($this->options as $key => $value) {

    //add the key back into the json object
    $value['key'] = $key;
    $row = json_encode($value);
    echo "jQuery('#{$this->id}_settings table tbody tr:last').before(create_zone_row({$row}));\n";
}
?>



    /**
     * This creates a new ZONE row
     */
    function create_zone_row(row) {
        //lets get the ID of the last one

        var el = '#' + pluginID + '_settings .jem-zone-row';
        lastID = jQuery(el).last().attr('id');

        //Handle no rows
        if (typeof lastID == 'undefined' || lastID == "") {
            lastID = 1;
        } else {
            lastID = Number(lastID) + 1;
        }

        var html = '\
                                <tr id="' + lastID + '" class="jem-zone-row" >\
                                        <input type="hidden" value="' + lastID + '" name="key[' + lastID + ']"></input>\
                                        <td><input type="checkbox" class="jem-zone-checkbox"></input></span></td>\
                                        <td><input type="text" size="30" value="' + row["key"] + '"  name="zone-name[' + lastID + ']"/></td>\
                                        <td>\
                                                <select class="hello45" name="condition[' + lastID + ']">\
                                                ' + generate_condition_html(row.condition) + '\
                                                </select>\
                                        </td>\
                                        <td>\
                                                <select multiple="multiple" class="multiselect chosen_select" name="countries[' + lastID + '][]">\
                                                ' + generate_country_html(row.countries) + '\
                                                                </select>\
                                        </td>\
                                </tr>\
                ';

        //This is the expandable/collapsable row for that holds the rates
        html += '\
                        <tr class="jem-rate-holder">\
                                <td colspan="1">\
                                </td>\
                                <td colspan="3">\
                                        <table class="jem-rate-table shippingrows widefat" id="' + lastID + '_rates">\
                                                <thead>\
                                                        <tr>\
                                                                <th></th>\
                                                                <th style="width: 30%">Min Value</th>\
                                                                <th style="width: 30%">Max Value</th>\
                                                                <th style="width: 40%">Shipping Rate</th>\
                                                        </tr>\
                                                </thead>\
                                                ' + create_rate_row(lastID, row) + '\
                                                <tr>\
                                                        <td colspan="4" class="add-rate-buttons">\
                                                                <a href="#" class="add button" name="key_' + lastID + '">Add New Rate</a>\
                                                                <a href="#" class="delete button">Delete Selected Rates</a>\
                                                        </td>\
                                                </tr>\
                                        </table>\
                                </td>\
                        </tr>\
                ';

        return html;
    }

    /**
     * This creates a new RATE row
     * The container Table is passed in and this row is added to it
     */
    function create_rate_row(lastID, row) {


        if (row == null || row.rates.length == 0) {
            //lets manufacture a rows
            //create dummy row
            var row = {};
            row.key = "";
            row.condition = [""];
            row.countries = [];
            row.rates = [];
            row.rates.push([]);
            row.rates[0].min = "";
            row.rates[0].max = "";
            row.rates[0].shipping = "";
        }
        //loop thru all the rate data and create rows

        //handles if there are no rate rows yet
        if (typeof (row.min) == 'undefined' || row.min == null) {
            row.min = [];
        }

        var html = '';
        for (var i = 0; i < row.rates.length; i++) {
            html += '\
                                <tr>\
                                        <td>\
                                                <input type="checkbox" class="jem-rate-checkbox" id="' + lastID + '"></input>\
                                        </td>\
                                        <td>\
                                                <input type="text" size="20" placeholder="" name="min[' + lastID + '][]" value="' + row.rates[i].min + '"></input>\
                                        </td>\
                                        <td>\
                                                <input type="text" size="20" placeholder="" name="max[' + lastID + '][]" value="' + row.rates[i].max + '"></input>\
                                        </td>\
                                        <td>\
                                                <input type="text" size="10" placeholder="" name="shipping[' + lastID + '][]" value="' + row.rates[i].shipping + '"></input>\
                                        </td>\
                                </tr>\
                        ';



        }


        return html;
    }

    /**
     * Handles the expansion contraction of the rate table for the zone
     */
    function expand_contract() {

        var row = jQuery(this).parent('td').parent('tr').next();

        if (jQuery(row).hasClass('jem-hidden-row')) {
            jQuery(row).removeClass('jem-hidden-row').addClass('jem-show-row');
            jQuery(this).removeClass('expand-icon').addClass('collapse-icon');
        } else {
            jQuery(row).removeClass('jem-show-row').addClass('jem-hidden-row');
            jQuery(this).removeClass('collapse-icon').addClass('expand-icon');
        }



    }


    //**************************************
    // Generates the HTML for the country
    // select. Uses an array of keys to
    // determine which ones are selected
    //**************************************
    function generate_country_html(keys) {

        html = "";

        for (var key in country_array) {

            if (keys.indexOf(key) != -1) {
                //we have a match
                html += '<option value="' + key + '" selected="selected">' + country_array[key] + '</option>';
            } else {
                html += '<option value="' + key + '">' + country_array[key] + '</option>';

            }
        }

        return html;
    }


    //**************************************
    // Generates the HTML for the CONDITION
    // select. Uses an array of keys to
    // determine which ones are selected
    //**************************************
    function generate_condition_html(keys) {

        html = "";

        for (var key in condition_array) {

            if (keys.indexOf(key) != -1) {
                //we have a match
                html += '<option value="' + key + '" selected="selected">' + condition_array[key] + '</option>';
            } else {
                html += '<option value="' + key + '">' + condition_array[key] + '</option>';

            }
        }

        return html;
    }

    //***************************
    // Handle add/delete clicks
    //***************************

    //ZONE TABLE


    /*
     * add new ZONE row
     */
    var zoneID = "#" + pluginID + "_settings";

    jQuery(zoneID).on('click', '.add-zone-buttons a.add', function () {

        //ok lets add a row!


        var id = "#" + pluginID + "_settings table tbody tr:last";
        //create empty row
        var row = {};
        row.key = "";
        row.min = [];
        row.rates = [];
        row.condition = [];
        row.countries = [];
        jQuery(id).before(create_zone_row(row));

        //turn on select2 for our row
        if (jQuery().chosen) {
            jQuery("select.chosen_select").chosen({
                width: '350px',
                disable_search_threshold: 5
            });
        } else {
            jQuery("select.chosen_select").select2();
        }


        return false;
    });

    /**
     * Delete ZONE row
     */
    jQuery(zoneID).on('click', '.add-zone-buttons a.delete', function () {

        //loop thru and see what is checked - if it is zap it!
        var rowsToDelete = jQuery(this).closest('table').find('.jem-zone-checkbox:checked');

        jQuery.each(rowsToDelete, function () {

            var thisRow = jQuery(this).closest('tr');
            //first lets get the next sibl;ing to this row
            var nextRow = jQuery(thisRow).next();

            //it should be a rate row
            if (jQuery(nextRow).hasClass('jem-rate-holder')) {
                //remove it!
                jQuery(nextRow).remove();
            } else {
                //trouble at mill
                return;
            }

            jQuery(thisRow).remove();
        });

        //TODO - need to delete associated RATES

        return false;
    });


    //RATE TABLES

    /**
     * ADD RATE BUTTON
     */
    jQuery(zoneID).on('click', '.add-rate-buttons a.add', function () {

        //we need to get the key of this zone - it's in the name of of the button
        var name = jQuery(this).attr('name');
        name = name.substring(4);

        //remove key_ 
        //ok lets add a row!


        var row = create_rate_row(name, null);
        jQuery(this).closest('tr').before(row);

        return false;
    });

    /**
     * Delete RATE roe
     */
    jQuery(zoneID).on('click', '.add-rate-buttons a.delete', function () {

        //loop thru and see what is checked - if it is zap it!
        var rowsToDelete = jQuery(this).closest('table').find('.jem-rate-checkbox:checked');

        jQuery.each(rowsToDelete, function () {
            jQuery(this).closest('tr').remove();
        });


        return false;
    });

    //These handle building the select arras


<?php
echo "jQuery('#{$this->id}_settings').on('click', '.jem-expansion', expand_contract) ;\n";
?>
</script>				