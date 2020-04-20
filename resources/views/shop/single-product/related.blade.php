{{--
Related Products
@version  3.9.0
@overwrite false
--}}

@if( $related_products )

  <section class="related products">
    <h2>{!! esc_html( apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) ) ) !!}</h2>

    @php(woocommerce_product_loop_start())
      <div class="grid grid-flow-row grid-cols-2 md:grid-cols-4 lg:grid-cols-6 grid-rows-auto gap-4 my-10">
        @foreach( $related_products as $i => $related_product )
          <div class="product type-product">
            @php($post_object = get_post( $related_product->get_id() ))
            @php(setup_postdata( $GLOBALS['post'] =& $post_object ))
            @include('shop.content-product')
          </div>
        @endforeach
      </div>
    @php(woocommerce_product_loop_end())
  </section>

@endif

@php( wp_reset_postdata() )
