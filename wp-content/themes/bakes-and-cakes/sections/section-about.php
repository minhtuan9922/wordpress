<?php
/**
 * Our Story Section
 * 
 * @package Bakes And Cakes
 */

$about_us_page  = get_theme_mod('bakes_and_cakes_about_us_page');
   if($about_us_page){
         $about_qry = new WP_Query(array(   
			       'post_type' => 'page',
			       'p' => $about_us_page,
				)); ?>
				
    <div class="container">
	   <?php if($about_qry->have_posts()){ 
	   	        while( $about_qry->have_posts() ){ $about_qry->the_post(); ?>
	    
	    <div class="columns-2">
			<header class="heading">
				<h1 class="main-title"><?php the_title(); ?></h1>		
			</header>
			<div class="text">
				<?php the_excerpt(); ?>
			</div>
				<div class="btn-holder">
				    <a href="<?php the_permalink(); ?>">
				        <?php echo _e('Read More', 'bakes-and-cakes'); ?>
				    </a>
				</div>
		</div>
        <?php if( has_post_thumbnail()){ ?>
		<div class="columns-2 image-holder">		   
			<?php the_post_thumbnail('bakes-and-cakes-about-thumb'); ?>			
		</div>
	    <?php } } }
	    wp_reset_postdata();?>	
	</div>
<?php } ?>