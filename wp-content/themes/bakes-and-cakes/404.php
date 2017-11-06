<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Bakes_And_Cakes
 */

get_header(); ?>
 

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            
            <div class="error-holder">
	            <div class="icon-holder">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/images/icon-error.png' );?>" alt="">
				</div>
				<div class="text-holder">
					<h1><?php esc_html_e( '404 Error', 'bakes-and-cakes' ); ?></h1>
					<h2><?php esc_html_e('Sorry, we can not find that page!','bakes-and-cakes'); ?></h2>
					<p><?php esc_html_e('Either something went wrong or the page does not exist anymore.','bakes-and-cakes'); ?></p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn"><?php esc_html_e('Homepage','bakes-and-cakes'); ?></a>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
