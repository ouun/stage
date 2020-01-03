import {adminbar} from "./adminbar";
import {objects} from "../config";
import detectIt from "detect-it/src";

/**
 * On scroll handling
 *
 * @type {{removeClasses: menuOnScroll.removeClasses, init: menuOnScroll.init, previousTop: number, onScroll: menuOnScroll.onScroll, classes: string, toggleClasses: menuOnScroll.toggleClasses, isInitialized: boolean, currentTop: number, addClasses: menuOnScroll.addClasses, isScrolling: boolean, isScrolled: boolean}}
 */
export const menuOnScroll = {

  isInitialized: false,
  isScrolling: false,
  isScrolled: false,
  previousTop: 0,
  currentTop: 0,
  offsetTop: 100,
  scrolledClasses: 'is-scrolled',
  upClasses: 'up',
  downClasses: 'down',

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
      menuOnScroll.offsetTop = adminbar.getAdminbarHeight();
    }
  },

  /**
   * Add event listener
   */
  onScroll: function () {
    document.addEventListener("scroll", function () {
      if ( !menuOnScroll.isScrolling ) {
        menuOnScroll.isScrolling = true;

        (!window.requestAnimationFrame)
          ? setTimeout(menuOnScroll.toggleClasses, 250)
          : requestAnimationFrame(menuOnScroll.toggleClasses);
      }
    }, detectIt.passiveEvents ? { passive: true } : false );
  },

  /**
   * Add/Remove classes depending on scrolling distance
   */
  toggleClasses: function () {
    let currentTop = window.pageYOffset || document.documentElement.scrollTop;

    if ( currentTop > menuOnScroll.offsetTop ) {
      menuOnScroll.addClasses( menuOnScroll.scrolledClasses );
      menuOnScroll.isScrolled = true;

      // Page is scrolled, check for up or down scrolling
      if ( currentTop > menuOnScroll.previousTop ) {
        // Scroll down
        menuOnScroll.addClasses( menuOnScroll.downClasses );
        menuOnScroll.removeClasses( menuOnScroll.upClasses );
      } else {
        // Scroll up
        menuOnScroll.addClasses( menuOnScroll.upClasses );
        menuOnScroll.removeClasses( menuOnScroll.downClasses );
      }

    } else {
      // We are at the top, remove the classes
      menuOnScroll.removeClasses( menuOnScroll.scrolledClasses );
      menuOnScroll.removeClasses( menuOnScroll.downClasses );
      menuOnScroll.removeClasses( menuOnScroll.upClasses );
      menuOnScroll.isScrolled = false;
    }

    menuOnScroll.isScrolling = false;
    menuOnScroll.currentTop = currentTop <= 0 ? 0 : currentTop;
    menuOnScroll.previousTop = currentTop <= 0 ? 0 : currentTop;
  },

  /**
   * Add classes
   */
  addClasses: function( classes ) {
    objects.mainHeader.addClass( classes );
  },

  /**
   * Remove classes
   */
  removeClasses: function ( classes ) {
    objects.mainHeader.removeClass( classes );
  },
};
