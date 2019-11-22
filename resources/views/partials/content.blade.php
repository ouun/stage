<article @php post_class('p-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/3 relative') @endphp>
  <header>
    @if(has_post_thumbnail())
      <div class="featured-image mb-4">
        {!! get_the_post_thumbnail() !!}
      </div>
    @endif
    <div class="post-meta">
      <h2 class="entry-title block mb-2">
        <a class="no-underline" href="{{ get_permalink() }}" title="{!! get_the_title() !!}">
          {!! get_the_title() !!}
        </a>
      </h2>
      @include('partials/entry-meta')
    </div>
  </header>
  <div class="entry-summary mt-4">
    @php the_excerpt() @endphp
  </div>
</article>
