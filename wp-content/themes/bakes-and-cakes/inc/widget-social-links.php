<?php
/**
 * Widget Social Links
 *
 * @package Bakes And Cakes
 */
 
function bakes_and_cakes_register_social_links_widget() {
    register_widget( 'bakes_and_cakes_Social_Links' );
}
add_action( 'widgets_init', 'bakes_and_cakes_register_social_links_widget' );

if( !class_exists( 'bakes_and_cakes_Social_Links' ) ):
 /**
 * Adds bakes_and_cakes_Social_Links widget.
 */
class bakes_and_cakes_Social_Links extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bakes_and_cakes_social_links', // Base ID
			__( 'RARA: Social Links', 'bakes-and-cakes' ), // Name
			array( 'description' => __( 'A Social Links Widget', 'bakes-and-cakes' ), ) // Args
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
	   
        $title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Social Media', 'bakes-and-cakes' );		
        $facebook    = ! empty( $instance['facebook'] ) ?  $instance['facebook'] : '' ;
        $twitter     = ! empty( $instance['twitter'] ) ?  $instance['twitter'] : '' ;
        $linkedin    = ! empty( $instance['linkedin'] ) ?  $instance['linkedin'] : '' ;
        $instagram   = ! empty( $instance['instagram'] ) ?  $instance['instagram'] : '' ;
        $google_plus = ! empty( $instance['google_plus'] ) ?  $instance['google_plus'] : '' ;
        $pinterest   = ! empty( $instance['pinterest'] ) ?  $instance['pinterest'] : '' ;
        $youtube     = ! empty( $instance['youtube'] ) ?  $instance['youtube'] : '' ;
        $ok     	 = ! empty( $instance['ok'] ) ?  $instance['ok'] : '' ;
        $vk          = ! empty( $instance['vk'] ) ?  $instance['vk'] : '' ;
        $xing    	 = ! empty( $instance['xing'] ) ?  $instance['xing'] : '' ;
        
        
        if( $facebook || $twitter ||  $linkedin || $instagram || $google_plus || $pinterest || $youtube || $ok || $vk || $xing ){ 
        echo $args['before_widget'];
        if( $title ) echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title'];
        
        ?>
            <ul class="social-networks">
				
				<?php if( $facebook ){ ?>
                <li><a href="<?php echo esc_url( $facebook ); ?>" target="_blank" title="<?php esc_attr_e( 'Facebook', 'bakes-and-cakes' ); ?>" class="fa fa-facebook"></a></li>
				
				<?php } if( $twitter ){ ?>
                <li><a href="<?php echo esc_url( $twitter ); ?>" target="_blank" title="<?php esc_attr_e( 'Twitter', 'bakes-and-cakes' ); ?>" class="fa fa-twitter"></a></li>
				
				<?php } if( $linkedin ){ ?>
                <li><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" title="<?php esc_attr_e( 'Linkedin', 'bakes-and-cakes' ); ?>" class="fa fa-linkedin"></a></li>
				
				<?php } if( $instagram ){ ?>
                <li><a href="<?php echo esc_url( $instagram ); ?>" target="_blank" title="<?php esc_attr_e( 'Instagram', 'bakes-and-cakes' ); ?>" class="fa fa-instagram"></a></li>
				
				<?php } if( $google_plus ){ ?>
                <li><a href="<?php echo esc_url( $google_plus ); ?>" target="_blank" title="<?php esc_attr_e( 'Google Plus', 'bakes-and-cakes' ); ?>" class="fa fa-google-plus"></a></li>
				
				<?php } if( $pinterest ){ ?>
                <li><a href="<?php echo esc_url( $pinterest ); ?>" target="_blank" title="<?php esc_attr_e( 'Pinterest', 'bakes-and-cakes' ); ?>" class="fa fa-pinterest"></a></li>
				
				<?php } if( $youtube ){ ?>
                <li><a href="<?php echo esc_url( $youtube ); ?>" target="_blank" title="<?php esc_attr_e( 'YouTube', 'bakes-and-cakes' ); ?>" class="fa fa-youtube"></a></li>

                <?php } if( $ok ){ ?>
                <li><a href="<?php echo esc_url( $ok ); ?>" target="_blank" title="<?php esc_attr_e( 'OK', 'bakes-and-cakes' ); ?>" class="fa fa-odnoklassniki"></a></li>

                <?php }if( $vk ){ ?>
                <li><a href="<?php echo esc_url( $vk ); ?>" target="_blank" title="<?php esc_attr_e( 'VK', 'bakes-and-cakes' ); ?>" class="fa fa-vk"></a></li>

                <?php } if( $xing ){ ?>
                <li><a href="<?php echo esc_url( $xing ); ?>" target="_blank" title="<?php esc_attr_e( 'Xing', 'bakes-and-cakes' ); ?>" class="fa fa-xing"></a></li>
                <?php } ?>
			</ul>
        <?php
        echo $args['after_widget'];
        }
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
        
        $title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Social Media', 'bakes-and-cakes' );		
        $facebook    = ! empty( $instance['facebook'] ) ?  $instance['facebook'] : '' ;
        $twitter     = ! empty( $instance['twitter'] ) ?  $instance['twitter'] : '' ;
        $linkedin    = ! empty( $instance['linkedin'] ) ?  $instance['linkedin'] : '' ;
        $instagram   = ! empty( $instance['instagram'] ) ?  $instance['instagram'] : '' ;
        $google_plus = ! empty( $instance['google_plus'] ) ?  $instance['google_plus'] : '' ;
        $pinterest   = ! empty( $instance['pinterest'] ) ?  $instance['pinterest'] : '' ;
        $youtube     = ! empty( $instance['youtube'] ) ?  $instance['youtube'] : '' ;
        $ok     	 = ! empty( $instance['ok'] ) ?  $instance['ok'] : '' ;
        $vk          = ! empty( $instance['vk'] ) ?  $instance['vk'] : '' ;
        $xing    	 = ! empty( $instance['xing'] ) ?  $instance['xing'] : '' ;
        
        ?>
		
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>"><?php _e( 'Facebook', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'facebook' )); ?>" type="text" value="<?php echo esc_url( $facebook ); ?>" />
		</p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>"><?php _e( 'Twitter', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'twitter' )); ?>" type="text" value="<?php echo esc_url( $twitter ); ?>" />
		</p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'linkedin' )); ?>"><?php _e( 'LinkedIn', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'linkedin' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'linkedin' )); ?>" type="text" value="<?php echo esc_url( $linkedin ); ?>" />
		</p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>"><?php _e( 'Instagram', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'instagram' )); ?>" type="text" value="<?php echo esc_url( $instagram ); ?>" />
		</p>

		<p>
            <label for="<?php echo esc_attr($this->get_field_id( 'google_plus' )); ?>"><?php _e( 'Google Plus', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'google_plus' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'google_plus' )); ?>" type="text" value="<?php echo esc_url( $google_plus ); ?>" />
		</p>

		<p>
            <label for="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>"><?php _e( 'Pinterest', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pinterest' )); ?>" type="text" value="<?php echo esc_url( $pinterest ); ?>" />
		</p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>"><?php _e( 'YouTube', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'youtube' )); ?>" type="text" value="<?php echo esc_url( $youtube ); ?>" />
		</p>

		<p>
            <label for="<?php echo esc_attr($this->get_field_id( 'ok' )); ?>"><?php _e( 'OK', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'ok' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'ok' )); ?>" type="text" value="<?php echo esc_url( $ok ); ?>" />
		</p>

		<p>
            <label for="<?php echo esc_attr($this->get_field_id( 'vk' )); ?>"><?php _e( 'VK', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'vk' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'vk' )); ?>" type="text" value="<?php echo esc_url( $vk ); ?>" />
		</p>

		<p>
            <label for="<?php echo esc_attr($this->get_field_id( 'xing' )); ?>"><?php _e( 'Xing', 'bakes-and-cakes' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'xing' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'xing' )); ?>" type="text" value="<?php echo esc_url( $xing ); ?>" />
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
		
        $instance['title']       = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : __( 'Social Media', 'bakes-and-cakes' );
        $instance['facebook']    = ! empty( $new_instance['facebook'] ) ? esc_url_raw( $new_instance['facebook'] ) : '';
        $instance['twitter']     = ! empty( $new_instance['twitter'] ) ? esc_url_raw( $new_instance['twitter'] ) : '';
        $instance['linkedin']    = ! empty( $new_instance['linkedin'] ) ? esc_url_raw( $new_instance['linkedin'] ) : '';
        $instance['instagram']   = ! empty( $new_instance['instagram'] ) ? esc_url_raw( $new_instance['instagram'] ) : '';
        $instance['google_plus'] = ! empty( $new_instance['google_plus'] ) ? esc_url_raw( $new_instance['google_plus'] ) : '';
        $instance['pinterest']   = ! empty( $new_instance['pinterest'] ) ? esc_url_raw( $new_instance['pinterest'] ) : '';
        $instance['youtube']     = ! empty( $new_instance['youtube'] ) ? esc_url_raw( $new_instance['youtube'] ) : '';
        $instance['ok']          = ! empty( $new_instance['ok'] ) ? esc_url_raw( $new_instance['ok'] ) : '';
        $instance['vk']          = ! empty( $new_instance['vk'] ) ? esc_url_raw( $new_instance['vk'] ) : '';
        $instance['xing']        = ! empty( $new_instance['xing'] ) ? esc_url_raw( $new_instance['xing'] ) : '';
		return $instance;
	}

} // class bakes_and_cakes_Social_Links 

endif;