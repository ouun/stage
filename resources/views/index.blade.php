@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if(! have_posts())
    @alert(['type' => 'warning'])
      {{ __('Sorry, no results were found.', 'stage') }}
    @endalert

    <div class="text-xl max-w-sm border-2 border-black py-3 my-6">
      {!! get_search_form(false) !!}
    </div>
  @endif

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
