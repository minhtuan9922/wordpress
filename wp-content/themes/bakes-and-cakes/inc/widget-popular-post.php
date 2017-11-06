<?php
/**
 * Widget Popular Post
 *
 * @package Bakes and Cakes
 */
 
// register bakes_and_cakes_Popular_Post widget
function bakes_and_cakes_register_popular_post_widget() {
    register_widget( 'bakes_and_cakes_Popular_Post' );
}
add_action( 'widgets_init', 'bakes_and_cakes_register_popular_post_widget' );

if( !class_exists( 'bakes_and_cakes_Popular_Post' ) ):
 /**
 * Adds bakes_and_cakes_Popular_Post widget.
 */
class bakes_and_cakes_Popular_Post extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bakes_and_cakes_popular_post', // Base ID
			__( 'RARA: Popular Post', 'bakes-and-cakes' ), // Name
			array( 'description' => __( 'A Popular Post Widget', 'bakes-and-cakes' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
	   
        $title          = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Most Viewed', 'bakes-and-cakes' );
        $num_post       = ! empty( $instance['num_post'] ) ? $instance['num_post'] : 3 ;
        $show_thumbnail = ! empty( $instance['show_thumbnail'] ) ?  $instance['show_thumbnail'] : '';
        $show_postdate  = ! empty( $instance['show_postdate'] ) ?  $instance['show_postdate'] : '';
        
        $bakes_and_cakes_qry = new WP_Query( array(
            'post_type'             => 'post',
            'post_status'           => 'publish',
            'posts_per_page'        => $num_post,
            'ignore_sticky_posts'   => true,
            'orderby'               => 'comment_count'
        ) );
        if( $bakes_and_cakes_qry->have_posts() ){
            echo $args['before_widget'];
            if( $title ) echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title'];
            ?>
            <ul>
                <?php 
                while( $bakes_and_cakes_qry->have_posts() ){
                    $bakes_and_cakes_qry->the_post();
                ?>
                    <li>
                        <?php if( has_post_thumbnail() && $show_thumbnail ){ ?>
                            <a href="<?php the_permalink();?>" class="post-thumbnail">
                                <?php the_post_thumbnail( 'bakes-and-cakes-post-thumb' );?>
                            </a>
                        <?php }?>
						<div class="entry-header">
							<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
							<?php if( $show_postdate ) {?>
                                    <span class="posted-on"><a href="<?php the_permalink(); ?>">
                                        <time datetime="<?php printf( __( '%1$s', 'bakes-and-cakes' ), esc_html(get_the_date('Y-m-d')) ); ?>">
                                        <?php printf( __( '%1$s', 'bakes-and-cakes' ), esc_html( get_the_date('Y/m/d') ) ); ?></time></a>
                                    </span>
                            <?php  } ?>
						</div>                        
                    </li>        
                <?php    
                }
            ?>
            </ul>
            <?php
            echo $args['after_widget'];   
        }
        wp_reset_postdata();  
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
        
        $title          = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Most Viewed', 'bakes-and-cakes' );		
        $num_post       = ! empty( $instance['num_post'] ) ? $instance['num_post'] : 3 ;
        $show_thumbnail = ! empty( $instance['show_thumbnail'] ) ?  $instance['show_thumbnail'] : '';
        $show_postdate  = ! empty( $instance['show_postdate'] ) ?  $instance['show_postdate'] : '';
        
        ?>
		
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'num_post' )); ?>"><?php esc_html_e( 'Number of Posts', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'num_post' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'num_post' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $num_post ); ?>" />
		</p>
        
        <p>
            <input id="<?php echo esc_attr($this->get_field_id( 'show_thumbnail' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_thumbnail' )); ?>" type="checkbox" value="1" <?php checked( '1', $show_thumbnail ); ?>/>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_thumbnail' )); ?>"><?php esc_html_e( 'Show Post Thumbnail', 'bakes-and-cakes' ); ?></label>
		</p>
        
        <p>
            <input id="<?php echo esc_attr($this->get_field_id( 'show_postdate' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_postdate' )); ?>" type="checkbox" value="1" <?php checked( '1', $show_postdate ); ?>/>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_postdate' )); ?>"><?php esc_html_e( 'Show Post Date', 'bakes-and-cakes' ); ?></label>
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		
        $instance = array();
		
        $instance['title']          = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : __( 'Most Viewed', 'bakes-and-cakes' );
        $instance['num_post']       = ! empty( $new_instance['num_post'] ) ? absint( $new_instance['num_post'] ) : 3 ;        
        $instance['show_thumbnail'] = ! empty( $new_instance['show_thumbnail'] ) ? absint( $new_instance['show_thumbnail'] ) : '';
        $instance['show_postdate']  = ! empty( $new_instance['show_postdate'] ) ? absint( $new_instance['show_postdate'] ) : '';
		
        return $instance;
        
	}

} // class bakes_and_cakes_Popular_Post 
endif;