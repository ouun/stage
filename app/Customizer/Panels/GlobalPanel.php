<?php

namespace Stage\Customizer\Panels;

use Stage\Customizer\Customizer;
use WPLemon\Field\WCAGLinkColor;
use WPLemon\Field\WCAGTextColor;

use function Stage\stage_get_default;

class GlobalPanel
{

    // Set panel ID
    private static $panel  = 'global';
    private static $config = 'global_conf';

    public function __construct()
    {

        /**
         * Set up config for panel
         */
        Customizer::addConfig(
            self::$config
        );

        /**
         * Set up the panel
         */
        Customizer::addPanel(self::$panel, array(
            'priority'    => 10,
            'title'       => esc_html__('Global Settings', 'stage'),
            'description' => esc_html__('Various settings for your website.', 'stage'),
        ));

        /**
         * Init sections with fields
         */
        $this->website();
        $this->branding();
        $this->typography();
        $this->colors();
    }

    public function website()
    {
        // Set section & settings ID
        $section = self::$panel . '_website';

        Customizer::addSection($section, array(
            'title'      => esc_html__('Website Information', 'stage'),
            'capability' => 'edit_theme_options',
            'priority'   => 10,
            'panel'      => self::$panel,
        ));

        /**
         * Site Name
         */
        Customizer::addField(
            array(
                'type'            => 'text',
                'option_type'     => 'option',
                'settings'        => 'blogname',
                'label'           => esc_html__('Titel of the Website', 'wp'),
                'description'     => esc_html__('This is so important!', 'wp'),
                'section'         => $section,
                'default'         => get_bloginfo('name', 'display'),
                'priority'        => 10,
                'transport'       => 'auto',
                'partial_refresh' => array(
                    'site_blogname' => array(
                        'selector'        => '.site_brand--name',
                        'settings'            => 'blogname',
                        'render_callback' => function () {
                            return get_bloginfo('name', 'display');
                        },
                    )
                )
            )
        );

        /**
         * Site Description
         */
        Customizer::addField(
            array(
                'type'            => 'text',
                'option_type'     => 'option',
                'settings'        => 'blogdescription',
                'label'           => esc_html__('Subtitle of the Website', 'wp'),
                'description'     => esc_html__('This is so important, too!', 'wp'),
                'section'         => $section,
                'default'         => get_bloginfo('description', 'display'),
                'priority'        => 20,
                'transport'       => 'auto',
                'partial_refresh' => array(
                    'blogdescription' => array(
                        'selector'        => '.site_brand--tagline',
                        'settings'        => 'blogdescription',
                        'render_callback' => function () {
                            return get_bloginfo('description', 'display');
                        },
                    )
                )
            )
        );
    }

    public function branding()
    {
        // Set section & settings ID
        $section = self::$panel . '_branding';

        /**
         * Add Section and fields for Branding
         */
        Customizer::addSection($section, array(
            'title'      => esc_html__('Logos & Branding', 'stage'),
            'capability' => 'edit_theme_options',
            'priority'   => 20,
            'panel'      => self::$panel,
        ));

        /**
         * Move WP native fields to Branding
         */
        add_action(
            'customize_register',
            function (\WP_Customize_Manager $wp_customize) use ($section) {
                // Custom Logo
                $custom_logo = $wp_customize->get_control('custom_logo');
                if ($custom_logo) {
                    $custom_logo->section  = $section;
                    $custom_logo->priority = 10;
                }

                // Site Icon & Favicon
                $site_icon = $wp_customize->get_control('site_icon');
                if ($site_icon) {
                    $site_icon->section  = $section;
                    $site_icon->priority = 20;
                }
            }
        );
    }

    public function typography()
    {
        // Set section & settings ID
        $section = self::$panel . '_typo';

        /**
         * Add Section and fields for Typography
         */
        Customizer::addSection($section, array(
            'title'       => esc_html__('Typography', 'stage'),
            'description' => esc_html__('Set typo settings for your website', 'stage'),
            'priority'    => 40,
            'panel'       => self::$panel,
        ));

        /**
         * Copy
         */
        Customizer::addField(
            array(
                'type'      => 'typography',
                'label'     => esc_html__('Copy Font', 'stage'),
                'settings'  => $section . '_copy',
                'section'   => $section,
                'priority'  => 10,
                'default'   => stage_get_default('global.typo.copy.fonts'),
                'choices'   => array(
                    'fonts' => stage_get_default('global.typo.choices.fonts'),
                ),
                'transport' => 'auto',
                'output'    => array(
                    array(
                        'choice'   => 'font-family',
                        'element'  => ':root',
                        'property' => '--copy-font-family',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'font-weight',
                        'element'  => ':root',
                        'property' => '--copy-font-weight',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                ),
            )
        );

        /**
         * Heading
         */
        Customizer::addField(
            array(
                'type'      => 'typography',
                'label'     => esc_html__('Headlines Font', 'stage'),
                'settings'  => $section . '_heading',
                'section'   => $section,
                'priority'  => 20,
                'default'   => stage_get_default('global.typo.heading.fonts'),
                'choices'   => array(
                    'fonts' => stage_get_default('global.typo.choices.fonts'),
                ),
                'transport' => 'auto',
                'output'    => array(
                    array(
                        'choice'   => 'font-family',
                        'element'  => ':root',
                        'property' => '--heading-font-family',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'font-weight',
                        'element'  => ':root',
                        'property' => '--heading-font-weight',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                ),
            )
        );
    }

    public function colors()
    {
        // Set section & settings ID
        $section     = self::$panel . '_colors';

        /**
         * Add Section and fields for Colors
         */
        Customizer::addSection($section, array(
            'title'       => esc_html__('Colors', 'stage'),
            'description' => esc_html__('Set color settings for your website', 'stage'),
            'priority'    => 60,
            'panel'       => self::$panel,
        ));

        // Fields are calculated from ColorsPanel.php
    }
}
