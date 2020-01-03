import {menu} from "../modules/menu";
import {lazy} from "../modules/lazy";
import {loader} from "../modules/loader";
import {gallery} from "../modules/gallery";
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

  if ( stage.features.loader ) {
    loader.init();
  }

  if ( stage.features.lazy ) {
    lazy.init();
  }

  if ( stage.features.gallery ) {
    gallery.init();
  }

  if ( stage.wp.adminbar_visible ) {
    adminbar.init();
  }

};
