<?php
namespace Stage\Customizer;

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
	 * @return array
	 */
	private static function get_config( $request ) {
		return config( self::$config_namespace . $request );
	}

	/**
	 *  Extract the default value from the
	 *  get_config() array from defaults.php
	 *
	 * @param string $request 'header.layout'
	 * @return string|array
	 */
	public static function get_default( $request ) {
		// Transform underscore requests
		// $request = str_replace( '_', '.', $request );
		$config = self::get_config( $request );

		// Handle string vs. array config
		if ( is_array( $config ) ) {
			// Return an array if requested
			return $config;
		} else {
			// Extract e.g. 'string' from.a.request.string
			$config = self::to_array( $config );
			return end( $config );
		}
	}

	/**
	 * Get setting from the customizer via theme_mod
	 * Supports nested array
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

		// 1st: Check against header.desktop.layout
		$theme_mod = get_theme_mod( (string) implode( '.', $request_array ) );

		// 2nd: Check against header_desktop_layout
		if ( empty( $theme_mod ) ) {
			$theme_mod = get_theme_mod( (string) implode( '_', $request_array ) );
		}

		// 3rd: Check against header_desktop[layout] and otherwise 4th try whatever was given
		if ( empty( $theme_mod ) ) {
			$key       = array_pop( $request_array );
			$theme_mod = get_theme_mod( (string) implode( '_', $request_array ) );
			$theme_mod = isset( $theme_mod[ $key ] ) ? $theme_mod[ $key ] : get_theme_mod( $request, $default );
		}

		return $theme_mod;
	}

	/**
	 * Get value from Customizer with fallback to defaults
	 *
	 * @param $request 'header.desktop.layout'
	 * @param bool|string     $fallback If no default available
	 *
	 * @return mixed|string
	 */
	public static function get_fallback( $request, $fallback = false ) {
		$default = self::get_default( $request );
		$custom  = self::get_chosen( $request, empty( $default ) ? $fallback : $default );

		return ! empty( $custom ) ? $custom : $default;
	}

	/**
	 * Get user chosen template path from Customizer
	 * With fallback to default in /config/defaults.php
	 * e.g. for:
	 * stage_get_fallback_template( $request, $data = array() );
	 *
	 * @param $request
	 * @return string path to template file
	 */
	public static function get_fallback_template_path( $request ) {
		$fallback = self::get_fallback( $request );
		$config   = self::to_array( self::get_config( $request ) );
		$default  = array_pop( $config );

		// Get path from default $config, view is removed via array_pop before
		$path = implode( '.', $config );

		// Set view from fallback
		$view = ! empty( $fallback ) ? $fallback : $default;

		// Does the file exist -> return path
		return view()->exists( "{$path}.{$view}" ) ? "{$path}.{$view}" : '';
	}

}
