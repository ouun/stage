<?php

/**
 * Theme helpers.
 *
 * @copyright https://ouun.io/ ouun
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace Stage;

use Stage\Customizer\Settings;
use Stage\Providers\TailwindServiceProvider;
use Throwable;

use function Roots\view;

/**
 * Helper function for debugging
 *
 * @param $dump
 */
function stage_dump($dump)
{
    if (is_array($dump) || is_object($dump)) {
        $message = '<pre>' . print_r($dump) . '</pre>';
    } else {
        $message = $dump;
    }

    wp_die($message);
}

/**
 * Helper function to access Stage config variables via
 * workaround until Laravel allows config access between apps
 * todo: Move & separate this to child theme: 1. Set config on load, add helper to get parent config
 *
 * @param null $key
 * @param null $default
 *
 * @return mixed|\Roots\Acorn\Config
 */
function stage_config($key = null, $default = null)
{
    // Requested config file
    $config = explode('.', $key)[0];
    $file   = get_template_directory() . '/config' . '/' . $config . '.php';

    if (file_exists($file)) {
        // Get Stage defaults config
        $stage['config'] = include $file;

        // Set as new config "Stage"
        \Roots\config(array( "stage.{$config}" => $stage['config'] ));

        // Return the config
        return \Roots\config("stage.{$key}", $default);
    }

    return \Roots\config($key, $default);
}

/**
 * Collect data for 'stage' JS object via 'stage_localize_script' filter
 *
 * @return array
 */
function stage_build_js_object()
{
    return array_merge(
        apply_filters('stage_localize_script', array()),
        array(
            'ajax'    => array(
                'url' => admin_url('admin-ajax.php'),
            ),
            'screens' => stage_get_default('global.screens'),
            'user'    => array(
                'is_admin'     => is_user_admin(),
                'is_logged_in' => is_user_logged_in(),
            ),
            'wp'      => array(
                'adminbar_visible' => is_admin_bar_showing(),
            ),
        )
    );
}

/**
 * Checks for active state of WooCommerce
 *
 * @return bool
 */
function stage_is_shop_active()
{
    return (bool) defined('WC_ABSPATH');
}

/**
 * Gets the statuses of each feature listed in defaults.php
 *
 * @return object Each feature and its state
 */
function stage_get_features_status()
{
    $features = stage_get_default('features');
    $status   = array();

    foreach ($features as $feature => $settings) {
        $status[ $feature ] = stage_is_feature_active($feature);
    }

    return (object) $status;
}

/**
 * Checks the activation status of a given Stage feature
 * todo: Edit after this is fixed: https://github.com/kirki-framework/control-checkbox/issues/3
 *
 * @param $feature
 *
 * @return bool
 */
function stage_is_feature_active($feature)
{
    $status = stage_get_fallback('features' . '.' . $feature . '.' . 'activate');
    // todo: Replace this when value is true/false instead of true or '1'

    return ( '0' !== $status || 'false' !== $status || $status == true ) ? (bool) $status : false;
}

/**
 * Render & process the fallback template file
 * from Settings::get_fallback_template_path()
 *
 * @param $chosen_key string
 * @param null              $default_key
 * @param $data array
 *
 * @return string Rendered template
 * @throws Throwable
 */
function stage_get_fallback_template($chosen_key, $default_key = null, $data = array())
{
    // Does the file exist -> return
    $path = Settings::getFallbackTemplatePath($chosen_key, $default_key);
    return stage_render_template($path, $data);
}

/**
 * Render view and overwrite $data
 *
 * @param $path
 * @param $data
 *
 * @return array|string
 * @throws Throwable
 */
function stage_render_template($path, $data)
{
    return view($path, view($path)->getData(), $data)->render();
}

/**
 * Helper to get customizer setting value
 * with fallback to defaults
 *
 * @param $request
 * @param bool|string $fallback If no default available
 *
 * @param bool        $pop
 *
 * @return mixed|string
 */
function stage_get_fallback($request, $fallback = false, $pop = false)
{
    return Settings::getFallback($request, $fallback, $pop);
}

/**
 * Helper to get customizer setting value
 * with fallback to defaults
 *
 * @param $request
 * @param bool    $pop
 *
 * @return mixed|string
 */
function stage_get_default($request, $pop = false)
{
    return Settings::getDefault($request, $pop);
}

/**
 * Customized do_action() for usage in blade
 *
 * @param string $action
 * @param string $arg
 * @return string
 */
function stage_do_action($action, $arg = '')
{
    // If action starts with "_" we request a WooCommerce action
    $action = mb_substr($action, 0, 4) === 'get_' ? str_replace('get', 'woocommerce', $action) : $action;
    return do_action($action, $arg);
}


/**
 * Get a list of all post types that the user might care about.
 */
function post_types()
{
      $collection = collect(get_post_types(array( '_builtin' => false ), 'objects'))
        ->pluck('label', 'name')
        ->except(array( 'acf-field', 'acf-field-group', 'wp_stream_alerts', 'wp_area' ))
        ->prepend(get_post_type_object('page')->labels->name, 'page')
        ->prepend(get_post_type_object('post')->labels->name, 'post')
        ->all();

      return $collection;
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
function build_url($parts)
{
    return ( isset($parts['scheme']) ? "{$parts['scheme']}:" : '' ) .
           ( ( isset($parts['user']) || isset($parts['host']) ) ? '//' : '' ) .
           ( isset($parts['user']) ? "{$parts['user']}" : '' ) .
           ( isset($parts['pass']) ? ":{$parts['pass']}" : '' ) .
           ( isset($parts['user']) ? '@' : '' ) .
           ( isset($parts['host']) ? "{$parts['host']}" : '' ) .
           ( isset($parts['port']) ? ":{$parts['port']}" : '' ) .
           ( isset($parts['path']) ? "{$parts['path']}" : '' ) .
           ( isset($parts['query']) ? "?{$parts['query']}" : '' ) .
           ( isset($parts['fragment']) ? "#{$parts['fragment']}" : '' );
}
