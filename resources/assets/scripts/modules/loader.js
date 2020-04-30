// do not import Barba like this if you load the library through the browser
import barba from '@barba/core';
import css from '@barba/css';
import {dropdown} from './menu/dropdown';
import {offCanvas} from './menu/off-canvas';
import {overlay} from "./overlay";
import {router} from 'js-dom-router';

/**
 * Content loader based on barba.js
 *
 * @type {{init: loader.init, initialized: boolean, preventLinks: loader.preventLinks, bootstrap: loader.bootstrap, hooks: loader.hooks}}
 */
export const loader = {

  initialized: false,

  /**
   * Init loader module
   */
  init: function () {

    loader.preventLinks();

    if ( ! loader.initialized ) {
      // tell barba to use the css module
      barba.use( css );
      // Add theme hooks
      loader.hooks();
      // Init barba.js
      loader.bootstrap();

      // Set init state
      loader.initialized = true;
    }
  },

  /**
   * Add hooks to different states
   */
  hooks: function () {
    // Before leave hook
    barba.hooks.before(data => {
      // Close open menus
      dropdown.close();
      offCanvas.close();
      overlay.open( true );

      return data;
    });

    // After leave hook
    barba.hooks.afterLeave(data => {
      // Update the active menu item classes
      if ( data.next.url.path ) {
        const activeClass = 'active';
        $( '.menu-item.' + activeClass ).removeClass( activeClass );
        $( `.menu-item > a[href="${ data.next.url.href }"]` ).parents( '.menu-item' ).addClass( activeClass )
      }
    });

    // After enter hook
    barba.hooks.beforeEnter(data => {

      // todo: Remove this temp fix for <footer> jumping above <main>: https://github.com/barbajs/barba/issues/479
      $( 'body' ).append($( 'body > footer' ));

      // Trigger for resetting features states
      $(document).trigger('loader-before-enter');

      // Update body classes
      loader.replaceBodyClasses( data );

      // Update Admin-Bar
      loader.replaceOldWithNew( '#wp-toolbar', data );

      // Update
      loader.replaceOldWithNew( 'header.main-header', data );

      return data;
    });

    barba.hooks.enter(data => {
      // Trigger for resetting features states
      $(document).trigger('loader-enter');

      // Scroll up the next page
      window.scrollTo(0, 0);

      return data;
    });

    // After everything hook
    barba.hooks.after(data => {
      // Fire 'post-load' JavaScript Event
      // Used by PlugIns and infiniteScroll
      $( document.body ).trigger( 'post-load' );
      $( document ).trigger( 'app' );

      // Fire router again after new content loaded
      router.ready();

      // Remove loading overlay
      overlay.close();

      return data;
    });
  },

  /**
   * Replace body classes
   *
   * @param data
   */
  replaceBodyClasses: function ( data ) {
    if ( data.next.html ) {
      const bodyElement = data.next.html.replace(/(<\/?)body( .+?)?>/gi, '$1notbody$2>', data.next.html);
      const bodyClasses = $(bodyElement).filter('notbody').attr('class');
      $("body").attr("class", bodyClasses);
    }
  },

  /**
   * Replaces element outside the replaced barba.js container
   * Used e.g. for WP Admin-Bar
   *
   * @param selector ID of element to replace
   * @param data barba.js data object
   */
  replaceOldWithNew: function ( selector, data ) {
    // Get from new DOM
    const element = $( data.next.html ).find( selector );

    if ( element.length > 0 ) {
      // Replace in DOM
      $( selector ).html( element.html() )
    }
  },

  /**
   * Prevent links to get handled by barba. E.g. all WordPress Links
   */
  preventLinks: function() {
    $( 'a' ).each( function() {
      if ( this.href.indexOf('/wp-admin/') !== -1
        || this.href.indexOf('/wp-login.php') !== -1
        || this.href.indexOf('#') !== -1
        || $(this).parent().hasClass('has-children')
      ) {
        $( this ).addClass('prevent');
      }
    });
  },

  /**
   * Bootstrap barba.js
   */
  bootstrap: function () {
    barba.init({
      debug: false,
      timeout: 5000,
      // define a custom function that will prevent Barba
      // from working on links that contains a `prevent` CSS class
      prevent: ({ el }) => el.classList && el.classList.contains('prevent'),
      schema: {
        prefix: 'data-loader',
      },
      transitions: [
        {
          name: 'fade',
          from: {
            namespace: ['page', 'post', 'shop'],
          },
          to: {
            namespace: ['page', 'post'],
          },
          appear() {
          },
        },
      ],
      views: [{
        namespace: 'shop',
        beforeLeave({ next }) {
          // Force regular load of products
          // todo: Await @barba/head to load <head> at https://barba.js.org/docs/plugins/head/
          barba.force(next.url.path);
        },
      }],
    });
  },
};
