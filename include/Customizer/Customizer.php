<?php

namespace Stage\Customizer;

use Stage\Customizer\Panels\ArchivesPanel;
use Stage\Customizer\Panels\FooterPanel;
use Stage\Customizer\Panels\GlobalPanel;
use Stage\Customizer\Panels\HeaderPanel;
use Stage\Customizer\Panels\SettingsPanel;
use Stage\Customizer\Panels\WebsitePanel;
use Stage\Customizer\Panels\WebsiteFeatures;
use Roots\Acorn\ServiceProvider;
use WP_Customize_Manager;

class Customizer extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 * todo: This should not be in register();
	 *
	 * @return void
	 */
	public function register() {
		// Set available viewport previews
		add_filter( 'customize_previewable_devices', '__return_empty_array' );

		// Disable Kirki Telemetry
		add_action( 'kirki_telemetry', '__return_false' );

		// Force downloading Google Fonts for GDPR
		add_filter( 'kirki_use_local_fonts', '__return_true' );

		// Do not inline CSS, build with action
		add_filter( 'kirki_output_inline_styles', '__return_false' );

		// Fix Kirki URL handling for local development, if in symlink folder
		add_filter(
			'kirki_path_url',
			function ( $url, $path ) {
				if ( defined( 'WP_ENV' ) && WP_ENV !== 'production' && substr( $url, 0, 4 ) !== 'http' ) {
					$url = get_template_directory_uri() . explode( get_template(), $path )[1];
				}
				return $url;
			},
			10,
			2
		);

		// Rename the css output action
		add_filter(
			'kirki_styles_action_handle',
			function () {
				return 'customizer-style';
			}
		);

		/**
		 * Filter the Kirki Standard Fonts
		 *
		 * @return array Standard Fonts
		 */
		add_filter( 'kirki_fonts_standard_fonts', function( $standard_fonts ) {

			// Remove Monospace font
			unset( $standard_fonts['monospace'] );

			$stage_defaults = [
				'serif'      => [
					'label' => esc_html__( 'System Serif', 'stage' ),
					'stack' => 'Constantia, Lucida Bright, Lucidabright, Lucida Serif, Lucida, DejaVu Serif, Bitstream Vera Serif, Liberation Serif, Georgia, serif',
				],
				'sans-serif' => [
					'label' => esc_html__( 'System Sans-Serif', 'stage' ),
					'stack' => 'system-ui, BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif',
				],
			];

			return apply_filters( 'stage_standard_fonts', wp_parse_args( $stage_defaults, $standard_fonts ) );

		}, 1, 20 );

		/**
		 * Register Kirki Modules
		 *
		 * @since 1.0
		 * @return void
		 */
		if ( is_customize_preview() ) {
			$modules = array(
				'core'               => '\Kirki\Compatibility\Kirki',
				'postMessage'        => '\Kirki\Module\Postmessage',
				'css'                => '\Kirki\Module\CSS',
				'selective-refresh'  => '\Kirki\Module\Selective_Refresh',
				'field-dependencies' => '\Kirki\Module\Field_Dependencies',
				'webfonts'           => '\Kirki\Module\Webfonts',
				'tooltips'           => '\Kirki\Module\Tooltips',
				'sync'               => '\Kirki\Module\Sync',
				'font-uploads'       => '\Kirki\Module\FontUploads',
				// 'preset'             => '\Kirki\Module\Preset',
				// 'gutenberg'          => '\Kirki\Module\Editor_Styles',
			);
		} elseif ( ! is_admin() && ! is_customize_preview() ) {
			$modules = array(
				'core'         => '\Kirki\Compatibility\Kirki',
				'webfonts'     => '\Kirki\Module\Webfonts',
				'css'          => '\Kirki\Module\CSS',
				'font-uploads' => '\Kirki\Module\FontUploads',
			);
		} elseif ( is_admin() ) {
			$modules = array(
				'core'         => '\Kirki\Compatibility\Kirki',
				'gutenberg'    => '\Kirki\Module\Editor_Styles',
				'css'          => '\Kirki\Module\CSS',
				'webfonts'     => '\Kirki\Module\Webfonts',
				'font-uploads' => '\Kirki\Module\FontUploads',
			);
		}

		if ( ! empty( $modules ) && is_array( $modules ) ) {
			foreach ( $modules as $key => $module ) {
				if ( class_exists( $module ) ) {
					new $module();
				} else {
					wp_die( 'Oh no! We are missing a Module Class for the Customizer: ' . $module );
				}
			}
		}

		/**
		 * Registers the controls and whitelists them for JS templating.
		 *
		 * @since 1.0
		 * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
		 * @return void
		 */
		add_action(
			'customize_register',
			function ( WP_Customize_Manager $wp_customize ) {
				/**
				 * Registers the control and whitelists it for JS templating.
				 * Only needs to run once per control-type/class,
				 * not needed for every control we add.
				 */
				$controls = array(
					'\Stage\Customizer\Controls\LayoutControl',
					'\Stage\Customizer\Controls\RangeValueControl',
					'\Stage\Customizer\Controls\ToggleControl',
					'\Kirki\Control\Base', // Activating this might overwrite normal text inputs
					'\Kirki\Control\Checkbox',
					'\Kirki\Control\Checkbox_Switch',
					'\Kirki\Control\ReactColor',
					'\Kirki\Control\Custom',
					'\Kirki\Control\Generic',
					'\Kirki\Control\Image',
					'\Kirki\Control\ReactSelect',
				);

				foreach ( $controls as $control ) {
					if ( class_exists( $control ) ) {
						$wp_customize->register_control_type( $control );
					} else {
						\Roots\wp_die( 'Oh no! We are missing a Control Class for the Customizer: ' . $control );
					}
				}
			}
		);
	}

	function boot() {
		/**
		 * Register Panels
		 */
		new WebsitePanel(); // HIDES AND MOVES CONTROLS!
		new WebsiteFeatures(); // HIDES AND MOVES CONTROLS!
		new SettingsPanel();
		new GlobalPanel();
		new HeaderPanel();
		new ArchivesPanel();
		new FooterPanel();

		/**
		 * Include customizer.js
		 */
		add_action(
			'customize_controls_enqueue_scripts',
			function () {
				wp_enqueue_script( 'stage/customize-controls.js', \Roots\asset( 'scripts/customizer/customize-controls.js', 'stage' )->uri(), array( 'customize-controls', 'jquery' ), null, true );
			}
		);

		/**
		 * Include customizer-preview.js
		 */
		add_action(
			'customize_preview_init',
			function () {
				wp_enqueue_script( 'stage/customize-preview.js', \Roots\asset( 'scripts/customizer/customize-preview.js', 'stage' )->uri(), array( 'customize-preview' ), null, true );
			}
		);

		/**
		 * Overwrite customer style
		 */
		add_action(
			'wp_enqueue_scripts',
			function() {
				if ( is_customize_preview() ) {
					wp_enqueue_style( 'stage/customizer/css', \Roots\asset( 'styles/customizer/customizer.css', 'stage' )->uri(), array( 'customize-preview' ), '1.0.0', 'all' );
				}
			},
			20
		);
	}
}
