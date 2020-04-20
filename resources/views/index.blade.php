@extends('layouts.app')

@section('content')
  @include('partials.archive.title')

  @if(! have_posts())
    @include('partials.archive.no-posts')
  @else
    @includeFirst(['partials.archive.content-' . get_post_type(), 'partials.archive.content'])
  @endif
@endsection

@if( $display_sidebar )
  @section('sidebar')
    @include('partials.sidebar')
  @endsection
@endif
