<?php 
	$fabify_hs_features				= get_theme_mod('hide_show_features','on'); 
	$fabify_features_title			= get_theme_mod('features_title'); 
	$fabify_features_desc			= get_theme_mod('features_description'); 
	$fabify_features_bg_setting		= get_theme_mod('features_background_setting',''); 
	$fabify_features_bg_position	= get_theme_mod('features_background_position','fixed'); 	
	if($fabify_hs_features == 'on') {
?>
<?php
	if($fabify_features_bg_setting !== '') {
?>
<section id="specia-feature" class="features-version-one" style="background: url('<?php echo esc_url($fabify_features_bg_setting); ?>') no-repeat <?php echo esc_attr($fabify_features_bg_position); ?> 0 0 / cover rgba(0, 0, 0, 0);">

<?php	
} else {
?>
<section id="specia-feature" class="features-version-one" style="background: url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/features.jpg') no-repeat fixed 0 0 / cover rgba(0, 0, 0, 0);">

<?php
}
?>
    <div class="features-overlay">
        <div class="container">
            
            <div class="row text-center padding-top-60 padding-bottom-30">
                <div class="col-sm-12">
					<?php if ($fabify_features_title)  : ?>
						<h2 class="section-heading wow zoomIn"><?php echo wp_filter_post_kses($fabify_features_title); ?></span></h2>
					<?php endif; ?>
					
					<?php if ($fabify_features_desc)  : ?>
						<p class="section-description"><?php echo esc_html($fabify_features_desc); ?></p>
					<?php endif; ?>
                </div>
            </div>
			
			<?php 
				if( is_active_sidebar('specia_feature_widget') ) :
					echo '<div class="row padding-bottom-30">';
						dynamic_sidebar( 'specia_feature_widget' );
					echo '</div>';
				endif;
			?>
		
		</div>
    </div>
</section>
<div class="clearfix"></div>
<?php } ?>