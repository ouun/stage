<div class="alignwide">
  <div class="wrap">
    <div class="flex flex-1 flex-wrap items-stretch grid-cards infinity-wrap md:-mx-2">
      @while( have_posts() ) @php the_post() @endphp
          @includeFirst( ['partials.archive.item-' . get_post_type(), 'partials.archive.item'] )
      @endwhile
    </div>
  </div>
</div>
