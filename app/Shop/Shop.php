<?php

/**
 * Init WC related Filters & Actions
 *
 * @package Stage\Shop
 */

namespace Stage\Shop;

/**
 * Class Shop
 *
 * @package Stage\Shop
 */
class Shop
{
    /**
     * Self init Shop
     *
     * @var Shop
     */
    private static $instance;

    /**
     * Self init Shop Class
     *
     * @return Shop
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Shop constructor.
     */
    private function __construct()
    {
        if (self::is_woo_active()) {
            add_action(
                'init',
                function () {
                    $filters  = new Filters();
                    $checkout = new Checkout();
                    $extras   = new Extras();
                }
            );
        }
    }

    /**
     * Check if WC is active
     *
     * @return bool
     */
    public static function is_woo_active()
    {
        return defined('WC_ABSPATH');
    }
}
