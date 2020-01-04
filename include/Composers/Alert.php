<?php

namespace Stage\Composers;

use Roots\Acorn\View\Composer;

class Alert extends Composer
{

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = array(
        'components.alert',
    );

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return array(
            'type' => $this->type(),
        );
    }

    /**
     * Returns the alert type.
     *
     * @return string
     */
    public function type()
    {
        return $this->data->get('type', 'primary');
    }
}
