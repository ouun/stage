{{--
Proceed to checkout button
@version  2.4.0
@overwrite false
--}}

<a href="<?php

echo esc_url(wc_get_checkout_url()); ?>" class="checkout-button btn btn-primary w-full m-0 py-3 uppercase">
  <?php esc_html_e('Proceed to checkout', 'woocommerce'); ?>
</a>
