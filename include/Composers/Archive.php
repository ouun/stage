<?php

namespace Stage\Composers;

use Roots\Acorn\View\Composer;
use function Stage\stage_get_default;
use function Stage\stage_get_fallback;

class Archive extends Composer {

	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = array(
		'index',
		'partials.grids.*',
	);

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
	public function with() {
		$with = array_merge(
			array(
				'layout' => stage_get_fallback( self::get_post_type_archive_config_key( get_post_type() ) . '.layout', false, true ),
			),
			self::combine_display_config()
		);

		return $with;
	}

	/**
	 * Used to auto generate customizer controls from defaults.php
	 *
	 * @return array
	 */
	public static function combine_display_config() {
		$data = array();

		foreach ( self::archives_to_register() as $post_type ) {
			// Fallback if nothing defined for post type
			$configs_key = self::get_post_type_archive_config_key( $post_type->name ) . '.display';
			$configs     = stage_get_default( $configs_key );

			foreach ( $configs as $key => $config ) {
				$data[ 'display_' . $key ] = stage_get_fallback( str_replace( '.', '_', $configs_key . '_' . $key ), $config );
			}
		}

		return $data;
	}

	/**
	 * Helper to get the config key with fallback
	 *
	 * @param string $post_type
	 *
	 * @return mixed|string
	 */
	public static function get_post_type_archive_config_key( $post_type ) {
		$configs_key = 'archive.' . $post_type;
		return ! empty( stage_get_default( $configs_key ) ) ? $configs_key : 'archive.fallback';
	}

	/**
	 * Loop through registered Post Types with archives
	 *
	 * @return \WP_Post_Type[]
	 */
	public static function archives_to_register() {
		$post_types = get_post_types(
			array(
				'public'             => true,
				'publicly_queryable' => true,
				'_builtin'           => true,
			),
			'objects'
		);

		foreach ( $post_types as $post_type ) {
			if ( ! get_post_type_archive_link( $post_type->name ) ) {
				unset( $post_types[ $post_type->name ] );
			}
		}

		return $post_types;
	}
}
