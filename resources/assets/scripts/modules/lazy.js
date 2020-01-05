import lozad from "lozad";

/**
 * Lazy Loading based on lozad.js
 *
 * @type {{init: lazy.init, isInitialized: boolean, bootstrap: (function(): {observer, triggerLoad, observe})}}
 */
export const lazy = {
  isInitialized: false,

  init: function () {
    // Init lozad.js
    if( !lazy.isInitialized ) {
      lazy.bootstrap().observe();
    }

    // Run lozad.js on dynamically added elements
    $(document).on( 'stage_infinity-append-items', function() {
      lazy.bootstrap().observe();
    });
  },

  bootstrap: function () {
    return lozad('.lazy[data-src]', {
      rootMargin: '500px 0px',
      threshold: 0.1,
      load: function (el) {
        // Custom implementation to load an element
        el.srcset = el.dataset.srcset;
        el.src = el.dataset.src;
        // console.log('loading element: ' + el.src + el.srcset);
      },
      loaded: function (el) {
        // Custom implementation on a loaded element
        $(el).addClass('is-loaded');
      },
    });
  },
};
