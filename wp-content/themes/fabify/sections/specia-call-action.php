<?php 
	$fabify_hs_call_actions			= get_theme_mod('hide_show_call_actions','on'); 
	$fabify_call_action_btn_lbl		= get_theme_mod('call_action_button_label');
	$fabify_call_action_btn_link	= get_theme_mod('call_action_button_link');
	if($fabify_hs_call_actions == 'on') :
?>
<section id="specia-cta" class="call-to-action wow fadeInDown">
    <div class="background-overlay">
        <div class="container">
            <div class="row padding-top-25 padding-bottom-25">
                
                <div class="col-md-9">
					<?php 
						$fabify_aboutusquery1 = new wp_query('page_id='.get_theme_mod('call_action_page',true)); 
						if( $fabify_aboutusquery1->have_posts() ) 
						{   while( $fabify_aboutusquery1->have_posts() ) { $fabify_aboutusquery1->the_post(); 
					?>
                    <h2 class="demo1"> <?php the_title(); ?> <span class="rotate"> <?php the_content(); ?></span> </h2>
					
					<?php } } wp_reset_postdata(); ?>
                </div>
				
				<?php if($fabify_call_action_btn_lbl) :?>
                <div class="col-md-3">
                    <a href="<?php echo esc_url($fabify_call_action_btn_link); ?>" class="call-btn-1"><?php echo esc_html($fabify_call_action_btn_lbl); ?></a>
                </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<?php wp_reset_postdata(); endif; ?>
