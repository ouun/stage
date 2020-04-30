{{--
Product Archives
@version  3.4.0
--}}

@extends('layouts.app')

@section('content')
  <div class="flex-1 archive-wrap">
    @action('woocommerce_before_main_content')

      @if( $show_page_title )
          @include('partials.single.page-title')
      @endif

      <div class="alignwide">
        @action('woocommerce_archive_description')
      </div>

      @if( woocommerce_product_loop() )

        <div class="alignwide text-xs flex flex-wrap">
          @action('woocommerce_before_shop_loop')
        </div>

        @php woocommerce_product_loop_start() @endphp

          @includeFirst(['partials.archive.content-' . get_post_type(), 'partials.archive.content'])

        @php woocommerce_product_loop_end() @endphp

        @action('woocommerce_after_shop_loop')
      @else
        @action('woocommerce_no_products_found')
      @endif

    @action('woocommerce_after_main_content')
  </div>
@endsection

@if( $display_sidebar )
  @section('sidebar')
    @include('partials.sidebar')
  @endsection
@endif
