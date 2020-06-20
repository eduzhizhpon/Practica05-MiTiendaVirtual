<?php
/**
 * NewSrore Theme Customizer
 *
 * @package NewSrore
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function newstore_customize_register($wp_customize) {

	$wp_customize->add_panel('themefarmer_fontpage_panel', array(
		'title'    => __('Frontpage Sections', 'newstore'),
		'priority' => 30,
	));

	$wp_customize->add_section('newstore_frontpage_banners_section', array(
		'title'    => __('Banners', 'newstore'),
		'priority' => 10,
		'panel'    => 'themefarmer_fontpage_panel',
	));

	for ($i=1; $i < 4; $i++) { 
		$wp_customize->add_setting('newstore_frontpage_banner_'.$i, array(
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'newstore_frontpage_banner_'.$i, array(
            'label'      => sprintf(esc_html__( 'Banner Image %s', 'newstore' ), $i),
            'section'    => 'newstore_frontpage_banners_section'
        )));

        $wp_customize->add_setting('newstore_frontpage_banner_link_'.$i, array(
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control('newstore_frontpage_banner_link_'.$i, array(
			'type'     => 'text',
			'section'  => 'newstore_frontpage_banners_section',
			'label'      => sprintf(esc_html__( 'Banner Image Link %s', 'newstore' ), $i),
		));
	}

	if(class_exists('WooCommerce')){
		$wp_customize->add_section('newstore_frontpage_categories_section', array(
			'title'    => __('Featured Categories', 'newstore'),
			'priority' => 170,
			'panel'    => 'themefarmer_fontpage_panel',
		));
		$cat_options = array('' => esc_html__( 'Select Category', 'newstore' ));
		$prod_categories = get_terms( 'product_cat', array(
				        'orderby'    => 'name',
				        'order'      => 'ASC',
				        'parent' 	 => 0,
				        'number'	 => 999,
				        'hide_empty' => true
				    ));
		foreach ($prod_categories as $key => $acat) {
			$cat_options[$acat->term_id]=$acat->name;
		}

		for ($i=1; $i <= 5; $i++){

			$wp_customize->add_setting('newstore_frontpage_cat_id_'.$i, array(
				'sanitize_callback' => 'absint',
			));

			$wp_customize->add_control('newstore_frontpage_cat_id_'.$i, array(
				'type'     => 'select',
				'section'  => 'newstore_frontpage_categories_section',
				'label'      => sprintf(esc_html__( 'Featured Category %s', 'newstore' ), $i),
				'choices'  => $cat_options,
			));
		}
	}



	$wp_customize->add_panel('newstore_header_options_panel', array(
		'priority' => 30,
		'title'    => __('Header Options', 'newstore'),
	));
	/*types*/
	$wp_customize->add_section('newstore_header_type_section', array(
		'title'    => __('Header Types', 'newstore'),
		'priority' => 10,
		'panel'    => 'newstore_header_options_panel',
	));

	$wp_customize->add_setting('newstore_sticky_header_enable', array(
		'sanitize_callback' => 'newstore_sanitize_checkbox',
		'default'           => true,
	));

	$wp_customize->add_control('newstore_sticky_header_enable', array(
		'type'     => 'checkbox',
		'priority' => 10,
		'section'  => 'newstore_header_type_section',
		'label'    => __('Sticky Header Enable/Disable', 'newstore'),
	));

	$wp_customize->add_setting('newstore_header_type', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => 'two',
	));

	$wp_customize->add_control('newstore_header_type', array(
		'type'    => 'radio',
		'section' => 'newstore_header_type_section',
		'label'   => __('Header Type', 'newstore'),
		'choices' => array(
			'one' => esc_html__('Small', 'newstore'),
			'two' => esc_html__('Large', 'newstore'),
		),
	));
	/*types*/

	/*topbar*/
	$wp_customize->add_section('newstore_topbar_section', array(
		'title'    => __('Topbar Options', 'newstore'),
		'priority' => 10,
		'panel'    => 'newstore_header_options_panel',
	));

	$wp_customize->add_setting('newstore_topbar_enable', array(
		'sanitize_callback' => 'newstore_sanitize_checkbox',
		'default'           => true,
	));

	$wp_customize->add_control('newstore_topbar_enable', array(
		'type'     => 'checkbox',
		'priority' => 10,
		'section'  => 'newstore_topbar_section',
		'label'    => __('Topbar Enable/Disable', 'newstore'),
	));

	$wp_customize->add_setting('newstore_top_email', array(
		'sanitize_callback' => 'sanitize_email',
	));

	$wp_customize->add_control('newstore_top_email', array(
		'type'    => 'email',
		'section' => 'newstore_topbar_section',
		'label'   => __('Email', 'newstore'),
	));

	$wp_customize->add_setting('newstore_top_phone', array(
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('newstore_top_phone', array(
		'type'     => 'text',
		'priority' => 200,
		'section'  => 'newstore_topbar_section',
		'label'    => __('Phone', 'newstore'),
	));

	$wp_customize->add_setting('newstore_top_address', array(
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('newstore_top_address', array(
		'type'     => 'textarea',
		'priority' => 200,
		'section'  => 'newstore_topbar_section',
		'label'    => __('Address', 'newstore'),
	));
	/*topbar*/

	/*Layout Options*/
	if (class_exists('ThemeFarmer_Field_Range')) {
		$wp_customize->add_section('newstore_site_layouts_section', array(
			'title'    => __('Site Layout Options', 'newstore'),
			'panel'    => 'newstore_layout_panel',
			'priority' => 10,
		));

		$wp_customize->add_setting('newstore_site_layout_type', array(
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
			'default' => 'full',
		));

		$wp_customize->add_control('newstore_site_layout_type', array(
			'type'     => 'select',
			'section'  => 'newstore_site_layouts_section',
			'label'    => __('Site Layout', 'newstore'),
			'choices' => array(
				'full' => esc_html__( 'Full Width', 'newstore' ),
				'boxed' => esc_html__( 'Boxed', 'newstore' ),
			)
		));

		$wp_customize->add_setting('newstore_site_content_width', array(
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
			'default'           => '1340',
		));

		$wp_customize->add_control(new ThemeFarmer_Field_Range($wp_customize, 'newstore_site_content_width', array(
			'section'    => 'newstore_site_layouts_section',
			'label'      => esc_html__('Container Width', 'newstore'),
			'responsive' => false,
			'min'        => 300,
			'max'        => 1500,
			'step'       => 1,
		)));
		
		$wp_customize->add_setting('newstore_blog_content_width', array(
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
			'default'           => 70,
		));

		$wp_customize->add_control(new ThemeFarmer_Field_Range($wp_customize, 'newstore_blog_content_width', array(
			'section'    => 'newstore_blog_page_layouts_section',
			'label'      => esc_html__('Site Content Width', 'newstore'),
			'responsive' => false,
			'min'        => 50,
			'max'        => 100,
			'step'       => 1,
		)));
	}

	if (class_exists('ThemeFarmer_Field_Image_Select')) {
		$wp_customize->add_panel('newstore_layout_panel', array(
			'title'    => __('Layouts Optinos', 'newstore'),
			'priority' => 30,
		));

		$wp_customize->add_section('newstore_blog_page_layouts_section', array(
			'title'    => __('Blog Layout', 'newstore'),
			'panel'    => 'newstore_layout_panel',
			'priority' => 10,
		));

		$wp_customize->add_setting('newstore_blog_post_index_layout', array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'right',
		));

		$wp_customize->add_control(new ThemeFarmer_Field_Image_Select($wp_customize, 'newstore_blog_post_index_layout', array(
			'label'   => __('All Posts Page Layout', 'newstore'),
			'section' => 'newstore_blog_page_layouts_section',
			'choices' => array(
				'left'  => esc_url(get_template_directory_uri() . '/images/layout/2cleft.png'),
				'full'  => esc_url(get_template_directory_uri() . '/images/layout/full.png'),
				'right' => esc_url(get_template_directory_uri() . '/images/layout/2cright.png'),
			),
		)));

		$wp_customize->add_setting('newstore_blog_single_post_layout', array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'right',
		));

		$wp_customize->add_control(new ThemeFarmer_Field_Image_Select($wp_customize, 'newstore_blog_single_post_layout', array(
			'label'   => __('Single Post Layout', 'newstore'),
			'section' => 'newstore_blog_page_layouts_section',
			'choices' => array(
				'left'  => esc_url(get_template_directory_uri() . '/images/layout/2cleft.png'),
				'full'  => esc_url(get_template_directory_uri() . '/images/layout/full.png'),
				'right' => esc_url(get_template_directory_uri() . '/images/layout/2cright.png'),
			),
		)));

		$wp_customize->add_setting('newstore_blog_single_page_layout', array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'right',
		));

		$wp_customize->add_control(new ThemeFarmer_Field_Image_Select($wp_customize, 'newstore_blog_single_page_layout', array(
			'label'   => __('Single Page Layout', 'newstore'),
			'section' => 'newstore_blog_page_layouts_section',
			'choices' => array(
				'left'  => esc_url(get_template_directory_uri() . '/images/layout/2cleft.png'),
				'full'  => esc_url(get_template_directory_uri() . '/images/layout/full.png'),
				'right' => esc_url(get_template_directory_uri() . '/images/layout/2cright.png'),
			),
		)));

		if (class_exists('WooCommerce')) {
			$wp_customize->add_section('newstore_shop_page_layouts_section', array(
				'title'    => __('Shop Layout', 'newstore'),
				'panel'    => 'newstore_layout_panel',
				'priority' => 10,
			));

			$wp_customize->add_setting('newstore_shop_index_layout', array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'left',
			));

			$wp_customize->add_control(new ThemeFarmer_Field_Image_Select($wp_customize, 'newstore_shop_index_layout', array(
				'label'   => __('Shop Layout', 'newstore'),
				'section' => 'newstore_shop_page_layouts_section',
				'choices' => array(
					'left'  => esc_url(get_template_directory_uri() . '/images/layout/2cleft.png'),
					'full'  => esc_url(get_template_directory_uri() . '/images/layout/full.png'),
					'right' => esc_url(get_template_directory_uri() . '/images/layout/2cright.png'),
				),
			)));

			$wp_customize->add_setting('newstore_shop_single_product_layout', array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'full',
			));

			$wp_customize->add_control(new ThemeFarmer_Field_Image_Select($wp_customize, 'newstore_shop_single_product_layout', array(
				'label'   => __('Single Product Layout', 'newstore'),
				'section' => 'newstore_shop_page_layouts_section',
				'choices' => array(
					'left'  => esc_url(get_template_directory_uri() . '/images/layout/2cleft.png'),
					'full'  => esc_url(get_template_directory_uri() . '/images/layout/full.png'),
					'right' => esc_url(get_template_directory_uri() . '/images/layout/2cright.png'),
				),
			)));
		}
	}
	
	if(class_exists('ThemeFarmer_Field_Sortable') && function_exists('themefarmer_field_sortable_sanitize')){
		$wp_customize->add_setting('newstore_post_index_meta', array(
			'sanitize_callback' => 'themefarmer_field_sortable_sanitize',
			'default' => array('posted_on', 'posted_by', 'post_comments', 'post_categories'),
		));

		$wp_customize->add_control(new ThemeFarmer_Field_Sortable($wp_customize, 'newstore_post_index_meta', array(
			'label'   => __('Manage Post Index Meta', 'newstore'),
			'description' => __('Note: changes may not visible in customizer but will work on site.', 'newstore'),
			'section' => 'newstore_blog_page_layouts_section',
			'choices'  => array(
				'posted_on' => esc_html__('Post Date', 'newstore'),
				'posted_by'         => esc_html__('Post Author', 'newstore'),
				'post_comments'     => esc_html__('Post Comments', 'newstore'),
				'post_categories'       => esc_html__('Post Categories', 'newstore'),
				'post_tags'    => esc_html__('Post Tags', 'newstore'),
			),
		)));
	}

			

	/*Layout Options*/

	$frontpage_sections = array('sidebar-widgets-front-page-top-widget-area', 'sidebar-widgets-front-page-products-widget-area', 'sidebar-widgets-front-page-widget-area-column');
	foreach ($frontpage_sections as $key => $asection_id) {
		$section = $wp_customize->get_section($asection_id);
		if($section){
			$section->panel = 'themefarmer_fontpage_panel';
			$section->priority = 200;
		}
	}

	if(class_exists('NewStore_Upsale_Customize_Section1')){
		/*$wp_customize->add_section(new NewStore_Upsale_Customize_Section($wp_customize, 'newstore-upsell', array(
			'priority' => 2,
		)));*/

		$wp_customize->add_section(new NewStore_Upsale_Customize_Section1($wp_customize, 'newstore-upsell-section', array(
			'priority' => 999,
			'title'    => __('UPGRADE TO PRO', 'newstore'),
			'pro_text' => __('Go Pro', 'newstore'),
			'pro_url'  => 'https://themefarmer.com/product/newstore-pro/',
		)));
	}
	
	$wp_customize->get_section('header_image')->panel         = 'newstore_header_options_panel';
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial('blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'newstore_customize_partial_blogname',
		));
		$wp_customize->selective_refresh->add_partial('blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'newstore_customize_partial_blogdescription',
		));
	}


	$wp_customize->add_setting('newstore_theme_link_color', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
		'default'           => '#E91E63',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newstore_theme_link_color', array(
		'label'   => __('Link Color', 'newstore'),
		'section' => 'colors',
	)));

	$wp_customize->add_setting('newstore_theme_link_hover_color', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
		'default'           => '#E91E63',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newstore_theme_link_hover_color', array(
		'label'   => __('Link Hover Color', 'newstore'),
		'section' => 'colors',
	)));

	$wp_customize->add_setting('newstore_theme_post_title_color', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
		'default'           => '#E91E63',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newstore_theme_post_title_color', array(
		'label'   => __('Article Title Color', 'newstore'),
		'section' => 'colors',
	)));

	$wp_customize->add_setting('newstore_theme_post_title_hover_color', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
		'default'           => '#E91E63',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newstore_theme_post_title_hover_color', array(
		'label'   => __('Article Title Hover Color', 'newstore'),
		'section' => 'colors',
	)));

	$wp_customize->add_setting('newstore_theme_post_meta_color', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
		'default'           => '#E91E63',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newstore_theme_post_meta_color', array(
		'label'   => __('Article Meta Color', 'newstore'),
		'section' => 'colors',
	)));

	$wp_customize->add_setting('newstore_theme_post_meta_hover_color', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
		'default'           => '#E91E63',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newstore_theme_post_meta_hover_color', array(
		'label'   => __('Article Meta Hover Color', 'newstore'),
		'section' => 'colors',
	)));


	$wp_customize->add_setting('newstore_product_disable_zoom_feature', array(
		'sanitize_callback' => 'newstore_sanitize_checkbox',
		'transport'         => 'refresh',
		'default'           => true,

	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newstore_product_disable_zoom_feature', array(
		'label'   => __('New "product image zoom magnifier"', 'newstore'),
		'section' => 'woocommerce_product_images',
		'type'     => 'checkbox',
		'priority' => 2,
	)));
}
add_action('customize_register', 'newstore_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function newstore_customize_partial_blogname() {
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function newstore_customize_partial_blogdescription() {
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function newstore_customize_preview_js() {
	wp_enqueue_script('newstore-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), '1.3.1', true);
}
add_action('customize_preview_init', 'newstore_customize_preview_js');

if (class_exists('WP_Customize_Section')){
	class NewStore_Upsale_Customize_Section extends WP_Customize_Section {
		public $type = 'themefarmer-upsell';
		public function render() {
			$classes = 'accordion-section control-section-' . $this->type;
			$id      = 'themefarmer-upsell-buttons-section';
			?>
		    <li id="accordion-section-<?php echo esc_attr($this->id); ?>"class="<?php echo esc_attr($classes); ?>">
		        <div class="themefarmer-upsale">
		          	<?php esc_html_e( 'UPGRADE TO PRO', 'newstore' ); ?><a href="<?php echo esc_url('https://themefarmer.com/theme/newstore-pro/'); ?>" target="_blank" class="themefarmer-upsale-bt" id="themefarmer-pro-button"><?php esc_html_e('Go Pro', 'newstore');?></a>
		        </div>
		    </li>
		    <?php
		}
	}


	class NewStore_Upsale_Customize_Section1 extends WP_Customize_Section {
		public $type = 'themefarmer-upsell-button';
		public $pro_text = '';
		public $pro_url = '';
		public function render() {
			?>
		    <li id="accordion-section-<?php echo esc_attr($this->id); ?>" class="accordion-section control-section cannot-expand <?php echo esc_attr('control-section-' . $this->type); ?>" style="display: block;">
		        <h3 class="accordion-section-title newstore-upsale">
		        	<?php echo esc_html($this->title); ?>
		        	<?php if($this->pro_text && $this->pro_url): ?>
		          	<a href="<?php echo esc_url($this->pro_url); ?>" target="_blank" class="theme-upsale-button button button-secondary alignright" id="newstore-pro-button"><?php echo esc_html($this->pro_text); ?></a>
		          	<?php endif; ?>
		        </h3>
		    </li>
		    <?php
		}
	}
}