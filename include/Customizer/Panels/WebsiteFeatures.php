<?php

namespace Stage\Customizer\Panels;

use Kirki\Compatibility\Kirki;

use function Stage\stage_get_fallback;

class WebsiteFeatures
{

    // Set panel ID
    private static $panel  = 'features';
    private static $config = 'features_conf';

    public function __construct()
    {

        /**
         * Set up config for panel
         */
        Kirki::add_config(
            self::$config,
            array(
                'capability'        => 'edit_theme_options',
                'option_type'       => 'option',
                'option_name'       => 'stage_options',
                'gutenberg_support' => false,
                'disable_output'    => false,
            )
        );

        /**
         * Set up the panel
         */
        Kirki::add_panel(
            self::$panel,
            array(
                'priority'    => 200,
                'title'       => esc_html__('Website Features', 'stage'),
                'description' => esc_html__('Activate & customize website features.', 'stage'),
            )
        );

        /**
         * Init sections with fields
         */
        $this->loader();
        $this->lazy();
        $this->infinity();
        $this->gallery();
    }


    public function loader()
    {
        // Set section & settings ID
        $section = self::$panel . '.loader';

        Kirki::add_section(
            $section,
            array(
                'title'      => esc_html__('Dynamic Page Loading & Transitions', 'stage'),
                'capability' => 'edit_theme_options',
                'priority'   => 10,
                'panel'      => self::$panel,
            )
        );

        /**
         * Feature Activation Toggle
         */
        $this->addFeatureActivationToggle($section);
    }


    public function lazy()
    {
        // Set section & settings ID
        $section = self::$panel . '.lazy';

        Kirki::add_section(
            $section,
            array(
                'title'      => esc_html__('Lazy Load Media', 'stage'),
                'capability' => 'edit_theme_options',
                'priority'   => 10,
                'panel'      => self::$panel,
            )
        );

        /**
         * Feature Activation Toggle
         */
        $this->addFeatureActivationToggle($section);
    }


    public function infinity()
    {
        // Set section & settings ID
        $section = self::$panel . '.infinity';

        Kirki::add_section(
            $section,
            array(
                'title'      => esc_html__('Infinite scrolling for Archives', 'stage'),
                'capability' => 'edit_theme_options',
                'priority'   => 10,
                'panel'      => self::$panel,
            )
        );

        /**
         * Feature Activation Toggle
         */
        $this->addFeatureActivationToggle($section);
    }


    public function gallery()
    {
        // Set section & settings ID
        $section = self::$panel . '.gallery';

        Kirki::add_section(
            $section,
            array(
                'title'      => esc_html__('Galleries', 'stage'),
                'capability' => 'edit_theme_options',
                'priority'   => 10,
                'panel'      => self::$panel,
            )
        );

        /**
         * Feature Activation Toggle
         */
        $this->addFeatureActivationToggle($section);
    }

    /**
     * Helper function to add common controls
     *
     * @param $section
     */
    public function addFeatureActivationToggle($section)
    {

        /**
         * Add Customizer settings & controls.
         *
         * @since 1.0
         */
        Kirki::add_field(
            self::$config,
            array(
                'type'     => 'kirki-switch',
                'settings' => $section . '.activate',
                'label'    => esc_html__('Activate', 'stage'),
                'section'  => $section,
                'default'  => stage_get_fallback($section . '.activate'),
                'priority' => 10,
            )
        );
    }
}
