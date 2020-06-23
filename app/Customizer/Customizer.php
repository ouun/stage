<?php

namespace Stage\Customizer;

use Kirki\Compatibility\Kirki;
use Stage\Customizer\Panels\ArchivesPanel;
use Stage\Customizer\Panels\ColorsPanel;
use Stage\Customizer\Panels\FooterPanel;
use Stage\Customizer\Panels\GlobalPanel;
use Stage\Customizer\Panels\HeaderPanel;
use Stage\Customizer\Panels\SettingsPanel;
use Stage\Customizer\Panels\WebsitePanel;
use Stage\Customizer\Panels\WebsiteFeatures;
use Roots\Acorn\ServiceProvider;
use Stage\View\Composers\Partials\Archive;
use WP_Customize_Manager;

use function Stage\stage_get_default;

class Customizer extends ServiceProvider
{


    public function boot()
    {
        // Disable Kirki Telemetry
        add_action('kirki_telemetry', '__return_false');

        // Force downloading Google Fonts for GDPR
        add_filter('kirki_use_local_fonts', '__return_true');

        // Do not inline CSS, build with action
        add_filter('kirki_output_inline_styles', '__return_true');

        // Fix Kirki URL handling for local development, if in symlink folder
        add_filter(
            'kirki_path_url',
            function ($url, $path) {
                if (defined('WP_ENV') && WP_ENV !== 'production' && substr($url, 0, 4) !== 'http') {
                    $url = get_template_directory_uri() . explode(get_template(), $path)[1];
                }

                return $url;
            },
            10,
            2
        );

        // Rename the css output action
        add_filter(
            'kirki_styles_action_handle',
            function () {
                return 'customizer-style';
            }
        );

        /**
         * Filter the Kirki Standard Fonts
         *
         * @return array Standard Fonts
         */
        add_filter(
            'kirki_fonts_standard_fonts',
            function ($standard_fonts) {

                // Remove Monospace font
                unset($standard_fonts['monospace']);

                $stage_defaults = array(
                    'serif'      => array(
                        'label' => esc_html__('System Serif', 'stage'),
                        'stack' => stage_get_default('global.typo.heading.fonts.font-family'),
                    ),
                    'sans-serif' => array(
                        'label' => esc_html__('System Sans-Serif', 'stage'),
                        'stack' => stage_get_default('global.typo.copy.fonts.font-family'),
                    ),
                );

                return apply_filters('stage_standard_fonts', wp_parse_args($stage_defaults, $standard_fonts));
            },
            1,
            20
        );

        /**
         * Register Kirki Modules
         *
         * @return void
         * @since 1.0
         */
        add_action(
            'after_setup_theme',
            function () {
                $modules = array(
                    // 'core'               => '\Kirki\Compatibility\Kirki',
                    'postMessage'        => '\Kirki\Module\Postmessage',
                    'css'                => '\Kirki\Module\CSS',
                    'selective-refresh'  => '\Kirki\Module\Selective_Refresh',
                    // 'field-dependencies' => '\Kirki\Module\Field_Dependencies',
                    'webfonts'           => '\Kirki\Module\Webfonts',
                    // 'tooltips'           => '\Kirki\Module\Tooltips',
                    'sync'               => '\Kirki\Module\Sync',
                    'font-uploads'       => '\Kirki\Module\FontUploads',
                );

                if (! empty($modules) && is_array($modules)) {
                    foreach ($modules as $key => $module) {
                        if (class_exists($module)) {
                            new $module();
                        } else {
                            wp_die('Oh no! We are missing a Module Class for the Customizer: ' . $module);
                        }
                    }
                }
            }
        );

        /**
         * Registers additional Controls and whitelists them for JS templating.
         *
         * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
         *
         * @return void
         * @since 1.0
         */
        add_action(
            'customize_register',
            function (WP_Customize_Manager $wp_customize) {
                /**
                 * Registers the control and whitelists it for JS templating.
                 * Only needs to run once per control-type/class,
                 * not needed for every control we add.
                 */
                $controls = array(
                    '\Stage\Customizer\Controls\LayoutControl',
                    '\Stage\Customizer\Controls\RangeValueControl',
                    '\Stage\Customizer\Controls\ToggleControl',
                    '\Kirki\Control\Base', // Activating this might overwrite normal text inputs
                    '\Kirki\Control\Checkbox',
                    '\Kirki\Control\Checkbox_Switch',
                    '\Kirki\Control\ReactColor',
                    '\Kirki\Control\Custom',
                    '\Kirki\Control\Generic',
                    '\Kirki\Control\ReactSelect',
                );

                foreach ($controls as $control) {
                    if (class_exists($control)) {
                        $wp_customize->register_control_type($control);
                    } else {
                        \Roots\wp_die('Oh no! We are missing a Control Class for the Customizer: ' . $control);
                    }
                }
            }
        );

        /**
         * Register Panels
         */
        add_action(
            'after_setup_theme',
            function () {

                /**
                 * Set default config is none is defined for field
                 */
                self::addConfig('stage', [
                    'capability'        => 'edit_theme_options',
                    'option_type'       => 'theme_mod',
                    'gutenberg_support' => true,
                    'disable_output'    => false,
                ]);

                new WebsitePanel(); // HIDES AND MOVES CONTROLS!
                new SettingsPanel();
                new WebsiteFeatures();
                new GlobalPanel();
                new HeaderPanel();
                new ArchivesPanel();
                new FooterPanel();
                new ColorsPanel();
            },
            100
        );

        /**
         * Include customizer.js
         */
        add_action(
            'customize_controls_enqueue_scripts',
            function () {
                wp_enqueue_script(
                    'stage/customize-controls.js',
                    \Roots\asset('scripts/customizer/customize-controls.js', 'stage')->uri(),
                    array(
                        'customize-controls',
                        'jquery',
                    ),
                    null,
                    true
                );

                // Collect data for 'stage' JS object via 'stage_localize_script' filter
                wp_localize_script('stage/customize-controls.js', 'stage', [
                    'archives' => Archive::registeredArchives(),
                ]);
            }
        );

        /**
         * Include customizer-preview.js
         */
        add_action(
            'customize_preview_init',
            function () {
                wp_enqueue_script(
                    'stage/customize-preview.js',
                    \Roots\asset('scripts/customizer/customize-preview.js', 'stage')->uri(),
                    array( 'customize-preview' ),
                    null,
                    true
                );
            }
        );

        /**
         * Overwrite customer style
         */
        add_action(
            'wp_enqueue_scripts',
            function () {
                if (is_customize_preview()) {
                    wp_enqueue_style(
                        'stage/customizer/css',
                        \Roots\asset('styles/customizer/customizer.css', 'stage')->uri(),
                        array( 'customize-preview' ),
                        '1.0.0',
                        'all'
                    );
                }
            },
            20
        );
    }


