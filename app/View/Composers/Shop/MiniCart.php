<?php

namespace Stage\View\Composers\Shop;

use Roots\Acorn\View\Composer;

use function Stage\stage_is_shop_active;

class MiniCart extends Composer
{

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = array(
        'layouts.header.partials.mini-cart',
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
            'minicart' => $this->getMiniCartHtml(),
            'mini_cart_default_menu' => $this->miniCartDefaultMenu()
        );
    }

    public function getMiniCartHtml()
    {
        ob_start();
            the_widget('WC_Widget_Cart', 'title=');
        return ob_get_clean();
    }

    public function miniCartDefaultMenu()
    {
        $out = '';

        if (!stage_is_shop_active()) {
            return '';
        }

        if (stage_is_shop_active() && ! is_admin()) {
            $items = array_merge(
                [
                    'cart' => [
                        'label' => sprintf(
                            __("Cart <sup class='cart-count count'>%d</sup>", 'stage'),
                            WC()->cart->get_cart_contents_count()
                        ),
                        'link'  => esc_url(wc_get_cart_url()),
                    ],
                ],
                wc_get_account_menu_items()
            );

            // Unset not needed links
            unset($items['edit-address']);
            unset($items['edit-account']);

            if (! is_user_logged_in()) {
                unset($items['customer-logout']);
            }

            foreach ($items as $slug => $item) {
                if (! isset($item['link']) || ! isset($item['label'])) {
                    $items[ $slug ] = [
                        'label' => esc_html($item),
                        'link'  => esc_url(wc_get_account_endpoint_url($slug)),
                        'icon'  => $slug,
                    ];
                }
            }

            $out .= '<ul class="colors-inherit">';
            foreach ($items as $slug => $item) {
                $out .= '<li class="nav-item px-2 py-2 border-t colors-inherit ' . $item['label'] . '">';
                // $out .= get_svg_icon($item['icon']);
                $out .= '<a href="' . $item['link'] . '">' . $item['label'] . '</a>';
                $out .= '</li>';
            }
            $out .= '</ul>';
        }

        return $out;
    }
}
