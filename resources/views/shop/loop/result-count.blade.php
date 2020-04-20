{{--
Result Count
@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.3.0
--}}

@php
  defined( 'ABSPATH' ) || exit;
@endphp

<p class="woocommerce-result-count flex-grow">
  <?php
  if ( $total <= $per_page || -1 === $per_page ) {
    /* translators: %d: total results */
    printf( _n( 'Showing the single result', 'Showing all %d results', $total, 'woocommerce' ), $total );
  } else {
    $first = ( $per_page * $current ) - $per_page + 1;
    $last  = min( $total, $per_page * $current );
    /* translators: 1: first result 2: last result 3: total results */
    printf( _nx( 'Showing the single result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'woocommerce' ), $first, $last, $total );
  }
  ?>
</p>
