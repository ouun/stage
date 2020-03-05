{{--
Displays a single product content
@version     3.4.0
--}}

@action('woocommerce_before_single_product')

@if($password_required)
  {!! $password_form !!}
  @php return; @endphp
@endif

<div id="product-{{ $id }}" class="{{ $product_class }}">
  <div class="product-header flex flex-wrap clearfix py-5">
    <div class="w-full md:w-2/3 clearfix flex-initial relative pb-10">
      @action('woocommerce_before_single_product_summary')
    </div>
    <div class="w-full md:w-1/3 relative pb-10">
      <div class="md:ml-10 md:pl-10 pb-10 md:border-l border-gray-300">
        @action('woocommerce_single_product_summary')
      </div>
    </div>
  </div>
  <div class="w-full py-10">
    @action('woocommerce_after_single_product_summary')
  </div>
</div>

@action('woocommerce_after_single_product')
