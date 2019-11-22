@extends('layouts.app')

@section('content')
  <header class="content-wrap">
    @include('partials.page-header')
  </header>

  <div class="content-wrap">
    <div class="text-xl max-w-sm border-2 border-black py-3 my-6">
      {!! get_search_form(false) !!}
    </div>

    @if (! have_posts())
      @alert(['type' => 'warning'])
        {{ __('Sorry, no results were found.', 'stage') }}
      @endalert
    @endif

    <div class="flex flex-wrap mb-4 -mx-4">
      @while(have_posts()) @php the_post() @endphp
        @include('partials.content-search')
      @endwhile
    </div>

    <div class="my-12">
      {!! get_the_posts_navigation() !!}
    </div>
  </div>
@endsection
