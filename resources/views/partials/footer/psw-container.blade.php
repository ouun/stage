<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="pswp__bg"></div>
  <div class="pswp__scroll-wrap">
    <div class="pswp__container">
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
    </div>
    <div class="pswp__ui pswp__ui--hidden">
      <div class="pswp__top-bar">
        <div class="pswp__counter"></div>
        <button class="pswp__button pswp__button--close" aria-label="<?php esc_attr_e( 'Close (Esc)', 'stage' ); ?>">
          @svg('x-circle')
        </button>
        <button class="pswp__button pswp__button--share" aria-label="<?php esc_attr_e( 'Share', 'stage' ); ?>">
          @svg('share')
        </button>
        <button class="pswp__button pswp__button--fs" aria-label="<?php esc_attr_e( 'Toggle fullscreen', 'stage' ); ?>">
          @svg('maximize', 'maximize')
          @svg('minimize', 'minimize')
        </button>
        <button class="pswp__button pswp__button--zoom" aria-label="<?php esc_attr_e( 'Zoom in/out', 'stage' ); ?>">
          @svg('zoom-in', 'zoom-in')
          @svg('zoom-out', 'zoom-out')
        </button>
        <div class="pswp__preloader">
          <div class="pswp__preloader__icn"></div>
        </div>
      </div>
      <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
        <div class="pswp__share-tooltip"></div>
      </div>
      <button class="pswp__button pswp__button--arrow--left" aria-label="<?php esc_attr_e( 'Previous (arrow left)', 'stage' ); ?>">
        @svg('arrow-left')
      </button>
      <button class="pswp__button pswp__button--arrow--right" aria-label="<?php esc_attr_e( 'Next (arrow right)', 'stage' ); ?>">
        @svg('arrow-right')
      </button>
      <div class="pswp__caption">
        <div class="pswp__caption__center"></div>
      </div>
    </div>
  </div>
</div>
