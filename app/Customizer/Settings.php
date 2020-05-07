<?php

namespace Stage\Customizer;

use Roots\Acorn\Application;

use function Roots\config;
use function Roots\view;

class Settings
{
    // Namespace where to find defaults via config()
    public static $config_namespace = 'defaults.';

    /**
     * Helper function to handle 'foo.bar' or 'foo_bar' strings as array
     *
     * @param $request
     * @return array
     */
    public static function toArray($request)
    {
        return explode('.', str_replace('_', '.', $request));
    }

    /**
     * Get config value from /app/config/defaults.php
     *
     * @param string $request 'header.layout'
     *
     * @return array
     */
    public static function getConfig($request)
    {
        return config(self::$config_namespace . $request);
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
    public static function getDefault($request, $pop = false)
    {
        // Transform underscore requests
        // $request = str_replace( '_', '.', $request );
        $config = self::getConfig($request);

        if ($pop) {
            // Pop e.g. 'string' from.a.request.string
            $config = self::toArray($config);
            return end($config);
        } else {
            // Return an array if requested
            return $config;
        }
    }

    /**
     * Get setting from the customizer via theme_mod
     * Supports nested array
     * todo: Simplify this via common naming convention (this.is.the.convention)
     *
     * @param $request 'header.desktop.layout'
     * @param $default
     * @return bool|string
     */
    public static function getChosen($request, $default = false)
    {
        // This can either be stored as mix of 'global_colors' and 'global_colors[secondary]'
        // Check against both to go sure that we get the value

        // e.g. 'header.desktop.layout' to array => [0] header, [1] desktop, [2] layout
        $request_array = self::toArray($request);

        // 1st: Check against header.desktop.layout as option or theme_mod
        $theme_mod = self::getThemeMod((string) implode('.', $request_array));
        $theme_mod = empty($theme_mod)
            ? self::getThemeOption((string) implode('.', $request_array))
            : $theme_mod;

        // 2nd: Check against header_desktop_layout
        if (!isset($theme_mod)) {
            $theme_mod = self::getThemeMod((string) implode('_', $request_array));
        }

        // 3rd: Check against header_desktop[layout]
        if (!isset($theme_mod)) {
            $key       = array_pop($request_array);
            $theme_mod = self::getThemeMod((string) implode('_', $request_array));
            $theme_mod = isset($theme_mod[ $key ]) ? $theme_mod[ $key ] : $theme_mod;
        }

        // 4th: Try whatever was given if is not a bool
        if (empty($theme_mod) && !is_bool($theme_mod) && !is_null($theme_mod)) {
            $theme_mod = self::getThemeMod($request, $default);
        }

        return $theme_mod;
    }

    /**
     * Get value for a option from the 'stage_options' table
     *
     * @param $name
     * @param string|false $default
     *
     * @return mixed|void|null
     */
    public static function getThemeOption($name, $default = '')
    {
        $options = get_option('stage_options');

        if (isset($options[ $name ])) {
            return apply_filters("stage_option_{$name}", $options[ $name ]);
        }

        return apply_filters("stage_option_{$name}", $default);
    }

    /**
     * Get and filter value from the theme_mods table
     *
     * @param $name
     * @param string|false $default
     *
     * @return mixed|void|null
     */
    public static function getThemeMod($name, $default = '')
    {
        $theme_mod = get_theme_mod($name, $default);

        return apply_filters("stage_option_{$name}", $theme_mod);
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
    public static function getFallback($request, $fallback = false, $pop = false)
    {

        $default = self::getDefault($request, $pop);

        return self::getChosen($request, empty($default) ? $fallback : $default);
    }

    /**
     * Get user chosen template path from Customizer
     * With fallback defined in /config/defaults.php
     *
     * @param string $request Key to look at in theme_mod() & option() 'archive.cpt.layout'
     *
     * @param null   $default_key Key to look at in config()
     *
     * @return string path to template file
     */
    public static function getFallbackTemplatePath($request, $default_key = null)
    {
        // Get the chosen layout e.g. "masonry"
        $fallback = self::getFallback($request, false, true);
        // Get path & default layout (e.g. "partials.grids.modern")
        $config  = self::toArray(self::getConfig($default_key ?: $request));
        $default = array_pop($config);

        // Get path from default $config, view is removed via array_pop before
        $path = implode('.', $config);

        // Set view from fallback
        $view = ! empty($fallback) ? $fallback : $default;

        // Does the file exist -> return path
        return view()->exists("{$path}.{$view}") ? "{$path}.{$view}" : '';
    }
}
