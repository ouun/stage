<?php

namespace Stage\Composers;

use Roots\Acorn\View\Composer;

class Shop extends Composer {

	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = array(
		'layouts.header',
		'shop.*',
	);

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
	public function with() {
		$shop = array(
			'shop' => $this->siteHasShop(),
		);

		if ( $shop['shop'] && ! is_admin() ) {
			$shop = wp_parse_args(
				array(
					'is_cart'             => is_cart(),
					'is_checkout'         => is_checkout(),
					'total_loop_prop'     => wc_get_loop_prop( 'total' ),
					'cart_url'            => esc_url( wc_get_cart_url() ),
					'cart_contents_count' => WC()->cart->get_cart_contents_count(),
					'show_page_title'     => apply_filters( 'woocommerce_show_page_title', false ),
				),
				$shop
			);
		}

		return $shop;
	}

	/**
	 * Is WooCommerce active?
	 *
	 * @return bool
	 */
	public static function siteHasShop() {
		return defined( 'WC_ABSPATH' );
	}
}
