<?php

namespace Stage\Composers;

use Roots\Acorn\View\Composer;

class Shop extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.header',
    ];

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
    public function with()
    {
        $shop = [
            'shop' => $this->site_has_shop(),
        ];

        if ( $shop['shop'] && ! is_admin() ) {
            array_merge(
                $shop,
                [
                    'is_cart'             => is_cart(),
                    'is_checkout'         => is_checkout(),
                    'cart_url'            => esc_url( wc_get_cart_url() ),
                    'cart_contents_count' => WC()->cart->get_cart_contents_count(),
                ]
            );
        }

        return $shop;
    }

    /**
     * Is WooCommerce active?
     *
     * @return bool
     */
    public static function site_has_shop() {
        return defined( 'WC_ABSPATH' );
    }
}
