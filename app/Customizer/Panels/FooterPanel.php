<?php

namespace Stage\Customizer\Panels;

use Kirki\Compatibility\Kirki;
use Kirki\Panel;
use Kirki\Section;
use Stage\Customizer\Customizer;

use function Stage\stage_get_default;
use function Stage\stage_get_fallback;

class FooterPanel
{

    // Set panel ID
    private static $panel  = 'footer';
    private static $config = 'footer_conf';

    public function __construct()
    {

        /**
         * Set up config for panel
         */
        Kirki::add_config(
            self::$config,
            array(
                'capability'     => 'edit_theme_options',
                'option_type'    => 'theme_mod',
                'disable_output' => false,
            )
        );

        /**
         * Set up the panel
         */
        new Panel(
            self::$panel,
            array(
                'priority'    => 30,
                'title'       => esc_attr__('Footer', 'stage'),
                'description' => esc_attr__('Customize the footer.', 'stage'),
            )
        );

        /**
         * Init sections with fields
         */
        $this->colors();
        $this->settings();
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

    public function settings()
    {
        // Set section & settings ID
        $section = self::$panel . '.settings';

        /**
         * Add Section and fields for Header Layout
         */
        new Section(
            $section,
            array(
                'title'       => esc_attr__('Settings', 'stage'),
                'description' => esc_attr__('Footer settings.', 'stage'),
                'panel'       => self::$panel,
                'type'        => 'expand',
                'priority'    => 10,
            )
        );

        Customizer::addField(
            self::$config,
            array(
                'type'            => 'text',
                'settings'        => $section . '.copyright',
                'label'           => esc_html__('Copyright Text', 'stage'),
                'section'         => $section,
                'default'         => stage_get_default($section . '.copyright'),
                'priority'        => 10,
                'transport'       => 'postMessage',
                'partial_refresh' => array(
                    'footer_copyright_text' => array(
                        'selector'            => 'footer p.copyright',
                        'container_inclusive' => false,
                        'fallback_refresh'    => false,
                        'render_callback'     => function () use ($section) {
                            return stage_get_fallback($section . '.copyright');
                        },
                    ),
                ),
            )
        );
    }
}
