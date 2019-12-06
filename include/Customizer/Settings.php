<?php
namespace Stage\Customizer;

use Roots\Acorn\Application;
use function Roots\config;
use function Roots\view;

class Settings {

	// Namespace where to find defaults via config()
	static $config_namespace = 'defaults.';

	/**
	 * Helper function to handle 'foo.bar' or 'foo_bar' strings as array
	 *
	 * @param $request
	 * @return array
	 */
	public static function to_array( $request ) {
		return explode( '.', str_replace( '_', '.', $request ) );
	}

	/**
	 * Get config value from /app/config/defaults.php
	 *
	 * @param string $request 'header.layout'
	 *
	 * @return array
	 */
	public static function get_config( $request ) {
		return config( self::$config_namespace . $request );
	}

	/**
	 *  Extract the default value from the
	 *  get_config() array from defaults.php
	 *
	 * @param string $request 'header.layout'
	 * @param bool   $pop Set true if you need last part only
	 *
	 * @return string|array
	 */
	public static function get_default( $request, $pop = false ) {
		// Transform underscore requests
		// $request = str_replace( '_', '.', $request );
		$config = self::get_config( $request );

		if ( $pop ) {
			// Pop e.g. 'string' from.a.request.string
			$config = self::to_array( $config );
			return end( $config );
		} else {
			// Return an array if requested
			return $config;
		}
	}

	/**
	 * Get setting from the customizer via theme_mod
	 * Supports nested array
	 * todo: Simplify this via common naming convention
	 *
	 * @param $request 'header.desktop.layout'
	 * @param $default
	 * @return string
	 */
	public static function get_chosen( $request, $default = '' ) {
		// This can either be stored as mix of 'global_colors' and 'global_colors[secondary]'
		// Check against both to go sure that we get the value

		// e.g. 'header.desktop.layout' to array => [0] header, [1] desktop, [2] layout
		$request_array = self::to_array( $request );

		// 1st: Check against header.desktop.layout as option or theme_mod
		$theme_mod = self::stage_get_theme_mod( (string) implode( '.', $request_array ) );
		$theme_mod = empty( $theme_mod ) ? self::stage_get_theme_option( (string) implode( '.', $request_array ) ) : $theme_mod;

		// 2nd: Check against header_desktop_layout
		if ( empty( $theme_mod ) ) {
			$theme_mod = self::stage_get_theme_mod( (string) implode( '_', $request_array ) );
		}

		// 3rd: Check against header_desktop[layout] and otherwise 4th try whatever was given
		if ( empty( $theme_mod ) ) {
			$key       = array_pop( $request_array );
			$theme_mod = isset( $theme_mod[ $key ] ) ? $theme_mod[ $key ] : self::stage_get_theme_mod( $request, $default );
		}

		return $theme_mod;
	}

	/**
	 * Get value for a option from the 'stage_options' table
	 *
	 * @param $name
	 * @param bool $default
	 *
	 * @return mixed|void|null
	 */
	public static function stage_get_theme_option( $name, $default = false ) {
		$options = get_option( 'stage_options' );

		if ( isset( $options[ $name ] ) ) {
			return apply_filters( "stage_option_{$name}", $options[ $name ] );
		}

		return apply_filters( "stage_option_{$name}", $default );
	}

	/**
	 * Get and filter value from the theme_mods table
	 *
	 * @param $name
	 * @param bool $default
	 *
	 * @return mixed|void|null
	 */
	public static function stage_get_theme_mod( $name, $default = false ) {
		$theme_mod = get_theme_mod( $name );

		if ( ! empty( $theme_mod ) ) {
			return apply_filters( "stage_option_{$name}", $theme_mod );
		}

		return apply_filters( "stage_option_{$name}", $default );
	}

	/**
	 * Get value from Customizer with fallback to defaults
	 *
	 * @param $request 'header.desktop.layout'
	 * @param bool|string     $fallback If no default available
	 *
	 * @param bool            $pop Set true if you need last part only
	 *
	 * @return mixed|string
	 */
	public static function get_fallback( $request, $fallback = false, $pop = false ) {

		$default = self::get_default( $request, $pop );

		return self::get_chosen( $request, empty( $default ) ? $fallback : $default );
	}

	/**
	 * Get user chosen template path from Customizer
	 * With fallback to default in /config/defaults.php
	 * e.g. for:
	 * stage_get_fallback_template( $request, $data = array() );
	 *
	 * @param string $request Key to look at in theme_mod() & option() 'archive.cpt.layout'
	 *
	 * @param null $default_key Key to look at in config()
	 *
	 * @return string path to template file
	 */
	public static function get_fallback_template_path( $request, $default_key = null ) {
		// Get the chosen layout e.g. "masonry"
		$fallback = self::get_fallback( $request, false, true );
		// Get path & default layout (e.g. "partials.grids.modern")
		$config  = self::to_array( self::get_config( $default_key ?: $request ) );
		$default = array_pop( $config );

		// Get path from default $config, view is removed via array_pop before
		$path = implode( '.', $config );

		// Set view from fallback
		$view = ! empty( $fallback ) ? $fallback : $default;

		// Does the file exist -> return path
		return view()->exists( "{$path}.{$view}" ) ? "{$path}.{$view}" : '';
	}

}
