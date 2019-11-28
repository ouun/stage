<?php

namespace Stage\Customizer\Panels;

use Stage\Customizer\Controls\ToggleControl;
use Kirki\Compatibility\Kirki;
use WP_Customize_Manager;
use function Stage\stage_get_default;

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
				'option_type'       => 'option',
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

	/**
	 * Helper function to add common controls
	 *
	 * @param $section
	 */
	function addFeatureActivationToggle( $section ) {

		/**
		 * Add Customizer settings & controls.
		 *
		 * @since 1.0
		 */
		Kirki::add_field( self::$config, [
			'type'        => 'checkbox_switch',
			'settings'    => $section . '.activate',
			'label'       => esc_html__( 'Activate', 'stage' ),
			'section'     => $section,
			'default'     => stage_get_default( $section . '.activate' ),
			'priority'    => 10,
		] );

	}

}
