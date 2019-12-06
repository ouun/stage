<?php

namespace Stage\Customizer\Panels;

use Stage\Composers\Header;
use Stage\Customizer\Controls\LayoutControl;
use Stage\Customizer\Controls\RangeValueControl;
use Stage\Customizer\Controls\ToggleControl;
use Kirki\Compatibility\Kirki;
use Kirki\Control\ReactSelect;
use Kirki\Panel;
use Kirki\Section;
use WP_Customize_Manager;
use function Stage\stage_get_default;
use function Stage\stage_get_fallback;
use function Stage\stage_get_fallback_template;
use function Roots\asset;

class HeaderPanel {


	// Set panel ID
	static $panel  = 'header';
	static $config = 'header_conf';

	public function __construct() {

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
				'priority'    => 20,
				'title'       => esc_attr__( 'Site Header & Menus', 'stage' ),
				'description' => esc_attr__( 'Customize the main header and menus.', 'stage' ),
			)
		);

		/**
		 * Init sections with fields
		 */
		$this->layout();
		$this->typography();
		$this->colors();

	}

	public function layout() {
		// Set section & settings ID
		$section = self::$panel . '_layout';

		/**
		 * Add Section and fields for Header Layout
		 */
		new Section(
			$section,
			array(
				'title'       => esc_attr__( 'Layout', 'stage' ),
				'description' => esc_attr__( 'Adjust theme colors.', 'stage' ),
				'panel'       => 'header',
				'type'        => 'expand',
				'priority'    => 10,
			)
		);

		/**
		 * Add Customizer settings & controls.
		 *
		 * @since 1.0
		 * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
		 * @return void
		 */
		add_action(
			'customize_register',
			function( WP_Customize_Manager $wp_customize ) use ( $section ) {

				/*
				* Desktop: Layout options
				*/
				$wp_customize->add_setting(
					'header.desktop.layout',
					array(
						'type'              => 'theme_mod',
						'capability'        => 'edit_theme_options',
						'default'           => stage_get_default( 'header.desktop.layout', true ),
						'transport'         => 'refresh', // Or postMessage.
						'sanitize_callback' => function( $layout ) {
							return $layout;
						},
					)
				);

				$wp_customize->add_control(
					new LayoutControl(
						$wp_customize,
						'header.desktop.layout',
						array(
							'type'    => 'layout',
							'label'   => esc_html__( 'Header Layout', 'stage' ),
							'section' => $section,
							'choices' => array(
								'horizontal-left'   => asset( 'images/customizer/header-horizontal-left.svg', 'stage' )->uri(),
								'horizontal-center' => asset( 'images/customizer/header-horizontal-center.svg', 'stage' )->uri(),
								'horizontal-right'  => asset( 'images/customizer/header-horizontal-right.svg', 'stage' )->uri(),
							),
						)
					)
				);

				/*
				* Desktop: Layout options
				*/
				$wp_customize->add_setting(
					'header.search.layout',
					array(
						'type'              => 'theme_mod',
						'capability'        => 'edit_theme_options',
						'default'           => stage_get_default( 'header.search.layout', true ),
						'transport'         => 'refresh', // Or postMessage.
						'sanitize_callback' => function( $layout ) {
							return $layout;
						},
					)
				);

				$wp_customize->add_control(
					new LayoutControl(
						$wp_customize,
						'header.search.layout',
						array(
							'type'    => 'layout',
							'label'   => esc_html__( 'Search Layout', 'stage' ),
							'section' => $section,
							'choices' => array(
								'below-header' => asset( 'images/customizer/header-horizontal-left.svg', 'stage' )->uri(),
								'fullscreen'   => asset( 'images/customizer/header-horizontal-center.svg', 'stage' )->uri(),
							),
						)
					)
				);

				/*
				* Desktop: Header Position
				*/
				$wp_customize->add_setting(
					'header.desktop.position',
					array(
						'type'              => 'theme_mod',
						'capability'        => 'edit_theme_options',
						'default'           => stage_get_default( 'header.desktop.position' ),
						'transport'         => 'refresh', // Or postMessage.
						'sanitize_callback' => function( $layout ) {
							return $layout;
						},
					)
				);

				$wp_customize->add_control(
					new ReactSelect(
						$wp_customize,
						'header.desktop.position',
						array(
							'label'   => esc_html__( 'Header Position', 'stage' ),
							'section' => $section,
							'choices' => array(
								'default'          => esc_attr__( 'Default', 'stage' ),
								'sticky'           => esc_attr__( 'Fixed on top', 'stage' ),
								'sticky auto-hide' => esc_attr__( 'Auto hide while scrolling', 'stage' ),
							),
						)
					)
				);

				/**
				 * Desktop: Header Fullwidth
				 */
				$wp_customize->add_setting(
					'header.desktop.fullwidth',
					array(
						'type'              => 'theme_mod',
						'capability'        => 'edit_theme_options',
						'default'           => stage_get_default( 'header.desktop.fullwidth' ),
						'transport'         => 'refresh',
						'sanitize_callback' => array( 'Stage\Customizer\Controls\ToggleControl', 'sanitize_toggle' ),
					)
				);

				$wp_customize->add_control(
					new ToggleControl(
						$wp_customize,
						'header.desktop.fullwidth',
						array(
							'label'    => esc_html__( 'Fullwidth header', 'stage' ),
							'section'  => $section,
							'settings' => 'header.desktop.fullwidth',
							'type'     => 'toggle',
						)
					)
				);

				/**
				 * Desktop: Header Fullwidth
				 */
				$wp_customize->add_setting(
					'header.branding.show_tagline',
					array(
						'type'              => 'theme_mod',
						'capability'        => 'edit_theme_options',
						'default'           => stage_get_default( 'header.branding.show_tagline' ),
						'transport'         => 'refresh',
						'sanitize_callback' => array( 'Stage\Customizer\Controls\ToggleControl', 'sanitize_toggle' ),
					)
				);

				$wp_customize->add_control(
					new ToggleControl(
						$wp_customize,
						'header.branding.show_tagline',
						array(
							'label'    => esc_html__( 'Show Tagline', 'stage' ),
							'section'  => $section,
							'settings' => 'header.branding.show_tagline',
							'type'     => 'toggle',
						)
					)
				);

				/**
				 * Desktop: Header Horizontal Padding
				 */
				$wp_customize->add_setting(
					'header.desktop.padding-x',
					array(
						'type'       => 'theme_mod',
						'capability' => 'edit_theme_options',
						'default'    => stage_get_default( 'header.desktop.padding-x' ),
						'transport'  => 'refresh',
					)
				);

				$wp_customize->add_control(
					new RangeValueControl(
						$wp_customize,
						'header.desktop.padding-x',
						array(
							'type'        => 'range-value',
							'section'     => $section,
							'settings'    => 'header.desktop.padding-x',
							'label'       => esc_html__( 'Horizontal Padding', 'stage' ),
							'input_attrs' => array(
								'min'    => '0',
								'max'    => '12',
								'step'   => '2',
								'prefix' => '',
								'suffix' => '',
							),
						)
					)
				);

				/**
				 * Desktop: Header Vertical Padding
				 */
				$wp_customize->add_setting(
					'header.desktop.padding-y',
					array(
						'type'       => 'theme_mod',
						'capability' => 'edit_theme_options',
						'default'    => stage_get_default( 'header.desktop.padding-y' ),
						'transport'  => 'refresh',
					)
				);

				$wp_customize->add_control(
					new RangeValueControl(
						$wp_customize,
						'header.desktop.padding-y',
						array(
							'type'        => 'range-value',
							'section'     => $section,
							'settings'    => 'header.desktop.padding-y',
							'label'       => esc_html__( 'Vertical Padding', 'stage' ),
							'input_attrs' => array(
								'min'    => '0',
								'max'    => '10',
								'step'   => '2',
								'prefix' => '',
								'suffix' => '',
							),
						)
					)
				);

				$wp_customize->selective_refresh->add_partial(
					'header.desktop.layout',
					array(
						'selector'        => 'header.main-header > .header-wrap',
						'settings'        => array( 'header.desktop.layout', 'header.desktop.position', 'header.desktop.fullwidth', 'header.branding.show_tagline', 'header.desktop.padding-x', 'header.desktop.padding-y' ),
						'render_callback' => function () {
							return stage_get_fallback_template(
								'header.desktop.layout',
								array(
									'layout'       => stage_get_fallback( 'header.desktop.layout' ),
									'position'     => stage_get_fallback( 'header.desktop.position' ),
									'fullwidth'    => stage_get_fallback( 'header.desktop.fullwidth' ),
									'logo'         => get_custom_logo(),
									'site_name'    => get_bloginfo( 'name' ),
									'site_tagline' => get_bloginfo( 'description' ),
									'show_tagline' => stage_get_fallback( 'header.branding.show_tagline' ),
								)
							);
						},
					)
				);
			}
		);
	}



	public function typography() {
		// Set section & settings ID
		$section = self::$panel . '_typography';

		new Section(
			$section,
			array(
				'title'    => esc_attr__( 'Typography', 'stage' ),
				'panel'    => 'header',
				'priority' => 30,
			)
		);

		Kirki::add_field(
			self::$config,
			array(
				'type'        => 'typography',
				'settings'    => $section,
				'label'       => esc_html__( 'Header Typo', 'stage' ),
				'section'     => $section,
				'default'     => array(
					'font-family' => '',
					'font-weight' => '',
				),
				'choices'     => array(
					'fonts' => stage_get_default( 'global.typo.choices.fonts' ),
				),
				'priority'    => 10,
				'transport'   => 'auto',
				'input_attrs' => array(
					'font-family' => array(
						'data-sync-master' => 'global_typo_copy[font-family]',
					),
					'font-weight' => array(
						'data-sync-master' => 'global_typo_copy[font-weight]',
					),
				),
				'output'      => array(
					array(
						'choice'   => 'font-family',
						'element'  => 'header.main-header',
						'property' => '--copy-font-family',
					),
					array(
						'choice'   => 'font-weight',
						'element'  => 'header.main-header',
						'property' => '--heading-font-weight',
					),
				),
			)
		);
	}

	public function colors() {
		// Set section & settings ID
		$section = self::$panel . '_colors';

		/**
		 * Add Section and fields for Header Style
		 */
		new Section(
			$section,
			array(
				'title'       => esc_attr__( 'Colors', 'stage' ),
				'panel'       => self::$panel,
				'priority'    => 20,
			)
		);

		Kirki::add_field(
			self::$config,
			array(
				'type'        => 'multicolor',
				'settings'    => $section,
				'label'       => esc_attr__( 'Main Menu', 'stage' ),
				'section'     => $section,
				'transport'   => 'auto',
				'choices'     => array(
					'menu_bg'         => esc_attr__( 'Background Color', 'stage' ),
					'menu_item'       => esc_attr__( 'Menu Item Color', 'stage' ),
					'menu_item_hover' => esc_attr__( 'Item Hover & Active', 'stage' ),
				),
				'default'     => array(
					'menu_bg'         => '',
					'menu_item'       => '',
					'menu_item_hover' => '',
				),
				'alpha'       => true,
				'input_attrs' => array(
					'menu_bg'         => array(
						'data-sync-master' => 'global_colors_main[body]', // add 'data-mode' attribute to input element
					),
					'menu_item'       => array(
						'data-sync-master' => 'global_colors_main[copy]', // add 'data-mode' attribute to input element
					),
					'menu_item_hover' => array(
						'data-sync-master' => 'global_colors_main[primary]', // add 'data-mode' attribute to input element
					),
				),
				'output'      => array(
					array(
						'choice'   => 'menu_bg',
						'element'  => 'header.main-header',
						'property' => '--color-body',
						'context'  => array(
							'front',
						),
					),
					array(
						'choice'   => 'menu_item',
						'element'  => 'header.main-header',
						'property' => '--color-copy',
						'context'  => array(
							'front',
						),
					),
					array(
						'choice'   => 'menu_item_hover',
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
}
