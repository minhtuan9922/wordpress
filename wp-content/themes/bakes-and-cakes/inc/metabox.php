<?php
/**
 * Bakes And Cakes Meta Box
 * 
 * @package Bakes And Cakes
 */

 add_action('add_meta_boxes', 'bakes_and_cakes_add_sidebar_layout_box');

function bakes_and_cakes_add_sidebar_layout_box(){    
    add_meta_box(
                 'bakes_and_cakes_sidebar_layout', // $id
                 __( 'Sidebar Layout', 'bakes-and-cakes' ), // $title
                 'bakes_and_cakes_sidebar_layout_callback', // $callback
                 'page', // $page
                 'normal', // $context
                 'high'); // $priority    
}

$bakes_and_cakes_sidebar_layout = array(         
        'right-sidebar' => array(
                        'value' => 'right-sidebar',
                        'label' => __( 'Right sidebar (default)', 'bakes-and-cakes' ),
                        'thumbnail' => get_template_directory_uri() . '/images/right-sidebar.png'
                    ),
        'no-sidebar' => array(
                        'value'     => 'no-sidebar',
                        'label'     => __( 'No sidebar', 'bakes-and-cakes' ),
                        'thumbnail' => get_template_directory_uri() . '/images/no-sidebar.png'
                    )   

    );

function bakes_and_cakes_sidebar_layout_callback(){
    global $post , $bakes_and_cakes_sidebar_layout;
    wp_nonce_field( basename( __FILE__ ), 'bakes_and_cakes_sidebar_layout_nonce' ); 
?>
<table class="form-table">
    <tr>
        <td colspan="4"><em class="f13"><?php esc_html_e( 'Choose Sidebar Template', 'bakes-and-cakes' ); ?></em></td>
    </tr>

    <tr>
        <td>
        <?php  
            foreach ($bakes_and_cakes_sidebar_layout as $bakes_and_cakes_field) {  
                $bakes_and_cakes_sidebar_metalayout = get_post_meta( $post->ID, 'bakes_and_cakes_sidebar_layout', true ); ?>

            <div class="radio-image-wrapper" style="float:left; margin-right:30px;">
                <label class="description">
                    <span><img src="<?php echo esc_url( $bakes_and_cakes_field['thumbnail'] ); ?>" alt="<?php echo esc_attr( $bakes_and_cakes_field['label'] ); ?>" /></span><br/>
                    <input type="radio" name="bakes_and_cakes_sidebar_layout" value="<?php echo esc_attr( $bakes_and_cakes_field['value'] ); ?>"
                    <?php checked( $bakes_and_cakes_field['value'], $bakes_and_cakes_sidebar_metalayout ); if(empty($bakes_and_cakes_sidebar_metalayout)) { checked( $bakes_and_cakes_field['value'], 'right-sidebar' ); } ?>/> 
                     &nbsp;<?php echo esc_html( $bakes_and_cakes_field['label'] ); ?>
                </label>
            </div>
            <?php } // end foreach 
            ?>
            <div class="clear"></div>
        </td>
    </tr>
</table>
<?php        
}

/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function bakes_and_cakes_save_sidebar_layout( $bakes_and_cakes_post_id ) { 
    global $bakes_and_cakes_sidebar_layout, $post; 

    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'bakes_and_cakes_sidebar_layout_nonce' ] ) || !wp_verify_nonce( $_POST[ 'bakes_and_cakes_sidebar_layout_nonce' ], basename( __FILE__ ) ) )
        return;

    // Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
        return;
        
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can( 'edit_page', $bakes_and_cakes_post_id ) )  
            return $bakes_and_cakes_post_id;  
    } elseif (!current_user_can( 'edit_post', $bakes_and_cakes_post_id ) ) {  
            return $bakes_and_cakes_post_id;  
    }  
    

    foreach ($bakes_and_cakes_sidebar_layout as $bakes_and_cakes_field) {  
        //Execute this saving function
        $bakes_and_cakes_old = get_post_meta( $bakes_and_cakes_post_id, 'bakes_and_cakes_sidebar_layout', true); 
        $bakes_and_cakes_new = sanitize_text_field( $_POST['bakes_and_cakes_sidebar_layout'] );
        if ( $bakes_and_cakes_new && $bakes_and_cakes_new != $bakes_and_cakes_old ) {  
            update_post_meta( $bakes_and_cakes_post_id, 'bakes_and_cakes_sidebar_layout', $bakes_and_cakes_new );  
        } elseif ( '' == $bakes_and_cakes_new && $bakes_and_cakes_old ) {  
            delete_post_meta( $bakes_and_cakes_post_id,'bakes_and_cakes_sidebar_layout', $bakes_and_cakes_old );  
        }  
     } // end foreach   
     
}
add_action('save_post', 'bakes_and_cakes_save_sidebar_layout'); 