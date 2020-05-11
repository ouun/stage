@extends('layouts.app')

@section('content')
  <div class="h-full content-wrap">
    @include('partials.archive.title')

    @if (! have_posts())
      <x-alert type="warning">
        {!! __('Sorry, but the page you are trying to view does not exist.', 'stage') !!}
      </x-alert>

      @include('components.search')
    @endif
  </div>
@endsection
