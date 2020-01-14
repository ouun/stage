<?php

namespace Stage\Providers;

use Roots\Acorn\ServiceProvider;

use function Roots\asset;
use function Stage\stage_get_default;
use function Stage\stage_get_fallback;

class BlockEditorServiceProvider extends ServiceProvider {

	/**
	 * Boot Gutenberg application services.
	 *
	 * @return void
	 */
	public function boot() {
		// Register Gutenberg Customization
		if ( self::isBlockEditorActive() ) {
			$this->addBlockEditorSupport();
		}
	}

	/**
	 * Returns Blocks Editor active state
	 *
	 * @return bool
	 */
	public static function isBlockEditorActive() {
		return class_exists( 'WP_Block_Type_Registry' );
	}

	/**
	 * Register color palette for Blocks Editor
	 *
	 * @return array
	 */
	private static function registerColorPalette() {
		// Merge more color pallets if required
		$register = array();
		$palettes = array(
			'global.colors',
			'global.colors.main',
		);

		foreach ( $palettes as $palette ) {
			$colors = stage_get_default( $palette );

			foreach ( $colors as $id => $color ) {
				if ( ! is_array( $color ) ) {
					$color = self::registerColor( $id, $palette );

					// Add color title if color already registered
					if ( isset( $register[ $color['color'] ] ) ) {
						$color['name'] = $register[ $color['color'] ]['name'] . ', ' . $color['name'];
					}

					$register[ $color['color'] ] = $color;
				}
			}
		}

		return $register;
	}

	/**
	 * Register aa single color
	 *
	 * @param $color
	 * @param string $config
	 *
	 * @return array
	 */
	private static function registerColor( $color, $config = '' ) {
		$config = empty( $config ) ?: $config . '.';
		return array(
			'name'  => ucfirst( __( $color, 'stage' ) ),
			'slug'  => $color,
			'color' => stage_get_fallback( $config . $color ),
		);
	}

	/**
	 * Registers font sizes
	 *
	 * @return array
	 */
	private static function registerFontSizes() {
		$register = array();

		foreach ( stage_get_default( 'global.typo.sizes' ) as $slug => $size ) {
			$register[] = array(
				'name'      => __( $size['name'], 'stage' ),
				'shortName' => __( strtoupper( $slug ), 'stage' ),
				'size'      => intval( $size['px'] ),
				'slug'      => $slug,
			);
		}

		return $register;
	}


	public function addBlockEditorSupport() {
		/**
		 * Default block styles on frontend
		 *
		 * Core blocks include default styles. The styles are enqueued for editing but are not enqueued
		 * for viewing unless the theme opts-in to the core styles. If you’d like to use default styles
		 * in your theme, add theme support for wp-block-styles:
		 *
		 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#default-block-styles
		 */
		// add_theme_support( 'wp-block-styles' );

		/**
		 * Add wrapper element to blocks with the "full" or "wide" attribute
		 *
		 * @link https://developer.wordpress.org/reference/functions/render_block/
		 */
		/*
		add_filter(
			'render_block',
			function ( $block_content, $block ) {
				// Only on the frontend and only for blocks that have an alignment.
				if ( is_admin() || ! isset( $block['attrs']['align'] ) ) {
					return $block_content;
				}

				if ( $block['attrs']['align'] === 'wide' ) {
					return $block_content = '<div class="block-wrap wp-block-wide-wrap">' . $block_content . '</div>';
				} elseif ( $block['attrs']['align'] == 'full' ) {
					return $block_content = '<div class="block-wrap wp-block-full-wrap">' . $block_content . '</div>';
				}

				return $block_content;
			},
			10,
			2
		);

		/**
		 * Register the theme assets with the block editor.
		 *
		 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#add-the-stylesheet
		 *
		 * @return void
		 */
		add_action(
			'enqueue_block_editor_assets',
			function () {
				if ( $manifest = asset( 'scripts/editor.asset.php' )->get() ) {
					wp_enqueue_script(
						'stage/editor.js',
						asset( 'scripts/editor.js' )->uri(),
						$manifest['dependencies'],
						$manifest['version']
					);

					wp_add_inline_script(
						'stage/editor.js',
						asset( 'scripts/manifest.js', 'stage' )->contents(),
						'before'
					);
				}

				wp_enqueue_style(
					'stage/editor.css',
					asset( 'styles/blocks/blocks-editor.css', 'stage' )->uri(),
					false,
					null
				);
			},
			100
		);

		/**
		 * Load blocks styles for frontend & backend
		 */
		add_action(
			'enqueue_block_assets',
			function () {
				wp_enqueue_style( 'stage/blocks.css', asset( 'styles/blocks/blocks.css', 'stage' )->uri(), false, null );
			}
		);

		/**
		 * Add support for Gutenberg wide images.
		 *
		 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#wide-alignment
		 */
		add_theme_support( 'align-wide' );

		/**
		 * Enable responsive embeds
		 *
		 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
		 */
		add_theme_support( 'responsive-embeds' );

		/**
		 * Custom Theme Block Color Palettes
		 *
		 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
		 */
		add_theme_support( 'editor-color-palette', self::registerColorPalette() );

		/**
		 * Block Font Sizes
		 *
		 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
		 */
		add_theme_support( 'editor-font-sizes', self::registerFontSizes() );
		// add_theme_support('disable-custom-font-sizes');

		/**
		 * Add editor styles
		 *
		 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#editor-styles
		 */
		add_theme_support( 'editor-styles' );
	}
}
