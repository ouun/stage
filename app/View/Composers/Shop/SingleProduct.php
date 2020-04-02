<?php

namespace Stage\View\Composers\Shop;

use Roots\Acorn\View\Composer;

class SingleProduct extends Composer
{

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = array(
        'shop.content-product',
        'shop.content-single-product',
    );

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        global $product;

        return array(
            'product'           => $product,
            'placeholder'       => false,
            'loaderNamespace'   => 'shop',
            'id'                => get_the_ID(),
            'product_class'     => esc_attr(implode(' ', wc_get_product_class('', get_the_ID()))),
            'password_required' => post_password_required(),
            'password_form'     => get_the_password_form(),
        );
    }
}
