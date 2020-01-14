@if(!$shop->is_cart && !$shop->is_checkout)
  @minicart
@endif

<div class="mini-cart-submenu">
  {!! $mini_cart_default_menu !!}
</div>
