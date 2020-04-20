@extends('layouts.app')

@section('content')
  @include('partials.archive.title')

  <div class="archive-wrap">
    <div class="alignwide">
      @include('components.search')

      @if (! have_posts())
        @include('partials.archive.no-posts')
      @endif
    </div>
  </div>

  @include( 'partials.archive.content' )
@endsection
