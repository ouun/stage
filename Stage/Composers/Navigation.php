<?php

namespace App\Composers;

use Log1x\Navi\NaviFacade as Navi;
use Roots\Acorn\View\Composer;

class Navigation extends Composer
{
	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = [
		'partials.header.navigation.*',
		'partials.navigation.*'
	];

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
	public function with()
	{
		return [
			'navigation' => $this->navigation(),
		];
	}

	/**
	 * Returns the primary navigation.
	 *
	 * @return array
	 */
	public function navigation()
	{
		return Navi::build('primary_navigation')->toArray();
	}
}
