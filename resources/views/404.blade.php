@extends('layouts.app')

@section('content')
  <div class="content-wrap h-full">
    @include('partials.page-header')

    @if (!have_posts())
      <div class="alert alert-warning mb-6">
        {{ __('Sorry, but the page you were trying to view does not exist.', 'stage') }}
      </div>

      <div class="h-12 border py-2">
        {!! get_search_form(false) !!}
      </div>
    @endif
  </div>
@endsection
