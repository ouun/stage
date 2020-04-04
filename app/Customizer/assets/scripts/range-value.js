( function ( $, api ) {

    api.controlConstructor['range-value'] = api.Control.extend({

        ready: function () {
            const control = this,
            reset    = control.container.find('.components-form-range-slider__reset'),
            range    = control.container.find('.components-form-range-slider__slider-input'),
            input    = control.container.find('.components-form-range-slider__number-input');

          // Change value on slide
            this.container.on('input', 'input[type="range"]', function () {
                let value = $(this).val();
              // Update the display value
                $(input).val(value);
                control.setting.set(value);
            });

            $(reset).on('click', function () {
                const defaultValue = $(input).data('default-value');
                $(input).val(defaultValue);
                $(range).val(defaultValue);
                control.setting.set(defaultValue);
            });
        }
    });
} )(jQuery, wp.customize);
