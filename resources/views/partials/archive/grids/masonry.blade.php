<div class="wrap-inner {{ $align }}">
  <div class="md:-mx-2">
    <div class="flex flex-wrap items-start flex-auto grid-masonry infinity-wrap items-wrap">
      {{-- Items are sorted into columns --}}
      <div class="w-full grid-col md:w-1/2 xl:w-1/3 grid-col--1 md:px-2"></div>
      <div class="hidden w-full grid-col md:w-1/2 xl:w-1/3 grid-col--2 md:block md:px-2"></div>
      <div class="hidden w-full grid-col md:w-1/2 xl:w-1/3 grid-col--3 lg:block lg:px-2"></div>

      {{-- Items to sort into coluumns --}}
      @while(have_posts()) @php the_post() @endphp
        @includeFirst( ['partials.archive.item-' . get_post_type(), 'partials.archive.item'] )
      @endwhile
    </div>
  </div>
</div>
