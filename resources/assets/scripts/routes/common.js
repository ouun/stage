import {menu} from "../modules/menu";
import {lazy} from "../modules/lazy";
import {loader} from "../modules/loader";
import {gallery} from "../modules/gallery";
import {accordions} from "../modules/accordions";
import {adminbar} from "../modules/menu/adminbar";

/**
 * Common
 */
export default () => {
  // Set stage object
  let stage = window.stage;

  // Init Modules
  stage.menu = menu;
  menu.init();

  // Init barba.js loader
  if ( stage.features.loader ) {
    loader.init();
  }

  // Init lozad.js lazy loading
  if ( stage.features.lazy ) {
    lazy.init();
  }

  // Init PhotoSwipe
  if ( stage.features.gallery ) {
    gallery.init();
  }

  // Init WP Adminbar
  if ( stage.wp.adminbar.visible ) {
    adminbar.init();
  }

  // Init Accordions
  accordions.init();

};
