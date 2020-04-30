{{--
@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.5.0
--}}

@php
  defined( 'ABSPATH' ) || exit;
@endphp

@svg('alert-circle', 'w-24 h-auto text-center mt-24 mb-6')

<div class="text-center text-3xl font-serif">
  <x-alert type="warning" message="{{ apply_filters( 'wc_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) }}" />
</div>

@if ( wc_get_page_id( 'shop' ) > 0 )
  <div class="text-center mt-6">
    <a class="button outline primary wc-backward" href="{!! esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))) !!}">
      {!! esc_html__('Return to shop', 'woocommerce') !!}
    </a>
  </div>
@endif
