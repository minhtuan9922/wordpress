<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bakes_And_Cakes
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	
	<header id="masthead" class="site-header" role="banner">
	    <div class="header-t">
			  <div class="container">
				 <div class="site-branding">
    			<?php 
              if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                the_custom_logo();
              } ?>
    			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
    			<?php
    			   $description = get_bloginfo( 'description', 'display' );
    			if ( $description || is_customize_preview() ) : ?>
    				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
    			<?php endif; ?>
    		</div><!-- .site-branding -->
        <div id="mobile-header">
          <a id="responsive-menu-button" href="#sidr-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
        </div>
			</div>
		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

  <?php $enable_slider    = get_theme_mod('bakes_and_cakes_ed_slider');
        $enabled_sections = bakes_and_cakes_get_sections();  
        $ed_breadcrumbs   = get_theme_mod('bakes_and_cakes_ed_breadcrumb');
        
        if( (is_front_page() || is_page_template('template-home.php')) && $enable_slider ) {
          
          do_action('bakes_and_cakes_slider');
       
        }

        if( is_home() || ! $enabled_sections || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ){ 
   	       
          echo '<div class="container">';
	          
            echo '<div id="content" class="site-content">'; 
              
              if($ed_breadcrumbs){ do_action('bakes_and_cakes_breadcrumbs'); }
        } ?>
