<?php

namespace Stage\View\Composers;

use Illuminate\View\View;
use Roots\Acorn\View\Composer;
use function Stage\stage_is_shop_active;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.single.title',
        'partials.archive.title',
        'partials.single.content',
        'partials.single.content-*',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function override()
    {
        return [
            'title' => $this->title(),
	        'align' => $this->align(),
        ];
    }

    /**
     * Returns the post title.
     *
     * @return string
     */
    public function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'stage');
        }

        if (is_tax() || is_category()) {
            return get_the_archive_title();
        }

        if (is_archive()) {
            return post_type_archive_title('', false);
        }

        if (is_search()) {
            return sprintf(
            /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'stage'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Not Found', 'stage');
        }

        return get_the_title();
    }

	/**
	 * Set logic to align posts and pages
	 * Adds class '.alignwide', '.alignscreen' or '.alignfull'
	 *
	 * @return mixed|void|null Alignment class
	 */
    public function align() {

	    $align = 'align';

	    // Wide align data privacy
	    if( is_privacy_policy() ) {
		    $align = 'alignwide';
	    }

    	// Wide align shop cart & checkout
    	if(stage_is_shop_active()) {
    		if(is_cart() || is_checkout()) {
    			$align = 'alignwide';
		    }
	    }

    	return apply_filters('stage_single_align_content', $align);

    }
}
