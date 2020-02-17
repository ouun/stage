<?php

namespace Stage\Providers;

use Roots\Acorn\ServiceProvider;

class ShopExtras extends ServiceProvider
{

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    add_filter(
      'woocommerce_sale_flash',
      function ( $text, $post, $product ) {

        $sale_saving = self::get_sale_saving( $product );

        if ( ! empty( $sale_saving ) ) {
          $text = '<span class="onsale">' . $sale_saving['percentage'] . '</span>';
        }

        return $text;

      },
      10,
      3
    );

    /**
     * Update cart items count when ajax add to cart triggered
     *
     * If we need to change the content in our mini cart using AJAX,
     * such as the products count in the cart or the total price, we need to use $fragments.
     * In this case, the key of array item is the selector of HTML element.
     */
    add_filter(
      'woocommerce_add_to_cart_fragments',
      function( $fragments ) {
        $fragments['.cart-count'] = '<sup class="cart-count count text-primary">' . WC()->cart->get_cart_contents_count() . '</sup>';
        return $fragments;
      }
    );
  }

  /**
   * Get sale price and percentage as array or string
   *
   * @param $product|$product_id The product or product ID
   * @param bool $as_string Receive array or string
   *
   * @return array|string|null
   */
  public static function get_sale_saving( $product, $as_string = false ) {

    if ( is_numeric( $product ) ) {
      $product = wc_get_product( $product );
    }

    $saving = [];

    // Only on sale products on frontend and excluding min/max price on variable products
    if ( $product->is_on_sale() && ! is_admin() && ! $product->is_type('variable') && ! $product->is_type('grouped') ) {
      // Get product prices
      $regular_price = (float) $product->get_regular_price(); // Regular price
      $sale_price = (float) $product->get_price(); // Active price (the "Sale price" when on-sale)

      // "Saving price" calculation and formatting
      $saving['amount'] = wc_price( $regular_price - $sale_price );

      // "Saving Percentage" calculation and formatting
      $saving['percentage'] = round( 100 - ( $sale_price / $regular_price * 100 ), 0 ) . '%';

      if( $as_string ) {
        $saving = $saving['percentage'] . ' (' . $saving['amount'] . ')';
      }

    }

    return !empty($saving) ? $saving : null;
  }

  /**
   * Get a custom sales price string
   *
   * @param $price
   * @param $regular_price
   * @param $sale_price
   *
   * @return string
   */
  function woocommerce_custom_sales_price( $price, $regular_price, $sale_price ) {
    // Getting the clean numeric prices (without html and currency).
    $regular_price = floatval( strip_tags( $regular_price ) );
    $sale_price    = floatval( strip_tags( $sale_price ) );

    // Percentage calculation and text.
    $percentage     = round( ( $regular_price - $sale_price ) / $regular_price * 100 ) . '%';
    $percentage_txt = __( ' Save ', 'woocommerce' ) . $percentage;

    return '<del>' . wc_price( $regular_price ) . '</del> <ins>' . wc_price( $sale_price ) . $percentage_txt . '</ins>';
  }
}
