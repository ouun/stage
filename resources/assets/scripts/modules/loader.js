// do not import Barba like this if you load the library through the browser
import barba from '@barba/core';
import css from '@barba/css';
import prefetch from '@barba/prefetch';
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

    if ( !this.initialized ) {
      // tell barba to use the css module
      barba.use( css );
      // Prefetch all urls in viewport
      // barba.use( prefetch );
      // Add theme hooks
      loader.hooks();
      // Init barba.js
      loader.bootstrap();

      // Set init state
      this.initialized = true;
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
        $( `.menu-item > a[href$="${ data.next.url.path }"]` ).parents( '.menu-item' ).addClass( activeClass )
      }
    });

    // After enter hook
    barba.hooks.beforeEnter(data => {
      // Update body classes
      $('body').attr(
        'class',
        $('main#main').attr('class')
      );

      // Trigger for resetting features states
      $(document).trigger('loader-before-enter');

      return data;
    });

    barba.hooks.enter(data => {
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
   * Prevent links to get handled by barba. E.g. all WordPress Links
   */
  preventLinks: function() {
    $( 'a' ).each( function() {
      if ( this.href.indexOf('/wp-admin/') !== -1
        || this.href.indexOf('/wp-login.php') !== -1
        || this.href.indexOf('#') !== -1
        || $(this).parent().hasClass('menu-item-has-children')
        || $(this).hasClass('prevent')
      ) {
        $( this ).attr( 'href', '#' ).addClass( 'prevent' );
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
            namespace: ['page', 'shop'],
          },
          to: {
            namespace: ['page'],
          },
          appear() {
          },
        },
        {
          name: 'test',
          from: {
            namespace: ['page', 'shop'],
          },
          to: {
            namespace: ['shop'],
          },
          appear() {
          },
          beforeLeave(data) {
            // Force regular load of product
            barba.force(data.next.url.path);
          },
        },
      ],
    });
  },
};
