<article @php post_class() @endphp>

  @include('partials.single.header')

  <div class="blocks-wrap {{ $align ?? 'align' }}">
    @php the_content() @endphp
  </div>

  @php comments_template('/partials/comments.blade.php') @endphp
</article>
