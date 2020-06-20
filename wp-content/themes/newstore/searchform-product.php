<form role="search" method="get" class="search-form nestore-search-form d-block w-100" autocomplete="off" action="<?php the_permalink(wc_get_page_id( 'shop' )); ?>">
	<div class="w-100 search-form-inner">
		<div class="search-form-cat-container">
		<?php 
			$swp_cat_dropdown_args = array(
				'taxonomy' 		   => 'product_cat',
				'show_option_all'  => esc_html__( 'All Categories', 'newstore'),
				'name'             => 'product_cat',
				'class'            => 'search-form-categories',
				'value_field'	   => 'slug',
				'selected'         => (isset($_GET['product_cat']) && $_GET['product_cat'])?sanitize_text_field($_GET['product_cat']):false,
			);
			wp_dropdown_categories( $swp_cat_dropdown_args );
		 ?>
		</div>
		<input type="search" class="input-text main-input-search tfwctool-auto-ajaxsearch-input" placeholder="<?php esc_attr_e('Search ','newstore'); ?>" value="<?php the_search_query(); ?>" name="s" title="<?php esc_attr_e('Search for:','newstore'); ?>" autcomplete="false">
		<span class="search-spinner"><i class="fa fa-refresh fa-spin"></i></span>
		<input type="hidden" name="post_type" value="product">
		<button type="submit" class="main-search-submit" ><i class="fa fa-search"></i></button>
	</div>
</form>