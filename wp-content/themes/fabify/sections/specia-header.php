<?php 					
	$fabify_hs_social= get_theme_mod('hide_show_social','1'); 
	$fabify_hs_contact_infos= get_theme_mod('hide_show_contact_infos','1'); 
	
	if ( ($fabify_hs_social) || ($fabify_hs_contact_infos) == '1') :
?>
<section id="specia-header" class="header-top-info-1">
    <div class="container">
        <div class="row">
            
			<?php 
				$fabify_header_email	= get_theme_mod('header_email'); 
				$fabify_header_contact	= get_theme_mod('header_contact_num'); 
			?>

            <div class="col-md-6 col-sm-7">
				<?php if($fabify_hs_contact_infos == '1') { ?>
					<!-- Start Contact Info -->
					<ul class="info pull-left">
						<?php if($fabify_header_email) { ?> 
							<li><a href="mailto:<?php echo esc_html($fabify_header_email); ?>"><i class="fa fa-envelope-o"></i> <?php echo esc_html($fabify_header_email); ?> </a></li>
						<?php } ?>
						
						<?php if($fabify_header_contact) { ?> 
							<li><a href="tel:<?php echo esc_html($fabify_header_contact); ?>"><i class="fa fa-phone"></i> <?php echo esc_html($fabify_header_contact); ?></a></li>
						<?php } ?>
					</ul>
					<!-- /End Contact Info -->
				<?php } ?>
			</div>
			
			<div class="col-md-6 col-sm-5">
                <!-- Start Social Media Icons -->
				<?php 
					$fabify_facebook_link		= get_theme_mod('facebook_link',''); 
					$fabify_linkedin_link		= get_theme_mod('linkedin_link',''); 
					$fabify_twitter_link		= get_theme_mod('twitter_link',''); 
					$fabify_googleplus_link		= get_theme_mod('googleplus_link',''); 
					$fabify_instagram_link		= get_theme_mod('instagram_link',''); 
					$fabify_dribble_link		= get_theme_mod('dribble_link',''); 
					$fabify_github_link			= get_theme_mod('github_link',''); 
					$fabify_bitbucket_link		= get_theme_mod('bitbucket_link',''); 
					$fabify_email_link			= get_theme_mod('email_link',''); 
					$fabify_skype_link			= get_theme_mod('skype_link',''); 
					$fabify_skype_action_link	= get_theme_mod('skype_action_link',''); 
					$fabify_vk_link				= get_theme_mod('vk_link','');
					$fabify_pinterest_link		= get_theme_mod('pinterest_link','');			
				?>
				
				
					<?php if($fabify_hs_social == '1') { ?>
						<ul class="social pull-right">
							<?php if($fabify_facebook_link) { ?> 
								<li><a href="<?php echo esc_url($fabify_facebook_link); ?>"><i class="fa fa-facebook"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_linkedin_link) { ?> 
							<li><a href="<?php echo esc_url($fabify_linkedin_link); ?>"><i class="fa fa-linkedin"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_twitter_link) { ?> 
							<li><a href="<?php echo esc_url($fabify_twitter_link); ?>"><i class="fa fa-twitter"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_googleplus_link) { ?> 
							<li><a href="<?php echo esc_url($fabify_googleplus_link); ?>"><i class="fa fa-google-plus"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_instagram_link) { ?> 
							<li><a href="<?php echo esc_url($fabify_instagram_link); ?>"><i class="fa fa-instagram"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_dribble_link) { ?> 
							<li><a href="<?php echo esc_url($fabify_dribble_link); ?>"><i class="fa fa-dribbble"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_github_link) { ?> 
							<li><a href="<?php echo esc_url($fabify_github_link); ?>"><i class="fa fa-github-alt"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_bitbucket_link) { ?> 
							<li><a href="<?php echo esc_url($fabify_bitbucket_link); ?>"><i class="fa fa-bitbucket"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_email_link) { ?> 
							<li><a href="mailto:<?php echo esc_attr($fabify_email_link); ?>"><i class="fa fa-envelope-o"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_skype_link) { ?> 
							<li><a href="<?php echo esc_attr($fabify_skype_link); ?>?<?php echo esc_attr($fabify_skype_action_link); ?>"><i class="fa fa-skype"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_vk_link) { ?> 
							<li><a href="<?php echo esc_url($fabify_vk_link); ?>"><i class="fa fa-vk"></i></a></li>
							<?php } ?>
							
							<?php if($fabify_pinterest_link) { ?> 
							<li><a href="<?php echo esc_url($fabify_pinterest_link); ?>"><i class="fa fa-pinterest-square"></i></a></li>
							<?php } ?>
						</ul>
					<?php } ?>
                <!-- /End Social Media Icons-->
            </div>
			
        </div>
    </div>
</section>

<div class="clearfix"></div>
<?php endif; ?>