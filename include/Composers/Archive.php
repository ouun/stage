<?php

namespace Stage\Composers;

use Roots\Acorn\View\Composer;

use function Stage\post_types;
use function Stage\stage_get_default;
use function Stage\stage_get_fallback;

class Archive extends Composer
{


    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = array(
        'index',
        'search',
        'front-page',
        'partials.grids.*',
    );

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return wp_parse_args(
            array(
                'layout' => self::getArchiveLayoutConfig(),
            ),
            self::getArchiveDisplayConfig()
        );
    }

    /**
     * Get config from Customizer with fallback to defaults
     * and another fallback in defaults to 'archive.fallback'
     *
     * @param null   $post_type
     * @param string $append_key Key to append to 'archive.cpt'
     *
     * @return mixed|string
     */
    public static function getArchiveConfig($post_type = null, $append_key = '')
    {
        $post_type = $post_type ?: get_post_type();
        $post_type = $post_type === 'page' ? 'post' : $post_type;

        // Set up required config keys
        $chosen_key  = 'archive.' . $post_type . $append_key; // theme_mod() or option() key
        $default_key = self::getPostTypeArchiveConfigKey($post_type) . $append_key; // config() key

        // Get the chosen layout e.g. "masonry"
        $config = stage_get_fallback($chosen_key, false, true);

        // No setting, get from default
        return empty($config) ? stage_get_default($default_key, true) : $config;
    }

    /**
     * Returns either value from Customizer or defaults.
     *
     * @param null $post_type
     *
     * @return mixed|string E.g. 'modern'
     */
    public static function getArchiveLayoutConfig($post_type = null)
    {
        return self::getArchiveConfig($post_type, '.layout');
    }

    /**
     * Get archive display configs
     *
     * @param null $post_type
     *
     * @return array
     */
    public static function getArchiveDisplayConfig($post_type = null)
    {
        $data = array();

        $post_type = $post_type ?: get_post_type();

        $configs_key = self::getPostTypeArchiveConfigKey($post_type) . '.display';
        $configs     = stage_get_default($configs_key);

        foreach ($configs as $key => $config) {
            $data[ 'display_' . $key ] = (bool) self::getArchiveConfig($post_type, '.display' . '.' . $key);
        }

        return $data;
    }

    /**
     * Helper to get the config key with fallback
     *
     * @param string $post_type
     *
     * @return mixed|string
     */
    public static function getPostTypeArchiveConfigKey($post_type)
    {
        $configs_key = 'archive.' . $post_type;
        return ! empty(stage_get_default($configs_key)) ? $configs_key : 'archive.fallback';
    }

    /**
     * Get registered Post Types with archives
     *
     * @return \WP_Post_Type[]
     */
    public static function archivesToRegister()
    {
        $post_types = post_types();
        foreach ($post_types as $name => $label) {
            if (! get_post_type_archive_link($name)) {
                unset($post_types[ $name ]);
            }
        }

        return $post_types;
    }
}
