{{--
Cart Page
@version  3.5.0
@overwrite false
--}}

@php
  defined( 'ABSPATH' ) || exit;
@endphp

@php
  do_action( 'woocommerce_before_cart' )
@endphp

<form class="woocommerce-cart-form flex flex-wrap md:-mx-4 mt-12" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
  <div class="w-full md:w-2/3 lg:w-3/5 md:px-4">

    <h2 class="text-2xl mb-6"><?php _e( 'Cart', 'woocommerce' ); ?></h2>

      <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents w-full" cellspacing="0">
        <thead>
        <tr class="text-xs uppercase text-accent border-b">
          <th class="product-remove">&nbsp;</th>
          <th class="product-thumbnail text-left"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
          <th class="product-name">&nbsp;</th>
          <th class="product-price">&nbsp;</th>
          <th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
          <th class="product-subtotal text-right"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

        <?php
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
        ?>
        <tr class="woocommerce-cart-form__cart-item border-b <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

          <td class="product-remove md:pr-4 ">
            <?php
            // @codingStandardsIgnoreLine
            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
              '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">'. get_svg('x', 'ml-auto text-gray-300 hover:text-gray-500') . '</a>',
              esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
              __( 'Remove this item', 'woocommerce' ),
              esc_attr( $product_id ),
              esc_attr( $_product->get_sku() )
            ), $cart_item_key );
            ?>
          </td>

          <td class="product-thumbnail md:py-4 py-4">
            <?php
            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
            if ( ! $product_permalink ) {
              echo $thumbnail; // PHPCS: XSS ok.
            } else {
              printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
            }
            ?>
          </td>

          <td class="product-name md:py-4 md:pl-4 md:text-xl" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
            <?php
            if ( ! $product_permalink ) {
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
            } else {
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
            }
            do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
            // Meta data.
            echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.
            // Backorder notification.
            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
            }
            ?>
          </td>

          <td class="product-price md:py-4" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
            <?php
            echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
            ?>
          </td>

          <td class="product-quantity py-4" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
            <?php
            if ( $_product->is_sold_individually() ) {
              $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
            } else {
              $product_quantity = woocommerce_quantity_input( array(
                'input_name'   => "cart[{$cart_item_key}][qty]",
                'input_value'  => $cart_item['quantity'],
                'max_value'    => $_product->get_max_purchase_quantity(),
                'min_value'    => '0',
                'product_name' => $_product->get_name(),
              ), $_product, false );
            }
            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
            ?>
          </td>

          <td class="product-subtotal py-4" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
            <?php
            echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
            ?>
          </td>
        </tr>
        <?php
        }
        }
        ?>

        <?php do_action( 'woocommerce_cart_contents' ); ?>

        <tr>
          <td colspan="6" class="actions border-b-0">

            <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

            <?php do_action( 'woocommerce_cart_actions' ); ?>

            <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
          </td>
        </tr>

        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
        </tbody>
      </table>
      <?php do_action( 'woocommerce_after_cart_table' ); ?>

  </div>

  <div class="cart-collaterals w-full md:w-1/3 lg:w-2/5 md:px-4">

    <h2 class="text-2xl mb-6"><?php _e( 'Cart totals', 'woocommerce' ); ?></h2>

    <?php if ( wc_coupons_enabled() ) { ?>
      <div class="js-accordion border-l border-r mb-4 bg-gray-100" data-accordion-prefix-classes="animated-accordion">
        <div class="js-accordion__panel">
          <h2 class="js-accordion__header">
            <?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>
            <span class="js-accordion__header-icon"></span>
          </h2>
          <div class="js-accordion__content">
            <div class="coupon">
              <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
              <button type="submit" class="button outline w-full" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
              <?php do_action( 'woocommerce_cart_coupon' ); ?>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

    <?php
    /**
     * Cart collaterals hook.
     *
     * @hooked woocommerce_cross_sell_display
     * @hooked woocommerce_cart_totals - 10
     */
    do_action( 'woocommerce_cart_collaterals' );
    ?>
  </div>
</form>

@php
  do_action( 'woocommerce_after_cart' )
@endphp
