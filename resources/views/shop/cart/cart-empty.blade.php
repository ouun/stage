{{--
@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.5.0
--}}

@php
  defined( 'ABSPATH' ) || exit;
@endphp

{{--
@hooked wc_empty_cart_message - 10
--}}
@action('woocommerce_cart_is_empty')

<div class="sw-cart__empty flex-column">
	@php do_action( 'woocommerce_cart_is_empty' ) @endphp

	@if ( wc_get_page_id( 'shop' ) > 0 )
		<p class="return-to-shop">
			<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
        <?php esc_html_e( 'Return to shop', 'woocommerce' ); ?>
			</a>
		</p>
	@endif
</div>
