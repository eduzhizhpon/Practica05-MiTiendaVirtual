<?php
function fabify_premium_setting( $wp_customize ) {

	$wp_customize->add_section(
        'upgrade_premium',
        array(
            'title' 		=> __('Upgrade to Premium','fabify'),
		)
    );
	
	/*=========================================
	Buttons
	=========================================*/
	
	class Fabify_Buttons_Customize_Control extends WP_Customize_Control {
	public $type = 'upgrade_premium';

	   function render_content() {
		?>
			<div class="premium_info">
				<ul>
					<li><a href="https://demo.speciatheme.com/pro/fabify/" class="btn-green" target="_blank"><i class="dashicons dashicons-desktop info-icon"></i><?php _e( 'Premium Demo','fabify' ); ?> </a></li>
					
					<li><a href="https://speciatheme.com/fabify-premium/" class="btn-red" target="_blank"><i class="dashicons dashicons-cart"></i><?php _e( 'Buy Now','fabify' ); ?> </a></li>
					
					<li><a href="http://specia.ticksy.com/" class="btn-green" target="_blank"><i class="dashicons dashicons-sos"></i><?php _e( 'Support Center','fabify' ); ?> </a></li>
				</ul>
			</div>
			<div>
				<ul>
					<li><a href="http://docs.speciatheme.com/themes/fabify-free/" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/documentation.png"></a></li>
					
					<li><a href="https://wordpress.org/support/theme/fabify/reviews/#new-post" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/rating.png"></a></li>
			</div>
		<?php
	   }
	}
	
		$wp_customize->add_setting(
			'premium_info_buttons',
			array(
			   'capability'     => 'edit_theme_options',
			   'sanitize_callback' => 'specia_sanitize_text',
			)	
		);
	
		$wp_customize->add_control( new Fabify_Buttons_Customize_Control( $wp_customize, 'premium_info_buttons', array(
				'section' => 'upgrade_premium',
				'setting' => 'premium_info_buttons',
			))
		);
}
add_action( 'customize_register', 'fabify_premium_setting',999 );
?>