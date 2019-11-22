{{--
Product Content
@version  3.4.0
@overwrite false
--}}

@php
  global $product;
@endphp

@if(empty($product) || ! $product->is_visible())
  @return
@endif

<div @php( wc_product_class( "w-full sm:w-1/2 md:w-1/3 lg:w-1/" . wc_get_loop_prop( 'columns' ), $product ) )>
  <div class="product-inner">
    @action('get_before_shop_loop_item' )
    <div class="product-image-container">
      @action('get_before_shop_loop_item_title' )
    </div>
    <div class="product-description">
      @action('get_shop_loop_item_title' )
      @action('get_after_shop_loop_item_title' )
    </div>
    @action('get_after_shop_loop_item' )
  </div>
</div>
