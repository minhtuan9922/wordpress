<?php
/**
 * Featured Dish Section
 * 
 * @package Bakes And Cakes
 */

$featured_product_page  = get_theme_mod('bakes_and_cakes_featured_product_page');  ?>

<div class="container">

<?php if($featured_product_page){
    
    $page_qry = new WP_Query(array(
        'post_type' => 'page',
        'p' => $featured_product_page,
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

if( bakes_and_cakes_is_woocommerce_activated() ){
    
	$featured_product_one   = get_theme_mod('bakes_and_cakes_product_one');
	$featured_product_two   = get_theme_mod('bakes_and_cakes_product_two');
	$featured_product_three = get_theme_mod('bakes_and_cakes_product_three');
	$featured_product_four  = get_theme_mod('bakes_and_cakes_product_four');
	$featured_product_five  = get_theme_mod('bakes_and_cakes_product_five');
	$featured_product_six   = get_theme_mod('bakes_and_cakes_product_six');
	$featured_product_seven = get_theme_mod('bakes_and_cakes_product_seven');
	$featured_product_eight = get_theme_mod('bakes_and_cakes_product_eight');
	$featured_product_nine  = get_theme_mod('bakes_and_cakes_product_nine');
	$featured_product_ten   = get_theme_mod('bakes_and_cakes_product_ten');

    if( $featured_product_one || $featured_product_two || $featured_product_three || $featured_product_four || $featured_product_five || $featured_product_six || $featured_product_seven || $featured_product_eight || $featured_product_nine || $featured_product_ten ){
    $featured_products = array(  $featured_product_one, $featured_product_two, $featured_product_three, $featured_product_four, $featured_product_five, $featured_product_six, $featured_product_seven, $featured_product_eight, $featured_product_nine, $featured_product_ten );
    $featured_products = array_diff( array_unique( $featured_products ), array('') );
    
    $product_qry = new WP_Query( array( 
        'post_type'           => 'product',
        'post__in'            => $featured_products,
        'orderby'             => 'post__in',
        'ignore_sticky_posts' => true,
        'posts_per_page'       => '10'
    
    ) );

        if($product_qry->have_posts()){ ?>
			<ul class="featured-slider">
			<?php while($product_qry->have_posts()){ $product_qry->the_post();
			      $price = get_post_meta( get_the_ID(), '_regular_price', true);?>
				<li>
					<div class="img-holder">
						<a href="<?php the_permalink(); ?>">
						     <?php the_post_thumbnail('bakes-and-cakes-product-thumb'); ?>
						</a>
					 </div>
					<div class="text-holder">
						<a href="<?php the_permalink(); ?>"><strong class="name"><?php the_title(); ?></strong></a>
						<span class="price">
						    <?php $string = wc_price( $price, array() );
						          echo wp_kses_post( $string ); ?>
						</span>
						
					</div>
				</li>
			<?php } ?>
			</ul>
	<?php } 
	wp_reset_postdata();
	} } ?>
</div>