    /**
     * Proxy function for Kirki Config.
     *
     * @static
     * @access public
     * @since 1.0
     * @param string $id   The config ID.
     * @param array  $args The config arguments.
     * @return void
     */
    public static function addConfig($id, $args = [])
    {

        $args = wp_parse_args($args, [
            'capability'        => 'edit_theme_options',
            'option_type'       => 'theme_mod',
            'gutenberg_support' => true,
            'disable_output'    => false,
        ]);

        Kirki::add_config($id, apply_filters('stage_customizer_config_args', $args));
    }


    /**
     * Proxy function for Kirki Panel.
     *
     * @static
     * @access public
     * @since 1.0
     * @param string $id   The section ID.
     * @param array  $args The field arguments.
     * @return void
     */
    public static function addPanel($id, $args)
    {
        Kirki::add_panel($id, apply_filters('stage_customizer_panel_args', $args));
    }


    /**
     * Proxy function for Kirki Section.
     *
     * @static
     * @access public
     * @since 1.0
     * @param string $id   The section ID.
     * @param array  $args The field arguments.
     * @return void
     */
    public static function addSection($id, $args)
    {
        Kirki::add_section($id, apply_filters('stage_customizer_section_args', $args));
    }


    /**
     * Proxy function for Kirki Field.
     *
     * @static
     * @access public
     * @param string|array $config
     * @param array $args The field arguments.
     * @return void
     * @since 1.0
     */
    public static function addField($config, $args = [])
    {

        // Use global config if none defined
        if (is_array($config)) {
            $args = $config;
            $config = 'stage';
        }

        Kirki::add_field($config, apply_filters('stage_customizer_field_args', $args));
    }
}
