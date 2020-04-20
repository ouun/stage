<?php

/**
 * Add WooCommerce support
 *
 * @package App
 */

namespace Stage;

if (stage_is_shop_active()) {
    /**
     * Some default settings
     * todo: Find a new home for this
     */
    remove_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    /**
     * Remove WooCommerce Generator tag
     */
	remove_action('wp_head', 'wc_generator');

    /**
     *  Wide allign shop pages
     */
    add_filter('post_class', function ($classes) {
        if (is_shop() || is_cart() || is_checkout()) {
            $classes[] = 'alignwide';
        }

        return $classes;
    });

	/**
	 * Remove Coupon Code from checkout, it is already in cart
	 */
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}
