<?php

namespace Stage\Customizer\Panels;

use Kirki\Compatibility\Kirki;

use function Stage\stage_get_default;
use function Stage\stage_get_fallback;

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
        Kirki::add_config(
            self::$config,
            array(
                'capability'        => 'edit_theme_options',
                'option_type'       => 'theme_mod',
                'gutenberg_support' => true,
                'disable_output'    => false,
            )
        );

        /**
         * Set up the panel
         */
        Kirki::add_panel(
            self::$panel,
            array(
                'priority'    => 10,
                'title'       => esc_html__('Global Settings', 'stage'),
                'description' => esc_html__('Various settings for your website.', 'stage'),
            )
        );

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

        // Remove the default WP fields early and set them back again
        add_action(
            'customize_register',
            function (\WP_Customize_Manager $wp_customize) {
                $wp_customize->remove_control('blogname');
                $wp_customize->remove_control('blogdescription');
                $wp_customize->remove_control('display_header_text');
            },
            5
        );

        Kirki::add_section(
            $section,
            array(
                'title'      => esc_html__('Website Information', 'stage'),
                'capability' => 'edit_theme_options',
                'priority'   => 10,
                'panel'      => self::$panel,
            )
        );

        Kirki::add_field(
            self::$config,
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
                    'global_website_name' => array(
                        'selector'        => '.site_brand--name',
                        'render_callback' => function () {
                            return get_bloginfo('name', 'display');
                        },
                    ),
                ),
            )
        );

        Kirki::add_field(
            self::$config,
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
                        'render_callback' => function () {
                            return get_bloginfo('description', 'display');
                        },
                    ),
                ),
            )
        );
    }

    public function branding()
    {
        // Set section & settings ID
        $section = self::$panel . '_branding';

        /**
         * Add Section and fields for Typography
         */
        Kirki::add_section(
            $section,
            array(
                'title'      => esc_html__('Logos & Branding', 'stage'),
                'capability' => 'edit_theme_options',
                'priority'   => 20,
                'panel'      => self::$panel,
            )
        );

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
        Kirki::add_section(
            $section,
            array(
                'title'       => esc_html__('Typography', 'stage'),
                'description' => esc_html__('Set typo settings for your website', 'stage'),
                'priority'    => 40,
                'panel'       => self::$panel,
            )
        );

        /**
         * Copy
         */
        Kirki::add_field(
            self::$config,
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
        Kirki::add_field(
            self::$config,
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
        $default_key = 'global.colors.';

        /**
         * Add Section and fields for Typography
         */
        Kirki::add_section(
            $section,
            array(
                'title'       => esc_html__('Colors', 'stage'),
                'description' => esc_html__('Set color settings for your website', 'stage'),
                'priority'    => 60,
                'panel'       => self::$panel,
            )
        );

        /**
         * Main colors
         */
        Kirki::add_field(
            self::$config,
            array(
                'type'      => 'multicolor',
                'label'     => esc_html__('Main Colors', 'stage'),
                'settings'  => $section,
                'section'   => $section,
                'priority'  => 10,
                'choices'   => array(
                    'copy'      => esc_html__('Default Text Color', 'stage'),
                    'heading'      => esc_html__('Default Heading Color', 'stage'),
                    'primary'   => esc_html__('Primary Color', 'stage'),
                    'secondary' => esc_html__('Secondary Color', 'stage'),
                    'body'      => esc_html__('Default Background Color', 'stage'),
                ),
                'default'   => array(
                    'copy'      => stage_get_default($default_key . 'main.copy'),
                    'heading'   => stage_get_default($default_key . 'main.copy'),
                    'primary'   => stage_get_default($default_key . 'main.primary'),
                    'secondary' => stage_get_default($default_key . 'main.secondary'),
                    'body'      => stage_get_default($default_key . 'main.body'),
                ),
                'transport' => 'auto',
                'output'    => array(
                    array(
                        'choice'   => 'copy',
                        'element'  => ':root',
                        'property' => '--color-copy',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
	                array(
		                'choice'   => 'heading',
		                'element'  => ':root',
		                'property' => '--color-heading',
		                'context'  => array(
			                'editor',
			                'front',
		                ),
	                ),
                    array(
                        'choice'   => 'primary',
                        'element'  => ':root',
                        'property' => '--color-primary',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'secondary',
                        'element'  => ':root',
                        'property' => '--color-secondary',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
	                array(
		                'choice'   => 'body',
		                'element'  => ':root',
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
         * Link colors
         */
        Kirki::add_field(
            self::$config,
            array(
                'type'        => 'multicolor',
                'label'       => esc_html__('Link Colors', 'stage'),
                'settings'    => $section . '_links',
                'section'     => $section,
                'priority'    => 20,
                'choices'     => array(
                    'link'  => esc_html__('Link Color', 'stage'),
                    'hover' => esc_html__('Hover & Focus Color', 'stage'),
                ),
                'default'     => array(
                    'link'  => '',
                    'hover' => '',
                ),
                'input_attrs' => array(
                    'data-sync-master' => 'global_colors_main[primary]', // add 'data-mode' attribute to input element
                ),
                'transport'   => 'auto',
                'output'      => array(
                    array(
                        'choice'   => 'link',
                        'element'  => ':root',
                        'property' => '--color-link',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                    array(
                        'choice'   => 'hover',
                        'element'  => ':root',
                        'property' => '--color-hover',
                        'context'  => array(
                            'editor',
                            'front',
                        ),
                    ),
                ),
            )
        );
    }
}
