<?php

/**
 * Theme filters.
 *
 * @copyright https://ouun.io/ ouun
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace Stage;

/**
 * Add classes to archives
 *
 * @return array
 */
add_filter(
    'body_class',
    function ($classes) {
        // Stage Framework Classes, critical for JS
        $classes[] = 'app';
        $classes[] = 'stage';

        // Config classes
        $classes = array_merge(
            (array) stage_get_default('body.classes'),
            $classes
        );

        // Used by customizer partial refresh for archives
        if (is_post_type_archive() || is_home()) {
            $classes[] = 'archive';
            $classes[] = get_post_type() . '-archive';
        }

        // Post Thumbnail
        if (is_singular() && ! is_front_page() && ! is_home() && has_post_thumbnail()) {
            $classes[] = 'featured-image';
        }

        return apply_filters('stage_body_classes', $classes);
    }
);

/**
 * Filter allowed mime types upload
 */
add_filter(
    'upload_mimes',
    function ($mimes) {

        // Images
        $mimes['svg'] = 'image/svg+xml';

        // Adds Filter to customize mime types
        return apply_filters('stage_upload_mimes', $mimes);
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
        return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'stage') . '</a>';
    }
);

/**
 * Remove WordPress.org from Meta Widget
 */
add_filter('widget_meta_poweredby', '__return_empty_string');

/**
 * Remove WP logo from Admin Toolbar
 */
add_action(
    'admin_bar_menu',
    function ($wp_admin_bar) {
        $wp_admin_bar->remove_node('wp-logo');
        $wp_admin_bar->remove_node('search');
    },
    999
);
