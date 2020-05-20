<div class="wrap-inner grid-modern infinity-wrap grid {{ $align }}">
  @while(have_posts()) @php the_post() @endphp
    @includeFirst( ['partials.archive.item-' . get_post_type(), 'partials.archive.item'] )
  @endwhile
</div>
