{{--
  Template Name: Headless
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  <header>
    @include('partials.single.thumbnail')

    <div class="post-meta container sr-only">
      @include('partials.single.title')
      @include('partials.single.meta')
    </div>
  </header>

  <div class="blocks-wrap {{ $align ?? 'align' }}">
    @php the_content() @endphp
  </div>
  @endwhile
@endsection
