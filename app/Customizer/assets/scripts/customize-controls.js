/**
 * This file allows you to add functionality to the Theme Customizer
 * panels.
 *
 * {@link https://codex.wordpress.org/Theme_Customization_API}
 * {@link https://developer.wordpress.org/themes/customize-api/the-customizer-javascript-api/#preview-js-and-controls-js}
 */
( function ( $, api, stage ) {

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

    });

} )(jQuery, wp.customize, window.stage);
