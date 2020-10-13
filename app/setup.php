<?php

/**
 * Theme setup.
 *
 * @copyright https://ouun.io/ ouun
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace Stage;

use function Roots\asset;

add_action(
    'wp_enqueue_scripts',
    function () {
        wp_enqueue_script(
            'stage/app.js',
            asset('scripts/app.js', 'stage')->uri(),
            array( 'jquery' ),
            null,
            true
        );

        // Collect data for 'stage' JS object via 'stage_localize_script' filter
        wp_localize_script('stage/app.js', 'stage', stage_build_js_object());

        if (is_single() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        wp_enqueue_style('stage/app.css', asset('styles/stage.css', 'stage')->uri(), false, null);

        if (stage_is_shop_active()) {
            wp_enqueue_style('stage/shop.css', asset('styles/shop.css', 'stage')->uri(), false, null);
        }
    },
    99
);

/**
 * Theme setup
 */
add_action(
    'after_setup_theme',
    function () {
        /**
         * Enable features from Soil when plugin is activated
         *
         * @link https://roots.io/plugins/soil/
         */
        add_theme_support('soil', array( 'clean-up', 'nav-walker', 'nice-search', 'relative-urls' ));

        /**
         * Load Theme translation
         *
         * @link https://developer.wordpress.org/reference/functions/load_theme_textdomain/
         */
        load_theme_textdomain('stage', asset('languages', 'stage')->path());

        /**
         * Enable plugins to manage the document title
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
         */
        add_theme_support('title-tag');

        /**
         * Register navigation menus
         *
         * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
         */
        register_nav_menus(
            array(
                'primary_navigation' => __('Primary Navigation', 'stage'),
                'footer_navigation'  => __('Footer Navigation', 'stage'),
            )
        );

        /**
         * Enable post thumbnails
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        /**
         * Enable HTML5 markup support
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
         */
        add_theme_support('html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form', 'script', 'style' ));

        /**
         * Enable selective refresh for widgets in customizer
         *
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
                'height'      => 25,
                'width'       => 100,
                'flex-width'  => true,
                'flex-height' => true,
                // 'header-text' => array( 'brand' ),
            )
        );

        /**
         * Use main stylesheet for visual editor
         */
        add_editor_style(asset('styles/app.css', 'stage')->uri());

        /**
         * Remove admin-bar spacing
         */
        add_theme_support('admin-bar', array( 'callback' => '__return_false' ));
    },
    20
);

/**
 * Register sidebars
 * Register the theme sidebars.
 *
 * @return void
 */
add_action(
    'widgets_init',
    function () {
        $config = array(
            'before_widget' => '<section class="widget p-4 %1$s %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        );

        register_sidebar(
            array(
                'id'   => 'sidebar-primary',
                'name' => __('Primary', 'stage'),
            ) + $config
        );

        register_sidebar(
            array(
                'id'   => 'sidebar-footer',
                'name' => __('Footer', 'stage'),
            ) + $config
        );
    }
);
