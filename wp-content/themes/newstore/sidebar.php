<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NewSrore
 */

if ( ! is_active_sidebar( 'sidebar' ) ) {
	return;
}
$layout_class = newstore_blog_widget_layout();
if($layout_class != 'full-width'){
?>
<aside id="secondary" class="sidebar-widget-area widget-area <?php echo esc_attr( $layout_class ); ?>">
	<?php dynamic_sidebar( 'sidebar' ); ?>
</aside><!-- #secondary -->
<?php
}
