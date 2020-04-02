@extends('layouts.app')

@section('content')
  <div class="h-full content-wrap">
    @include('partials.archive.title')

    @if (! have_posts())
      <x-alert type="warning" message="Sorry, but the page you are trying to view does not exist." />

      @include('components.search')
    @endif
  </div>
@endsection
