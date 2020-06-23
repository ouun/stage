{{--
  Template Name: Wide Aligned
--}}

@extends('layouts.app')

@section('content')
  <div class="alignwide">
    @while(have_posts()) @php the_post() @endphp
      @includeFirst(['partials.single.content-' . get_post_type(), 'partials.single.content'])
    @endwhile
  </div>
@endsection
