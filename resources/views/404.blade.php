@extends('layouts.app')

@section('content')
  <div class="h-full content-wrap">
    @include('partials.archive.title')

    @if (! have_posts())
      @alert(['type' => 'warning'])
        {{ __('Sorry, but the page you were trying to view does not exist.', 'stage') }}
      @endalert

      @include('components.search')
    @endif
  </div>
@endsection
