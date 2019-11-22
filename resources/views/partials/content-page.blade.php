<article @php post_class('wp-blocks') @endphp>
  <header>
    @include('partials.page-header')
  </header>
  <div class="entry-content">
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'stage'), 'after' => '</p></nav>']) !!}
  </footer>

  @php comments_template('/partials/comments.blade.php') @endphp
</article>
