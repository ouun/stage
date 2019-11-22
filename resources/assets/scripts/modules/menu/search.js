import {objects} from "../config";
import {overlay} from "../overlay";
import {dropdown} from "./dropdown";
import {offCanvas} from "./off-canvas";
import {menuAutoHide} from "./auto-hide";

/**
 * Search handling
 *
 * @type {{init: search.init, trigger: search.trigger, close: search.close, open: search.open}}
 */
export const search = {

  isInitialized: false,
  isOpen:        false,

  /**
   * Init the search
   */
  init: function () {
    if ( !search.isInitialized ) {
      search.trigger();

      // Init only once
      this.isInitialized = true;
    }
  },

  /**
   * Add opening triggers
   */
  trigger: function () {
    // Icon click: Open search field
    objects.searchTrigger.on( 'click', function( event ) {
      event.preventDefault();

      // Open or close the search
      if ( search.isOpen ) {
        search.close();
      } else {
        search.open();
      }
    });

    // Escape: Close search
    $(document).keyup(function( e ) {
      if ( e.keyCode === 27 ) {
        search.close();
      }
    });
  },

  /**
   * Open the search
   */
  open: function () {
    // close Menu
    offCanvas.close();
    dropdown.close();

    // Remove auto-hidden menu support
    if ( menuAutoHide.active() ) {
      objects.mainHeader.removeClass('auto-hide');
    }

    // Toggle visibility
    objects.searchTrigger.addClass('is-visible z-1');
    objects.searchWrap.addClass('is-visible').find('input[type="search"]').focus();

    // Open overlay
    overlay.open();

    // Set new state
    this.isOpen = true;
  },

  /**
   * Close the search
   */
  close: function () {
    objects.searchWrap.removeClass('z-1').removeClass('is-visible');
    objects.searchTrigger.removeClass('is-visible');

    // Close overlay
    overlay.close();

    // Add back auto-hide if is used
    if ( menuAutoHide.active() ) {
      objects.mainHeader.addClass('auto-hide');
    }

    // Set new state
    this.isOpen = false;
  },
};
