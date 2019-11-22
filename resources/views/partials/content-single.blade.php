<article @php post_class() @endphp>
  <header class="mt-0 mb-12">
    <div class="featured-image mb-6">
      {!! get_the_post_thumbnail() !!}
    </div>
    <div class="post-meta px-block-spacing text-center md:text-left md:px-0">
      <h1 class="entry-title">
        {!! get_the_title() !!}
      </h1>
      @include('partials/entry-meta')
    </div>
  </header>
  <div class="entry-content">
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'stage'), 'after' => '</p></nav>']) !!}
  </footer>

  @php comments_template('/partials/comments.blade.php') @endphp

</article>
