<div class="flex flex-wrap items-stretch -mx-4 grid-cards infinity-wrap">
  @while( have_posts() ) @php the_post() @endphp
    @includeFirst( ['partials.archive.item-' . get_post_type(), 'partials.archive.item'] )
  @endwhile
</div>
