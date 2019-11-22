import {objects} from "../config";
import detectIt from "detect-it/src";

/**
 * Auto-hide menu
 *
 * @type {{init: menuAutoHide.init, scrolling: boolean, scrollDelta: number, previousTop: number, onScroll: menuAutoHide.onScroll, isInitialized: boolean, autoHide: menuAutoHide.autoHide, currentTop: number, scrollOffset: number, headerHeight: number, simpleNavigation: menuAutoHide.simpleNavigation}}
 */
export const menuAutoHide = {
  isInitialized: false,
  scrolling: false,
  previousTop: 0,
  currentTop: 0,
  scrollDelta: 10,
  scrollOffset: 1000,
  headerHeight: 0,
  classes: 'is-hidden',

  /**
   * Init auto-hide functionality if required
   */
  init: function () {
    if ( menuAutoHide.active() ) {
      // Initially set header height
      menuAutoHide.headerHeight = objects.mainHeader.height();

      if ( objects.mainHeader.length && !menuAutoHide.isInitialized ) {
        menuAutoHide.onScroll();

        // Event Listener: Show menu after page-load
        $( window ).on( 'loader-before-enter', function () {
          menuAutoHide.removeClasses();
        });

        // Set state & init only once
        menuAutoHide.isInitialized = true;
      }
    }
  },

  /**
   * Is auto-hide active
   *
   * @returns {boolean}
   */
  active: function () {
    return objects.mainHeader.hasClass('auto-hide');
  },

  /**
   * On Scroll hide/show header
   * Avoid costly calculations while the window size is in flux.
   * https://css-tricks.com/debouncing-throttling-explained-examples/#article-header-id-1
   */
  onScroll: function () {
    document.addEventListener( "wheel", function () {
      if( !menuAutoHide.scrolling ) {
        menuAutoHide.scrolling = true;
        (!window.requestAnimationFrame)
          ? setTimeout( menuAutoHide.autoHide, 250 )
          : requestAnimationFrame( menuAutoHide.autoHide );
      }
    }, detectIt.passiveEvents ? {passive:true} : false );

    $( window ).on( 'resize', function() {
      menuAutoHide.headerHeight = objects.mainHeader.height();
    });
  },

  /**
   * Auto hide header
   */
  autoHide: function () {
    let currentTop = $( window ).scrollTop();

    menuAutoHide.simpleNavigation( currentTop );

    menuAutoHide.previousTop = currentTop;
    menuAutoHide.scrolling = false;
  },

  /**
   * Hide/Show header
   *
   * @param currentTop
   */
  simpleNavigation: function ( currentTop ) {
    if ( menuAutoHide.previousTop - currentTop > menuAutoHide.scrollDelta ) {
      //if scrolling up...
      menuAutoHide.removeClasses();
    } else if( currentTop - menuAutoHide.previousTop > menuAutoHide.scrollDelta && currentTop > menuAutoHide.scrollOffset ) {
      //if scrolling down...
      menuAutoHide.addClasses();
    }
  },

  /**
   * Add classes
   */
  addClasses: function() {
    objects.mainHeader.addClass( menuAutoHide.classes );
  },

  /**
   * Remove classes
   */
  removeClasses: function () {
    objects.mainHeader.removeClass( menuAutoHide.classes );
  },

};
