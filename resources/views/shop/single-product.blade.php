{{--
Content Product Category
@version  1.6.4
--}}

@extends('layouts.app')
@section('content')
  @action('get_before_main_content')
  @while_posts @post
    @include('shop.content-single-product')
  @endwhile
  @action('get_after_main_content')
@endsection
