<?php

namespace Stage\Providers;

use Roots\Acorn\ServiceProvider;
use function Stage\stage_config;

class ShopFilters extends ServiceProvider {

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot() {
		add_filter(
			'woocommerce_before_output_product_categories',
			function () {
				return '<section class="product-categories mb-5 py-5">';
			}
		);

		add_filter(
			'woocommerce_after_output_product_categories',
			function () {
				return '</section>';
			}
		);

		// Remove WC styles.
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'shop_dequeue_wc_styles' ) );

		// Remove WC <main> tags.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		// Customize Stage loop item classes
		add_filter('stage_product_archive_item_classes', function ($classes) {
			global $product;

			// Add WooCommerce item classes
			$classes = array_merge($classes, wc_get_product_class( $product ));
			$classes[] = "grid-item";
			$classes[] = "w-full";
			$classes[] = "sm:w-1/2";
			$classes[] = "md:w-1/3";
			$classes[] = "lg:w-1/" . wc_get_loop_prop( 'columns' );

			return $classes;
		});

		// Fade animation for Flexslider.
		add_filter(
			'woocommerce_single_product_carousel_options',
			function ( $options ) {
				$options['directionNav'] = true;
				$options['animation']    = 'fade';
				return $options;
			}
		);

		// Thumbnail sizes.
		add_filter(
			'single_product_archive_thumbnail_size',
			function() {
				return 'large';
			}
		);

		add_filter(
			'subcategory_archive_thumbnail_size',
			function() {
				return 'large';
			}
		);

		add_filter(
			'woocommerce_gallery_image_size',
			function() {
				return 'large';
			}
		);

		// Move categories out of products grid in archive.
		// remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );
		// add_filter( 'woocommerce_before_shop_loop', 'woocommerce_maybe_show_product_subcategories' );

		// Remove category counter for archives.
		add_filter( 'woocommerce_subcategory_count_html', '__return_null' );

		// Customize single product tabs.
		add_filter( 'woocommerce_product_tabs', array( $this, 'shop_reorder_product_tabs' ), 98 );

		// Change review tab title.
		add_filter( 'woocommerce_product_reviews_tab_title', array( $this, 'shop_review_tab_title' ) );

		// Pagination links.
		add_filter( 'woocommerce_pagination_args', array( $this, 'shop_pagination_args' ) );

		// Remove WC placeholder image.
		add_filter( 'woocommerce_placeholder_img_src', array( $this, 'shop_custom_woocommerce_placeholder' ), 10 );

		// Controls the size used in the product grid/catalog for category images.
		add_filter(
			'subcategory_archive_thumbnail_size',
			function ( $size ) {
				return 'large';
			}
		);

		// Customize product name in cart.
		add_filter(
			'woocommerce_cart_item_name',
			function ( $link_text, $product_data ) {

				// Separate product variables if available.
				if ( $product_data['variation_id'] ) {
					$link_text  = str_replace( '- ' . wc_get_formatted_variation( $product_data['variation'], true, false ), '', $link_text );
					$link_text .= '<span class="flex text-xs uppercase text-gray-500">' . wc_get_formatted_variation( $product_data['variation'], false ) . '</span>';
				}

				return $link_text;
			},
			10,
			2
		);

		// Add VAT notice to prices.
		add_filter(
			'woocommerce_get_price_suffix',
			function ( $html, $product, $price, $qty ) {
				// $html .= ' <span class="vat_notice">' . __( 'incl. VAT', 'woocommerce' ) . '</span>';
				return $html;
			},
			10,
			4
		);

		/**
		 * Remove select2 & prettyPhoto styles and scripts
		 */
		add_action(
			'wp_enqueue_scripts',
			function() {
				wp_dequeue_style( 'selectWoo' );
				wp_deregister_style( 'selectWoo' );

				wp_dequeue_style( 'select2' );
				wp_deregister_style( 'select2' );

				wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
				wp_dequeue_script( 'prettyPhoto' );
				wp_dequeue_script( 'prettyPhoto-init' );
			},
			100
		);

		/**
		 * Change variation price from (min - max) to (From min).
		 */
		add_filter(
			'woocommerce_variable_price_html',
			function ( $wc_format_price_range, $product ) {
				$prefix = __( 'From', 'woocommerce' );

				$min_regular_price = $product->get_variation_regular_price( 'min', true );
				$min_sale_price    = $product->get_variation_sale_price( 'min', true );
				$max_active_price  = $product->get_variation_price( 'max', true );
				$min_active_price  = $product->get_variation_price( 'min', true );

				$price_html = ( $min_sale_price === $min_regular_price ) ? wc_price( $min_active_price ) :
					'<del class="text-xs text-black">' . wc_price( $min_regular_price ) . '</del> <ins>' . wc_price( $min_active_price ) . '</ins>';

				return $min_active_price === $max_active_price ? $price_html : sprintf( '%s %s', $prefix, $price_html );
			},
			10,
			2
		);
	}

	/**
	 * Dequeue WC Styles
	 *
	 * @param array $enqueue_styles Styles WC enqueues.
	 *
	 * @return mixed
	 */
	public static function shop_dequeue_wc_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-general'] );     // Remove the gloss.
		unset( $enqueue_styles['woocommerce-layout'] );      // Remove the layout.
		// unset( $enqueue_styles['woocommerce-smallscreen'] ); // Remove the smallscreen optimisation.
		return $enqueue_styles;
	}

	/**
	 * Change product tabs priorities.
	 *
	 * @param array $tabs Product tabs.
	 *
	 * @return mixed
	 */
	public static function shop_reorder_product_tabs( $tabs ) {

		// Change the priority.
		$tabs['description']['priority'] = 5;  // Description first.
		$tabs['reviews']['priority']     = 10; // Reviews second.

		return $tabs;
	}

	/**
	 * Customize the Reviews tab title
	 *
	 * @param string $title Reviews tab title.
	 *
	 * @return string
	 */
	public static function shop_review_tab_title( $title ) {
		$count = substr( $title, -2, -1 );    // returns "3".
		$title = substr( $title, 0, -3 );      // removes (3).

		return $title . '<span class="count text-primary">' . $count . '</span>';
	}

	/**
	 * Customize shop pagination.
	 *
	 * @param array $args Shop Pagination.
	 *
	 * @return mixed
	 */
	public static function shop_pagination_args( $args ) {
		$args['prev_text'] = get_svg( 'arrow-left' );
		$args['next_text'] = get_svg( 'arrow-right' );

		return $args;
	}

	/**
	 * Customize image placeholder
	 *
	 * @return bool
	 */
	public static function shop_custom_woocommerce_placeholder() {
		return false;
	}
}
