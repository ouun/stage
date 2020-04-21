{{-- Cart Content --}}
@if(!$shop->is_cart && !$shop->is_checkout)
  {!! $minicart !!}
@endif

{{-- Menu --}}
<div class="mini-cart-submenu colors-inherit">
  {!! $mini_cart_default_menu !!}
</div>
