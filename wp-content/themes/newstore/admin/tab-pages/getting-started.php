<div class="row">
	<div class="col">
		<p><?php echo __('Welcome! Thank you for choosing NewStore. <br> To import demo data you need to install these plugins <strong>WooCommerce, One Click Demo Import, ThemeFarmer Companion</strong>, <br>If you want to import <strong>Demo 2, Demo 3 or Demo 4</strong> you will also need <strong>Elementor Page Bulder</strong> <br> <strong>For Floating Cart, Quick View, Wishlist, Smart Variation Swatches, Ajex Search "WooCommerce Tools" plugin is needed.</strong> <br> To disable any of the feature go to WP Menu -> WooCommerce Tools -> Dashboard', 'newstore'); ?></p>
		<br><a href="<?php echo esc_url('https://www.youtube.com/watch?v=WSqwS-maAvk'); ?>" target="_blank"><?php esc_html_e( 'Full Theme Setup Video', 'newstore' ); ?></a> <br><br> <a href="<?php echo esc_url('https://www.youtube.com/watch?v=MDZGjhrxTLg'); ?>" target="_blank"><?php echo esc_html__( 'Quick Demo Data Import Video', 'newstore' ); ?></a> <br><br>
		<h2><?php esc_html_e('Recommended actions', 'newstore'); ?></h2>
		<p><?php esc_html_e('we have created list of steps to take so you get amazing expriance with theme.', 'newstore'); ?></p>
		<a class="button" href="<?php echo esc_url(admin_url( 'themes.php?page=newstore-welcome&tab=recommended_actions' )); ?>"><?php esc_html_e('Go to Recommended actions', 'newstore'); ?></a>
	</div>
	<div class="col">
		<h2><?php esc_html_e('Read Theme Documentation', 'newstore'); ?></h2>
		<p><?php esc_html_e('Missing Something..? Please check our full documentation for detaild information about NewStore ', 'newstore'); ?></p>
		<a class="button" href="<?php echo esc_url($this->docs_link); ?>" target="_blank"><?php esc_html_e('Go to Documentation', 'newstore'); ?></a>
	</div>
	<div class="col">
		<h2><?php esc_html_e('Customize NewStore ', 'newstore'); ?></h2>
		<p><?php esc_html_e('Use customizer to setup NewStore ', 'newstore'); ?></p>
		<a class="button button-primary" href="<?php echo esc_url( admin_url('customize.php') ); ?>" target="_blank"><?php esc_html_e('Go to Customizer', 'newstore'); ?></a>
	</div>
</div>
