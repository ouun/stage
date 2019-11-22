import PhotoSwipe from 'photoswipe';
import PhotoSwipeUI_Default from 'photoswipe/dist/photoswipe-ui-default';
import {objects} from "./config";

/**
 * PhotoSwipe based Galleries
 *
 * @type {{init: gallery.init, prepare: gallery.prepare, $element: *, isInitialized: boolean, options: {getThumbBoundsFn: (function(*): {w: *, x: *, y: *}), barsSize: {top: *, bottom: string}, mainClass: string, shareEl: boolean, escKey: boolean, preloaderEl: boolean, index: number, galleryPIDs: boolean, galleryUID: number, preload: number[], showHideOpacity: boolean}, setPictures: gallery.setPictures, bootstrap: (function()), setGallery: gallery.setGallery, items: [], clickOpen: gallery.clickOpen}}
 */
export const gallery = {

  $element: document.querySelectorAll('.pswp')[0],
  isInitialized: false,
  items: [],
  options: {
    // see http://photoswipe.com/documentation/options.html
    barsSize: {top:$('.pswp__top-bar').outerHeight(), bottom:'auto'},
    shareEl: false,
    escKey: true,
    preload: [1,2],
    preloaderEl: true,
    showHideOpacity: true,
    mainClass: 'gallery',
    galleryPIDs: true,
    galleryUID: 0,
    index: 0,
    getThumbBoundsFn: function( index ) {
      // Get the thumbnail by GID & PID
      let thumb = $( "img[data-gid=" + gallery.options.galleryUID + "][data-pid=" + index + "]");
      // Get coordinates
      let y = thumb.offset().top;
      let x = thumb.offset().left;
      // Set coordinates and width
      return { x: x, y: y, w:thumb.outerWidth() };
    },
  },

  /**
   * Init galleries if required
   */
  init: function () {
    if ( !gallery.isInitialized ) {
      // Get & set the items
      gallery.prepare();
      gallery.clickOpen();

      // Set new state, init only once
      gallery.isInitialized = true;
    }

    // Re-Init after new content loaded
    $( window ).one( 'post-load', function () {
      gallery.isInitialized = false;
    });
  },

  /**
   * Boot PhotoSwipe
   */
  bootstrap: function () {
    return  new PhotoSwipe( gallery.$element, PhotoSwipeUI_Default, gallery.items, gallery.options );
  },

  /**
   * Manipulate DOM for supporting this
   */
  prepare: function () {
    // Set unique gallery IDs
    $('.stage-gallery').each( function ( index ) {
      let galleryID = index + 1;

      // Add ID to gallery
      $( this ).attr( 'data-gid', galleryID );
      // Add ID to each image
      $( this ).find( 'a' ).each( function( index ) {
        let $anchor = $( this );
        let $image  = $anchor.find( 'img' );

        if ( $image.attr( 'data-full' ) && $image.attr( 'data-full-width' ) && $image.attr( 'data-full-height' ) ) {
          $image.attr( 'data-gid', galleryID ).attr( 'data-pid', index );
          // Prevent link from loading with barba.js
          $anchor.attr( 'data-barba-prevent', 'self' ).attr( 'href', '#' );
        }
      })
    });
  },

  /**
   * Add event listener
   */
  clickOpen: function () {
    $('.stage-gallery a').on('click', function ( e ) {
      // Do not follow the link
      e.preventDefault();
      // Set the gallery
      gallery.setGallery( $( this ).find('img') );
      // Open the gallery
      gallery.bootstrap().init();
    });
  },

  /**
   * Set and prepare clicked gallery
   *
   * @param $image
   */
  setGallery: function ( $image ) {
    // Set image & gallery index, where to start
    gallery.options.galleryUID = parseInt( $( $image ).attr( 'data-gid' ).length ? $( $image ).attr( 'data-gid' ) : 0 );
    gallery.options.index = parseInt($( $image ).attr( 'data-pid' ).length ? $( $image ).attr( 'data-pid' ) : 0 );
    // Clear gallery items
    gallery.items = [];
    // Set new items
    gallery.setPictures( $( $image ).parents( '.stage-gallery' ) );
  },

  /**
   * Set and prepare pictures of clicked gallery
   *
   * @param $container
   */
  setPictures: function ( $container = objects.main ) {
    // For each image, create the corresponding PhotoSwipe item by retrieving
    // the full size information in data attributes set on server side:
    $( $container ).find( 'img[data-full]' ).each( function() {
      let $image = $( this );

      // Retrieve image caption if any:
      let $caption = $( this ).closest('figure').find( 'figcaption' );

      // Add pictures to items array
      if ( $image.attr( 'data-full' ) && $image.attr( 'data-full-width' ) && $image.attr( 'data-full-height' ) ) {
        gallery.items.push({
          src: $image.attr('data-full'),
          msrc:  $image.attr('src'),
          pid: parseInt( $image.attr('data-pid') ) + 1,
          w: $image.attr('data-full-width'),
          h: $image.attr('data-full-height'),
          title: $caption.length ? $caption.text() : '',
        });
      }
    } );
  },
};
