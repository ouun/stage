<?php

namespace Stage\Customizer\Panels;

use Kirki\Panel;

class SettingsPanel
{

    // Set panel ID
    private static $panel  = 'settings';

    public function __construct()
    {

        /**
         * Set up the panel
         */
        new Panel(self::$panel, array(
            'priority'    => 130,
            'title'       => esc_html__('Website Settings', 'stage'),
        ));
    }
}
