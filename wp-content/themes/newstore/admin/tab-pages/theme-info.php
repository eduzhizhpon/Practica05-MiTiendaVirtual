<div class="row">
	<div class="theme-left">
		<div class="theme-info-inner">
			<img src="<?php echo esc_url($this->theme->get_screenshot()); ?>" class="img-responsive theme-screenshot">
		</div>
	</div>
	<div class="theme-right">
		<div class="theme-info-inner">
			<div class="theme-setup-instructions">
				<ul>
					<li><?php esc_html_e( 'Please check Documentation or theme setup video.', 'newstore' ); ?></li>
					<li><?php esc_html_e( 'if you still face issue feel free to contact us on chat on our site.', 'newstore' ); ?></li>
					<li><a href="<?php echo esc_url('https://themefarmer.com/') ?>"><?php esc_html_e( 'ThemeFamrer', 'newstore' ); ?></a></li>

				</ul>
				<br>
				<br> 
				<a href="<?php echo esc_url('https://www.youtube.com/watch?v=WSqwS-maAvk'); ?>" target="_blank"><?php esc_html_e( 'Full Theme Setup Video', 'newstore' ); ?></a> <br><br> <a href="<?php echo esc_url('https://www.youtube.com/watch?v=MDZGjhrxTLg'); ?>" target="_blank"><?php echo esc_html__( 'Quick Demo Data Import Video', 'newstore' ); ?></a> <br><br>
				<hr>
				<div class="demo-data-import text-center">
					<?php if(class_exists('OCDI_Plugin')): ?>
						<a class="button" href="<?php echo esc_url(admin_url('themes.php?page=pt-one-click-demo-import')); ?>"><?php esc_html_e( 'Import Demo Data', 'newstore' ); ?></a>
					<?php else: ?>
						<strong><?php esc_html_e( 'If you want to import demo data you need to install recommended plugins And go to Appearance -> Import Demo Data', 'newstore' ); ?></strong>
					<?php endif ?>
				</div>
			</div>
			<div class="info-links">
					<strong><?php esc_html_e('Theme Links', 'newstore');?></strong>
					<br>
					<br>
					<?php if(!empty($this->demo_link)): ?>
					<a class="button button-default" href="<?php echo esc_url($this->demo_link); ?>" target="_blank"><?php esc_html_e('Theme Demo', 'newstore');?></a>
					<?php endif; ?>
					<?php if(!empty($this->docs_link)): ?>
					<a class="button button-default" href="<?php echo esc_url($this->docs_link); ?>" target="_blank"><?php esc_html_e('Theme Documentation', 'newstore');?></a>
					<?php endif; ?>
					<?php if(!empty($this->theme_page)): ?>
					<a class="button button-default" href="<?php echo esc_url($this->theme_page); ?>" target="_blank"><?php esc_html_e('Theme Page', 'newstore');?></a>
					<?php endif; ?>
					<?php if(!empty($this->rate_link)): ?>
					<a class="button button-default" href="<?php echo esc_url($this->rate_link); ?>" target="_blank"><?php esc_html_e('Rate this theme', 'newstore');?></a>
					<?php endif; ?>
					<hr>
					<?php if (!empty($this->pro_link)):?>
					<a class="button button-orange" href="<?php echo esc_url($this->pro_link); ?>" target="_blank"><?php esc_html_e('View Pro Version', 'newstore');?></a>
					<?php endif; ?>
			</div>
			
		</div>
	</div>
</div>
<div style="clear: both;"></div>