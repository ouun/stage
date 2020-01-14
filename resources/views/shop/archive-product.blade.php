{{--
Product Archives
@version  3.4.0
--}}

@extends('layouts.app')

@section('content')
    @action('get_before_main_content')

    @if( $show_page_title )
        @include('partials.single.page-title')
    @endif

    @action('get_archive_description')
    @if_posts

    {{--
    <div class="flex items-end content-center justify-between flex-wrap pb-5 mb-5">
      @action('get_before_shop_loop')
    </div>
    --}}

    @php woocommerce_product_loop_start() @endphp

      @if($total_loop_prop)
        @while_posts @post
          @action('get_shop_loop')
          @include('shop.content-product')
        @endwhile
      @endif

    @php woocommerce_product_loop_end() @endphp

      @action('get_after_shop_loop')
    @else
      @action('get_no_products_found')
    @endif
    @action('get_after_main_content')
@endsection
