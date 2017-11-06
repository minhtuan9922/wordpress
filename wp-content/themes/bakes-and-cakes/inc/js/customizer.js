jQuery(document).ready(function($) {
	
	/* Move widgets to their respective sections */
	wp.customize.section( 'sidebar-widgets-google-map' ).panel( 'bakes_and_cakes_home_page_settings' );
	wp.customize.section( 'sidebar-widgets-google-map' ).priority( '40' );
    
});


( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['pro-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );