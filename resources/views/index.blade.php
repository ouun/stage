@extends('layouts.app')

@section('content')
  @include('partials.archive.title')

  @if(! have_posts())
    <x-alert type="warning" message="Sorry, no results were found" />

    @include('components.search')
  @else
    @includeFirst(['partials.archive.content-' . get_post_type(), 'partials.archive.content'])
  @endif
@endsection

@if( $display_sidebar )
  @section('sidebar')
    @include('partials.sidebar')
  @endsection
@endif
