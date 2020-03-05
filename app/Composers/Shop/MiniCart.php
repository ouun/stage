<?php

namespace Stage\Composers\Shop;

use Roots\Acorn\View\Composer;

class MiniCart extends Composer {

	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = array(
		'layouts.header.shop.mini-cart',
	);

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
	public function with() {
		global $product;

		return array(
			'minicart' => $this->get_mini_cart_html(),
		);
	}

	function get_mini_cart_html() {
		ob_start();
			the_widget( 'WC_Widget_Cart', 'title=' );
		return ob_get_clean();
	}
}
