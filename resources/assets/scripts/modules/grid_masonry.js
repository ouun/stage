import Colcade from 'colcade';

const defaultContainer = 'main .grid-masonry';

export const msnry = {

  /**
   * Init Colcade Masonry
   *
   * @param container
   */
  init: function( container = defaultContainer ) {
    if ( msnry.available( container ) ) {
      // Bootstrap
      let colcade = msnry.bootstrap( container );

      if ( msnry.active( container ) ) {
        // Event Listener: Append items loaded with infinityScroll
        msnry.appendItems();
        // Event Listener: Destroy masonry after mew post loaded
        $( window ).one( 'post-load', function () {
          colcade.destroy();
        });
      }
    }
  },

  bootstrap: function(container = defaultContainer ) {

    const colcade = new Colcade( container, {
      columns: '.grid-col',
      items: '.grid-item',
    });

    $( container ).addClass( 'masonry-active' );

    return colcade;

  },

  /**
   * Container element in DOM?
   *
   * @param container
   * @returns {boolean}
   */
  available: function ( container = defaultContainer ) {
    return !!document.querySelector( container );
  },

  /**
   * Returns the instance
   *
   * @param container
   * @returns {object} The InfiniteScroll instance
   */
  get: function( container = defaultContainer ) {
    return msnry.bootstrap( container );
  },

  /**
   * Is it initialized?
   *
   * @param container
   * @returns {boolean}
   */
  active: function ( container = defaultContainer ) {
    return !!$( container ).hasClass( 'masonry-active' );
  },

  /**
   * Destroy msnry instance
   *
   * @param container
   */
  destroy: function ( container = defaultContainer ) {
    msnry.bootstrap( container ).destroy();
  },

  /**
   * Add items to Masonry grid
   *
   * @param container
   */
  appendItems: function ( container = defaultContainer ) {
    if ( stage.features.infinity ) {
      $(document).on( 'stage_infinity-append-items', function ( event, response, path, items ) {
        msnry.bootstrap( container ).append( items );
      });
    }
  },

};
