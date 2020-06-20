<?php
function fabify_header_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Header Settings Panel
	=========================================*/
	$wp_customize->add_panel( 
		'header_section', 
		array(
			'priority'      => 127,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Header Section', 'fabify'),
		) 
	);
	
	
	/*=========================================
	Header Cart & Button
	=========================================*/
	$wp_customize->add_section(
        'cart_button',
        array(
        	'priority'      => 4,
            'title' 		=> __('Header Cart & Button','fabify'),
			'panel'  		=> 'header_section',
		)
    );
	
	$wp_customize->add_setting( 
		'header_cart' , 
			array(
			'default' => 'on',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'specia_sanitize_select',
			'transport'         => $selective_refresh,
		) 
	);

	$wp_customize->add_control(
		'header_cart' , 
			array(
			'label'          => __( 'Hide/ Show Header Cart', 'fabify' ),
			'section'        => 'cart_button',
			'settings'		 => 'header_cart',
			'type'           => 'radio',
			'choices'        => 
			array(
				'on' => 'Show',
				'off'  => 'Hide'
			) 
		) 
	);
	
	$wp_customize->add_setting(
    	'button_icon',
    	array(
	        'default'			=> 'fa-clock-o',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control( 
		'button_icon',
		array(
		    'label'   => __('Button Icon','fabify'),
		    'section' => 'cart_button',
			'settings'=> 'button_icon',
			'type' => 'text',
			'description'    => sprintf(__( "Want to get more icons <a href='https://fontawesome.com/v4.7.0/icons/' target='_blank'>Click Here</a>", "fabify" )),
		)  
	);
	
	$wp_customize->add_setting(
    	'button_label',
    	array(
	        'default'			=> __( 'Book Now', 'fabify' ),
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control( 
		'button_label',
		array(
		    'label'   => __('Button Label','fabify'),
		    'section' => 'cart_button',
			'settings'=> 'button_label',
			'type' => 'text'
		)  
	);
	
	$wp_customize->add_setting(
    	'button_url',
    	array(
			'sanitize_callback' => 'specia_sanitize_url',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control( 
		'button_url',
		array(
		    'label'   => __('Button URL','fabify'),
		    'section' => 'cart_button',
			'settings'=> 'button_url',
			'type' => 'text'
		)  
	);
	
}

add_action( 'customize_register', 'fabify_header_setting' );

// Header section selective refresh
function fabify_home_header_section_partials( $wp_customize ){
	
	// header_cart
	$wp_customize->selective_refresh->add_partial(
		'header_cart', array(
			'selector' => '.fabify-cart',
			'container_inclusive' => true,
			'render_callback' => 'cart_button',
			'fallback_refresh' => true,
		)
	);
	}

add_action( 'customize_register', 'fabify_home_header_section_partials' );
?>