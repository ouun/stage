<?php

namespace Stage\View\Composers;

use Roots\Acorn\View\Composer;

use function Stage\stage_is_shop_active;

class Alignment extends Composer
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
            'align' => $this->align(),
        );
    }

    /**
     * Set logic to align posts and pages
     * Adds class '.alignwide', '.alignscreen' or '.alignfull'
     *
     * @return mixed|void|null Alignment class
     */
    public function align()
    {

        // Align wide by default
        $align = 'alignwide';

        // Wide align single pages & posts
        if (is_singular(['post', 'page'])) {
            $align = 'align';
        }

        // Screen align WC Account page
        if (stage_is_shop_active()) {
            if (is_account_page() && is_user_logged_in()) {
                $align = 'alignscreen';
            }
        }

        return apply_filters('stage_single_align_content', $align);
    }
}
