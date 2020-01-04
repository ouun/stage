<?php

namespace Stage\Composers;

use Roots\Acorn\View\Composer;

use function Stage\stage_get_features_status;

class App extends Composer
{


    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = array(
        '*',
    );

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return array(
            'siteName' => $this->siteName(),
            'features' => stage_get_features_status(),
        );
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name', 'display');
    }
}
