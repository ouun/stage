{{--
Breadcrump navigations
@version     3.6.0
--}}

@php
  defined( 'ABSPATH' ) || exit;
@endphp

@if ( $max_value && $min_value === $max_value )
  ?>
  <div class="quantity hidden">
    <input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
  </div>
@else
  @php
    /* translators: %s: Quantity. */
    $labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : '';
  @endphp
  <div class="quantity">
    <label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></label>
      <input
        type="number"
        id="<?php echo esc_attr( $input_id ); ?>"
        class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
        step="<?php echo esc_attr( $step ); ?>"
        min="<?php echo esc_attr( $min_value ); ?>"
        max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
        name="<?php echo esc_attr( $input_name ); ?>"
        value="<?php echo esc_attr( $input_value ); ?>"
        title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
        size="4"
        inputmode="<?php echo esc_attr( $inputmode ); ?>"
        @if ( ! empty( $labelledby ) )
          aria-labelledby="<?php echo esc_attr( $labelledby ); ?>" />
        @endif
  </div>
@endif
