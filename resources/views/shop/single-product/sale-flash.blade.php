@php global $post, $product @endphp

@if( $product->is_on_sale() )
  @php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); @endphp
@endif
