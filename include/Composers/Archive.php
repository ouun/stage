<?php

namespace Stage\Composers;

use Roots\Acorn\View\Composer;
use function Stage\post_types;
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
		return wp_parse_args(
			self::get_archive_display_config(),
			array(
				'layout' => stage_get_fallback( self::get_post_type_archive_config_key( get_post_type() ) . '.layout', false, true ),
			)
		);
	}

	/**
	 * Get current archive combined display configs
	 *
	 * @param null $post_type
	 *
	 * @return array
	 */
	public static function get_archive_display_config( $post_type = null ) {
		$data = array();

		$post_type = $post_type ? $post_type : get_post_type();

		$configs_key = self::get_post_type_archive_config_key( $post_type ) . '.display';
		$configs     = stage_get_default( $configs_key );

		foreach ( $configs as $key => $config ) {
			$data[ 'display_' . $key ] = stage_get_fallback( 'archive.' . $post_type . '.display' . '.' . $key, $config );
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
		$post_types = post_types();
		foreach ( $post_types as $name => $label ) {
			if ( ! get_post_type_archive_link( $name ) ) {
				unset( $post_types[ $name ] );
			}
		}

		return $post_types;
	}
}
