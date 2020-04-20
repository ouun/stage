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
    @action( 'woocommerce_before_shop_loop_item_title' )
  </div>
  <div class="product-description">
    @action( 'woocommerce_shop_loop_item_title' )
    @action( 'woocommerce_after_shop_loop_item_title' )
  </div>
  @action( 'woocommerce_after_shop_loop_item' )
</div>
