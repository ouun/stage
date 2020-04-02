<?php

namespace Stage\Customizer\Panels;

use WP_Customize_Manager;
use Stage\View\Composers\Partials\Archive;
use Stage\Customizer\Controls\LayoutControl;
use Stage\Customizer\Controls\ToggleControl;
use Kirki\Compatibility\Kirki;
use Kirki\Section;

use function Stage\stage_get_default;
use function Stage\stage_get_fallback_template;

class ArchivesPanel
{

    // Set panel ID
    private static $panel  = 'archives';
    private static $config = 'archives_conf';

    public function __construct()
    {
        /**
         * Register Global Config
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
         * Register Panel
         */
        // Layout Panel
        Kirki::add_panel(
            self::$panel,
            array(
                'priority' => 20,
                'title'    => esc_attr__('Archives', 'stage'),
            )
        );

        foreach (Archive::archivesToRegister() as $cpt_name => $cpt_label) {
            // Set section & settings ID
            $section = self::$panel . '_' . $cpt_name;

            /**
             * Add Section and fields for Header Style
             */
            new Section(
                $section,
                array(
                    'title' => $cpt_label,
                    'panel' => self::$panel,
                )
            );

            /**
             * Add display options, automate generation from defaults
             *
             * @since 1.0
             * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
             * @return void
             */
            add_action(
                'customize_register',
                function (WP_Customize_Manager $wp_customize) use ($section, $cpt_name, $cpt_label) {
                    // Archive layout settings
                    $id                        = 'archive.' . $cpt_name . '.layout';
                    $config                    = Archive::getPostTypeArchiveConfigKey($cpt_name) . '.layout';
                    $display_configs['layout'] = $id;

                    $wp_customize->add_setting(
                        $id,
                        array(
                            'type'              => 'theme_mod',
                            'capability'        => 'edit_theme_options',
                            'default'           => stage_get_default($config, true),
                            'transport'         => 'postMessage', // Or postMessage.
                            'sanitize_callback' => function ($layout) {
                                return $layout;
                            },
                        )
                    );

                    $wp_customize->add_control(
                        new LayoutControl(
                            $wp_customize,
                            $id,
                            array(
                                'type'    => 'layout',
                                'label'   => esc_html__('Grid Layout', 'stage'),
                                'section' => $section,
                                'choices' => array(
                                    'cards'   => \Roots\asset('images/customizer/grid-cards.svg', 'stage')->uri(),
                                    'modern'  => \Roots\asset('images/customizer/grid-modern.svg', 'stage')->uri(),
                                    'masonry' => \Roots\asset('images/customizer/grid-masonry.svg', 'stage')->uri(),
                                ),
                            )
                        )
                    );

                    // Archive item display settings
                    foreach (Archive::getArchiveDisplayConfig($cpt_name) as $key => $display_config) {
                        $id                      = 'archive.' . $cpt_name . '.' . str_replace('_', '.', $key);
                        $display_configs[ $key ] = $id;

                        $wp_customize->add_setting(
                            $id,
                            array(
                                'type'              => 'theme_mod',
                                'capability'        => 'edit_theme_options',
                                'default'           => $display_config,
                                'transport'         => 'postMessage', // Or postMessage.
                                'sanitize_callback' => array(
                                    'Stage\Customizer\Controls\ToggleControl',
                                    'sanitize_toggle'
                                ),
                            )
                        );

                        $wp_customize->add_control(
                            new ToggleControl(
                                $wp_customize,
                                $id,
                                array(
                                    'label'   => __(ucwords(str_replace('_', ' ', $key)), 'stage'),
                                    'section' => $section,
                                )
                            )
                        );
                    }

                    // Add common refresh partial
                    if (! empty($display_configs)) {
                        $wp_customize->selective_refresh->add_partial(
                            $id,
                            array(
                                'selector'            => 'body.' . $cpt_name . '-archive .archive-wrap',
                                'settings'            => array_values($display_configs),
                                'container_inclusive' => false,
                                'render_callback'     => function () use ($cpt_name) {
                                    // Get $layout based on available setting
                                    $chosen_key  = 'archive.' . $cpt_name . '.layout'; // theme_mod() or option() key
                                    $default_key = Archive::getPostTypeArchiveConfigKey($cpt_name) . '.layout';

                                    return stage_get_fallback_template(
                                        $chosen_key,
                                        $default_key,
                                        Archive::getArchiveDisplayConfig()
                                    );
                                },
                            )
                        );
                    }
                }
            );
        }
    }
}
