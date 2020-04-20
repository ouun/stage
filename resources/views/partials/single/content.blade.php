<article @php post_class() @endphp>
  <header class="mt-0 mb-12">
    @if( has_post_thumbnail() )
      <div class="container overflow-hidden h-half-screen">
        {!! get_the_post_thumbnail( get_the_ID(), 'full', [ 'class' => 'alignscreen w-full h-full object-cover object-center' ]) !!}
      </div>
    @endif
    <div class="post-meta container mt-12">
      @include('partials.single.title')
      @include('partials.single.meta')
    </div>
  </header>
  <div class="blocks-wrap">
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'stage'), 'after' => '</p></nav>']) !!}
  </footer>

  @php comments_template('/partials/single/comments.blade.php') @endphp
</article>
