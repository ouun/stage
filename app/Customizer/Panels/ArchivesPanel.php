<?php

namespace Stage\Customizer\Panels;

use Kirki\Control\Checkbox_Switch;
use Kirki\Panel;
use Kirki\Section;
use WP_Customize_Manager;
use Stage\View\Composers\Partials\Archive;
use Stage\Customizer\Controls\LayoutControl;

use function Stage\stage_get_default;
use function Stage\stage_get_fallback_template;

class ArchivesPanel
{

    // Set panel ID
    private static $panel  = 'archives';

    public function __construct()
    {

        /**
         * Set up the panel
         */
        new Panel(self::$panel, array(
            'priority'    => 20,
            'title'       => esc_html__('Archives', 'stage'),
        ));

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
                    $id                        = "archive.$cpt_name.layout";
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
                                    'cards'   => \Roots\asset('images/grid-cards.svg', 'stage')->uri(),
                                    'modern'  => \Roots\asset('images/grid-modern.svg', 'stage')->uri(),
                                    'masonry' => \Roots\asset('images/grid-masonry.svg', 'stage')->uri(),
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
                                'transport'         => $key == 'display_sidebar' ?
                                    'refresh' :
                                    'postMessage',
                                'sanitize_callback'    => 'Stage\stage_bool_to_string',
                                'sanitize_js_callback' => 'Stage\stage_string_to_bool',
                            )
                        );

                        // Add control.
                        $wp_customize->add_control(new Checkbox_Switch($wp_customize, $id, [
                            'section'   => $section,
                            'choices'   => [
                                'on' => __(ucwords(str_replace('_', ' ', $key)), 'stage'),
                                'off'  => __(ucwords(str_replace('_', ' ', $key)), 'stage'),
                            ],
                        ]));
                    }

                    // Add common refresh partial
                    if (! empty($display_configs)) {
                        $wp_customize->selective_refresh->add_partial(
                            $id,
                            array(
                                'selector'            => 'body.' . $cpt_name . '-archive .archive-wrap .wrap-inner',
                                'settings'            => array_values($display_configs),
                                'container_inclusive' => true,
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
