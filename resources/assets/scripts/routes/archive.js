import { infinity } from "../modules/infinite-scroll";
import { msnry } from "../modules/grid_masonry";

/**
 * Archives
 */
export default () => {
  msnry.init();

  if ( stage.features.infinity ) {
    const infScroll = infinity.init();

    jQuery( 'main .archive-wrap' ).on( 'stage-customizer-layout-changed', function( e, data ) {
      // Scroll up the page
      $([document.documentElement, document.body]).animate({
        scrollTop: $('main').offset().top,
      }, 50);

      // Destroy the infiniteScroll instance
      infinity.destroy( infScroll );

      // Build new Masonry
      if( data.layout === 'masonry' ) {
        msnry.init();
      }
    });
  }
};
