<?php

namespace Stage\Customizer\Panels;

use Kirki\Field\ReactColor;
use Stage\Customizer\Customizer;
use Stage\Customizer\Settings;

use function Stage\stage_get_default;

class ColorsPanel
{
    // Set panel ID
    private static $panel  = 'colors';
    private static $config = 'colors_conf';

    public function __construct()
    {

        /**
         * Set up config for panel
         */
        Customizer::addConfig(
            self::$config,
            array(
                'capability'     => 'edit_theme_options',
                'disable_output' => false,
            )
        );

        /**
         * Set up the panel
         */
        Customizer::addPanel(
            self::$panel,
            array(
                'priority'    => 30,
                'title'       => esc_attr__('Colors', 'stage'),
                'description' => esc_attr__('Customize your colors.', 'stage'),
            )
        );

        /**
         * Init sections with fields
         */

        $sections = [
            'global' => [
                'label' => esc_html('Global', 'stage'),
                'element' => ':root',
                'priority' => 10,
            ],
            'header' => [
                'label' => esc_html('Header', 'stage'),
                'element' => 'body > header',
                'priority' => 20,
            ],
            'footer' => [
                'label' => esc_html('Footer', 'stage'),
                'element' => 'body > footer',
                'priority' => 30,
            ]
        ];


        foreach ($sections as $section => $args) {
            $this->registerColors($section, $args);
        }
    }

    /**
     * Register Color Configs
     *
     * @param $section
     * @param $args
     */
    public function registerColors($section, $args)
    {
        $default_key = $section . '.colors.';

        /**
         * Add Section and fields for Colors
         */
        Customizer::addSection($section . '_colors', array(
            'title'       => sprintf(
            /* translators: %s: Header */
                esc_html__('%s Colors', 'repack'),
                $args['label']
            ),
            'description' => esc_html__('Set color settings for your website', 'stage'),
            'panel'       => self::$panel,
        ));

        /**
         * Main colors
         */
        Customizer::addField(
            self::$config,
            array(
                'type'      => 'multicolor',
                'settings'  => $section . '_colors',
                'section'   => $section . '_colors',
                'choices'   => array(
                    'primary'   => esc_html__('Primary Color', 'stage'),
                    'secondary' => esc_html__('Secondary Color', 'stage'),
                    'body'      => esc_html__('Default Background Color', 'stage'),
                    'copy'      => esc_html__('Default Text Color', 'stage'),
                    'heading'   => esc_html__('Default Heading Color', 'stage'),
                ),
                'default'   => array(
                    'primary'   => stage_get_default($default_key . 'primary'),
                    'secondary' => stage_get_default($default_key . 'secondary'),
                    'body'      => stage_get_default($default_key . 'body'),
                    'copy'      => stage_get_default($default_key . 'copy'),
                    'heading'   => stage_get_default($default_key . 'copy'),
                ),
                'input_attrs' => $section === 'global' ? [] : array(
                    'primary'        => array(
                        'data-sync-master' => 'global_colors[primary]',
                    ),
                    'secondary'       => array(
                        'data-sync-master' => 'global_colors[secondary]',
                    ),
                    'body'        => array(
                        'data-sync-master' => 'global_colors[body]',
                    ),
                    'copy'        => array(
                        'data-sync-master' => 'global_colors[copy]',
                    ),
                    'heading'       => array(
                        'data-sync-master' => 'global_colors[copy]',
                    ),
                ),
                'transport' => 'auto',
                'output'    => array(
                    array(
                        'choice'   => 'copy',
                        'element'  => $args['element'],
                        'property' => '--color-copy',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'heading',
                        'element'  => $args['element'],
                        'property' => '--color-heading',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'primary',
                        'element'  => $args['element'],
                        'property' => '--color-primary',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'secondary',
                        'element'  => $args['element'],
                        'property' => '--color-secondary',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'body',
                        'element'  => $args['element'],
                        'property' => '--color-body',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                ),
            )
        );

        /**
         * Link Colors
         */
        Customizer::addField(
            self::$config,
            array(
                'type'        => 'multicolor',
                'settings'    => $section . '_colors_links',
                'section'     => $section . '_colors',
                'choices'     => array(
                    'link'  => esc_html__('Link Color', 'stage'),
                    'hover' => esc_html__('Hover & Focus Color', 'stage'),
                ),
                'default'     => array(
                    'link'  => '',
                    'hover' => '',
                ),
                'input_attrs' => $section === 'global' ? [
                    'link'         => array(
                        'data-sync-master' => 'global_colors[copy]',
                    ),
                    'hover'       => array(
                        'data-sync-master' => 'global_colors[primary]',
                    ),
                ] : [
                    'link'         => array(
                        'data-sync-master' => 'global_colors_links[link]',
                    ),
                    'hover'       => array(
                        'data-sync-master' => 'global_colors_links[hover]',
                    ),
                ],
                'transport'   => 'auto',
                'output'      => array(
                    array(
                        'choice'   => 'link',
                        'element'  => $args['element'],
                        'property' => '--color-link',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'hover',
                        'element'  => $args['element'],
                        'property' => '--color-hover',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                ),
            )
        );

        /**
         * Color Palettes
         */
        foreach (Settings::getDefault('global.colors.palettes') as $palette => $shades) {
            foreach ($shades as $shade => $color) {
                $key = $palette . '-' . $shade;

                new ReactColor(
                    [
                        'kirki_config' => self::$config,
                        'label'        => ucfirst($palette) . ' ' . $shade,
                        'settings'     => $section . '_colors_' . $palette . '[' . $shade . ']',
                        'section'      => $section . '_colors',
                        'choices'      => array(
                            'formComponent' => 'TwitterPicker',
                        ),
                        'default' => $color,
                        'input_attrs' => $section != 'global' ? [
                            'data-sync-master' => 'global_colors_' . $palette . '[' . $shade . ']',
                        ] : [],
                        'disable_output' => false,
                        'gutenberg_support' => true,
                        'transport'   => 'auto',
                        'output'    => [
                            [
                                'element'  => $args['element'],
                                'property' => "--color-$key",
                                'context'  => array(
                                    'editor',
                                    'front',
                                ),
                            ],
                        ],
                    ]
                );
            }
        }
    }
}
