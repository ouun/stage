<?php
/**
 * Adjustments on images to support e.g. lazy-loading.
 *
 * @package App
 */

namespace App;

$activate = true;

/**
 * Register Image Sizes
 */
add_image_size( 'low-res', 64, 48, false );

if ( $activate ) {
	/**
	 * Adjust image output to use Lozad (lazy loading) & PhotoSwipe (Lightbox)
	 * todo: We are awaiting a "attachment_image_html" filter to match them all
	 * todo: This currently deactivated, adapt it to wherever
	 *
	 * @note This has NO effect on gutenberg blocks.
	 */
	add_filter(
		'wp_get_attachment_image_attributes',
		function ( $attributes, $attachment ) {
			// Bail on admin.
			if ( is_admin() || is_customize_preview() ) {
				return $attributes;
			}

			// Adjust <img> for lazy loading.
			if ( isset( $attributes['src'] ) ) {
				$attributes['data-src'] = $attributes['src'];

				$low_res_image_src = get_low_res_image_src( $attributes['src'], $attachment->ID )[0];

				if ( $low_res_image_src ) {
					$attributes['src'] = $low_res_image_src;
				} else {
					unset( $attributes['src'] );
				}

				$attributes['class'] .= ' lazy-load';
			}

			if ( isset( $attributes['srcset'] ) ) {
				$attributes['data-srcset'] = $attributes['srcset'];
				unset( $attributes['srcset'] );
			}

			// Adjust <img> for PhotoSwipe.
			/*
			if ( strpos( (string) $attributes['class'], 'wp-image' ) !== false ) {
				$full_size = wp_get_attachment_image_src( $attachment->ID, 'full' );
				if ( ! empty( $full_size ) ) {
					if ( ! empty( $full_size[0] ) ) {
						$attr['data-large_image']        = $full_size[0];
						$attr['data-large_image_width']  = $full_size[1];
						$attr['data-large_image_height'] = $full_size[2];
					}
				}
			}
			*/

			return $attributes;
		},
		10,
		2
	);

	/**
	 * Add wrapper element to blocks with the "full" or "wide" attribute
	 * // Todo: The following two functions could be combined into one
	 *
	 * @link https://developer.wordpress.org/reference/functions/render_block/
	 */
	add_filter( 'render_block_data', function ( $block, $source_block ) {
		// Fail early
		if ( is_admin() || ! isset( $source_block['blockName'] ) ) {
			return $block;
		}

		// Add custom attribute 'stage-media-gallery' to media linked galleries and images
		if ( $source_block['blockName'] === 'core/gallery' &&  isset( $source_block['attrs']['linkTo'] ) &&  $source_block['attrs']['linkTo'] === 'media' ) {
			$block['attrs']['stage-media-gallery'] = true;
		}

		// Add custom attribute 'stage-media-gallery' to media linked images
		if ( $source_block['blockName'] === 'core/image' && isset( $source_block['attrs']['linkDestination'] ) && $source_block['attrs']['linkDestination'] === 'media' ) {
			$block['attrs']['stage-media-gallery'] = true;
		}

		return $block;
	}, 20, 2 );

	add_filter( 'render_block', function ( $block_content, $block ) {
		// Fail early
		if ( is_admin() || ! isset( $block['blockName'] ) ) {
			return $block_content;
		}

		// Add a dedicated class to the gallery
		if ( $block['blockName'] === 'core/gallery' &&  isset( $block['attrs']['stage-media-gallery'] ) && $block['attrs']['stage-media-gallery'] ) {
			//$block_content = str_replace( $block['attrs']['className'], $block['attrs']['className'] . ' stage-media-gallery', $block_content );
			$block_content = '<div class="stage-media-gallery">' . $block_content . '</div>';

			// \Roots\wp_die(print_r($block));

			/*
			foreach ( $block['attrs']['ids'] as $id ) {
				$full_res = get_low_res_image_src( '', $id, 'full'  );

				if ( ! empty( $full_res ) && isset( $full_res[0] ) &&  isset( $full_res[1] ) &&  isset( $full_res[2] ) ) {
					// $block_content = preg_replace( '/<img ([^>]+?)[\/ ]*>/', '<img $1' . 'data-full="' . $full_res[0] . '" data-full-width="' . $full_res[1] . '" data-full-height="' . $full_res[2] . '" />', $block_content );
					$block_content = preg_replace( '/<img ([^>]+?)data-id=\"1045\"([^>]+?)[\/ ]*>/', '<img $1' . 'data-full="' . $full_res[0] . '" data-full-width="' . $full_res[1] . '" data-full-height="' . $full_res[2] . '" />', $block_content );
				}
			}
			*/
		}

		// Add a dedicated class to the images
		if ( $block['blockName'] === 'core/image' &&  isset( $block['attrs']['stage-media-gallery'] ) && $block['attrs']['stage-media-gallery'] ) {
			$block_content = '<div class="stage-media-gallery">' . $block_content . '</div>';

			// Add full size image data to DOM
			$full_res = get_low_res_image_src( '', $block['attrs']['id'], 'full'  );
			if ( ! empty( $full_res ) && isset( $full_res[0] ) &&  isset( $full_res[1] ) &&  isset( $full_res[2] ) ) {
				$block_content = preg_replace( '/<img ([^>]+?)[\/ ]*>/', '<img $1' . 'data-full="' . $full_res[0] . '" data-full-width="' . $full_res[1] . '" data-full-height="' . $full_res[2] . '" />', $block_content );
			}
		}

		return $block_content;

	}, 10, 2 );


	/**
	 * Filter the_content output for Gutenberg support
	 */
	add_filter(
		'the_content',
		function ( $html ) {
			return manipulate_image_html( $html );
		}
	);

	/**
	 * Manipulates HTML to support lazy-loading
	 *
	 * @note This has effect on gutenberg blocks.
	 *
	 * @param string $html HTML which contains images to manipulate.
	 *
	 * @return string|string[]|null
	 */
	function manipulate_image_html( $html ) {
		// -- Change src/srcset to data attributes, and replace img src with its low res version
		// https://regex101.com/r/65oTIM/1/
		$html = preg_replace_callback(
			'/<img(.*?)(src=)\"(.*?)\"(.*?)(srcset=)\"(.*?)\"(.*?)>/i',
			function ( $matches ) {

				$noscript = "<noscript><img$matches[1]$matches[2]$matches[3]$matches[4]$matches[5]\"$matches[6]\"$matches[7]></noscript>";

				$low_res = get_low_res_image_src( $matches[3], null, 'low-res' );
				$full_res = get_low_res_image_src( $matches[3], null, 'full'  );

				if ( ! empty( $full_res ) && isset( $full_res[0] ) &&  isset( $full_res[1] ) &&  isset( $full_res[2] ) ) {
					$matches[7] .= 'data-full="' . $full_res[0] . '" data-full-width="' . $full_res[1] . '" data-full-height="' . $full_res[2] . '"';
				}

				if ( ! empty( $low_res ) ) {
					return "<img$matches[1]$matches[2]" . $low_res[0] . " data-$matches[2]$matches[3]$matches[4]data-$matches[5]\"$matches[6]\"$matches[7]>" . $noscript;
				} else {
					return "<img$matches[1]data-$matches[2]$matches[3]$matches[4]data-$matches[5]\"$matches[6]\"$matches[7]>" . $noscript;
				}

			},
			$html
		);

		// Wrap images in a .lazy-wrap div for clean and not blurred borders. Copy image classes to wrapping div.
		// $html = preg_replace( '/(<img|<iframe)(.*?)(src=)\"(.*?)\"(.*?)class=\"(.*?)\"([^>]*>)/i', '<div class="lazy-wrap $6">$1$2data-$3"$4"$5class="$6"$7</div>', $html );

		// Add .lazy class to each image that already has a class.
		$html = preg_replace( '/(<img|<iframe)(.*?)class=\"(.*?)\"(.*?)>/i', '$1$2class="$3 lazy-load"$4>', $html );

		// Add .lazy class to each image that doesn't already have a class.
		$html = preg_replace( '/(<img|<iframe)((?:(?!class=).)*?)>/i', '$1 class="lazy-load"$2>', $html );

		return $html;
	}

	/**
	 * Gets the ID of a low-res image by attachment URL
	 *
	 * @param string $image_url URL to image.
	 * @param int $image_id ID of required image.
	 *
	 * @param string $size Image size
	 *
	 * @return int ID of the low-res image
	 */
	function get_low_res_image_src( string $image_url = '', int $image_id = null, string $size = 'low-res' ) {

		$image_id = $image_id ?: attachment_url_to_postid( $image_url );

		return wp_get_attachment_image_src( $image_id, $size );
	}
}
