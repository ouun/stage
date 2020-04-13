import "jquery-accessible-accordion-aria";

export const accordions = {
  isInitialized: false,

  /**
   * Init accordions if required
   */
  init: function () {
    if ( !accordions.isInitialized ) {
      // Get & set the items
      $('.js-accordion').accordion({ buttonsGeneratedContent: 'html' });

      // Set new state, init only once
      accordions.isInitialized = true;
    }

    // Re-Init after new content loaded
    $( window ).one( 'post-load', function () {
      accordions.isInitialized = false;
    });
  },
};
