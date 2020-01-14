<div class="flex flex-wrap items-start flex-auto -mx-4 grid-masonry infinity-wrap items-wrap">
  {{-- Items are sorted into the columns --}}
  <div class="w-full grid-col md:w-1/2 xl:w-1/3 grid-col--1"></div>
  <div class="hidden w-full grid-col md:w-1/2 xl:w-1/3 grid-col--2 md:block"></div>
  <div class="hidden w-full grid-col md:w-1/2 xl:w-1/3 grid-col--3 lg:block"></div>

  {{-- Items to sort in --}}
  @while(have_posts()) @php the_post() @endphp
    @includeFirst( ['partials.archive.item-' . get_post_type(), 'partials.archive.item'] )
  @endwhile
</div>
