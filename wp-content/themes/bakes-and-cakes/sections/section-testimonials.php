<?php
/**
 * Testimonials Section
 * 
 * @package Bakes And Cakes
 */
  $testimonial_cat   = get_theme_mod('bakes_and_cakes_testimonials_section_cat');
  $testimonial_page  = get_theme_mod('bakes_and_cakes_testimonial_page');
            
    echo '<div class="container">';
    if($testimonial_page){
        $page_qry = new WP_Query(array(   
		   'post_type' => 'page',
	       'p' => $testimonial_page,
		));
			
		if($page_qry->have_posts()){
		    while($page_qry->have_posts()){ $page_qry->the_post(); 
				echo '<header class="header">';
				  echo '<h1 class="main-title">';
				    the_title();
				  echo '</h1>';
				    the_excerpt();
				echo '</header>';
		    }
		}
	    wp_reset_postdata();
    }

    if($testimonial_cat){
        $testimonial_qry = new WP_Query( array(
 	        'post_type' => 'post',
            'posts_per_page' => 5,
            'cat' => $testimonial_cat,
            'ignore_sticky_posts' => true
            )); 

        if($testimonial_qry->have_posts()){ $i = 0;?>
			<div class="tab-content">
			<?php while($testimonial_qry->have_posts()){
			      $testimonial_qry->the_post(); $i++;?>
				<div id="tab<?php echo $i; ?>">
				   <?php the_content(); ?>
				</div>
			<?php } ?>
			</div>
			<ul class="tabset">
			<?php $j=0;
			    while($testimonial_qry->have_posts()){
			      $testimonial_qry->the_post(); $j++; ?>
				<li>
					<a href="#tab<?php echo $j; ?>" <?php if($j%3 == 0 ){ echo 'class="active"'; } ?>>
					<?php $id = get_the_ID();
					      $image = wp_get_attachment_url(get_post_thumbnail_id($id)); ?>
						<img src="<?php echo esc_url($image); ?>" height="98" width="98" alt="">
						<span class="text-holder">
							<strong class="name"><?php the_title(); ?></strong>
							<?php if(has_excerpt()){ ?>
							<span><?php the_excerpt(); ?></span>
							<?php } ?>
						</span>
					</a>
				</li>
			<?php } ?>
			</ul>
	<?php } } 
	echo '</div>'; ?>