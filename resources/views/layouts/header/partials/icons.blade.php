<ul class="icons menu colors-inherit h-full">
  {{-- WooCommerce Cart Icon --}}
  @if($shop)
    <li class="menu-item menu-icon colors-inherit hover-open has-children {{ $is_cart ? 'active hide-submenu' : '' }}">
      <a class="w-6 h-6 relative cart-trigger self-center mx-2 overflow-visible prevent" href="{{ $cart_url }}" title="{!! __( 'View your shopping cart', 'stage' ) !!}">
        @svg('shopping-cart', 'search--open opacity-100 absolute inset-0')
        <span class="absolute bottom-2/3 left-3/4 text-xs text-primary">
          {{ $cart_contents_count }}
        </span>
      </a>

      <div class="menu-cart-content sub-menu colors-inherit">
        @include('layouts.header.partials.mini-cart')
      </div>
    </li>
  @endif

  {{-- Search Icon --}}
  <li class="menu-item menu-icon colors-inherit {{ is_search() ? 'active' : '' }}">
    <a class="w-6 h-6 relative search-trigger self-center mx-2 cursor-pointer prevent" href="{{ get_search_link() }}">
      @svg('search', 'search--open opacity-100 absolute inset-0')
      @svg('x', 'search--close opacity-0 absolute inset-0')
    </a>
  </li>

  {{-- Mobile Off-Canvas-Menu--}}
  <li class="menu-item menu-icon colors-inherit">
    <button class="w-6 h-6 relative nav-trigger self-center ml-2 lg:hidden" type="button" aria-label="Menu" aria-controls="navigation">
      @svg('menu', 'nav--open opacity-100 absolute inset-0')
      @svg('x', 'nav--close opacity-0 absolute inset-0')
    </button>
  </li>
</ul>
