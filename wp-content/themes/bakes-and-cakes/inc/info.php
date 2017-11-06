<?php
/**
 * Bakes and Cakes Theme Info
 *
 * @package bakes_and_cakes
 */

function bakes_and_cakes_customizer_theme_info( $wp_customize ) {
	
    $wp_customize->add_section( 'theme_info' , array(
		'title'       => __( 'Video Tutorial' , 'bakes-and-cakes' ),
		'priority'    => 6,
		));

     // Theme info
    $wp_customize->add_setting(
		'setup_instruction',
		array(
			'sanitize_callback' => 'wp_kses_post'
		)
	);

	$wp_customize->add_control(
		new bakes_and_cakes_Theme_Info( 
			$wp_customize,
			'setup_instruction',
			array(
				'settings'		=> 'setup_instruction',
				'section'		=> 'theme_info',
				'description'	=> __( 'Check out step-by-step video tutorial to create your website like the demo of Bakes and Cakes WordPress theme.', 'bakes-and-cakes' ),
			)
		)
	);

	$wp_customize->add_setting('theme_info_theme',array(
		'default' => '',
		'sanitize_callback' => 'wp_kses_post',
		));
    
    $theme_info = '';
	$theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Video Tutorial', 'bakes-and-cakes' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/documentation/bakes-cakes/' ) . '" target="_blank">' . __( 'here', 'bakes-and-cakes' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme Demo', 'bakes-and-cakes' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/previews/?theme=bakes-and-cakes' ) . '" target="_blank">' . __( 'here', 'bakes-and-cakes' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Support Ticket', 'bakes-and-cakes' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/support-ticket/' ) . '" target="_blank">' . __( 'here', 'bakes-and-cakes' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Rate this theme', 'bakes-and-cakes' ) . ': </label><a href="' . esc_url( 'https://wordpress.org/support/theme/bakes-and-cakes/reviews' ) . '" target="_blank">' . __( 'here', 'bakes-and-cakes' ) . '</a></span><br />';


	$wp_customize->add_control( 
		new bakes_and_cakes_Theme_Info( 
			$wp_customize,
			'theme_info_theme',
			array(
				'section' => 'theme_info',
				'description' => $theme_info
			)
		)
	);

	$wp_customize->add_setting('theme_info_more_theme',array(
		'default' => '',
		'sanitize_callback' => 'wp_kses_post',
		));

}
add_action( 'customize_register', 'bakes_and_cakes_customizer_theme_info' );


if( class_exists( 'WP_Customize_control' ) ){

	class bakes_and_cakes_Theme_Info extends WP_Customize_Control
	{
    	/**
       	* Render the content on the theme customizer page
       	*/
       	public function render_content()
       	{
       		?>
       		<label>
       			<strong class="customize-text_editor"><?php echo esc_html( $this->label ); ?></strong>
       			<br />
       			<span class="customize-text_editor_desc">
       				<?php echo wp_kses_post( $this->description ); ?>
       			</span>
       		</label>
       		<?php
       	}
    }//editor close
    
}//class close

if( class_exists( 'WP_Customize_Section' ) ) :
/**
 * Adding Go to Pro Section in Customizer
 * https://github.com/justintadlock/trt-customizer-pro
 */
class bakes_and_cakes_Customize_Section_Pro extends WP_Customize_Section {

	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'pro-section';

	/**
	 * Custom button text to output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $pro_text = '';

	/**
	 * Custom pro button URL.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $pro_url = '';

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function json() {
		$json = parent::json();

		$json['pro_text'] = $this->pro_text;
		$json['pro_url']  = esc_url( $this->pro_url );

		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	protected function render_template() { ?>

		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

			<h3 class="accordion-section-title">
				{{ data.title }}

				<# if ( data.pro_text && data.pro_url ) { #>
					<a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
				<# } #>
			</h3>
		</li>
	<?php }
}
endif;

add_action( 'customize_register', 'bakes_and_cakes_sections_pro' );
function bakes_and_cakes_sections_pro( $manager ) {
	// Register custom section types.
	$manager->register_section_type( 'bakes_and_cakes_Customize_Section_Pro' );

	// Register sections.
	$manager->add_section(
		new bakes_and_cakes_Customize_Section_Pro(
			$manager,
			'bakes_and_cakes_view_pro',
			array(
				'title'    => esc_html__( 'Pro Available', 'bakes-and-cakes' ),
                'priority' => 5, 
				'pro_text' => esc_html__( 'VIEW PRO THEME', 'bakes-and-cakes' ),
				'pro_url'  => 'https://raratheme.com/wordpress-themes/bakes-and-cakes-pro/'
			)
		)
	);
}