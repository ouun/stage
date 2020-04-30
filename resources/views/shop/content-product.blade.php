{{--
Product Content
@version  3.6.0
@overwrite false
--}}

@if(empty($product) || ! $product->is_visible())
  @return
@endif

<div class="product-inner {{ $product_class }}">
  @action( 'woocommerce_before_shop_loop_item' )

  <div class="product-image-container">
    @if( ( $has_thumbnail || $display_placeholder ) && $display_thumbnail )
      @action( 'woocommerce_before_shop_loop_item_title' )
    @endif
  </div>

  @if( $display_headline || $display_meta || $display_excerpt || $display_tags )
    <div class="product-description">
      @if( $display_headline )
        @action( 'woocommerce_shop_loop_item_title' )
      @endif
      @action( 'woocommerce_after_shop_loop_item_title' )
    </div>
  @endif

  @action( 'woocommerce_after_shop_loop_item' )
</div>
