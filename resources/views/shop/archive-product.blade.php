{{--
Product Archives
@version  3.4.0
--}}

@extends('layouts.app')

@section('content')
    @action('woocommerce_before_main_content')

    @if( $show_page_title )
        @include('partials.single.page-title')
    @endif

    @action('woocommerce_archive_description')

    @if( woocommerce_product_loop() )

        {{--
        <div class="flex items-end content-center justify-between flex-wrap pb-5 mb-5">
          @action('woocommerce_before_shop_loop')
        </div>
        --}}

        @php woocommerce_product_loop_start() @endphp

        @if($total_loop_prop)
          @hasposts
            @posts
              @php
                the_post();
                do_action('woocommerce_shop_loop');
                wc_get_template_part('content', 'product');
              @endphp
            @endposts
          @endhasposts
        @endif

        @php woocommerce_product_loop_end() @endphp

      @action('woocommerce_after_shop_loop')
    @else
      @action('woocommerce_no_products_found')
    @endif

    @action('woocommerce_after_main_content')
@endsection
