<?php

namespace Stage\Customizer\Panels;

use Kirki\Compatibility\Kirki;
use Kirki\Panel;
use Kirki\Section;

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
        $section = self::$panel . '_colors';

        /**
         * Add Section and fields for Header Style
         */
        new Section(
            $section,
            array(
                'title'    => esc_attr__('Colors', 'stage'),
                'panel'    => self::$panel,
                'priority' => 20,
            )
        );

        Kirki::add_field(
            self::$config,
            array(
                'type'        => 'multicolor',
                'settings'    => $section,
                'label'       => esc_attr__('Footer Colors', 'stage'),
                'section'     => $section,
                'transport'   => 'auto',
                'choices'     => array(
                    'footer_bg'         => esc_attr__('Background Color', 'stage'),
                    'footer_item'       => esc_attr__('Text Color', 'stage'),
                    'footer_item_hover' => esc_attr__('Item Hover & Active', 'stage'),
                ),
                'default'     => array(
                    'footer_bg'         => '',
                    'footer_item'       => '',
                    'footer_item_hover' => '',
                ),
                'alpha'       => true,
                'input_attrs' => array(
                    'footer_bg'         => array(
                        'data-sync-master' => 'global_colors_main[body]',
                    ),
                    'footer_item'       => array(
                        'data-sync-master' => 'global_colors_main[copy]',
                    ),
                    'footer_item_hover' => array(
                        'data-sync-master' => 'global_colors_main[primary]',
                    ),
                ),
                'output'      => array(
                    array(
                        'choice'   => 'footer_bg',
                        'element'  => 'footer.footer-wrap',
                        'property' => '--color-body',
                        'context'  => array(
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'footer_copy',
                        'element'  => 'footer.footer-wrap',
                        'property' => '--color-copy',
                        'context'  => array(
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'footer_copy',
                        'element'  => 'footer.footer-wrap',
                        'property' => '--color-link',
                        'context'  => array(
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'footer_item_hover',
                        'element'  => 'header.main-header',
                        'property' => '--color-hover',
                        'context'  => array(
                            'front',
                        ),
                    ),
                ),
            )
        );
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

        Kirki::add_field(
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
