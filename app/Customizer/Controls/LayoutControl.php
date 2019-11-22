<?php
/**
 * Range Value Control
 */

namespace App\Customizer\Controls;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if WP_Customize_Control does not exist.
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * This class is for the layout control in the Customizer.
 * Credits to Rich Tabor / Theme Beans
 *
 * @access public
 */
class LayoutControl extends \WP_Customize_Control {
	/**
	 * The type of customize control.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'layout';

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue() {

		wp_enqueue_style( 'stage/customizer/css', \Roots\asset( 'styles/customizer/controls.css' )->uri(), false, '1.0.0', 'all' );
		wp_enqueue_script( 'stage/customizer/layout-js', \Roots\asset( 'scripts/customizer/layout.js' )->uri(), array( 'jquery' ), '1.0.0', true );

		// Localization.
		$layout_control_l10n['open']  = esc_html__( 'Change', 'stage' );
		$layout_control_l10n['close'] = esc_html__( 'Close', 'stage' );

		wp_localize_script( 'stage/customizer/layout-js', 'layoutLocalization', $layout_control_l10n );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		// The setting value.
		$this->json['id']      = $this->id;
		$this->json['value']   = $this->value();
		$this->json['link']    = $this->get_link();
		$this->json['choices'] = $this->choices;

	}

	/**
	 * Don't render the control content from PHP, as it's rendered via JS on load.
	 */
	public function render_content() {}

	/**
	 * Render a JS template for the content of the control.
	 */
	protected function content_template() {
		?>

		<# if ( ! data.choices ) {
		return;
		} #>

		<div class="components-base-control components-layout-control">
			<div class="components-base-control__field">
				<# if ( data.label ) { #>
				<span class="components-layout-control__label customize-control-title">{{ data.label }}</span>
				<# } #>

				<# if ( data.description ) { #>
				<span class="customize-control-description">{{ data.description }}</span>
				<# } #>

				<button id="layout-switcher" class="button layout-switcher"><?php esc_html_e( 'Change', 'stage' ); ?></button>

				<div class="layout-switcher__wrapper">

					<# for ( choice in data.choices ) { #>

					<input type="radio" value="{{ choice }}" name="_customize-{{ data.id }}" id="{{ data.id }}-{{ choice }}" class="layout" {{{ data.link }}} <# if ( data.value === choice ) { #> checked="checked" <# } #> />

					<label for="{{ data.id }}-{{ choice }}" class="login-designer-templates__label">

						<div class="intrinsic">
							<div class="layout-screenshot" style="background-image: url( {{ data.choices[ choice ] }} );"></div>
						</div>

					</label>

					<# } #>

				</div>
			</div>
		</div>

		<?php
	}
}
