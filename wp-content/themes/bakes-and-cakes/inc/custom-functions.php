<?php 

/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Bakes And Cakes
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bakes_and_cakes_body_classes( $classes ) {

    global $post;

    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if( is_404() ) {
      $classes[] = 'error';
    }

    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
    $classes[] = 'custom-background-image';
  }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
    $classes[] = 'custom-background-color';
  }
    
   
    if( ! is_active_sidebar( 'right-sidebar' ) || is_page_template( 'template-home.php' ) || is_search()) {
        $classes[] = 'full-width'; 
    }

    if(is_page()){
        $bakes_and_cakes_post_class = bakes_and_cakes_sidebar_layout();
        if( $bakes_and_cakes_post_class == 'no-sidebar' )
            $classes[] = 'full-width';
    }
    if( bakes_and_cakes_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
      $classes[] = 'full-width';
    }

    return $classes;
}
add_filter( 'body_class', 'bakes_and_cakes_body_classes' );

/**
 * Custom Bread Crumb
 *
 * @link http://www.qualitytuts.com/wordpress-custom-breadcrumbs-without-plugin/
 */
 
function bakes_and_cakes_breadcrumbs_cb() {
 
    $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter   = get_theme_mod( 'bakes_and_cakes_breadcrumb_separator', __( '>', 'bakes-and-cakes' ) ); // delimiter between crumbs
    $home        = get_theme_mod( 'bakes_and_cakes_breadcrumb_home_text', __( 'Home', 'bakes-and-cakes' ) ); // text for the 'Home' link
    $showCurrent = get_theme_mod( 'bakes_and_cakes_ed_current', '1' ); // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before      = '<span class="current">'; // tag before the current crumb
    $after       = '</span>'; // tag after the current crumb
    
    global $post;
    $homeLink = home_url();
    
    if ( is_front_page() ) {
    
        if ( $showOnHome == 1 ) echo '<div id="crumbs"><a href="' . esc_url( $homeLink ) . '">' . esc_html( $home ) . '</a></div>';
    
    } else {
    
        echo '<div id="crumbs"><a href="' . esc_url( $homeLink ) . '">' . esc_html( $home ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span> ';
    
        if ( is_category() ) {
            $thisCat = get_category( get_query_var( 'cat' ), false );
            if ( $thisCat->parent != 0 ) echo get_category_parents( $thisCat->parent, TRUE, ' <span class="separator">' . esc_html( $delimiter ) . '</span> ' );
            echo $before .  esc_html( single_cat_title( '', false ) ) . $after;
        
        } elseif ( is_search() ) {
            echo $before . esc_html__( 'Search Results for "', 'bakes-and-cakes' ) . esc_html( get_search_query() ) . esc_html__( '"', 'bakes-and-cakes' ) . $after;
        
        } elseif ( is_day() ) {
            echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span> ';
            echo '<a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . esc_html( get_the_time( 'F' ) ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span> ';
            echo $before . esc_html( get_the_time( 'd' ) ) . $after;
        
        } elseif ( is_month() ) {
            echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span> ';
            echo $before . esc_html( get_the_time( 'F' ) ) . $after;
        
        } elseif ( is_year() ) {
            echo $before . esc_html( get_the_time( 'Y' ) ) . $after;
    
        } elseif ( is_single() && !is_attachment() ) {
            if ( bakes_and_cakes_is_woocommerce_activated() && 'product' === get_post_type() ) {
                if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {
                    $main_term = apply_filters( 'woocommerce_breadcrumb_main_term', $terms[0], $terms );
                    $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                    $ancestors = array_reverse( $ancestors );
                    foreach ( $ancestors as $ancestor ) {
                        $ancestor = get_term( $ancestor, 'product_cat' );    
                        if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                            echo '<a href="' . esc_url( get_term_link( $ancestor ) ) . '">' . esc_html( $ancestor->name ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span>';
                        }
                    }
                    echo '<a href="' . esc_url( get_term_link( $main_term ) ) . '">' . esc_html( $main_term->name ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span>';
                }
                if ( $showCurrent == 1 ) echo  $before . esc_html( get_the_title() ) . $after;
            }elseif ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . esc_url( $homeLink . '/' . $slug['slug'] ) . '/">' . esc_html( $post_type->labels->singular_name ) . '</a>';
                if ( $showCurrent == 1 ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ' . $before . esc_html( get_the_title() ) . $after;
            } else {
                $cat = get_the_category(); 
                if( $cat ){
                    $cat = $cat[0];
                    $cats = get_category_parents( $cat, TRUE, ' <span class="separator">' . esc_html( $delimiter ) . '</span> ' );
                    if ( $showCurrent == 0 ) $cats = preg_replace( "#^(.+)\s$delimiter\s$#", "$1", $cats );
                    echo $cats;
                }
                if ( $showCurrent == 1 ) echo $before . esc_html( get_the_title() ) . $after;
            }
        
        } elseif( bakes_and_cakes_is_woocommerce_activated() && ( is_product_category() || is_product_tag() ) ){
            
            $current_term = $GLOBALS['wp_query']->get_queried_object();
            if( is_product_category() ){
                $ancestors = get_ancestors( $current_term->term_id, 'product_cat' );
                $ancestors = array_reverse( $ancestors );
            foreach ( $ancestors as $ancestor ) {
              $ancestor = get_term( $ancestor, 'product_cat' );    
              if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                echo '<a href="' . esc_url( get_term_link( $ancestor ) ) . '">' . esc_html( $ancestor->name ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span> ';
              }
            }
            }           
            if ( $showCurrent == 1 ) echo $before . esc_html( $current_term->name ) . $after;
        
        } elseif( bakes_and_cakes_is_woocommerce_activated() && is_shop() ){
            if ( get_option( 'page_on_front' ) == wc_get_page_id( 'shop' ) ) {
            return;
          }
          $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
        
          if ( ! $_name ) {
            $product_post_type = get_post_type_object( 'product' );
            $_name = $product_post_type->labels->singular_name;
          }
            if ( $showCurrent == 1 ) echo $before . esc_html( $_name ) . $after;
        
        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . esc_html( $post_type->labels->singular_name ) . $after;
        
        } elseif ( is_attachment() ) {
            $parent = get_post( $post->post_parent );
            $cat = get_the_category( $parent->ID ); 
            if( $cat ){
                $cat = $cat[0];
                echo get_category_parents( $cat, TRUE, ' <span class="separator">' . esc_html( $delimiter ) . '</span> ');
                echo '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( $parent->post_title ) . '</a>' . ' <span class="separator">' . esc_html( $delimiter ) . '</span> ';
            }
            if ( $showCurrent == 1 ) echo  $before . esc_html( get_the_title() ) . $after;
        
        } elseif ( is_page() && !$post->post_parent ) {
            if ( $showCurrent == 1 ) echo $before . esc_html( get_the_title() ) . $after;
    
        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while( $parent_id ){
                $page = get_page( $parent_id );
                $breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . esc_html( get_the_title( $page->ID ) ) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse( $breadcrumbs );
            for ( $i = 0; $i < count( $breadcrumbs) ; $i++ ){
                echo $breadcrumbs[$i];
                if ( $i != count( $breadcrumbs ) - 1 ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ';
            }
            if ( $showCurrent == 1 ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ' . $before . esc_html( get_the_title() ) . $after;
        
        } elseif ( is_tag() ) {
            echo $before . esc_html( single_tag_title( '', false ) ) . $after;
        
        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata( $author );
            echo $before . esc_html( $userdata->display_name ) . $after;
        
        } elseif ( is_404() ) {
            echo $before . esc_html__( 'Error 404', 'bakes-and-cakes' ) . $after;
        
        } elseif( is_home() ){
            echo $before;
                single_post_title();
            echo $after;
            }
    
        echo '</div>';
    
    }
} // end bakes_and_cakes_breadcrumbs()

add_action( 'bakes_and_cakes_breadcrumbs', 'bakes_and_cakes_breadcrumbs_cb' );

/**
 * Hook to move comment text field to the bottom in WP 4.4
 * 
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-move-comment-text-field-to-bottom-in-wordpress-4-4/  
 */
function bakes_and_cakes_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'bakes_and_cakes_move_comment_field_to_bottom' );

if( ! function_exists( 'bakes_and_cakes_slider_cb' )):
/**
 * Callback for Home Page Slider 
**/
function bakes_and_cakes_slider_cb(){
    
    $bakes_and_cakes_slider_caption  = get_theme_mod( 'bakes_and_cakes_slider_caption', '1' );
    $bakes_and_cakes_slider_readmore = get_theme_mod( 'bakes_and_cakes_slider_readmore', __( 'Continue Reading', 'bakes-and-cakes' ) );
    $bakes_and_cakes_slider_cat      = get_theme_mod( 'bakes_and_cakes_slider_cat' );
    
    if( $bakes_and_cakes_slider_cat ){
        $bakes_and_cakes_qry = new WP_Query ( array( 
            'post_type'     => 'post', 
            'post_status'   => 'publish',
            'posts_per_page'=> -1,                    
            'cat'           => $bakes_and_cakes_slider_cat,
            'order'         => 'ASC'
        ) );
        
        if( $bakes_and_cakes_qry->have_posts() ){?>
           <div class="banner">
                 <ul id="slider">
                    <?php
                    while( $bakes_and_cakes_qry->have_posts() ){
                        $bakes_and_cakes_qry->the_post();
                        $bakes_and_cakes_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'bakes-and-cakes-slider' );
                    ?>
                        <?php if( has_post_thumbnail() ){?>
                        <li>
                            <img src="<?php echo esc_url( $bakes_and_cakes_image[0] ); ?>" alt="<?php the_title_attribute(); ?>" />
                            <?php if( $bakes_and_cakes_slider_caption ){ ?>
                            <div class="banner-text">
                                <div class="container">
                                    <div class="text">
                                        <strong class="title"><?php the_title(); ?></strong>
                                        <?php the_excerpt(); ?>
                                        <a class="btn" href="<?php the_permalink(); ?>"><?php echo esc_html( $bakes_and_cakes_slider_readmore );?></a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    <?php
                    }
                    ?>
                    </ul>
                </div>
            <?php
        }
        wp_reset_postdata();       
    }    
 }

endif;

add_action( 'bakes_and_cakes_slider', 'bakes_and_cakes_slider_cb' );


function bakes_and_cakes_get_sections(){

    $bakes_and_cakes_sections = array(
            
            'about-section' => array(
                'id' => 'about',
                'class' => 'intro'
              ),

            'product-section' => array(
                'id' => 'product',
                'class' => 'featured'
              ),

            'events-section' => array(
                'id' => 'events',
                'class' => 'special'
              ),

            'our-staff-section' => array(
                'id' => 'staff',
                'class' => 'our-staff'
              ),

            'testimonial-section' => array(
                'id' => 'testimonials',
                'class' => 'testimonial'
              ),

            'blog-section' => array(
                'id' => 'blog',
                'class' => 'blog-section'
              ),

            'promotional-section' => array(
                'id' => 'promotional',
                'class' => 'promotional-block'
              ),
      );
    $bakes_and_cakes_enabled_section = array();
    foreach ( $bakes_and_cakes_sections as $bakes_and_cakes_section ) {
        
        if ( esc_attr( get_theme_mod( 'bakes_and_cakes_ed_' . $bakes_and_cakes_section['id'] . '_section' ) ) == 1 ){
            $bakes_and_cakes_enabled_section[] = array(
                'id' => $bakes_and_cakes_section['id'],
                'class' => $bakes_and_cakes_section['class']
            );
        }
    }
    return $bakes_and_cakes_enabled_section;
  }

function bakes_and_cakes_bg_image_settings(){

       $bakes_and_cakes_bg_images = array(
         
        'staff-section' => array(
            'bgimage' => 'staff'
        ),

        'promotional-section' => array(
            'bgimage' => 'promotional'
        ) 
      );
    $bakes_and_cakes_bg = array();
    foreach($bakes_and_cakes_bg_images as $bakes_and_cakes_bg_image){
    
    if( get_theme_mod( 'bakes_and_cakes_' . $bakes_and_cakes_bg_image['bgimage'] . '_background_image' ) ){
       $bakes_and_cakes_bg[] = array(
        'bgimage' => $bakes_and_cakes_bg_image['bgimage']
        );
    }
  }
  return  $bakes_and_cakes_bg;
 }

if( ! function_exists( 'bakes_and_cakes_footer_top' ) ) :
/**
 * Footer Top
 *  
*/
function bakes_and_cakes_footer_top(){
    ?>
    <div class="footer-t">
        <div class="row">
            <div class="three-cols">
                <div class="col">   
                    <?php  
                    if (is_active_sidebar('footer-first')) {
                        dynamic_sidebar('footer-first');
                    } ?>
                </div>
                <div class="col center">   
                    <section class="widget widget_contact_form">    
                    <?php   
                        if (is_active_sidebar('footer-second')) { ?>
                            <div class="form-holder"> 
                                <?php dynamic_sidebar('footer-second'); ?>
                            </div>
                    <?php } ?>
                    </section>
                </div>
                <div class="col">
                    <?php if (is_active_sidebar('footer-third')) {
                            dynamic_sidebar('footer-third');
                        } ?>
                </div>
            </div>    
        </div>
    </div>
<?php
}
endif;
add_action( 'bakes_and_cakes_footer_top', 'bakes_and_cakes_footer_top' );

if( ! function_exists( 'bakes_and_cakes_footer_info' ) ) :
/**
 * Footer Info
 * 
*/
function bakes_and_cakes_footer_info(){
    $copyright_text = get_theme_mod( 'bakes_and_cakes_footer_copyright_text' );
    ?>
    <div class="site-info">        
        <span>
        <?php 
            if( $copyright_text ){
                echo wp_kses_post( $copyright_text );
            }else{
                esc_html_e( '&copy; ', 'bakes-and-cakes' ); 
                esc_html_e( date_i18n( 'Y' ), 'bakes-and-cakes' );
                echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>.';    
            }
        ?>
        </span>
        <a href="<?php echo esc_url( 'http://raratheme.com/wordpress-themes/bakes-and-cakes/' ); ?>" rel="author" target="_blank">
            <?php echo esc_html__( 'Bakes and Cakes by Rara Theme.', 'bakes-and-cakes' ); ?>
        </a>
        <?php printf(esc_html__('Powered by %s', 'bakes-and-cakes'), '<a href="' . esc_url(__('https://wordpress.org/', 'bakes-and-cakes')) . '">WordPress.</a>'); ?>
    </div><!-- .site-info -->
<?php
}
endif;
add_action( 'bakes_and_cakes_footer', 'bakes_and_cakes_footer_info' );

/**
 * Escape iframe
*/
function bakes_and_cakes_sanitize_iframe( $iframe ){
        $allow_tag = array(
            'iframe'=>array(
            'src'   => array()
            ) );
    return wp_kses( $iframe, $allow_tag );
    }


/**
 * Ajax Callback for Team section
*/
function bakes_and_cakes_home_team_ajax(){

    $id   = $_POST['id'];
    $staff_cat = get_theme_mod('bakes_and_cakes_staff_section_cat');
    $response  = '';

    $args = array( 
        'title'               => $id,
        'post_status'         => 'publish',
        'cat'                 => $staff_cat,    
        'ignore_sticky_posts' => true,
    );
    
    $bakes_and_cakes_qry = new WP_Query( $args );
    if( !empty( $id ) && $bakes_and_cakes_qry->have_posts() ){
        while( $bakes_and_cakes_qry->have_posts() ){ 
            $bakes_and_cakes_qry->the_post(); 
            
            if( has_post_thumbnail() ){
                $response .= '<div class="img-holder">';
                $response .= get_the_post_thumbnail( get_the_ID(), 'bakes-and-cakes-staff-thumb' );
                $response .= '</div>';
            } 
            $response .= '<div class="text-holder">';
            $response .= '<strong class="name">' . esc_html( get_the_title() ) . '</strong>';
            $response .= wpautop(  wp_kses_post( get_the_content() ) );
            $response .= '</div>';   

            
        }
        wp_reset_postdata(); 
    }
    echo $response;
    
    wp_die();
}
add_action( 'wp_ajax_bakes_and_cakes_team_ajax', 'bakes_and_cakes_home_team_ajax' );
add_action( 'wp_ajax_nopriv_bakes_and_cakes_team_ajax', 'bakes_and_cakes_home_team_ajax' ); 

/**
 * Query if Rara One Click Demo Import id activate
*/
function is_rocdi_activated(){
    return class_exists( 'RDDI_init' ) ? true : false;
}