<?php

namespace App\Customizer\Panels;

use App\Customizer\Controls\ToggleControl;
use Kirki\Compatibility\Kirki;
use WP_Customize_Manager;
use function App\stage_get_default;

class WebsiteFeatures {

	// Set panel ID
	static $panel  = 'features';
	static $config = 'features_conf';

	public function __construct() {

		/**
		 * Set up config for panel
		 */
		Kirki::add_config(
			self::$config,
			array(
				'capability'        => 'edit_theme_options',
				'option_type'       => 'theme_mod',
				'gutenberg_support' => false,
				'disable_output'    => false,
			)
		);

		/**
		 * Set up the panel
		 */
		Kirki::add_panel(
			self::$panel,
			array(
				'priority'    => 200,
				'title'       => esc_html__( 'Website Features', 'stage' ),
				'description' => esc_html__( 'Activate & customize website features.', 'stage' ),
			)
		);

		/**
		 * Init sections with fields
		 */
		$this->loader();
		$this->lazy();
		$this->infinity();
		$this->gallery();
	}


	public function loader() {
		// Set section & settings ID
		$section = self::$panel . '.loader';

		Kirki::add_section(
			$section,
			array(
				'title'      => esc_html__( 'Dynamic Page Loading & Transitions', 'stage' ),
				'capability' => 'edit_theme_options',
				'priority'   => 10,
				'panel'      => self::$panel,
			)
		);

		/**
		 * Feature Activation Toggle
		 */
		$this->addFeatureActivationToggle( $section );
	}


	public function lazy() {
		// Set section & settings ID
		$section = self::$panel . '.lazy';

		Kirki::add_section(
			$section,
			array(
				'title'      => esc_html__( 'Lazy Load Media', 'stage' ),
				'capability' => 'edit_theme_options',
				'priority'   => 10,
				'panel'      => self::$panel,
			)
		);

		/**
		 * Feature Activation Toggle
		 */
		$this->addFeatureActivationToggle( $section );
	}


	public function infinity() {
		// Set section & settings ID
		$section = self::$panel . '.infinity';

		Kirki::add_section(
			$section,
			array(
				'title'      => esc_html__( 'Infinite scrolling for Archives', 'stage' ),
				'capability' => 'edit_theme_options',
				'priority'   => 10,
				'panel'      => self::$panel,
			)
		);

		/**
		 * Feature Activation Toggle
		 */
		$this->addFeatureActivationToggle( $section );
	}


	public function gallery() {
		// Set section & settings ID
		$section = self::$panel . '.gallery';

		Kirki::add_section(
			$section,
			array(
				'title'      => esc_html__( 'Galleries', 'stage' ),
				'capability' => 'edit_theme_options',
				'priority'   => 10,
				'panel'      => self::$panel,
			)
		);

		/**
		 * Feature Activation Toggle
		 */
		$this->addFeatureActivationToggle( $section );

	}


	function addFeatureActivationToggle( $section ) {
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

				$wp_customize->add_setting(
					$section . '.activate',
					array(
						'type'              => 'theme_mod',
						'capability'        => 'edit_theme_options',
						'default'           => stage_get_default( $section . '.activate' ),
						'transport'         => 'refresh',
						'sanitize_callback' => array( 'App\Customizer\Controls\ToggleControl', 'sanitize_toggle' ),
					)
				);

				$wp_customize->add_control(
					new ToggleControl(
						$wp_customize,
						$section . '.activate',
						array(
							'label'    => esc_html__( 'Activate', 'stage' ),
							'section'  => $section,
							'settings' => $section . '.activate',
							'type'     => 'toggle',
						)
					)
				);

			}
		);
	}

}
