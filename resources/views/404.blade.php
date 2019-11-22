@extends('layouts.app')

@section('content')
  <div class="content-wrap h-full">
    @include('partials.page-header')

    @if (!have_posts())
      <div class="alert alert-warning mb-6">
        {{ __('Sorry, but the page you were trying to view does not exist.', 'stage') }}
      </div>

      {!! get_search_form(false) !!}

    @endif
  </div>
@endsection
