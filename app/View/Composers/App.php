<?php

namespace Stage\View\Composers;

use Roots\Acorn\View\Composer;

use function Stage\post_types;
use function Stage\stage_get_features_status;
use function Stage\stage_is_shop_active;

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
            'loaderNamespace' => $this->loaderNamespace(),
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

    /**
     * Returns current JS loader namespace
     * @see https://barba.js.org/docs/userguide/markup/
     *
     * @return string
     */
    public function loaderNamespace()
    {
        if (stage_is_shop_active()) {
            // Checkout
            if (is_shop() || is_checkout() || is_cart() || is_product()) {
                return 'shop';
            }
        }

        return get_post_type();
    }
}
