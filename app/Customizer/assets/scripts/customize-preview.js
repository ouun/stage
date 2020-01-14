/**
 * This file allows you to add functionality to the Theme Customizer
 * live preview. jQuery is readily available.
 *
 * {@link https://codex.wordpress.org/Theme_Customization_API}
 */
( function( $, api ) {
  $(document).ready(function(){

  // Run when Preview ist active
  api.preview.bind( 'active', function() {
    if ( 'undefined' !== typeof wp && api && api.selectiveRefresh ) {
      /**
       * Prevent links from usage with barba.js
       */
      $('.prevent').attr( 'href', '#' );

      /**
       * Trigger custom events on layout elements when layout control changes
       */
      api.selectiveRefresh.bind( 'partial-content-rendered', function (placement) {
        // When new content is rendered run with each control of the partial
        $.each( placement.partial.params.settings, function ( index, controlID ) {
          // Trigger custom event on the elements
          api( controlID, function ( control ) {
            $( placement.partial.params.selector ).trigger( 'stage-customizer-layout-changed', {
              layout: control.get(),
              selector: placement.partial.params.selector
            });
          });
        });
      });
    }
  });


  /**
   * Some useful examples
   * Use it if required
   */

  // Update the site title in real time...
  /*
  api( 'blogname', function( value ) {
    value.bind( function( newval ) {
      console.log(newval);
      $( '#site-title a' ).html( newval );
    } );
  } );
  */

  // New content loaded via selective refresh
  /*
  api.selectiveRefresh.bind('partial-content-rendered', function ( placement ) {
    console.log( placement );
    console.log( placement.partial.params.selector );

    $( placement.partial.params.selector ).trigger( 'layoutChanged', [ data.layout ] );
  });
  */

// Preview -> Control Panel
  /*
  api.preview.bind( 'active', function() {
    api.preview.send( 'preview-to-control', 'preview-to-control' );
    console.log('Sent!');
  } );
 */

  // Preview <- Control Panel
  /*
  api.preview.bind( 'control-to-preview', function( data ) {
    console.log('Data from control panel: ', data);
  } );
 */

  } );
} )( jQuery, wp.customize );
