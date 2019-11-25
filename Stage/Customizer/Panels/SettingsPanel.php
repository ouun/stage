<?php
namespace App\Customizer\Panels;

use Kirki\Compatibility\Kirki;

class SettingsPanel {


	// Set panel ID
	static $panel  = 'settings';
	static $config = 'settings_conf';

	public function __construct() {

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
				'priority' => 130,
				'title'    => esc_attr__( 'Website Settings', 'stage' ),
			)
		);

	}
}
