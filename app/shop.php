<?php

/**
 * WooCommerce setup.
 *
 * @copyright https://ouun.io/ ouun
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace Stage;

/**
 * Declare WooCommerce Support
 *
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 */
add_theme_support(
	'woocommerce',
	array(
		'thumbnail_image_width' => 150,
		'single_image_width'    => 300,
		'product_grid'          => array(
			'default_rows'    => 3,
			'min_rows'        => 2,
			'max_rows'        => 8,
			'default_columns' => 4,
			'min_columns'     => 2,
			'max_columns'     => 5,
		),
	)
);

add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
remove_theme_support( 'wc-product-gallery-zoom' );
