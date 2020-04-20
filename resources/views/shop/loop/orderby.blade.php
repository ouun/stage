{{--
Show options for ordering
@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.6.0
--}}

@php
  defined( 'ABSPATH' ) || exit;
@endphp

<form class="woocommerce-ordering flex-none" method="get">
  <select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
    <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
    <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
    <?php endforeach; ?>
  </select>
  <input type="hidden" name="paged" value="1" />
  <?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>
