import {menu} from "../modules/menu";
import {lazy} from "../modules/lazy";
import {loader} from "../modules/loader";
import {gallery} from "../modules/gallery";

/**
 * Common
 */
export default () => {
  // Init Modules
  menu.init();

  if ( stage.features.loader ) {
    loader.init();
  }

  if ( stage.features.lazy ) {
    lazy.init();
  }

  if ( stage.features.gallery ) {
    gallery.init()
  }
};
