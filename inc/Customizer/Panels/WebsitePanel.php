<?php
namespace Stage\Customizer\Panels;

use function Roots\asset;

class WebsitePanel {


	// Set panel ID
	static $panel  = 'website';
	static $config = 'website_conf';

	public function __construct() {

		/**
		 * Add some style
		 */
		add_action(
			'customize_controls_enqueue_scripts',
			function () {
				wp_add_inline_style( 'customize-controls', '#accordion-panel-nav_menus { margin-top: 15px }' );
			}
		);

		/**
		 * Theme customizer
		 */
		add_action(
			'customize_register',
			function ( \WP_Customize_Manager $wp_customize ) {
				$wp_customize->remove_control( 'blogname' );
			},
			5
		);

		/**
		 * Rearrange native WP sections / fields
		 * to own structure
		 */
		add_action(
			'customize_register',
			function ( \WP_Customize_Manager $wp_customize ) {
				// Remove Sections
				$wp_customize->remove_section( 'colors' );

				// Header Media -> Layout/Header Media
				$background_image = $wp_customize->get_section( 'background_image' );
				if ( $background_image ) {
					$background_image->panel = 'global';
				}

				// Front-Page Settings -> Settings/Front-Page Settings
				$static_front_page = $wp_customize->get_section( 'static_front_page' );
				if ( $static_front_page ) {
					$static_front_page->panel = 'settings';
				}

				// Front-Page Settings -> Settings/Front-Page Settings
				$custom_css = $wp_customize->get_section( 'custom_css' );
				if ( $custom_css ) {
					$custom_css->panel = 'settings';
				}

				// Shop Settings Title
				$shop = $wp_customize->get_panel( 'woocommerce' );
				if ( $shop ) {
					$shop->title = __( 'Shop Settings', 'stage' );
				}
			},
			20
		);
	}
}
