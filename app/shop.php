<?php

/**
 * WooCommerce Hooks
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
     *  Wide align shop pages
     */
    add_filter('stage_single_align_content', function ($align) {
        if (is_shop() || is_cart() || is_checkout()) {
            $align = 'alignwide';
        }

        return $align;
    });

    /**
     * Remove Coupon Code from checkout, it is already in cart
     */
    remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
}
