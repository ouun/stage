<?php

namespace Stage\Composers;

use Roots\Acorn\View\Composer;

class Title extends Composer
{
	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = [
		'partials.page-header'
	];

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
	public function with()
	{
		return [
			'title' => $this->title(),
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

		if (is_archive()) {
			return get_the_archive_title();
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
}
