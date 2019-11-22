import {objects} from "./config";
import {offCanvas} from "./menu/off-canvas";
import {search} from "./menu/search";
import {dropdown} from "./menu/dropdown";

/**
 * Content Overlay
 *
 * @type {{isOpen: boolean, clickClose: overlay.clickClose, swipe: overlay.swipe, toggle: overlay.toggle, close: overlay.close, open: overlay.open}}
 */
export const overlay = {

  isOpen: false,

  /**
   * Toggle overlay state
   */
  toggle: function () {
    if ( overlay.isOpen ) {
      overlay.close();
    } else {
      overlay.open()
    }
  },

  /**
   * Click to close
   */
  clickClose: function () {
    objects.overlay.one('click', function( event ) {
      event.preventDefault();

      dropdown.close();
      search.close();
      overlay.close();
    });
  },

  /**
   * Open overlay
   *
   * @param loading Show loading indicator
   * @param opacity Allows overwriting opacity
   */
  open: function ( loading = false ) {
    // Show overlay
    objects.overlay.addClass('is-visible');

    if ( loading ) {
      // Add loading indicator
      objects.overlay.addClass('is-loading');
    }

    // Add event listener for closing
    overlay.clickClose();

    // Set new state
    this.isOpen = true;
  },

  /**
   * Close overlay
   */
  close: function () {
    // Hide overlay
    objects.overlay.removeClass('is-visible').removeClass('is-loading');

    // Set new state
    this.isOpen = false;
  },

  /**
   * Swipe to close nav
   * todo: Currently not used and tested
   */
  swipe: function () {
    objects.overlay.on('swiperight', function(){
      if ( objects.mainHeader.hasClass('nav-is-visible') && objects.offCanvasMenu.hasClass('pin-r') ) {
        offCanvas.close();
        overlay.close();
      }
    });

    objects.overlay.on('swipeleft', function(){
      if ( objects.mainHeader.hasClass('nav-is-visible') && objects.offCanvasMenu.hasClass('pin-l') ) {
        offCanvas.close();
        overlay.close();
      }
    });

    // Set new state
    this.isOpen = false;
  },

};
