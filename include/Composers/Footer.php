<?php

namespace Stage\Composers;

use Roots\Acorn\View\Composer;

use function Stage\stage_get_fallback;

class Footer extends Composer
{


    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = array(
        'partials.footer',
    );

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return array(
            'copyright' => stage_get_fallback('footer.settings.copyright'),
        );
    }
}
