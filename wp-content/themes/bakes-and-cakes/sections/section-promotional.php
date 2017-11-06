<?php
/**
 * Promotional Block Section
 * 
 * @package Bakes And Cakes
 */


$button      = get_theme_mod('bakes_and_cakes_promotional_block_button');
$button_link = get_theme_mod('bakes_and_cakes_promotional_block_button_link');
$promotional_page  = get_theme_mod('bakes_and_cakes_promotional_page');
            
    echo '<div class="container">';
    if($promotional_page){
        $page_qry = new WP_Query(array(   
		   'post_type' => 'page',
	       'p' => $promotional_page,
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
		if($button && $button_link){ ?>
			<div class="btn-holder">
				<a href="<?php echo esc_url( $button_link ); ?>" class="btn-join"><?php echo esc_html($button); ?></a>
			</div>
		<?php } ?>
		</div>