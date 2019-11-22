@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @noposts
    @alert(['type' => 'warning'])
    {{ __('Sorry, no results were found.', 'stage') }}
    @endalert

    {!! get_search_form(false) !!}
  @endnoposts

  <div class="flex-1 archive-wrap">
    @include( 'partials.grids.' . $layout )

    {!! get_the_posts_navigation() !!}
  </div>

@endsection

@if( $display_sidebar )
  @section('sidebar')
    @include('partials.sidebar')
  @endsection
@endif
