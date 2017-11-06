<?php
/**
 * Blog Section
 * 
 * @package Bakes And Cakes
 */

$blog_page   = get_theme_mod('bakes_and_cakes_blog_page');
            
    echo '<div class="container">';
    if($blog_page){
        $page_qry = new WP_Query(array(   
		   'post_type' => 'page',
	       'p' => $blog_page,
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

	$blog_qry = new WP_Query( array( 
	    'post_type'             => 'post',
	    'posts_per_page'        => 4,
	    'ignore_sticky_posts'   => true
	 ));   
        if( $blog_qry->have_posts() ){ ?>   
            <div class="row">
	            <?php while($blog_qry->have_posts()){ $blog_qry->the_post(); ?>
			        <article class="post">
						<?php if(has_post_thumbnail()){ ?>
							<a href="<?php the_permalink(); ?>" class="post-thumbnail">
								<?php the_post_thumbnail('bakes-and-cakes-blog-thumb');?>
							</a>
						<?php } ?>
						<div class="text-holder">
							<header class="entry-header">
								<span class="posted-on"><a href="<?php the_permalink(); ?>"><time><?php echo esc_html(get_the_date()); ?></time></a></span>
								<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							</header>
						</div>
					</article>
			        <?php }  ?>
			    </div>
	        <?php } 
	        wp_reset_postdata();
		echo '</div>';
