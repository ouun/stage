<?php
/**
 * Add WooCommerce support
 *
 * @package App
 */

namespace Roots;

if ( defined( 'WC_ABSPATH' ) ) {
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

	/**
	 * Set template path to /shop
	 */
	add_filter(
		'woocommerce_template_path',
		function () {
			return 'shop/';
		},
		100,
		1
	);

	/**
	 * Some default settings
	 * todo: Find a new home for this
	 */
	remove_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/**
	 * @param string $template
	 *
	 * @return string
	 */
	function wc_template_loader( string $template ) {

		if ( strpos( $template, WC_ABSPATH ) === - 1 ) {
			return $template;
		}

		return locate_template(
			app( 'sage.finder' )->locate(
				WC()->template_path() . str_replace(
					WC_ABSPATH . 'templates/',
					'',
					$template
				)
			)
		) ?: $template;
	}

	add_filter( 'template_include', __NAMESPACE__ . '\\wc_template_loader', 90, 1 );
	add_filter( 'comments_template', __NAMESPACE__ . '\\wc_template_loader', 100, 1 );

	add_filter(
		'wc_get_template_part',
		function ( $template ) {
			$theme_template = locate_template(
				app( 'sage.finder' )->locate(
					WC()->template_path() . str_replace( WC_ABSPATH . 'templates/', '', $template )
				)
			);

			if ( $theme_template ) {
				$view = app( 'view.finder' )
					->getPossibleViewNameFromPath( $file = realpath( $theme_template ) );

				$view = trim( $view, '\\/.' );

				/** Gather data to be passed to view */
				$data = array_reduce(
					get_body_class(),
					function ( $data, $class ) use ( $view, $file ) {
						return apply_filters( "sage/template/{$class}/data", $data, $view, $file );
					},
					array()
				);

				echo view( $view, $data )->render();
			}

			return $template;
		},
		PHP_INT_MAX,
		1
	);

	add_action(
		'woocommerce_before_template_part',
		function ( $template_name, $template_path, $located, $args ) {
			$theme_template = locate_template( app( 'sage.finder' )->locate( WC()->template_path() . $template_name ) );

			if ( $theme_template ) {
				$view = app( 'view.finder' )
					->getPossibleViewNameFromPath( $file = realpath( $theme_template ) );

				$view = trim( $view, '\\/.' );

				/** Gather data to be passed to view */
				$data = array_reduce(
					get_body_class(),
					function ( $data, $class ) use ( $view, $file ) {
						return apply_filters( "sage/template/{$class}/data", $data, $view, $file );
					},
					array()
				);

				echo view(
					$view,
					array_merge(
						compact( explode( ' ', 'template_name template_path located args' ) ),
						$data,
						$args
					)
				)->render();
			}
		},
		PHP_INT_MAX,
		4
	);

	add_filter(
		'wc_get_template',
		function ( $template, $template_name, $args ) {
			$theme_template = locate_template( app( 'sage.finder' )->locate( WC()->template_path() . $template_name ) );

			// return theme filename for status screen
			if ( is_admin() &&
				 ! wp_doing_ajax() &&
				 function_exists( 'get_current_screen' ) &&
				 get_current_screen() &&
				 get_current_screen()->id === 'woocommerce_page_wc-status' ) {
				return $theme_template ?: $template;
			}

			// return empty file, output already rendered by 'woocommerce_before_template_part' hook
			return $theme_template ? view( 'empty' )->getPath() : $template;
		},
		100,
		3
	);
}
