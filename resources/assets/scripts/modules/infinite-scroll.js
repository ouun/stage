import InfiniteScroll from 'infinite-scroll';

/**
 * Infinity Loading Module
 *
 * @type {{container: string, init: infinity.init, get: (function(*=): *), isInitialized: boolean, available: (function(*=): boolean), active: (function(*=): boolean), destroy: infinity.destroy, addLoadingIndicator: infinity.addLoadingIndicator, triggerEvent: infinity.triggerEvent, bootstrap: (function(*=, *=, *=, *=)), animateItems: infinity.animateItems}}
 */
export const infinity = {

  isInitialized: false,
  container: 'main .infinity-wrap',
  nextPath: '.nav-previous > a',

  /**
   * Init InfiniteScroll
   *
   * @param container
   */
  init: function( container = infinity.container ) {
    if ( infinity.available( container ) && !infinity.isInitialized && stage.features.infinity ) {
      // Bootstrap infinity scroll
      let infScroll = infinity.bootstrap(container);
      infinity.isInitialized = true;

      if ( infinity.active( container ) ) {
        // Add event listener to append items
        infinity.animateItems( container );
        // Add custom event triggers
        infinity.triggerEvent( container );
        // Destroy instance on 'page-load'
        $(window).one('post-load', function () {
          infinity.destroy(infScroll);
        });

        return infScroll;
      }
    }
  },

  /**
   * Bootstraps infiniteScroll and returns the instance
   *
   * @param container
   * @param nextPath
   * @param append
   * @param hide
   * @returns {object} The InfiniteScroll instance
   */
  bootstrap: function( container = infinity.container, nextPath = infinity.nextPath, append = '.grid-item', hide = '.nav-links' ) {

    infinity.addLoadingIndicator( hide, nextPath );

    return new InfiniteScroll( document.querySelector( container ), {
      debug: false,
      path: nextPath,
      append: append,
      hideNav: hide,
      history: 'push',
      status: '.page-load-status',
      scrollThreshold: 800,
    });
  },

  /**
   * DOM manipulation for loading indicator
   *
   * @param hide
   * @param nextPath
   */
  addLoadingIndicator: function ( hide, nextPath ) {
    if ( $(nextPath).length ) {
      $( hide ).parent().append(
        '<div class="page-load-status block pt-8 pb-4">' +
        '<p class="infinite-scroll-request hidden loading"></p>' +
        '</div>'
      );
    }
  },

  /**
   * Container element in DOM?
   *
   * @param container
   * @param nextPath
   * @returns {boolean}
   */
  available: function ( container = infinity.container, nextPath = infinity.nextPath ) {
    return !! document.querySelector( container ) && document.querySelector( nextPath );
  },

  /**
   * Is it initialized?
   *
   * @param container
   * @returns {boolean}
   */
  active: function ( container = infinity.container ) {
    return !!infinity.get( container );
  },

  /**
   * Returns the instance
   *
   * @param container
   * @returns {object} The InfiniteScroll instance
   */
  get: function( container = infinity.container ) {
    return InfiniteScroll.data( container );
  },

  /**
   * Destroy infinity instance
   *
   * @param infScroll
   */
  destroy: function ( infScroll ) {
    if ( infScroll ) {
      infScroll.destroy();
    }
  },

  /**
   * Custom event trigger 'stage_infinity-append-items'
   * Fired when appending new items
   */
  triggerEvent: function( container ) {
    infinity.get( container ).on( 'append', function ( event, response, path, items ) {
      $( document ).trigger('stage_infinity-append-items', [ event, response, path, items ]);
    });
  },

  /**
   * Adds animation to newly added items
   *
   * @param container
   */
  animateItems: function ( container ) {
    infinity.get( container ).on( 'append', function ( response, path, items ) {
      // Reload common events e.g. for lazy loading
      items.forEach(function (element, index) {
        // Hide loaded elements
        element.classList.add('invisible');

        // Display one by one
        setTimeout(function timer() {
          element.classList.add('animate-loading');
          element.classList.remove('invisible');
        }, index * 100);
      });
    });
  },

};
