<?php

/**
 * Range Value Control
 *
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 * @phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols
 * @phpcs:disable Generic.Files.LineLength.TooLong
 */

namespace Stage\Customizer\Controls;

/**
 * This class is for the range value control in the Customizer.
 *
 * @access public
 */
class RangeValueControl extends \WP_Customize_Control
{


    /**
     * The type of customize control.
     *
     * @access public
     * @since  1.0.0
     * @var    string
     */
    public $type = 'range-value';

    /**
     * Enqueue scripts and styles.
     *
     * @access public
     * @since  1.0.0
     * @return void
     */
    public function enqueue()
    {
        wp_enqueue_style(
            'stage/customizer/css',
            \Roots\asset('styles/customizer/controls.css', 'stage')->uri(),
            false,
            '1.0.0',
            'all'
        );

        wp_enqueue_script(
            'stage/customizer/range-value-js',
            \Roots\asset('scripts/customizer/range-value.js', 'stage')->uri(),
            array( 'jquery' ),
            '1.0.0',
            true
        );
    }

    /**
     * Add custom parameters to pass to the JS via JSON.
     *
     * @access public
     * @since  1.0.0
     * @return void
     */
    public function to_json()
    {
        parent::to_json();

        // The setting value.
        $this->json['id']                    = $this->id;
        $this->json['value']                 = $this->value();
        $this->json['link']                  = $this->get_link();
        $this->json['defaultValue']          = $this->setting->default;
        $this->json['input_attrs']['min']    = ( isset($this->input_attrs['min']) ) ? $this->input_attrs['min'] : '0';
        $this->json['input_attrs']['max']    = ( isset($this->input_attrs['max']) ) ? $this->input_attrs['max'] : '100';
        $this->json['input_attrs']['step']   = ( isset($this->input_attrs['step']) ) ? $this->input_attrs['step'] : '1';
        $this->json['input_attrs']['suffix'] = ( isset($this->input_attrs['suffix']) ) ? $this->input_attrs['suffix'] : '';
        $this->json['input_attrs']['prefix'] = ( isset($this->input_attrs['prefix']) ) ? $this->input_attrs['prefix'] : '';
    }

    /**
     * Don't render the content via PHP.  This control is handled with a JS template.
     *
     * @access public
     * @since  1.0.0
     * @return void
     */
    public function render_content()
    {
    }

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
    protected function content_template()
    {
        ?>
        <div class="components-base-control components-range-value-control">

            <div class="components-base-control__field">
                <# if ( data.label ) { #>
                <label for="inspector-range-value-control-{{ data.id }}" class="components-range-value-control__label customize-control-title">{{ data.label }}</label>
                <# } #>
                <div class="components-form-range-slider <# if ( data.value ) { #>is-custom<# } #>">
                    <span class="components-form-range-slider__container">
                        <a type="button" value="reset" class="components-form-range-slider__reset"><span>Reset {{ data.label }}</span></a>
                        <input type="range" class="components-form-range-slider__range-input" value="{{ data.value }}" data-default-value="{{ data.defaultValue }}" min="{{ data.input_attrs['min'] }}" max="{{ data.input_attrs['max'] }}" step="{{ data.input_attrs['step'] }}" {{{ data.link }}}>
                        <span class="components-form-range-slider__display">
                            <# if ( data.input_attrs['prefix'] ) { #>
                                <em>{{ data.input_attrs['prefix'] }}</em>
                            <# } #>
                                <input type="number" id="inspector-range-value-control-{{ data.id }}" class="components-form-range-slider__number-input" value="{{ data.value }}" data-default-value="{{ data.defaultValue }}" min="{{ data.input_attrs['min'] }}" max="{{ data.input_attrs['max'] }}" {{{ data.link }}} />
                            <# if ( data.input_attrs['suffix'] ) { #>
                                <em>{{ data.input_attrs['suffix'] }}</em>
                            <# } #>
                        </span>
                    </span>
                </div>
            </div>

            <# if ( data.description ) { #>
            <p id="inspector-range-value-control-{{ data.id }}__help" class="components-base-control__help customize-panel-description description">{{ data.description }}</p>
            <# } #>
        </div>
        <?php
    }
}
