<?php
/**
 * Toggle Customizer Control
 */

namespace Stage\Customizer\Controls;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if WP_Customize_Control does not exist.
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * This class is for the toggle control in the Customizer.
 *
 * @access public
 */
class ToggleControl extends \WP_Customize_Control {

	/**
	 * The type of customize control.
	 *
	 * @access public
	 * @since  1.3.4
	 * @var    string
	 */
	public $type = 'toggle';

	/**
	 * Enqueue scripts and styles.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( 'stage/customizer/css', \Roots\asset( 'styles/customizer/controls.css' )->uri(), false, '1.0.0', 'all' );
		wp_enqueue_script( 'stage/customizer/toggle-js', \Roots\asset( 'scripts/customizer/toggle.js' )->uri(), array( 'jquery' ), '1.0.0', true );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// The setting value.
		$this->json['id']                    = $this->id;
		$this->json['value']                 = $this->value();
		$this->json['link']                  = $this->get_link();
		$this->json['defaultValue']          = $this->setting->default;
		$this->json['input_attrs']['toggle'] = ( isset( $this->input_attrs['toggle'] ) ) ? $this->input_attrs['toggle'] : '';
	}

	/**
	 * Don't render the content via PHP.  This control is handled with a JS template.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function render_content() {}

	/**
	 * An Underscore (JS) template for this control's content.
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see    WP_Customize_Control::print_template()
	 *
	 * @access protected
	 * @since  1.0.0
	 * @return void
	 */
	protected function content_template() {
		?>
		<div class="components-base-control components-toggle-control">
			<div class="components-base-control__field">
				<# if ( data.label ) { #>
				<label for="inspector-toggle-control-{{ data.id }}" class="components-toggle-control__label customize-control-title">{{ data.label }}</label>
				<# } #>
				<span class="components-form-toggle <# if ( data.value ) { #>is-checked<# } #>">
					<input class="components-form-toggle__input" id="inspector-toggle-control-{{ data.id }}" type="checkbox" value="{{ data.value }}" data-toggles="{{ data.input_attrs['toggle'] }}" {{{ data.link }}} <# if ( data.value ) { #> checked="checked" <# } #> />
					<span class="components-form-toggle__track"></span>
					<span class="components-form-toggle__thumb"></span>
					<# if ( data.value ) { #>
					<svg class="components-form-toggle__on" width="2" height="6" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 6">
						<path d="M0 0h2v6H0z"></path>
					</svg>
					<# } else { #>
					<svg class="components-form-toggle__off" width="6" height="6" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6">
						<path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path>
					</svg>
					<# } #>
				</span>
			</div>
			<# if ( data.description ) { #>
			<p id="inspector-toggle-control-{{ data.id }}__help" class="components-base-control__help customize-panel-description description">{{ data.description }}</p>
			<# } #>
		</div>
		<?php
	}

	/**
	 * Toggle sanitization callback example.
	 *
	 * Sanitization callback for 'toggle' type controls. This callback sanitizes `$checked`
	 * as a boolean value, either TRUE or FALSE.
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	public static function sanitize_toggle( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}
}
