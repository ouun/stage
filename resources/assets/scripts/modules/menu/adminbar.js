import {objects} from "../config";

/**
 * Adjust behavior with WP adminbar
 *
 * @type {{init: adminbar.init, getAdminbarHeight: adminbar.getAdminbarHeight, addFixedHeaderSpacing: adminbar.addFixedHeaderSpacing, headerPosition: string, isInitialized: boolean, bootstrap: adminbar.bootstrap, height: number}}
 */
export const adminbar = {

  isInitialized: false,
  headerPosition: '',
  height: 0,

  /**
   * Init
   */
  init: function () {
    if ( ! adminbar.isInitialized ) {

      adminbar.bootstrap();

      $( window ).resize( function() {
        adminbar.bootstrap();
      } );

      adminbar.isInitialized = true;
    }
  },

  /**
   * Bootstrap
   */
  bootstrap: function() {
    // Set Header position
    adminbar.headerPosition = objects.mainHeader.css('position');

    if ( adminbar.headerPosition === 'fixed' ) {
      // Set latest height
      adminbar.getAdminbarHeight();
      // Add spacing to menu
      adminbar.addFixedHeaderSpacing();
    }
  },

  /**
   * Get admin-bar height
   */
  getAdminbarHeight: function () {
    adminbar.height = $('#wpadminbar').outerHeight();
    return adminbar.height;
  },

  /**
   * Add spacing to <header>
   */
  addFixedHeaderSpacing: function () {
      objects.mainHeader.css('top', adminbar.height + 'px')
  },
};
