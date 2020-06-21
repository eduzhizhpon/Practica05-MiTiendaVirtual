=== WooCommerce - PayPhone Gateway ===
Contributors: PayPhone
Tags: Woocommerce, Gateway Payment
Requires at least: 2.5
Tested up to: 5.2.4
Requires PHP: 5.3
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

WooCommerce - PayPhone Gateway agrega una nueva pasarela de pago para realizar los cobros de tus productos de woocommerce mediante PayPhone.

== Description ==
WooCommerce - PayPhone Gateway adds a new payment gateway to charge woocommerce products through PayPhone. To be able to use this plugin you must first become a PayPhone Store, if you are not yet you can enter to [PayPhone](https://livepayphone.com)

This plugin get the total amount, taxes, shipping, order id and send to PayPhone to do the payment. Once the payment is completed, the response is received and the corresponding order is updated.

== Installation ==

= Minimum Requirements =

* WordPress 2.5 or greater

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type "WooCommerce PayPal Express Checkout" and click Search Plugins. Once you’ve found our plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Install Now.

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your webserver via your favourite FTP application. The
WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

If on the off-chance you do encounter issues with the callback url pages after an update you simply need to flush the permalinks by going to WordPress > Settings > Permalinks and hitting 'save'. That should return things to normal.

== Configuration ==

You can access the plugin settings by going to Woocommerce > Settings > Checkout > PayPhone

The enable/disable checkbox allow you to show or not the gateway in checkout page

The gateway description help the user to know what the gateway do.

The Token and Token test field allow to communicate with PayPhone, you can get the value by entering [this page](https://appdeveloper.payphonetodoesposible.com)

Test mode checkbox enable or disable the test mode. In test mode all transaction are fake.

You can select the page that will be displayed if the payment was canceled or rejected


== Frequently Asked Questions ==

= Does this plugin work with credit cards or just PayPhone? =

This plugin supports payments only using PayPhone. If you want to pay using credit and debit card also you need to contact with us by [info@livepayphone.com](mailto:info@livepayphone.com)

= Does this support both production mode and sandbox mode for testing? =

Yes it does - production and sandbox mode is driven by how you connect.  You may choose to connect in either mode, and disconnect and reconnect in the other mode whenever you want. Anly need to get the correct credentials at [this page](https://appdeveloper.payphonetodoesposible.com)

= Where can I find documentation? =

For help setting up and configuring, please refer to our [user guide](https://docs.livepayphone.com/)

= Where can I get support? =

If you get stuck, you can ask for help using the email info@livepayphone.com. Or you can access to our [forum](https://docs.livepayphone.com/forums/)

== Changelog ==
1.1.4
Fix bugs (Coupon support)
1.1.3
Fix bugs (convert from decimal to integer)
1.1.2
Add support for direct payment compatibilities in wordpress 5.3
1.1.1
Add hook when the pay was cancelled or approved
Cancelled hook: payphone_canceled_pay
Approved hook: payphone_approved_pay
This hooks receive pay result in first parameters
1.1.0
Correction of bugs
The option of test mode is eliminated. Now you can enable test mode from the developer console
1.0.4
Add support for the card addon
1.0.3
Correction of bugs
1.0.2
Update of docs page

1.0.0 Release