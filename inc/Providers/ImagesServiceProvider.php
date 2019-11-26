<?php

namespace Stage\Providers;

use Roots\Acorn\ServiceProvider;
use function Stage\stage_is_feature_active;

class ImagesServiceProvider extends ServiceProvider {


	public $lazy;
	public $gallery;

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot() {
		// Store feature state in variable
		$this->lazy    = stage_is_feature_active( 'lazy' );
		$this->gallery = stage_is_feature_active( 'gallery' );

		/**
		 * Register Image Sizes
		 */
		if ( $this->lazy ) {
			add_image_size( 'low-res', 64, 48, false );
		}

		/**
		 * Filter blocks HTML
		 */
		if ( $this->gallery ) {
			add_filter(
				'render_block',
				function ( $block_content, $block ) {
					return $this->stage_manipulate_blocks_html( $block_content, $block );
				},
				10,
				2
			);
		}

		/**
		 * Filter the_content output for Gutenberg support
		 */
		if ( $this->lazy || $this->gallery ) {
			add_filter(
				'the_content',
				function ( $html ) {
					return $this->stage_manipulate_image_html( $html );
				}
			);
		}
	}

	/**
	 * Add gallery wrappers
	 *
	 * @param $block_content
	 * @param $block
	 *
	 * @return string
	 */
	protected function stage_manipulate_blocks_html( $block_content, $block ) {
		// Fail early
		if ( is_admin() || ! isset( $block['blockName'] ) ) {
			return $block_content;
		}

		// Add a dedicated class to the gallery
		if ( $block['blockName'] === 'core/gallery' && isset( $block['attrs']['linkTo'] ) && $block['attrs']['linkTo'] === 'media' ) {
			$block_content = '<div class="stage-gallery">' . $block_content . '</div>';

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
		if ( $block['blockName'] === 'core/image' && isset( $block['attrs']['linkDestination'] ) && $block['attrs']['linkDestination'] === 'media' ) {
			$block_content = '<div class="stage-gallery">' . $block_content . '</div>';
		}

		return $block_content;
	}

	/**
	 * Manipulates HTML to support lozad.js and PhotoSwipe.js
	 * Change src/srcset to data attributes, and replace img src with its low res version
	 * https://regex101.com/r/65oTIM/1/
	 *
	 * @note This has effect on gutenberg blocks.
	 *
	 * @param string $html HTML which contains images to manipulate.
	 *
	 * @return string|string[]|null
	 */
	protected function stage_manipulate_image_html( $html ) {
		$html = preg_replace_callback(
			'/<(img)(.*?)(src=)\"(.*?)\"(.*?)(srcset=)\"(.*?)\"(.*?)>/i',
			function ( $m ) {

				$out = '';

				if ( $this->gallery ) {
					$m = $this->stage_images_add_gallery_markup( $m );
				}

				if ( $this->lazy ) {
					$m = $this->stage_images_add_lazy_markup( $m );
				}

				$out .= "<$m[1]$m[2]$m[3]$m[4]$m[5]$m[6]\"$m[7]\"$m[8]>";
				$out .= '<noscript>' . $m[0] . '</noscript>';

				return $out;

			},
			$html
		);

		if ( $this->lazy ) {
			$html = $this->stage_add_lazy_class( $html );
		}

		return $html;
	}

	/**
	 * Adjust image markup for lazy loading
	 *
	 * @param $matches
	 *
	 * @return mixed
	 */
	protected function stage_images_add_lazy_markup( $matches ) {

		$placeholder = $this->stage_get_image( $matches[4], null, 'low-res' );

		if ( ! empty( $placeholder ) ) {
			// Replace src attribute
			$matches[2] .= 'src="' . $placeholder[0] . '"';
			$matches[3]  = 'data-src=';

			// Replace srcset with data-srcset
			$matches[6] = 'data-srcset=';
		}

		return $matches;
	}

	/**
	 * Adjust image markup for images
	 *
	 * @param $matches
	 *
	 * @return mixed
	 */
	protected function stage_images_add_gallery_markup( $matches ) {
		$image = $this->stage_get_image( $matches[4], null, 'full' );

		if ( ! empty( $image ) && isset( $image[0] ) && isset( $image[1] ) && isset( $image[2] ) ) {
			$matches[8] .= 'data-full="' . $image[0] . '" data-full-width="' . $image[1] . '" data-full-height="' . $image[2] . '"';
		}

		return $matches;
	}

	/**
	 * Add lazy class to images and iframes
	 *
	 * @param $html
	 *
	 * @return string|string[]|null
	 */
	protected function stage_add_lazy_class( $html ) {
		// Wrap images in a .lazy-wrap div for clean and not blurred borders. Copy image classes to wrapping div.
		// $html = preg_replace( '/(<img|<iframe)(.*?)(src=)\"(.*?)\"(.*?)class=\"(.*?)\"([^>]*>)/i', '<div class="lazy-wrap $6">$1$2data-$3"$4"$5class="$6"$7</div>', $html );

		// Add .lazy class to each image that already has a class.
		$html = preg_replace( '/(<img|<iframe)(.*?)class=\"(.*?)\"(.*?)>/i', '$1$2class="$3 lazy"$4>', $html );

		// Add .lazy class to each image that doesn't already have a class.
		$html = preg_replace( '/(<img|<iframe)((?:(?!class=).)*?)>/i', '$1 class="lazy"$2>', $html );

		return $html;
	}

	/**
	 * Gets image by id with fallback to src
	 *
	 * @param string   $image_url
	 * @param int|null $image_id
	 * @param string   $size
	 *
	 * @return array|false Returns an array (url, width, height, is_intermediate), or false, if no image is available.
	 */
	public function stage_get_image( string $image_url = '', int $image_id = null, string $size = 'low-res' ) {
		$image_id = $image_id ?: attachment_url_to_postid( $image_url );

		return wp_get_attachment_image_src( $image_id, $size );
	}
}
