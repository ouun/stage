<div class="grid-masonry infinity-wrap items-wrap flex flex-wrap flex-auto items-start -mx-4">
  <!-- Items are sorted into the columns -->
  <div class="grid-col w-full md:w-1/2 xl:w-1/3 grid-col--1"></div>
  <div class="grid-col w-full md:w-1/2 xl:w-1/3 grid-col--2 hidden md:block"></div>
  <div class="grid-col w-full md:w-1/2 xl:w-1/3 grid-col--3 hidden lg:block"></div>

  <!-- Items to sort in -->
  @while(have_posts()) @php the_post() @endphp
    @includeFirst(['partials.content-'.get_post_type(), 'partials.content'])
  @endwhile
</div>
