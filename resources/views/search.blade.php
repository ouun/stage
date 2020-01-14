@extends('layouts.app')

@section('content')
  @include('partials.archive.title')

  <div class="archive-wrap">
    <div class="alignwide">
      @include('components.search')
    </div>

    @if (! have_posts())
      @alert(['type' => 'warning'])
        {{ __('Sorry, no results were found.', 'stage') }}
      @endalert
    @endif
  </div>

  @include( 'partials.archive.content' )
@endsection
