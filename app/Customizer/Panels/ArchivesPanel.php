<?php
namespace Stage\Customizer\Panels;

use WP_Customize_Manager;
use Stage\Composers\Archive;
use Stage\Customizer\Controls\LayoutControl;
use Stage\Customizer\Controls\ToggleControl;
use Kirki\Compatibility\Kirki;
use Kirki\Section;
use function Stage\stage_get_default;
use function Stage\stage_get_fallback_template;

class ArchivesPanel {

	// Set panel ID
	static $panel  = 'archives';
	static $config = 'archives_conf';

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
				'priority' => 20,
				'title'    => esc_attr__( 'Archives', 'stage' ),
			)
		);

		foreach ( Archive::archives_to_register() as $archive ) {
			// Set section & settings ID
			$section = self::$panel . '_' . $archive->name;

			/**
			 * Add Section and fields for Header Style
			 */
			new Section(
				$section,
				array(
					'title' => $archive->label,
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
				function( WP_Customize_Manager $wp_customize ) use ( $section, $archive ) {
					// Archive layout settings
					$id                = 'archive.' . $archive->name . '.layout';
					$config            = Archive::get_post_type_archive_config_key( $archive->name ) . '.layout';
					$display_configs[] = $id;

					$wp_customize->add_setting(
						$id,
						array(
							'type'              => 'theme_mod',
							'capability'        => 'edit_theme_options',
							'default'           => stage_get_default( $config ),
							'transport'         => 'postMessage', // Or postMessage.
							'sanitize_callback' => function( $layout ) {
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
								'label'   => esc_html__( 'Grid Layout', 'stage' ),
								'section' => $section,
								'choices' => array(
									'cards'   => \Roots\asset( 'images/customizer/grid-cards.svg' )->uri(),
									'modern'  => \Roots\asset( 'images/customizer/grid-modern.svg' )->uri(),
									'masonry' => \Roots\asset( 'images/customizer/grid-masonry.svg' )->uri(),
								),
							)
						)
					);

					// Archive item display settings
					foreach ( Archive::combine_display_config() as $key => $display_config ) {
						$id                = 'archive_' . $archive->name . '_' . $key;
						$display_configs[] = $id;

						$wp_customize->add_setting(
							$id,
							array(
								'type'              => 'theme_mod',
								'capability'        => 'edit_theme_options',
								'default'           => $display_config,
								'transport'         => 'postMessage', // Or postMessage.
								'sanitize_callback' => array( 'App\Customizer\Controls\ToggleControl', 'sanitize_toggle' ),
							)
						);

						$wp_customize->add_control(
							new ToggleControl(
								$wp_customize,
								$id,
								array(
									'label'   => __( $key, 'stage' ),
									'section' => $section,
								)
							)
						);
					}

					// Add common refresh partial
					if ( ! empty( $display_configs ) ) {
						$wp_customize->selective_refresh->add_partial(
							$id,
							array(
								'selector'            => 'main.' . $archive->name . '-archive .archive-wrap',
								'settings'            => $display_configs,
								'container_inclusive' => false,
								'render_callback'     => function () use ( $archive, $id, $display_configs ) {
									$config = Archive::get_post_type_archive_config_key( get_post_type() ) . '.layout';

									return stage_get_fallback_template(
										$config,
										array(
											'test'   => $display_configs[0],
											'layout' => get_theme_mod( $display_configs[0] ),
										)
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
