<?php

namespace Stage\View\Composers\Partials\Footer;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class Navigation extends Composer
{

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = array(
        'layouts.footer.navigation'
    );

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return array(
            'navigation' => $this->navigation(),
        );
    }

    /**
     * Returns the primary navigation.
     *
     * @return array
     */
    public function navigation()
    {
        if (! has_nav_menu('footer_navigation')) {
            return array();
        }

        return Navi::build('footer_navigation')->toArray();
    }
}
