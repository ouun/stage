<?php

namespace Stage;

/**
 * Add classes to archives
 *
 * @return array
 */
add_filter(
	'body_class',
	function( $classes ) {
		// Stage defaults classes
		$classes = array_merge( [
			'app',
			'stage',
			'flex',
			'flex-col',
			'min-h-full',
			'antialiased',
			'bg-body'
		], $classes );

		// Used by customizer partial refresh for archives
		if ( is_post_type_archive() || is_home() ) {
			$classes[] = 'archive';
			$classes[] = get_post_type() . '-archive';
		}

		// Post Thumbnail
		if ( is_singular() && !is_front_page() && !is_home() && has_post_thumbnail() ) {
			$classes[] = 'featured-image';
		}

		return apply_filters( 'stage_body_classes', $classes );
	}
);

/**
 * Filter allowed mime types upload
 */
add_filter(
	'upload_mimes',
	function ( $mimes ) {

		// Images
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';

		// Adds Filter to customize mime types
		return apply_filters( 'stage_upload_mimes', $mimes );

	},
	1,
	1
);

/**
 * Add features state to 'stage' object accessible from JS
 */
add_filter(
	'stage_localize_script',
	function () {
		return array(
			'features' => stage_get_features_status(),
		);
	}
);

/**
 * Add "… Continued" to the excerpt
 *
 * @return string
 */
add_filter(
	'excerpt_more',
	function () {
		return ' &hellip; <a href="' . get_permalink() . '">' . __( 'Continued', 'stage' ) . '</a>';
	}
);

/**
 * Remove WordPress.org from Meta Widget
 */
add_filter( 'widget_meta_poweredby', '__return_empty_string' );

/**
 * Remove WP logo from Admin Toolbar
 */
add_action( 'admin_bar_menu', function ( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
	$wp_admin_bar->remove_node( 'search' );
}, 999 );

/**
 * Modify oEmbed URL parameters.
 * todo: This is not yet production tested
 */
add_filter(
	'embed_oembed_html',
	function ( $cache, $url, $attr, $post_id ) {
		preg_match( '/src="([^"]*)"/i', $cache, $sources );
		if ( ! empty( $sources ) ) {
			$src = $sources[1];
		}
		if ( ! empty( $src ) && ! empty( $url ) ) {
			$is_youtube = strpos( $src, 'youtube' ) !== false;
			$is_vimeo   = strpos( $src, 'vimeo' ) !== false;
			if ( $is_youtube ) {
				// @see https://developers.google.com/youtube/player_parameters#Parameters
				$args = array(
					'rel'            => 0,
					'modestbranding' => 1,
				);
			} elseif ( $is_vimeo ) {
				$args = array(
					'title'          => 0,
					'byline'         => 0,
					'portrait'       => 0,
					'controls'       => 0,
					'iv_load_policy' => 3,
				);
			}
			if ( ! empty( $args ) && ( $parts = parse_url( $src ) ) ) {
				$query = ! empty( $parts['query'] ) ? wp_parse_args( $parts['query'] ) : array();
				// Override URL attributes with shortcode ones.
				$query = array_merge( $query, $attr );
				// Add in defaults unless they are already defined.
				$query = array_merge( $args, $query );
				// Force /embed endpoint for youtube.
				if ( $is_youtube && $parts['path'] == '/watch' ) {
					$parts['path'] = '/embed/' . $query['v'];
					unset( $query['v'] );
				}
				if ( $is_vimeo && is_numeric( substr( $parts['path'], 1 ) ) ) {
					$parts['host'] = 'player.vimeo.com';
					$parts['path'] = "/video{$parts['path']}";
				}
				// Use schemeless URL and re-build the query.
				$parts['scheme'] = null;
				$parts['query']  = build_query( $query );
				// Rebuild the URL
				$url   = build_url( $parts );
				$cache = str_replace( $src, $url, $cache );
			}
		}
		return $cache;
	},
	10,
	4
);
