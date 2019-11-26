<?php

namespace Stage;

use Stage\Customizer\Settings;
use function Roots\view;

/**
 * Gets the statuses of each feature listed in defaults.php
 *
 * @return object Each feature and its state
 */
function stage_get_features_status() {
	$features = stage_get_default('features' );
	$status = [];

	foreach ( $features as $feature => $settings ) {
		$status[ $feature ] = stage_is_feature_active( $feature );
	}

	return (object) $status;
}

/**
 * Checks the activation status of a given Stage feature
 *
 * @param $feature
 *
 * @return bool
 */
function stage_is_feature_active( $feature ) {
	$status = stage_get_fallback( 'features' . '.' . $feature . '.' . 'activate' );
	return ( ( isset( $status ) && true == $status ) ? true : false );
}

/**
 * Render & process the fallback template file
 * from Settings::get_fallback_template_path()
 *
 * @param $request string
 * @param $data array
 *
 * @return string Rendered template
 * @throws \Throwable
 */
function stage_get_fallback_template( $request, $data = [] ) {
	// Does the file exist -> return
	$path = Settings::get_fallback_template_path( $request );
	return view( $path, view( $path )->getData(), $data )->render();
}

/**
 * Helper to get customizer setting value
 * with fallback to defaults
 *
 * @param $request
 * @param bool|string $fallback If no default available
 *
 * @return mixed|string
 */
function stage_get_fallback( $request, $fallback = false ) {
	return Settings::get_fallback( $request, $fallback );
}

/**
 * Helper to get customizer setting value
 * with fallback to defaults
 *
 * @param $request
 * @return mixed|string
 */
function stage_get_default( $request ) {
	return Settings::get_default( $request );
}

/**
 * Get a list of all post types that the user might care about.
 */
function post_types() {
	return collect( get_post_types( [ '_builtin' => false ], 'objects' ) )
		->pluck( 'label', 'name' )
		->except( [ 'acf-field', 'acf-field-group', 'wp_stream_alerts' ] )
		->prepend( get_post_type_object( 'page' )->labels->name, 'page' )
		->prepend( get_post_type_object( 'post' )->labels->name, 'post' )
		->all();
}

/**
 * Build a URL string based on URL parts.
 *
 * @see https://stackoverflow.com/a/35207936/319855
 *
 * @param array $parts Parts of the URL as returned by `parse_url`
 *
 * @return string
 */
function build_url( $parts ) {
	return ( isset( $parts['scheme'] ) ? "{$parts['scheme']}:" : '' ) .
		   ( ( isset( $parts['user'] ) || isset( $parts['host'] ) ) ? '//' : '' ) .
		   ( isset( $parts['user'] ) ? "{$parts['user']}" : '' ) .
		   ( isset( $parts['pass'] ) ? ":{$parts['pass']}" : '' ) .
		   ( isset( $parts['user'] ) ? '@' : '' ) .
		   ( isset( $parts['host'] ) ? "{$parts['host']}" : '' ) .
		   ( isset( $parts['port'] ) ? ":{$parts['port']}" : '' ) .
		   ( isset( $parts['path'] ) ? "{$parts['path']}" : '' ) .
		   ( isset( $parts['query'] ) ? "?{$parts['query']}" : '' ) .
		   ( isset( $parts['fragment'] ) ? "#{$parts['fragment']}" : '' );
}
