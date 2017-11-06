<?php
/**
 * Bakes And Cakes Theme Customizer.
 *
 * @package Bakes_And_Cakes
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bakes_and_cakes_customize_register( $wp_customize ) {

  /* Option list of all post */ 
    $options_posts = array();
    $options_posts_obj = get_posts('posts_per_page=-1');
    $options_posts[''] = __( 'Choose Post', 'bakes-and-cakes' );
    foreach ( $options_posts_obj as $posts ) {
        $options_posts[$posts->ID] = $posts->post_title;
    }

    /** Option list of all pages */ 
    $options_pages = array();
    $options_pages_obj = get_posts('posts_per_page=-1&post_type=page');
    $options_pages[''] = __( 'Choose Page', 'bakes-and-cakes' );
    foreach ( $options_pages_obj as $bac_pages ) {
        $options_pages[$bac_pages->ID] = $bac_pages->post_title; 
    }
    
    if( bakes_and_cakes_is_woocommerce_activated() ){
        /* Option list of all post */ 
        $options_products = array();
        $options_products_obj = get_posts('posts_per_page=-1&post_type=product');
        $options_products[''] = __( 'Choose Product', 'bakes-and-cakes' );
        foreach ( $options_products_obj as $posts ) {
            $options_products[$posts->ID] = $posts->post_title;
        }
    }

    /* Option list of all categories */
    $bakes_and_cakes_args = array(
       'type'                     => 'post',
       'orderby'                  => 'name',
       'order'                    => 'ASC',
       'hide_empty'               => 1,
       'hierarchical'             => 1,
       'taxonomy'                 => 'category'
    ); 
    $bakes_and_cakes_option_categories = array();
    $bakes_and_cakes_category_lists = get_categories( $bakes_and_cakes_args );
    $bakes_and_cakes_option_categories[''] = __( 'Choose Category', 'bakes-and-cakes' );
    foreach( $bakes_and_cakes_category_lists as $bakes_and_cakes_category ){
        $bakes_and_cakes_option_categories[$bakes_and_cakes_category->term_id] = $bakes_and_cakes_category->name;
    }


    /** Default Settings */    
    $wp_customize->add_panel( 
        'wp_default_panel',
         array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Default Settings', 'bakes-and-cakes' ),
            'description' => __( 'Default section provided by wordpress customizer.', 'bakes-and-cakes' ),
        ) 
    );
    
    $wp_customize->get_section( 'title_tagline' )->panel     = 'wp_default_panel';
    $wp_customize->get_section( 'colors' )->panel            = 'wp_default_panel';
    $wp_customize->get_section( 'background_image' )->panel  = 'wp_default_panel';
    $wp_customize->get_section( 'static_front_page' )->panel = 'wp_default_panel'; 
    
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'background_color' )->transport = 'refresh';
    $wp_customize->get_setting( 'background_image' )->transport = 'refresh';
	 
    
     /** BreadCrumb Settings */
    $wp_customize->add_section(
        'bakes_and_cakes_breadcrumb_settings',
        array(
            'title' => __( 'Breadcrumb Settings', 'bakes-and-cakes' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
        )
    );
   

    /** Enable/Disable BreadCrumb */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_breadcrumb',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_breadcrumb',
        array(
            'label' => __( 'Enable Breadcrumb', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Show/Hide Current */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_current',
        array(
            'default' => '1',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_current',
        array(
            'label' => __( 'Show current', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Home Text */
    $wp_customize->add_setting(
        'bakes_and_cakes_breadcrumb_home_text',
        array(
            'default' => __( 'Home', 'bakes-and-cakes' ),
            'sanitize_callback' => 'bakes_and_cakes_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_breadcrumb_home_text',
        array(
            'label' => __( 'Breadcrumb Home Text', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_breadcrumb_settings',
            'type' => 'text',
        )
    );
    
    /** Breadcrumb Separator */
    $wp_customize->add_setting(
        'bakes_and_cakes_breadcrumb_separator',
        array(
            'default' => __( '>', 'bakes-and-cakes' ),
            'sanitize_callback' => 'bakes_and_cakes_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_breadcrumb_separator',
        array(
            'label' => __( 'Breadcrumb Separator', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_breadcrumb_settings',
            'type' => 'text',
        )
    );
    /** BreadCrumb Settings Ends */
    

    /** Home Page Settings */
    $wp_customize->add_panel( 
        'bakes_and_cakes_home_page_settings',
         array(
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'title' => __( 'Home Page Settings', 'bakes-and-cakes' ),
            'description' => __( 'Customize Home Page Settings', 'bakes-and-cakes' ),
        ) 
    );
     /** About Us Section */
    $wp_customize->add_section(
        'bakes_and_cakes_about_us_settings',
        array(
            'title' => __( 'About Us Section', 'bakes-and-cakes' ),
            'priority' => 20,
            'panel' => 'bakes_and_cakes_home_page_settings',
        )
    );
    /** Enable/Disable about us Section */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_about_section',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_about_section',
        array(
            'label' => __( 'Enable About us Section', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_about_us_settings',
            'type' => 'checkbox',
        )
    );
     /*select page for about us section*/
    $wp_customize->add_setting(
        'bakes_and_cakes_about_us_page',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_about_us_page',
        array(
            'label' => __( 'Select Page', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_about_us_settings',
            'type' => 'select',
            'choices' => $options_pages,
        )
    );

    /* Featured Product Section*/
     $wp_customize-> add_section(
        'bakes_and_cakes_featured_product_settings',
        array(
            'title'=> __('Featured Product Section','bakes-and-cakes'),
            'priority'=> 30,
            'panel'=> 'bakes_and_cakes_home_page_settings'
            )
        );

    /** Enable/Disable featured_dish Section */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_product_section',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_product_section',
        array(
            'label' => __( 'Enable Featured Product Section', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'checkbox',
        )
    );
 /*select page for Product section*/
    $wp_customize->add_setting(
        'bakes_and_cakes_featured_product_page',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_featured_product_page',
        array(
            'label' => __( 'Select Page', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_pages,
        )
    );
   if( bakes_and_cakes_is_woocommerce_activated() ){
     /*select product */
    $wp_customize->add_setting(
        'bakes_and_cakes_product_one',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_product_one',
        array(
            'label' => __( 'Select Product One', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_products,
        )
    );
    
      /*select product */
    $wp_customize->add_setting(
        'bakes_and_cakes_product_two',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_product_two',
        array(
            'label' => __( 'Select Product Two', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_products,
        )
    );

     /*select product */
    $wp_customize->add_setting(
        'bakes_and_cakes_product_three',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_product_three',
        array(
            'label' => __( 'Select Product Three', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_products,
        )
    );

     /*select product */
    $wp_customize->add_setting(
        'bakes_and_cakes_product_four',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_product_four',
        array(
            'label' => __( 'Select Product Four', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_products,
        )
    );

     /*select product */
    $wp_customize->add_setting(
        'bakes_and_cakes_product_five',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_product_five',
        array(
            'label' => __( 'Select Product Five', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_products,
        )
    );

     /*select product */
    $wp_customize->add_setting(
        'bakes_and_cakes_product_six',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_product_six',
        array(
            'label' => __( 'Select Product Six', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_products,
        )
    );
    
    /*select product */
    $wp_customize->add_setting(
        'bakes_and_cakes_product_seven',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_product_seven',
        array(
            'label' => __( 'Select Product Seven', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_products,
        )
    );

    /*select product */
    $wp_customize->add_setting(
        'bakes_and_cakes_product_eight',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_product_eight',
        array(
            'label' => __( 'Select Product Eight', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_products,
        )
    );

    /*select product */
    $wp_customize->add_setting(
        'bakes_and_cakes_product_nine',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_product_nine',
        array(
            'label' => __( 'Select Product Nine', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_products,
        )
    );

    /*select product */
    $wp_customize->add_setting(
        'bakes_and_cakes_product_ten',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_product_ten',
        array(
            'label' => __( 'Select Product Ten', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_featured_product_settings',
            'type' => 'select',
            'choices' => $options_products,
        )
    );


    }

    /* Events Section */
     $wp_customize-> add_section(
        'bakes_and_cakes_events_settings',
        array(
            'title'=> __('Events Section','bakes-and-cakes'),
            'priority'=> 30,
            'panel'=> 'bakes_and_cakes_home_page_settings'
            )
        );

    /** Enable/Disable events Section */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_events_section',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_events_section',
        array(
            'label' => __( 'Enable Events Section', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_events_settings',
            'type' => 'checkbox',
        )
    );

    /* Title for events section  */
    $wp_customize->add_setting(
        'bakes_and_cakes_events_section_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'bakes_and_cakes_sanitize_nohtml'
            )
        );

    $wp_customize-> add_control(
        'bakes_and_cakes_events_section_title',
        array(
              'label' => __('Events Section Title','bakes-and-cakes'),
              'section' => 'bakes_and_cakes_events_settings', 
              'type' => 'text',
            ));
    
    /* select first post for events  */
    
    $wp_customize->add_setting(
        'bakes_and_cakes_first_event_post',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        ));

    $wp_customize->add_control(
        'bakes_and_cakes_first_event_post',
        array(
            'label' => __( 'Select First Event Post', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_events_settings',
            'type' => 'select',
            'choices' => $options_posts,
        ) );


    /* select second post for events  */

    $wp_customize->add_setting(
        'bakes_and_cakes_second_event_post',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );

    $wp_customize->add_control(
        'bakes_and_cakes_second_event_post',
        array(
            'label' => __( 'Select Second Event Post', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_events_settings',
            'type' => 'select',
            'choices' => $options_posts,
        )
    );

    /*  Enable/Disable Reservation Section */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_make_reservation_section',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_make_reservation_section',
        array(
            'label' => __( 'Enable Make Reservation Section', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_events_settings',
            'type' => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'bakes_and_cakes_events_make_reservation_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'bakes_and_cakes_sanitize_nohtml'
            )
        );
    $wp_customize-> add_control(
        'bakes_and_cakes_events_make_reservation_title',
        array(
              'label' => __('Reservation Title','bakes-and-cakes'),
              'section' => 'bakes_and_cakes_events_settings', 
              'type' => 'text',
            ));

    $wp_customize->add_setting(
        'bakes_and_cakes_events_reservation_content_first',
        array(
            'default'=> '',
            'sanitize_callback'=> 'bakes_and_cakes_sanitize_nohtml'
            )
        );

    $wp_customize-> add_control(
        'bakes_and_cakes_events_reservation_content_first',
        array(
              'label' => __('Content Here','bakes-and-cakes'),
              'section' => 'bakes_and_cakes_events_settings', 
              'type' => 'textarea',
            ));

    $wp_customize->add_setting(
        'bakes_and_cakes_events_reservation_phone_number',
        array(
            'default'=> '',
            'sanitize_callback'=> 'bakes_and_cakes_sanitize_nohtml'
            )
        );

    $wp_customize-> add_control(
        'bakes_and_cakes_events_reservation_phone_number',
        array(
              'label' => __('Phone Number','bakes-and-cakes'),
              'section' => 'bakes_and_cakes_events_settings', 
              'type' => 'text',
            ));

    $wp_customize->add_setting(
        'bakes_and_cakes_events_reservation_content_second',
        array(
            'default'=> '',
            'sanitize_callback'=> 'bakes_and_cakes_sanitize_nohtml'
            )
        );

    $wp_customize-> add_control(
        'bakes_and_cakes_events_reservation_content_second',
        array(
              'label' => __('More Content Here','bakes-and-cakes'),
              'section' => 'bakes_and_cakes_events_settings', 
              'type' => 'textarea',
            ));

    $wp_customize->add_setting(
        'bakes_and_cakes_events_reservation_button',
        array(
            'default'=> '',
            'sanitize_callback'=> 'bakes_and_cakes_sanitize_nohtml'
            )
        );

    $wp_customize-> add_control(
        'bakes_and_cakes_events_reservation_button',
        array(
              'label' => __('Button Text','bakes-and-cakes'),
              'section' => 'bakes_and_cakes_events_settings', 
              'type' => 'text',
            ));

    $wp_customize->add_setting(
        'bakes_and_cakes_events_reservation_button_link',
        array(
            'default'=> '',
            'sanitize_callback'=> 'bakes_and_cakes_sanitize_url'
            )
        );

    $wp_customize-> add_control(
        'bakes_and_cakes_events_reservation_button_link',
        array(
              'label' => __('Button Link','bakes-and-cakes'),
              'section' => 'bakes_and_cakes_events_settings', 
              'type' => 'text',
            ));

    /** Our Staff Section */
    $wp_customize->add_section(
        'bakes_and_cakes_our_staff_settings',
        array(
            'title' => __( 'Our staff Section', 'bakes-and-cakes' ),
            'priority' => 30,
            'panel' => 'bakes_and_cakes_home_page_settings',
        )
    );
    /** Enable/Disable our staff Section */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_staff_section',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_staff_section',
        array(
            'label' => __( 'Enable Our Staff Section', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_our_staff_settings',
            'type' => 'checkbox',
        )
    );

    /*select page for staff section*/
    $wp_customize->add_setting(
        'bakes_and_cakes_staff_page',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_staff_page',
        array(
            'label' => __( 'Select Page', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_our_staff_settings',
            'type' => 'select',
            'choices' => $options_pages,
        )
    );

    /** select category */
    $wp_customize-> add_setting(
        'bakes_and_cakes_staff_section_cat',
        array(
            'default'=> '',
            'sanitize_callback'=> 'bakes_and_cakes_sanitize_select',
        ));
    
    $wp_customize->add_control(
        'bakes_and_cakes_staff_section_cat',
        array(
            'label'=> __('Choose Category','bakes-and-cakes'),
            'section' => 'bakes_and_cakes_our_staff_settings',
            'type' => 'select',
            'choices' => $bakes_and_cakes_option_categories,
        ));

    /** Upload a Background Image */
    $wp_customize->add_setting(
        'bakes_and_cakes_staff_background_image',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'bakes_and_cakes_staff_background_image',
           array(
               'label'      => __( 'Upload Background Image', 'bakes-and-cakes' ),
               'section'    => 'bakes_and_cakes_our_staff_settings',
               'width'      => 1920,
               'height'     => 800,
           )
       )
    );

    /* testimonials section */
    $wp_customize-> add_section(
        'bakes_and_cakes_testimonial_settings',
        array(
            'title'=> __('Testimonials Section','bakes-and-cakes'),
            'priority'=> 30,
            'panel'=> 'bakes_and_cakes_home_page_settings'
            )
        );

    /** Enable/Disable Testimonials Section */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_testimonials_section',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_testimonials_section',
        array(
            'label' => __( 'Enable Testimonials Section', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_testimonial_settings',
            'type' => 'checkbox',
        )
    );

     /*select page for testimonial section*/
    $wp_customize->add_setting(
        'bakes_and_cakes_testimonial_page',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_testimonial_page',
        array(
            'label' => __( 'Select Page', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_testimonial_settings',
            'type' => 'select',
            'choices' => $options_pages,
        )
    );

      /** select category */
    $wp_customize-> add_setting(
        'bakes_and_cakes_testimonials_section_cat',
        array(
        'default'=> '',
        'sanitize_callback'=> 'bakes_and_cakes_sanitize_select',
        ));
    
    $wp_customize->add_control(
        'bakes_and_cakes_testimonials_section_cat',
        array(
        'label'=> __('Choose Category','bakes-and-cakes'),
        'section' => 'bakes_and_cakes_testimonial_settings',
        'type' => 'select',
        'choices' => $bakes_and_cakes_option_categories,
    ));

       /* Blog Section */
    $wp_customize-> add_section(
        'bakes_and_cakes_blog_settings',
        array(
            'title'=> __('Blog Section','bakes-and-cakes'),
            'priority'=> 30,
            'panel'=> 'bakes_and_cakes_home_page_settings'
            )
        );

    /** Enable/Disable Blog Section */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_blog_section',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_blog_section',
        array(
            'label' => __( 'Enable Blog Section', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_blog_settings',
            'type' => 'checkbox',
        )
    );

     /*select page for blog section*/
    $wp_customize->add_setting(
        'bakes_and_cakes_blog_page',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_blog_page',
        array(
            'label' => __( 'Select Page', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_blog_settings',
            'type' => 'select',
            'choices' => $options_pages,
        )
    );

    /* Promotional Block Section */
    $wp_customize-> add_section(
        'bakes_and_cakes_promotional_block_settings',
        array(
            'title'=> __('Promotional Block Section','bakes-and-cakes'),
            'priority'=> 30,
            'panel'=> 'bakes_and_cakes_home_page_settings'
            )
        );

    /** Enable/Disable Promotional_block Section */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_promotional_section',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_promotional_section',
        array(
            'label' => __( 'Enable promotional Block Section', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_promotional_block_settings',
            'type' => 'checkbox',
        )
    );
    
    /*select page for promotional section*/
    $wp_customize->add_setting(
        'bakes_and_cakes_promotional_page',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_promotional_page',
        array(
            'label' => __( 'Select Page', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_promotional_block_settings',
            'type' => 'select',
            'choices' => $options_pages,
        )
    );

    /** Upload a Background Image */
    $wp_customize->add_setting(
        'bakes_and_cakes_promotional_background_image',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'bakes_and_cakes_promotional_background_image',
           array(
               'label'      => __( 'Upload Background Image', 'bakes-and-cakes' ),
               'section'    => 'bakes_and_cakes_promotional_block_settings',
               'width'      => 1920,
               'height'     => 550,
           )
       )
    );


    $wp_customize-> add_setting(
        'bakes_and_cakes_promotional_block_button',
        array(
            'default' => '' ,
            'sanitize_callback'=> 'bakes_and_cakes_sanitize_nohtml',
         ));

    $wp_customize-> add_control(
        'bakes_and_cakes_promotional_block_button',
        array(
            'label'=> __('Button Text', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_promotional_block_settings',
            'type' => 'text',
            ));

    $wp_customize-> add_setting(
        'bakes_and_cakes_promotional_block_button_link',
        array(
            'default' => '' ,
            'sanitize_callback'=> 'bakes_and_cakes_sanitize_url',
         ));

    $wp_customize-> add_control(
        'bakes_and_cakes_promotional_block_button_link',
        array(
            'label'=> __('Button Link', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_promotional_block_settings',
            'type' => 'text',
            ));

    /** Slider Settings */
    $wp_customize->add_section(
        'bakes_and_cakes_slider_settings',
        array(
            'title' => __( 'Slider Settings', 'bakes-and-cakes' ),
            'priority' => 10,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Enable/Disable Slider */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_slider',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_slider',
        array(
            'label' => __( 'Enable Home Page Slider', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_slider_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Auto Transition */
    $wp_customize->add_setting(
        'bakes_and_cakes_slider_auto',
        array(
            'default' => '1',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_slider_auto',
        array(
            'label' => __( 'Enable Slider Auto Transition', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_slider_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Loop */
    $wp_customize->add_setting(
        'bakes_and_cakes_slider_loop',
        array(
            'default' => '1',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_slider_loop',
        array(
            'label' => __( 'Enable Slider Loop', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_slider_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Control */
    $wp_customize->add_setting(
        'bakes_and_cakes_slider_control',
        array(
            'default' => '1',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_slider_control',
        array(
            'label' => __( 'Enable Slider Control', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_slider_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Caption */
    $wp_customize->add_setting(
        'bakes_and_cakes_slider_caption',
        array(
            'default' => '1',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_slider_caption',
        array(
            'label' => __( 'Enable Slider Caption', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_slider_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Slider Animation */
    $wp_customize->add_setting(
        'bakes_and_cakes_slider_animation',
        array(
            'default' => 'slide',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_slider_animation',
        array(
            'label' => __( 'Choose Slider Animation', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_slider_settings',
            'type' => 'select',
            'choices' => array(
                'fade' => __( 'Fade', 'bakes-and-cakes' ),
                'slide' => __( 'Slide', 'bakes-and-cakes' ),
            )
        )
    );
    
    /** Slider Speed */
    $wp_customize->add_setting(
        'bakes_and_cakes_slider_speed',
        array(
            'default' => '7000',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_slider_speed',
        array(
            'label' => __( 'Slider Speed', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_slider_settings',
            'type' => 'text',
        )
    );
    
    /** Animation Speed */
    $wp_customize->add_setting(
        'bakes_and_cakes_animation_speed',
        array(
            'default' => '600',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_animation_speed',
        array(
            'label' => __( 'Animation Speed', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_slider_settings',
            'type' => 'text',
        )
    );
    
    /** Slider Readmore */
    $wp_customize->add_setting(
        'bakes_and_cakes_slider_readmore',
        array(
            'default' => __( 'Continue Reading', 'bakes-and-cakes' ),
            'sanitize_callback' => 'bakes_and_cakes_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_slider_readmore',
        array(
            'label' => __( 'Readmore Text', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_slider_settings',
            'type' => 'text',
        )
    );
    
    /** Select Category */
    $wp_customize->add_setting(
        'bakes_and_cakes_slider_cat',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_slider_cat',
        array(
            'label' => __( 'Choose Slider Category', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_slider_settings',
            'type' => 'select',
            'choices' => $bakes_and_cakes_option_categories,
        )
    );
    /** Slider Settings Ends */    

    /** Blog page Settings */
    $wp_customize->add_section(
        'bakes_and_cakes_blog_page_settings',
        array(
            'title' => __( 'Blog Page Settings', 'bakes-and-cakes' ),
            'priority' => 55,
            'capability' => 'edit_theme_options',
        )
    );

    /** Enable/Disable full content in blog page */
    $wp_customize->add_setting(
        'bakes_and_cakes_ed_full_content',
        array(
            'default' => '',
            'sanitize_callback' => 'bakes_and_cakes_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_ed_full_content',
        array(
            'label' => __( 'Enable Full content', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_blog_page_settings',
            'type' => 'checkbox',
        )
    );
    
     /** Footer Section */
    $wp_customize->add_section(
        'bakes_and_cakes_footer_section',
        array(
            'title' => __( 'Footer Settings', 'bakes-and-cakes' ),
            'priority' => 70,
        )
    );
    
    /** Copyright Text */
    $wp_customize->add_setting(
        'bakes_and_cakes_footer_copyright_text',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'bakes_and_cakes_footer_copyright_text',
        array(
            'label' => __( 'Copyright Info', 'bakes-and-cakes' ),
            'section' => 'bakes_and_cakes_footer_section',
            'type' => 'textarea',
        )
    );
 

    /**
     * Sanitization Functions
     * 
     * @link https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php 
     */ 
    function bakes_and_cakes_sanitize_url( $bakes_and_cakes_url ){
        return esc_url_raw( $bakes_and_cakes_url );
    }
    
    function bakes_and_cakes_sanitize_checkbox( $bakes_and_cakes_checked ){
        // Boolean check.
	   return ( ( isset( $bakes_and_cakes_checked ) && true == $bakes_and_cakes_checked ) ? true : false );
    }

    function bakes_and_cakes_sanitize_select( $bakes_and_cakes_input, $bakes_and_cakes_setting ) {
        // Ensure input is a slug.
        $bakes_and_cakes_input = sanitize_key( $bakes_and_cakes_input );
        // Get list of choices from the control associated with the setting.
        $bakes_and_cakes_choices = $bakes_and_cakes_setting->manager->get_control( $bakes_and_cakes_setting->id )->choices;
        // If the input is a valid key, return it; otherwise, return the default.
        return ( array_key_exists( $bakes_and_cakes_input, $bakes_and_cakes_choices ) ? $bakes_and_cakes_input : $bakes_and_cakes_setting->default );
    }
    
    function bakes_and_cakes_sanitize_number_absint( $bakes_and_cakes_number, $bakes_and_cakes_setting ) {
        // Ensure $bakes_and_cakes_number is an absolute integer (whole number, zero or greater).
        $bakes_and_cakes_number = absint( $bakes_and_cakes_number );
        // If the input is an absolute integer, return it; otherwise, return the default
        return ( $bakes_and_cakes_number ? $bakes_and_cakes_number : $bakes_and_cakes_setting->default );
    }
    
    function bakes_and_cakes_sanitize_nohtml( $bakes_and_cakes_nohtml ) {
        return wp_filter_nohtml_kses( $bakes_and_cakes_nohtml );
    }

    function bakes_and_cakes_sanitize_image( $image, $setting ) {
        /*
         * Array of valid image file types.
         *
         * The array includes image mime types that are included in wp_get_mime_types()
         */
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif'          => 'image/gif',
            'png'          => 'image/png',
            'bmp'          => 'image/bmp',
            'tif|tiff'     => 'image/tiff',
            'ico'          => 'image/x-icon'
        );
        // Return an array with file extension and mime_type.
        $file = wp_check_filetype( $image, $mimes );
        // If $image has a valid mime_type, return it; otherwise, return the default.
        return ( $file['ext'] ? $image : $setting->default );
    }
    
    
}
add_action( 'customize_register', 'bakes_and_cakes_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bakes_and_cakes_customize_preview_js() {
	wp_enqueue_script( 'bakes_and_cakes_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'bakes_and_cakes_customize_preview_js' );
