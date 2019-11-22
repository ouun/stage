<div class="grid-modern infinity-wrap grid -mx-4">
  @while(have_posts()) @php the_post() @endphp
    @includeFirst(['partials.content-'.get_post_type(), 'partials.content'])
  @endwhile
</div>
