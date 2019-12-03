import {adminbar} from "./adminbar";
import {objects} from "../config";
import detectIt from "detect-it/src";

/**
 * On scroll handling
 *
 * @type {{removeClasses: menuOnScroll.removeClasses, init: menuOnScroll.init, previousTop: number, onScroll: menuOnScroll.onScroll, classes: string, toggleClasses: menuOnScroll.toggleClasses, isInitialized: boolean, currentTop: number, addClasses: menuOnScroll.addClasses, isScrolling: boolean}}
 */
export const menuOnScroll = {

  isInitialized: false,
  isScrolling: false,
  previousTop: 0,
  currentTop: 0,
  offsetTop: 0,
  classes: 'is-scrolled',

  init: function () {
    if ( !menuOnScroll.isInitialized ) {
      menuOnScroll.onScroll();

      // Check for offset
      menuOnScroll.setOffset();

      // Set state & init only once
      menuOnScroll.isInitialized = true;

      // Event Listener: Expand menu after page-load
      $( window ).on( 'loader-before-enter', function () {
        menuOnScroll.removeClasses();
      });
    }
  },

  /**
   * Adds offset e.g. for admin bar
   */
  setOffset: function () {
    // Add offset if adminbar is visible
    if( stage.wp.adminbar_visible ) {
      menuOnScroll.offsetTop = adminbar.height;
    }
  },

  /**
   * Add event listener
   */
  onScroll: function () {
    document.addEventListener("wheel", function () {
      if ( !menuOnScroll.isScrolling ) {
        menuOnScroll.isScrolling = true;

        (!window.requestAnimationFrame)
          ? setTimeout(menuOnScroll.toggleClasses, 250)
          : requestAnimationFrame(menuOnScroll.toggleClasses);
      }
    }, detectIt.passiveEvents ? {passive:true} : false );
  },

  /**
   * Add/Remove classes depending on scrolling distance
   */
  toggleClasses: function () {
    let currentTop = $( window ).scrollTop();

    if ( menuOnScroll.currentTop < 100 ) {
      if (currentTop > menuOnScroll.offsetTop) {
        menuOnScroll.addClasses();
      } else {
        menuOnScroll.removeClasses();
      }
    }

    menuOnScroll.isScrolling = false;
    menuOnScroll.currentTop = currentTop;
  },

  /**
   * Add classes
   */
  addClasses: function() {
    objects.mainHeader.addClass( menuOnScroll.classes );
  },

  /**
   * Remove classes
   */
  removeClasses: function () {
    objects.mainHeader.removeClass(  menuOnScroll.classes  );
  },
};
