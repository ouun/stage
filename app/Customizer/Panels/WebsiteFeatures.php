<?php

namespace Stage\Customizer\Panels;

use Kirki\Panel;
use Kirki\Section;
use Kirki\Control\Checkbox_Switch;

use function Stage\stage_bool_to_string;
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
        /*
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
        */

        /**
         * Set up the panel
         */
        new Panel(self::$panel, array(
            'priority'    => 200,
            'title'       => esc_html__('Website Features', 'stage'),
            'description' => esc_html__('Activate & customize website features.', 'stage'),
        ));


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

        new Section($section, array(
            'title'      => esc_html__('Dynamic Page Loading & Transitions', 'stage'),
            'capability' => 'edit_theme_options',
            'priority'   => 10,
            'panel'      => self::$panel,
        ));

        /**
         * Feature Activation Toggle
         */
        $this->addFeatureActivationToggle($section);
    }


    public function lazy()
    {
        // Set section & settings ID
        $section = self::$panel . '.lazy';

        new Section($section, array(
            'title'      => esc_html__('Lazy Load Media', 'stage'),
            'capability' => 'edit_theme_options',
            'priority'   => 10,
            'panel'      => self::$panel,
        ));

        /**
         * Feature Activation Toggle
         */
        $this->addFeatureActivationToggle($section);
    }


    public function infinity()
    {
        // Set section & settings ID
        $section = self::$panel . '.infinity';

        new Section($section, array(
            'title'      => esc_html__('Infinite scrolling for Archives', 'stage'),
            'capability' => 'edit_theme_options',
            'priority'   => 10,
            'panel'      => self::$panel,
        ));

        /**
         * Feature Activation Toggle
         */
        $this->addFeatureActivationToggle($section);
    }


    public function gallery()
    {
        // Set section & settings ID
        $section = self::$panel . '.gallery';

        new Section($section, array(
            'title'      => esc_html__('Galleries', 'stage'),
            'capability' => 'edit_theme_options',
            'priority'   => 10,
            'panel'      => self::$panel,
        ));


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
         * @param \WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
         * @return void
         */
        add_action('customize_register', function ($wp_customize) use ($section) {
            // Add setting.
            $wp_customize->add_setting("stage[$section.activate]", [
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'default'           => stage_get_fallback($section . '.activate'),
                'transport'         => 'refresh', // Or postMessage.
                'sanitize_callback'    => 'Stage\stage_bool_to_string',
                'sanitize_js_callback' => 'Stage\stage_string_to_bool',
            ]);

            // Add control.
            $wp_customize->add_control(new Checkbox_Switch($wp_customize, "stage[$section.activate]", [
                'label' => esc_html__('Activate', 'stage'),
                'section' => $section,
            ]));
        });
    }
}
