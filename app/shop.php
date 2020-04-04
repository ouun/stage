<?php

/**
 * Add WooCommerce support
 *
 * @package App
 */

if (defined('WC_ABSPATH')) {
    /**
     * Some default settings
     * todo: Find a new home for this
     */
    remove_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
