@extends('layouts.app')

@section('content')
  @include('partials.archive.title')

  <div class="archive-wrap">
    <div class="alignwide">
      @include('components.search')
    </div>

    @if (! have_posts())
      <x-alert type="warning" message="Sorry, no results were found." />
    @endif
  </div>

  @include( 'partials.archive.content' )
@endsection
