<?php

namespace Stage;

use function Roots\asset;

/**
 * Theme assets
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('stage/vendor.js', asset('scripts/vendor.js', 'parent')->uri(), ['jquery'], null, true);
    wp_enqueue_script('stage/app.js', asset('scripts/app.js', 'parent')->uri(), ['stage/vendor.js', 'jquery'], null, true);

    wp_add_inline_script('stage/vendor.js', asset('scripts/manifest.js', 'parent')->contents(), 'before');

	// Collect data for 'stage' JS object via 'stage_localize_script' filter
	wp_localize_script( 'stage/app.js', 'stage', apply_filters( 'stage_localize_script', [
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
	] ) );

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    $styles = ['styles/app.css'];

    foreach ($styles as $stylesheet) {
        if (asset($stylesheet)->exists()) {
            wp_enqueue_style('stage/' . basename($stylesheet, '.css'), asset($stylesheet, 'parent')->uri(), false, null);
        }
    }
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

	/**
	 * Load Theme tranlsation
	 * @link https://developer.wordpress.org/reference/functions/load_theme_textdomain/
	 */
	load_theme_textdomain('stage', asset('languages')->path() );

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'stage'),
        'footer_navigation' => __('Footer Navigation', 'stage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Enable custom logo file in Customizer
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'     => 25,
			'width'      => 100,
			'flex-width' => true,
			'flex-height' => true,
			// 'header-text' => array( 'brand' ),
		)
	);

	/**
     * Use main stylesheet for visual editor
     */
    add_editor_style( asset('styles/app.css')->uri() );
}, 20);

/**
 * Register sidebars
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ];

    register_sidebar([
        'name' => __('Primary', 'stage'),
        'id' => 'sidebar-primary'
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'stage'),
        'id' => 'sidebar-footer'
    ] + $config);
});
