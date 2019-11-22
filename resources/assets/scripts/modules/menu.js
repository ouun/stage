import {menuOnScroll} from "./menu/on-scroll";
import {menuAutoHide} from "./menu/auto-hide";
import {offCanvas} from "./menu/off-canvas";
import {search} from "./menu/search";
import {dropdown} from "./menu/dropdown";

/**
 * Init Menu modules
 *
 * @type {{init: menu.init, isInitialized: boolean}}
 */
export const menu = {

  isInitialized: false,

  /**
   * Init modules
   */
  init: function () {
    if ( !menu.isInitialized ) {
      // Init Menu modules
      search.init();
      dropdown.init();
      offCanvas.init();
      menuOnScroll.init();
      menuAutoHide.init();

      // Set state cause we init only once
      this.isInitialized = true;
    }
  },
};
