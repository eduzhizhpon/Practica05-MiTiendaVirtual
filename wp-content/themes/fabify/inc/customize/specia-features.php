<?php
function fabify_features_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Features Section Panel
	=========================================*/
	$wp_customize->add_panel( 
		'features_panel', 
		array(
			'priority'      => 128,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Features Section', 'fabify'),
		) 
	);
	
	// Features Settings Section // 
	$wp_customize->add_section(
        'features_setting',
        array(
        	'priority'      => 1,
             'title' 		=> __('Settings','fabify'),
			'panel'  		=> 'features_panel',
		)
    );
	
	$wp_customize->add_setting( 
		'hide_show_features' , 
			array(
			'default' 		=> 'on',
			'capability' 	=> 'edit_theme_options',
			'sanitize_callback' => 'specia_sanitize_select',
			'transport'         => $selective_refresh,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_features' , 
		array(
			'label'          => __( 'Hide / Show Section', 'fabify' ),
			'section'        => 'features_setting',
			'settings'   	 => 'hide_show_features',
			'type'           => 'radio',
			'choices'        => 
			array(
				'on' => __( 'Show', 'fabify' ),
				'off' => __( 'Hide', 'fabify' )
			) 
		) 
	);
	
	// Features Header Section // 
	$wp_customize->add_section(
        'features_header',
        array(
        	'priority'      => 2,
            'title' 		=> __('Header','fabify'),
			'panel'  		=> 'features_panel',
		)
    );
	
	// Features Title // 
	$wp_customize->add_setting(
    	'features_title',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'specia_sanitize_html',
			'transport'         => $selective_refresh,
		)
	);	
	
	$wp_customize->add_control( 
		'features_title',
		array(
		    'label'   => __('Section Title','fabify'),
		    'section' => 'features_header',
			'settings'   	 => 'features_title',
			'type'           => 'text',
		)  
	);
	
	// Features Description // 
	$wp_customize->add_setting(
    	'features_description',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'specia_sanitize_html',
			'transport'         => $selective_refresh,
		)
	);	
	
	$wp_customize->add_control( 
		'features_description',
		array(
		    'label'   => __('Section Description','fabify'),
		    'section' => 'features_header',
			'settings'   	 => 'features_description',
			'type'           => 'textarea',
		)  
	);
	
	// Features Background Section // 
	$wp_customize->add_section(
        'features_background',
        array(
        	'priority'      => 3,
            'title' 		=> __('Background','fabify'),
			'panel'  		=> 'features_panel',
		)
    );
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'features_background_setting' , 
    	array(
			'default' 			=> '',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'specia_sanitize_url',	
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'features_background_setting' ,
		array(
			'label'          => __( 'Background Image', 'fabify' ),
			'section'        => 'features_background',
			'settings'   	 => 'features_background_setting',
		) 
	));
	
	$wp_customize->add_setting( 
		'features_background_position' , 
			array(
			'default' => 'fixed',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'specia_sanitize_select',
		) 
	);
	
	$wp_customize->add_control(
		'features_background_position' , 
			array(
				'label'          => __( 'Image Position', 'fabify' ),
				'section'        => 'features_background',
				'settings'       => 'features_background_position',
				'type'           => 'radio',
				'choices'        => 
				array(
					'fixed'=> __( 'Fixed', 'fabify' ),
					'scroll' => __( 'Scroll', 'fabify' )
			)  
		) 
	);
	
}

add_action( 'customize_register', 'fabify_features_setting' );

// Feature section selective refresh
function fabify_home_feature_section_partials( $wp_customize ){
	
	// hide_show_features
	$wp_customize->selective_refresh->add_partial(
		'hide_show_features', array(
			'selector' => '.features-version-one',
			'container_inclusive' => true,
			'render_callback' => 'features_setting',
			'fallback_refresh' => true,
		)
	);
	
	// features_title
	$wp_customize->selective_refresh->add_partial( 'features_title', array(
		'selector'            => '.features-version-one .section-heading',
		'settings'            => 'features_title',
		'render_callback'  => 'fabify_home_features_title_render_callback',
	
	) );
	
	// features_description
	$wp_customize->selective_refresh->add_partial( 'features_description', array(
		'selector'            => '.features-version-one .section-description',
		'settings'            => 'features_description',
		'render_callback'  => 'fabify_home_features_description_render_callback',
	
	) );
	}

add_action( 'customize_register', 'fabify_home_feature_section_partials' );

// features_title
function fabify_home_features_title_render_callback() {
	return get_theme_mod( 'features_title' );
}
// features_description
function fabify_home_features_description_render_callback() {
	return get_theme_mod( 'features_description' );
}
?>