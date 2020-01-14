<article @php post_class() @endphp>
  <header class="mt-0 mb-12">
    @if( has_post_thumbnail() )
      <div class="overflow-hidden h-half-screen">
        {!! get_the_post_thumbnail( get_the_ID(), 'full', [ 'class' => 'w-full h-full object-cover object-center' ]) !!}
      </div>
    @endif
    <div class="container mt-12 text-center post-meta px-block-spacing md:text-left md:px-0">
      <h1 class="entry-title">
        {!! get_the_title() !!}
      </h1>
      @include('partials.single.meta')
    </div>
  </header>
  <div class="blocks-wrap">
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'stage'), 'after' => '</p></nav>']) !!}
  </footer>
</article>
