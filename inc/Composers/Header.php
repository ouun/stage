<?php

namespace Stage\Composers;

use Roots\Acorn\View\Composer;
use function Stage\stage_get_fallback;

class Header extends Composer {

	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = [
		'partials.header',
	];

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
	public function with() {
		return [
			'logo'         => get_custom_logo(),
			'site_name'    => get_bloginfo( 'name' ),
			'site_tagline' => get_bloginfo( 'description' ),
			'show_tagline' => stage_get_fallback( 'header.branding.show_tagline' ),
			'home_url'     => esc_url( home_url( '/' ) ),
			'desktop'      => [
				'layout'    => stage_get_fallback( 'header.desktop.layout' ),
				'position'  => stage_get_fallback( 'header.desktop.position' ), // fixed, sticky, relative, ...
				'fullwidth' => stage_get_fallback( 'header.desktop.fullwidth' ) ? 'fullwidth' : 'boxed',
				'padding-x' => 'sm:px-' . stage_get_fallback( 'header.desktop.padding-x' ),
				'padding-y' => 'sm:py-' . stage_get_fallback( 'header.desktop.padding-y' ),
			],
			'mobile'       => [
				'layout'   => stage_get_fallback( 'header.mobile.layout' ), // fixed, sticky, relative, ...
				'position' => stage_get_fallback( 'header.mobile.position' ),
			],
			'search'    => [
				'layout' => stage_get_fallback( 'header.search.layout' ),
			],
		];
	}
}
