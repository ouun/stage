/**
 * This file allows you to add functionality to the Theme Customizer
 * panels.
 *
 * {@link https://codex.wordpress.org/Theme_Customization_API}
 * {@link https://developer.wordpress.org/themes/customize-api/the-customizer-javascript-api/#preview-js-and-controls-js}
 */
( function( $, api ) {

  api.bind( 'ready', function() {

    // Control Panel <- Previewer
    api.previewer.bind( 'preview-to-control', function( data ) {
      console.log('Data from preview window: ', data);
    });

    // Control Panel -> Previewer
    api.previewer.bind( 'ready', function() {
      api.previewer.send('control-to-preview', 'control-to-preview');
    });

    /**
     * Change to new posts page after setting new setting
     */
    /*
    api( 'page_for_posts', function( setting ) {
      setting.bind( function( pageId ) {
        pageId = parseInt( pageId, 10 );
        if ( pageId > 0 ) {
          api.previewer.previewUrl.set( api.settings.url.home + '?page_id=' + pageId );
        }
      });
    });
     */

  } );

} )( jQuery, wp.customize );
