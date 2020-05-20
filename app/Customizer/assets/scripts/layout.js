( function ( $, api ) {

    api.controlConstructor['layout'] = api.Control.extend({

        ready: function () {
            const control = this;

            api(control.id, function ( value ) {
                value.bind(function ( newLayout ) {
                    // Set the new value
                    control.setting.set(newLayout);
                });
            });

            control.container.on('click', '.layout-switcher', function (e) {

                const wrapper = $(this).next($('.layout-switcher__wrapper'));

                e.preventDefault();

                wrapper.toggleClass('open');
              /* global layoutLocalization */
                if ( $(this).text() === layoutLocalization.open ) {
                    $(this).text(layoutLocalization.close);
                } else {
                    $(this).text(layoutLocalization.open);
                }
            });
        },
    });

} )(jQuery, wp.customize);
