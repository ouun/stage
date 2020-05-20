<?php

namespace Stage\Customizer\Panels;

use Kirki\Compatibility\Field;
use Kirki\Control\Checkbox_Switch;
use Kirki\Panel;
use Kirki\Section;
use WP_Customize_Manager;

use function Stage\stage_get_fallback;

class WebsiteFeatures
{

    // Set panel ID
    private static $panel  = 'features';

    public function __construct()
    {

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

        add_action(
            'customize_register',
            function (WP_Customize_Manager $wp_customize) use ($section) {
                $wp_customize->add_setting(
                    "stage[$section.activate]",
                    array(
                        'type'              => 'option',
                        'capability'        => 'edit_theme_options',
                        'default'           => stage_get_fallback($section . '.activate'),
                        'sanitize_callback'    => 'Stage\stage_bool_to_string',
                        'sanitize_js_callback' => 'Stage\stage_string_to_bool',
                    )
                );

                // Add control.
                $wp_customize->add_control(new Checkbox_Switch(
                    $wp_customize,
                    "stage[$section.activate]",
                    [
                        'section'   => $section,
                        'priority'          => -999,
                        'choices'           => [
                            'yes' => esc_html__('Deactivate Feature', 'stage'),
                            'no'  => esc_html__('Activate Feature', 'stage'),
                        ],
                    ]
                ));
            }
        );
    }
}
