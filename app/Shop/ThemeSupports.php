<?php

/**
 * Declare WooCommerce theme_supports()
 *
 * @package App\Shop
 */

namespace Stage\Shop;

if (! class_exists('ThemeSupports')) {

    /**
     * Class ThemeSupports
     *
     * @package App\Shop
     */
    class ThemeSupports
    {
        /**
         * Self init ThemeSupports
         *
         * @var ThemeSupports
         */
        private static $instance;

        /**
         * Self init ThemeSupports
         *
         * @return ThemeSupports
         */
        public static function get_instance()
        {
            if (null === self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * ThemeSupports constructor.
         */
        public function __construct()
        {
            /**
             * Declare WooCommerce Support
             *
             * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
             */
            add_theme_support(
                'woocommerce',
                array(
                    'thumbnail_image_width' => 150,
                    'single_image_width'    => 300,
                    'product_grid'          => array(
                        'default_rows'    => 3,
                        'min_rows'        => 2,
                        'max_rows'        => 8,
                        'default_columns' => 4,
                        'min_columns'     => 2,
                        'max_columns'     => 5,
                    ),
                )
            );

            remove_theme_support('wc-product-gallery-zoom');
            add_theme_support('wc-product-gallery-lightbox');
            add_theme_support('wc-product-gallery-slider');
        }
    }
}
