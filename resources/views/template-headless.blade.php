{{--
  Template Name: Headless
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  <header class="mt-0 mb-12">
    @include('partials.single.thumbnail')

    <div class="post-meta container mt-12 sr-only">
      @include('partials.single.title')
      @include('partials.single.meta')
    </div>
  </header>

  <div class="blocks-wrap {{ $align ?? 'align' }}">
    @php the_content() @endphp
  </div>
  @endwhile
@endsection
