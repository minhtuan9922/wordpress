<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bakes_And_Cakes
 */
$enabled_sections = bakes_and_cakes_get_sections();  

if( is_home() || ! $enabled_sections || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ){ echo '</div></div>'; } ?>
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		
		<div class="container">

			<?php 
            do_action( 'bakes_and_cakes_footer_top' );
			do_action( 'bakes_and_cakes_footer' ); ?>
		
		</div>
	
	</footer><!-- #colophon -->
	<a href="javascript:void(0);" class="btn-top"><span><?php _e('Top','bakes-and-cakes'); ?></span></a>

</div><!-- #page -->

<?php wp_footer();?>

</body>
</html>
