{{--
Content Product Category
@version  1.6.4
--}}

@extends('layouts.app')
@section('content')
  @action('woocommerce_before_main_content')

  @posts
    @include('shop.content-single-product')
  @endposts

  @action('woocommerce_after_main_content')
@endsection
