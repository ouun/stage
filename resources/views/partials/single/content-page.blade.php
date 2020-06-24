<article @php post_class() @endphp>

  @include('partials.single.header-page')

  <div class="blocks-wrap {{ $align ?? 'align' }}">
    @php the_content() @endphp
  </div>

  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'stage'), 'after' => '</p></nav>']) !!}
  </footer>

  @php comments_template('/partials/comments.blade.php') @endphp
</article>
