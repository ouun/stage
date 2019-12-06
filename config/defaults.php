<?php
/**
 * This file contains the defaults used by Stage
 * Overwrite them here or via the Customizer settings
 */

return [

	/*
	|--------------------------------------------------------------------------
	| The theme defaults
	|--------------------------------------------------------------------------
	|
	| Sets the defaults for all settings in the Customizer
	| Used throughout the whole theme by using stage_get_default()
	|
	*/

	/**
	 * Stage Features
	 */
	'features' => [
		'lazy' => [
			'activate' => false,
		],
		'loader' => [
			'activate' => false,
		],
		'infinity' => [
			'activate' => false,
		],
		'gallery' => [
			'activate' => false,
		],
	],

	/**
	 * Global style defaults
	 */
	'global' => [
		// All colors are registered as wp-blocks colors.
		'colors' => [
			'main'     => [
				'body'     => 'rgb(249, 249, 249)',
				'copy'     => 'rgb(0, 0, 0)',
				'heading'     => 'rgb(0, 0, 0)',
				'primary'       => 'rgb(43, 108, 176)',
				'secondary'     => 'rgb(221, 107, 32)',
			],
			'links'    => [
				'link'  => '',
				'hover' => '',
			],
			'copy'     => '#222',
			'gray-200' => 'var(--color-gray-200)',
			'gray-800' => 'var(--color-gray-800)',
		],

		// All font sizes are registered as wp-blocks font-sizes.
		'typo'   => [
			'heading' => [
				'fonts' => [
					'font-family' => 'Constantia, Lucida Bright, Lucidabright, Lucida Serif, Lucida, DejaVu Serif, Bitstream Vera Serif, Liberation Serif, Georgia, serif',
					'font-weight' => 'regular',
				],
			],
			'copy'    => [
				'fonts' => [
					'font-family' => 'system-ui, BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif',
					'font-weight' => 'regular',
				],
			],
			'choices' => [
				'fonts' => [
					'google'   => [ 'popularity', 100 ],
				],
			],
			'sizes'   => [
				'xs'   => [
					'value' => 'var(--font-size-xs)',
					'name'  => __( 'Extra Small', 'stage' ),
					'px'    => '12',
				],
				'sm'   => [
					'value' => 'var(--font-size-sm)',
					'name'  => __( 'Small', 'stage' ),
					'px'    => '14',
				],
				'base' => [
					'value' => 'var(--font-size-base)',
					'name'  => __( 'Normal', 'stage' ),
					'px'    => '16',
				],
				'lg'   => [
					'value' => 'var(--font-size-lg)',
					'name'  => __( 'Large', 'stage' ),
					'px'    => '18',
				],
				'xl'   => [
					'value' => 'var(--font-size-xl)',
					'name'  => __( 'Extra Large', 'stage' ),
					'px'    => '20',
				],
				'2xl'  => [
					'value' => 'var(--font-size-2xl)',
					'name'  => __( 'XX Large', 'stage' ),
					'px'    => '24',
				],
				'3xl'  => [
					'value' => 'var(--font-size-3xl)',
					'name'  => __( '3X Large', 'stage' ),
					'px'    => '30',
				],
				'4xl'  => [
					'value' => 'var(--font-size-4xl)',
					'name'  => __( '4X Large', 'stage' ),
					'px'    => '36',
				],
				'5xl'  => [
					'value' => 'var(--font-size-5xl)',
					'name'  => __( '5X Large', 'stage' ),
					'px'    => '48',
				],
			],
		],
	],

	/**
	 * Layout settings
	 */
	'header' => [
		'branding' => [
			'show_tagline' => false,
		],
		'colors'  => [
			'overwrite' => false,
		],
		'typo'    => [
			'overwrite' => false,
		],
		'mobile'  => [
			'position' => 'sticky',
			'layout'   => 'partials.header.off-canvas', // Template path.
		],
		'desktop' => [
			'position'  => 'sticky',
			'layout'    => 'partials.header.horizontal-left', // Template path.
			'fullwidth' => false,
			'open'      => 'click-open', // click-open or hover-open sub-menu.
			'padding-x' => '0',
			'padding-y' => '4',
		],
		'search' => [
			'layout' => 'partials.header.search.fullscreen'
		],
	],

	/**
	 * Archives Settings
	 * Allows overwriting CPTs
	 */
	'archive' => [
		'post' => [
			'layout' => 'partials.grids.modern',
			'display' => [
				'sidebar' => false,
				'thumbnail' => true,
				'placeholder' => false,
				'headline' => true,
				'meta' => false,
				'excerpt' => true,
				'tags' => false,
			],
		],
		'fallback' => [
			'layout' => 'partials.grids.masonry',
			'display' => [
				'sidebar' => true,
				'thumbnail' => true,
				'placeholder' => false,
				'headline' => true,
				'meta' => false,
				'excerpt' => true,
				'tags' => false,
			],
		],
	],

	/**
	 * Footer Settings
	 */
	'footer' => [
		'settings' => [
			esc_html__( 'Copyright %1$s, all rights reserved by %2$s.', 'stage' ), date("Y"), get_bloginfo( 'name', 'display' )
		]
	]
];
