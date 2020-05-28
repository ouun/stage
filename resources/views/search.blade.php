@extends('layouts.app')

@section('content')
  @include('partials.archive.title')

  <div class="archive-wrap">
    <div class="alignwide">
      @include('components.search')
    </div>
  </div>

  @if (! have_posts())
    @include('partials.archive.no-posts')
  @else
    @include( 'partials.archive.content' )
  @endif

@endsection
