{{--
Fallback template if an overwrite does not exist
This gets the template parts from WC plugin path

@see 	      https://docs.woocommerce.com/document/template-structure/
@author 		ouun.io
@package 	  WooCommerce/Templates
@version    3.0.0
--}}

@extends('layouts.app')

@section('content')
  <section class="wp-blocks">
    @php(woocommerce_content())
  </section>
@endsection
