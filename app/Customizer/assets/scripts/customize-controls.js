/**
 * This file allows you to add functionality to the Theme Customizer
 * panels.
 *
 * {@link https://codex.wordpress.org/Theme_Customization_API}
 * {@link https://developer.wordpress.org/themes/customize-api/the-customizer-javascript-api/#preview-js-and-controls-js}
 */
( function ( $, api, stage,  { __ } ) {

    api.bind('ready', function () {

      // Control Panel <- Previewer
        api.previewer.bind('preview-to-control', function ( data ) {
            console.log('Data from preview window: ', data);
        });

      // Control Panel -> Previewer
        api.previewer.bind('ready', function () {
            api.previewer.send('control-to-preview', 'control-to-preview');
        });

      /**
       * Edit Archive Settings, change view
       * @see https://make.xwp.co/2016/07/21/navigating-to-a-url-in-the-customizer-preview-when-a-section-is-expanded/
       */
        $.each(stage.archives, (post_type, data) => {
            api.section('archives_' + post_type, function ( section ) {
                let previousUrl, clearPreviousUrl, previewUrlValue;
                previewUrlValue = api.previewer.previewUrl;
                clearPreviousUrl = function () {
                    previousUrl = null;
                };

                section.expanded.bind(function ( isExpanded ) {
                    if ( isExpanded ) {
                        previousUrl = previewUrlValue.get();
                        previewUrlValue.set(data.url);
                        previewUrlValue.bind(clearPreviousUrl);
                    } else {
                        previewUrlValue.unbind(clearPreviousUrl);
                        if ( previousUrl ) {
                            previewUrlValue.set(previousUrl);
                        }
                    }
                });
            });
        });

      /**
       * Change to new posts page after setting new setting
       */
        api('page_for_posts', function ( setting ) {
            setting.bind(function ( pageId ) {
                pageId = parseInt(pageId, 10);
                if ( pageId > 0 ) {
                    api.previewer.previewUrl.set(api.settings.url.home + '?page_id=' + pageId);
                }
            });
        });

      /**
       * Add Reset Button to Controls
       */
        api.control.each(function ( control ) {

            let isSyncedControl = control.params.inputAttrs !== undefined && control.params.inputAttrs.toString().match(/data-sync-master="(.*?)"/);

            if (control.params.type === 'kirki-react-color' || isSyncedControl) {
                let controlLabel = control.params.label;
                let controlDescription = control.params.description;

                const append = '<span class="stage-reset-value hide"><span>' + __('Reset to default', 'stage') + '</span></span>';

                // Support React- & Non-React controls
                if ( $(control.selector + ' label').length ) {
                  // Works for react field
                    if ( controlLabel !== '' ) {
                        $(control.selector + ' label').append(append);
                    } else if ( controlDescription !== '' ) {
                        control.params.description = controlDescription + append;
                    }
                } else {
                  // Kirki Backwards compatibility
                    if ( controlLabel !== '' ) {
                        control.params.label = controlLabel + append;
                    } else if ( controlDescription !== '' ) {
                        control.params.description = controlDescription + append;
                    }
                }

                // Add event listener
                $(control.selector).on('click', '.stage-reset-value', function () {
                    // Reset to master value if a slave
                    // let defaultValue = !isSyncedControl ? control.params.default : wp.customize.control(control.params.masterID).setting.get();
                    // control.setting.set(defaultValue);
                    control.setting.set(control.params.default);
                });

                // On change
                api(control.id, function ( value ) {
                    value.bind(function ( newValue ) {
                        showResetButton(control, newValue, isSyncedControl);
                    });
                });
            }
        });

        function showResetButton( control, newValue, isSyncedControl )
        {
            let defaultValue = !isSyncedControl ? control.params.default : wp.customize.control(control.params.masterID).setting.get();

            if ( defaultValue === newValue ) {
                $(control.selector).find('.stage-reset-value').addClass('hide');
            } else {
                $(control.selector).find('.stage-reset-value').removeClass('hide');
            }
        }
    });

} )(jQuery, wp.customize, window.stage, wp.i18n);
